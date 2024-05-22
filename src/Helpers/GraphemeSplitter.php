<?php
/**
 * Created by Michael Poletaew <poletaew@gmail.com>
 * at 16:10, 21.05.2024 GMT+4
 */

namespace Poletaew\SmsSegmentCalculator\Helpers;

class GraphemeSplitter
{
    public static function splitGraphemes(string $message): array
    {
        $graphemes = [];
        for ($i = 0; $i < grapheme_strlen($message); ++$i) {
            $graphemes[] = grapheme_substr($message, $i, 1);
        }

        return $graphemes;
    }
}