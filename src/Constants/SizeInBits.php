<?php
/**
 * Created by Michael Poletaew <poletaew@gmail.com>
 * at 13:06, 21.05.2024 GMT+4
 */

namespace Poletaew\SmsSegmentCalculator\Constants;

class SizeInBits
{
    const SEPTET = 7;
    const OCTET = 8;
    const UCS2 = 16;
    const MAX_MESSAGE_SIZE = 1120; // max size of a SMS is 140 octets -> 140 * 8 bits = 1120 bits
}