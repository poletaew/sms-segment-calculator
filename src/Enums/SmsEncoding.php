<?php
/**
 * Created by Michael Poletaew <poletaew@gmail.com>
 * at 13:10, 20.05.2024 GMT+4
 */

namespace Poletaew\SmsSegmentCalculator\Enums;

enum SmsEncoding: string
{
    case GSM7 = 'GSM-7';
    case UCS2 = 'UCS-2';
}
