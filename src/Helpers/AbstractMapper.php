<?php
/**
 * Created by Michael Poletaew <poletaew@gmail.com>
 * at 18:49, 21.05.2024 GMT+4
 */

namespace Poletaew\SmsSegmentCalculator\Helpers;

abstract class AbstractMapper
{
    const MAP = [];
    public static function get(int|string $fromValue): mixed
    {
        $map = static::MAP;
        foreach (static::MAP as $item) {
            if ($item['from'] === $fromValue) {
                return $item['to'];
            }
        }
        return null;
    }
}