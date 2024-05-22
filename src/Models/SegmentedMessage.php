<?php
/**
 * Created by Michael Poletaew <poletaew@gmail.com>
 * at 14:00, 21.05.2024 GMT+4
 */

namespace Poletaew\SmsSegmentCalculator\Models;

use InvalidArgumentException;
use Poletaew\SmsSegmentCalculator\Enums\SmsEncoding;
use Poletaew\SmsSegmentCalculator\Helpers\GraphemeSplitter;
use Poletaew\SmsSegmentCalculator\Helpers\SmartEncodeMapper;
use Poletaew\SmsSegmentCalculator\Helpers\UnicodeToGSMMapper;

class SegmentedMessage
{
    private SmsEncoding|string $encoding;

    /** @var Segment[] */
    private array $segments = [];
    private array $graphemes = [];
    private SmsEncoding $realEncoding;
    private int $numberOfUnicodeScalars;
    private int $numberOfCharacters;
    private array $encodedChars = [];
    private ?string $lineBreakStyle;
    private array $warnings = [];

    private static array $validEncodingValues = [SmsEncoding::GSM7, SmsEncoding::UCS2, 'auto'];

    public function __construct(string $message, SmsEncoding|string $encoding = 'auto', bool $smartEncoding = false)
    {
        if (!in_array($encoding, self::$validEncodingValues, true)) {
            throw new InvalidArgumentException("Encoding $encoding not supported. Valid values for encoding are " . implode(', ', self::$validEncodingValues));
        }

        if ($smartEncoding) {
            $message = SmartEncodeMapper::encode($message);
        }

        $this->graphemes = array_reduce(GraphemeSplitter::splitGraphemes($message), function ($accumulator, $grapheme) {
            $result = ($grapheme === "\r\n") ? str_split($grapheme) : [$grapheme];
            return array_merge($accumulator, $result);
        }, []);

        $this->numberOfUnicodeScalars = mb_strlen($message);
        $this->encoding = $encoding;

        if ($this->encoding === 'auto') {
            $this->realEncoding = $this->hasAnyUCSCharacters($this->graphemes) ? SmsEncoding::UCS2 : SmsEncoding::GSM7;
        } else {
            if ($encoding === SmsEncoding::GSM7 && $this->hasAnyUCSCharacters($this->graphemes)) {
                throw new InvalidArgumentException('The string provided is incompatible with GSM-7 encoding');
            }
            $this->realEncoding = $this->encoding;
        }

        $this->encodedChars = $this->encodeChars($this->graphemes);
        $this->numberOfCharacters = ($this->realEncoding === SmsEncoding::UCS2)
            ? count($this->graphemes)
            : $this->countCodeUnits($this->encodedChars);
        $this->segments = $this->buildSegments($this->encodedChars);
        $this->lineBreakStyle = $this->detectLineBreakStyle($message);
        $this->warnings = $this->checkForWarnings();
    }

    public function getRealEncodingName(): string
    {
        return $this->realEncoding->value;
    }

    public function getTotalSize(): int
    {
        return array_reduce($this->segments, fn($size, Segment $segment) => $size + $segment->sizeInBits(), 0);
    }

    public function getMessageSize(): int
    {
        return array_reduce($this->segments, fn($size, Segment $segment) => $size + $segment->messageSizeInBits(), 0);
    }

    public function getSegmentsCount(): int
    {
        return count($this->segments);
    }

    public function getNonGsmCharacters(): array
    {
        return array_map(fn($encodedChar) => $encodedChar->getRaw(), array_filter($this->encodedChars, fn($encodedChar) => !$encodedChar->isGSM7()));
    }

    public function getNumberOfUnicodeScalars(): int
    {
        return $this->numberOfUnicodeScalars;
    }

    public function getNumberOfCharacters(): int
    {
        return $this->numberOfCharacters;
    }

    public function getWarnings(): array
    {
        return $this->warnings;
    }

    private function detectLineBreakStyle(string $message): ?string
    {
        $hasWindowsStyle = str_contains($message, "\r\n");
        $hasUnixStyle = str_contains($message, "\n");
        $mixedStyle = $hasWindowsStyle && $hasUnixStyle;
        $noBreakLine = !$hasWindowsStyle && !$hasUnixStyle;

        if ($noBreakLine) {
            return null;
        }
        if ($mixedStyle) {
            return 'LF+CRLF';
        }
        return $hasUnixStyle ? 'LF' : 'CRLF';
    }

    private function checkForWarnings(): array
    {
        $warnings = [];
        if ($this->lineBreakStyle) {
            $warnings[] = 'The message has line breaks, the web page utility only supports LF style. If you insert a CRLF it will be converted to LF.';
        }
        return $warnings;
    }

    private function hasAnyUCSCharacters(array $graphemes): bool
    {
        foreach ($graphemes as $grapheme) {
            if (mb_strlen($grapheme) >= 2 || (mb_strlen($grapheme) === 1 && !UnicodeToGSMMapper::getByChar($grapheme))) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param EncodedChar[] $encodedChars
     * @return Segment[]
     */
    private function buildSegments(array $encodedChars): array
    {
        $segments = [new Segment()];
        $currentSegment = $segments[0];

        foreach ($encodedChars as $encodedChar) {
            if ($currentSegment->freeSizeInBits() < $encodedChar->sizeInBits()) {
                $segments[] = new Segment(true);
                $currentSegment = end($segments);
                $previousSegment = prev($segments);

                if (!$previousSegment->hasUserDataHeader()) {
                    $removedChars = $previousSegment->addHeader();
                    foreach ($removedChars as $char) {
                        $currentSegment->push($char);
                    }
                }
            }
            $currentSegment->push($encodedChar);
        }

        return $segments;
    }

    /**
     * @return EncodedChar[]
     */
    private function encodeChars(array $graphemes): array
    {
        return array_map(fn($grapheme) => new EncodedChar($grapheme, $this->realEncoding), $graphemes);
    }

    /**
     * @param EncodedChar[] $encodedChars
     * @return int
     */
    private function countCodeUnits(array $encodedChars): int
    {
        return array_reduce(
            $encodedChars,
            fn(int $accumulator, EncodedChar $nextEncodedChar) => $accumulator + count($nextEncodedChar->getCodeUnits()),
            0);
    }

    public function getSegments(): array
    {
        return $this->segments;
    }

    public function getGraphemes(): array
    {
        return $this->graphemes;
    }

    /**
     * @return EncodedChar[]
     */
    public function getEncodedChars(): array
    {
        return $this->encodedChars;
    }
}