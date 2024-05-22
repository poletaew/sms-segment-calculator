<?php
/**
 * Created by Michael Poletaew <poletaew@gmail.com>
 * at 13:17, 21.05.2024 GMT+4
 */

namespace Poletaew\SmsSegmentCalculator\Models;

use Poletaew\SmsSegmentCalculator\Constants\SizeInBits;

/**
 * Represent a User Data Header
 * Twilio messages reserve 6 of this per segment in a concatenated message
 */

class UserDataHeader {
    public bool $isReservedChar;
    public bool $isUserDataHeader;

    public function __construct() {
        $this->isReservedChar = true;
        $this->isUserDataHeader = true;
    }

    public static function codeUnitSizeInBits(): int {
        return SizeInBits::OCTET;
    }

    public function sizeInBits(): int {
        return SizeInBits::OCTET;
    }
}