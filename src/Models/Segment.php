<?php
/**
 * Created by Michael Poletaew <poletaew@gmail.com>
 * at 13:14, 21.05.2024 GMT+4
 */

namespace Poletaew\SmsSegmentCalculator\Models;

use Poletaew\SmsSegmentCalculator\Constants\SizeInBits;

/**
 * Segment Class
 * A modified array representing one segment and adds some helper functions
 */
class Segment {
    private array $elements = [];
    public bool $hasTwilioReservedBits;
    private bool $hasUserDataHeader;

    public function __construct(bool $withUserDataHeader = false) {
        $this->hasTwilioReservedBits = $withUserDataHeader;
        $this->hasUserDataHeader = $withUserDataHeader;
        if ($withUserDataHeader) {
            for ($i = 0; $i < 6; $i++) {
                $this->elements[] = new UserDataHeader();
            }
        }
    }

    // Size in bits *including* User Data Header (if present)
    public function sizeInBits(): int {
        return array_reduce($this->elements, function($accumulator, EncodedChar|UserDataHeader $encodedChar) {
            return $accumulator + $encodedChar->sizeInBits();
        }, 0);
    }

    // Size in bits *excluding* User Data Header (if present)
    public function messageSizeInBits(): int {
        return array_reduce($this->elements, function($accumulator, EncodedChar|UserDataHeader $encodedChar) {
            return $accumulator + ($encodedChar instanceof UserDataHeader ? 0 : $encodedChar->sizeInBits());
        }, 0);
    }

    public function freeSizeInBits(): int {
        return SizeInBits::MAX_MESSAGE_SIZE - $this->sizeInBits();
    }

    public function addHeader(): array {
        if ($this->hasUserDataHeader) {
            return [];
        }
        $leftOverChar = [];
        $this->hasTwilioReservedBits = true;
        $this->hasUserDataHeader = false;
        for ($i = 0; $i < 6; $i++) {
            array_unshift($this->elements, new UserDataHeader());
        }
        // Remove characters
        while ($this->freeSizeInBits() < 0) {
            array_unshift($leftOverChar, array_pop($this->elements));
        }
        return $leftOverChar;
    }

    // Adding some methods to manipulate the internal array similar to JS array methods
    public function push($element) {
        $this->elements[] = $element;
    }

    public function pop() {
        return array_pop($this->elements);
    }

    public function unshift($element) {
        array_unshift($this->elements, $element);
    }

    public function reduce(callable $callback, $initial) {
        return array_reduce($this->elements, $callback, $initial);
    }

    public function hasUserDataHeader()
    {
        return $this->hasUserDataHeader;
    }
}