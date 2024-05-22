<?php
/**
 * Created by Michael Poletaew <poletaew@gmail.com>
 * at 12:34, 21.05.2024 GMT+4
 */

namespace Poletaew\SmsSegmentCalculator\Models;

use IntlChar;
use Poletaew\SmsSegmentCalculator\Constants\SizeInBits;
use Poletaew\SmsSegmentCalculator\Enums\SmsEncoding;
use Poletaew\SmsSegmentCalculator\Helpers\UnicodeToGSMMapper;

class EncodedChar
{
    private array $codeUnits = [];
    private bool $isGSM7;
    private SmsEncoding $encoding;
    public string $raw;

    // Constructor
    public function __construct(string $char, SmsEncoding $encoding)
    {
        $this->raw = $char;
        $this->encoding = $encoding;

        $gsmChar = UnicodeToGSMMapper::getByChar($char);
        $this->isGSM7 = $char && mb_strlen($char) === 1 && $gsmChar;

        if ($this->isGSM7) {
            $this->codeUnits = $gsmChar;
        } else {
            $char16 = mb_convert_encoding($char, 'UTF-16', mb_detect_encoding($char));
            $this->codeUnits = unpack('n*', $char16);
        }
    }

    // Method to get the code unit size in bits
    public function codeUnitSizeInBits(): int
    {
        return $this->encoding === SmsEncoding::GSM7 ? SizeInBits::SEPTET : SizeInBits::OCTET;
    }

    // Method to get the size in bits
    public function sizeInBits(): int
    {
        if ($this->encoding === SmsEncoding::UCS2 && $this->isGSM7) {
            return SizeInBits::UCS2; // GSM characters use 16 bits in UCS-2 encoding
        }
        $bitsPerUnits = $this->encoding === SmsEncoding::GSM7 ? SizeInBits::SEPTET : SizeInBits::UCS2;
        return $bitsPerUnits * count($this->codeUnits);
    }

    public function getCodeUnits(): array
    {
        return $this->codeUnits;
    }

    public function isGSM7(): bool
    {
        return $this->isGSM7;
    }
}