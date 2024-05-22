<?php
/**
 * Created by Michael Poletaew <poletaew@gmail.com>
 * at 15:04, 20.05.2024 GMT+4
 */

namespace Poletaew\SmsSegmentCalculator\Helpers;

class SmartEncodeMapper extends AbstractMapper
{
    const MAP = [
        ['from' => "\u{00ab}", 'to' => '"'], // LEFT-POINTING DOUBLE ANGLE QUOTATION MARK
        ['from' => "\u{00bb}", 'to' => '"'], // RIGHT-POINTING DOUBLE ANGLE QUOTATION MARK
        ['from' => "\u{201c}", 'to' => '"'], // LEFT DOUBLE QUOTATION MARK
        ['from' => "\u{201d}", 'to' => '"'], // RIGHT DOUBLE QUOTATION MARK
        ['from' => "\u{02ba}", 'to' => '"'], // MODIFIER LETTER DOUBLE PRIME
        ['from' => "\u{02ee}", 'to' => '"'], // MODIFIER LETTER DOUBLE APOSTROPHE
        ['from' => "\u{201f}", 'to' => '"'], // DOUBLE HIGH-REVERSED-9 QUOTATION MARK
        ['from' => "\u{275d}", 'to' => '"'], // HEAVY DOUBLE TURNED COMMA QUOTATION MARK ORNAMENT
        ['from' => "\u{275e}", 'to' => '"'], // HEAVY DOUBLE COMMA QUOTATION MARK ORNAMENT
        ['from' => "\u{301d}", 'to' => '"'], // REVERSED DOUBLE PRIME QUOTATION MARK
        ['from' => "\u{301e}", 'to' => '"'], // DOUBLE PRIME QUOTATION MARK
        ['from' => "\u{ff02}", 'to' => '"'], // FULLWIDTH QUOTATION MARK
        ['from' => "\u{2018}", 'to' => "'"], // LEFT SINGLE QUOTATION MARK
        ['from' => "\u{2019}", 'to' => "'"], // RIGHT SINGLE QUOTATION MARK
        ['from' => "\u{02BB}", 'to' => "'"], // MODIFIER LETTER TURNED COMMA
        ['from' => "\u{02c8}", 'to' => "'"], // MODIFIER LETTER VERTICAL LINE
        ['from' => "\u{02bc}", 'to' => "'"], // MODIFIER LETTER APOSTROPHE
        ['from' => "\u{02bd}", 'to' => "'"], // MODIFIER LETTER REVERSED COMMA
        ['from' => "\u{02b9}", 'to' => "'"], // MODIFIER LETTER PRIME
        ['from' => "\u{201b}", 'to' => "'"], // SINGLE HIGH-REVERSED-9 QUOTATION MARK
        ['from' => "\u{ff07}", 'to' => "'"], // FULLWIDTH APOSTROPHE
        ['from' => "\u{00b4}", 'to' => "'"], // ACUTE ACCENT
        ['from' => "\u{02ca}", 'to' => "'"], // MODIFIER LETTER ACUTE ACCENT
        ['from' => "\u{0060}", 'to' => "'"], // GRAVE ACCENT
        ['from' => "\u{02cb}", 'to' => "'"], // MODIFIER LETTER GRAVE ACCENT
        ['from' => "\u{275b}", 'to' => "'"], // HEAVY SINGLE TURNED COMMA QUOTATION MARK ORNAMENT
        ['from' => "\u{275c}", 'to' => "'"], // HEAVY SINGLE COMMA QUOTATION MARK ORNAMENT
        ['from' => "\u{0313}", 'to' => "'"], // COMBINING COMMA ABOVE
        ['from' => "\u{0314}", 'to' => "'"], // COMBINING REVERSED COMMA ABOVE
        ['from' => "\u{fe10}", 'to' => "'"], // PRESENTATION FORM FOR VERTICAL COMMA
        ['from' => "\u{fe11}", 'to' => "'"], // PRESENTATION FORM FOR VERTICAL IDEOGRAPHIC COMMA
        ['from' => "\u{00F7}", 'to' => '/'], // DIVISION SIGN
        ['from' => "\u{00bc}", 'to' => '1/4'], // VULGAR FRACTION ONE QUARTER
        ['from' => "\u{00bd}", 'to' => '1/2'], // VULGAR FRACTION ONE HALF
        ['from' => "\u{00be}", 'to' => '3/4'], // VULGAR FRACTION THREE QUARTERS
        ['from' => "\u{29f8}", 'to' => '/'], // BIG SOLIDUS
        ['from' => "\u{0337}", 'to' => '/'], // COMBINING SHORT SOLIDUS OVERLAY
        ['from' => "\u{0338}", 'to' => '/'], // COMBINING LONG SOLIDUS OVERLAY
        ['from' => "\u{2044}", 'to' => '/'], // FRACTION SLASH
        ['from' => "\u{2215}", 'to' => '/'], // DIVISION SLASH
        ['from' => "\u{ff0f}", 'to' => '/'], // FULLWIDTH SOLIDUS
        ['from' => "\u{29f9}", 'to' => '\\'], // BIG REVERSE SOLIDUS
        ['from' => "\u{29f5}", 'to' => '\\'], // REVERSE SOLIDUS OPERATOR
        ['from' => "\u{20e5}", 'to' => '\\'], // COMBINING REVERSE SOLIDUS OVERLAY
        ['from' => "\u{fe68}", 'to' => '\\'], // SMALL REVERSE SOLIDUS
        ['from' => "\u{ff3c}", 'to' => '\\'], // FULLWIDTH REVERSE SOLIDUS
        ['from' => "\u{0332}", 'to' => '_'], // COMBINING LOW LINE
        ['from' => "\u{ff3f}", 'to' => '_'], // FULLWIDTH LOW LINE
        ['from' => "\u{20d2}", 'to' => '|'], // COMBINING LONG VERTICAL LINE OVERLAY
        ['from' => "\u{20d3}", 'to' => '|'], // COMBINING SHORT VERTICAL LINE OVERLAY
        ['from' => "\u{2223}", 'to' => '|'], // DIVIDES
        ['from' => "\u{ff5c}", 'to' => '|'], // FULLWIDTH VERTICAL LINE
        ['from' => "\u{23b8}", 'to' => '|'], // LEFT VERTICAL BOX LINE
        ['from' => "\u{23b9}", 'to' => '|'], // RIGHT VERTICAL BOX LINE
        ['from' => "\u{23d0}", 'to' => '|'], // VERTICAL LINE EXTENSION
        ['from' => "\u{239c}", 'to' => '|'], // LEFT PARENTHESIS EXTENSION
        ['from' => "\u{239f}", 'to' => '|'], // RIGHT PARENTHESIS EXTENSION
        ['from' => "\u{23bc}", 'to' => '-'], // HORIZONTAL SCAN LINE-7
        ['from' => "\u{23bd}", 'to' => '-'], // HORIZONTAL SCAN LINE-9
        ['from' => "\u{2015}", 'to' => '-'], // HORIZONTAL BAR
        ['from' => "\u{fe63}", 'to' => '-'], // SMALL HYPHEN-MINUS
        ['from' => "\u{ff0d}", 'to' => '-'], // FULLWIDTH HYPHEN-MINUS
        ['from' => "\u{2010}", 'to' => '-'], // HYPHEN
        ['from' => "\u{2043}", 'to' => '-'], // HYPHEN BULLET
        ['from' => "\u{fe6b}", 'to' => '@'], // SMALL COMMERCIAL AT
        ['from' => "\u{ff20}", 'to' => '@'], // FULLWIDTH COMMERCIAL AT
        ['from' => "\u{fe69}", 'to' => '$'], // SMALL DOLLAR SIGN
        ['from' => "\u{ff04}", 'to' => '$'], // FULLWIDTH DOLLAR SIGN
        ['from' => "\u{01c3}", 'to' => '!'], // LATIN LETTER RETROFLEX CLICK
        ['from' => "\u{fe15}", 'to' => '!'], // PRESENTATION FORM FOR VERTICAL EXLAMATION MARK
        ['from' => "\u{fe57}", 'to' => '!'], // SMALL EXCLAMATION MARK
        ['from' => "\u{ff01}", 'to' => '!'], // FULLWIDTH EXCLAMATION MARK
        ['from' => "\u{fe5f}", 'to' => '#'], // SMALL NUMBER SIGN
        ['from' => "\u{ff03}", 'to' => '#'], // FULLWIDTH NUMBER SIGN
        ['from' => "\u{fe6a}", 'to' => '%'], // SMALL PERCENT SIGN
        ['from' => "\u{ff05}", 'to' => '%'], // FULLWIDTH PERCENT SIGN
        ['from' => "\u{fe60}", 'to' => '&'], // SMALL AMPERSAND
        ['from' => "\u{ff06}", 'to' => '&'], // FULLWIDTH AMPERSAND
        ['from' => "\u{201a}", 'to' => ','], // SINGLE LOW-9 QUOTATION MARK
        ['from' => "\u{0326}", 'to' => ','], // COMBINING COMMA BELOW
        ['from' => "\u{fe50}", 'to' => ','], // SMALL COMMA
        ['from' => "\u{fe51}", 'to' => ','], // SMALL IDEOGRAPHIC COMMA
        ['from' => "\u{ff0c}", 'to' => ','], // FULLWIDTH COMMA
        ['from' => "\u{ff64}", 'to' => ','], // HALFWIDTH IDEOGRAPHIC COMMA
        ['from' => "\u{2768}", 'to' => '('], // MEDIUM LEFT PARENTHESIS ORNAMENT
        ['from' => "\u{276a}", 'to' => '('], // MEDIUM FLATTENED LEFT PARENTHESIS ORNAMENT
        ['from' => "\u{fe59}", 'to' => '('], // SMALL LEFT PARENTHESIS
        ['from' => "\u{ff08}", 'to' => '('], // FULLWIDTH LEFT PARENTHESIS
        ['from' => "\u{27ee}", 'to' => '('], // MATHEMATICAL LEFT FLATTENED PARENTHESIS
        ['from' => "\u{2985}", 'to' => '('], // LEFT WHITE PARENTHESIS
        ['from' => "\u{2769}", 'to' => ')'], // MEDIUM RIGHT PARENTHESIS ORNAMENT
        ['from' => "\u{276b}", 'to' => ')'], // MEDIUM FLATTENED RIGHT PARENTHESIS ORNAMENT
        ['from' => "\u{fe5a}", 'to' => ')'], // SMALL RIGHT PARENTHESIS
        ['from' => "\u{ff09}", 'to' => ')'], // FULLWIDTH RIGHT PARENTHESIS
        ['from' => "\u{27ef}", 'to' => ')'], // MATHEMATICAL RIGHT FLATTENED PARENTHESIS
        ['from' => "\u{2986}", 'to' => ')'], // RIGHT WHITE PARENTHESIS
        ['from' => "\u{204e}", 'to' => '*'], // LOW ASTERISK
        ['from' => "\u{2217}", 'to' => '*'], // ASTERISK OPERATOR
        ['from' => "\u{229B}", 'to' => '*'], // CIRCLED ASTERISK OPERATOR
        ['from' => "\u{2722}", 'to' => '*'], // FOUR TEARDROP-SPOKED ASTERISK
        ['from' => "\u{2723}", 'to' => '*'], // FOUR BALLOON-SPOKED ASTERISK
        ['from' => "\u{2724}", 'to' => '*'], // HEAVY FOUR BALLOON-SPOKED ASTERISK
        ['from' => "\u{2725}", 'to' => '*'], // FOUR CLUB-SPOKED ASTERISK
        ['from' => "\u{2731}", 'to' => '*'], // HEAVY ASTERISK
        ['from' => "\u{2732}", 'to' => '*'], // OPEN CENTRE ASTERISK
        ['from' => "\u{2733}", 'to' => '*'], // EIGHT SPOKED ASTERISK
        ['from' => "\u{273a}", 'to' => '*'], // SIXTEEN POINTED ASTERISK
        ['from' => "\u{273b}", 'to' => '*'], // TEARDROP-SPOKED ASTERISK
        ['from' => "\u{273c}", 'to' => '*'], // OPEN CENTRE TEARDROP-SPOKED ASTERISK
        ['from' => "\u{273d}", 'to' => '*'], // HEAVY TEARDROP-SPOKED ASTERISK
        ['from' => "\u{2743}", 'to' => '*'], // HEAVY TEARDROP-SPOKED PINWHEEL ASTERISK
        ['from' => "\u{2749}", 'to' => '*'], // BALLOON-SPOKED ASTERISK
        ['from' => "\u{274a}", 'to' => '*'], // EIGHT TEARDROP-SPOKED PROPELLER ASTERISK
        ['from' => "\u{274b}", 'to' => '*'], // HEAVY EIGHT TEARDROP-SPOKED PROPELLER ASTERISK
        ['from' => "\u{29c6}", 'to' => '*'], // SQUARED ASTERISK
        ['from' => "\u{fe61}", 'to' => '*'], // SMALL ASTERISK
        ['from' => "\u{ff0a}", 'to' => '*'], // FULLWIDTH ASTERISK
        ['from' => "\u{02d6}", 'to' => '+'], // MODIFIER LETTER PLUS SIGN
        ['from' => "\u{fe62}", 'to' => '+'], // SMALL PLUS SIGN
        ['from' => "\u{ff0b}", 'to' => '+'], // FULLWIDTH PLUS SIGN
        ['from' => "\u{3002}", 'to' => '.'], // IDEOGRAPHIC FULL STOP
        ['from' => "\u{fe52}", 'to' => '.'], // SMALL FULL STOP
        ['from' => "\u{ff0e}", 'to' => '.'], // FULLWIDTH FULL STOP
        ['from' => "\u{ff61}", 'to' => '.'], // HALFWIDTH IDEOGRAPHIC FULL STOP
        ['from' => "\u{ff10}", 'to' => '0'], // FULLWIDTH DIGIT ZERO
        ['from' => "\u{ff11}", 'to' => '1'], // FULLWIDTH DIGIT ONE
        ['from' => "\u{ff12}", 'to' => '2'], // FULLWIDTH DIGIT TWO
        ['from' => "\u{ff13}", 'to' => '3'], // FULLWIDTH DIGIT THREE
        ['from' => "\u{ff14}", 'to' => '4'], // FULLWIDTH DIGIT FOUR
        ['from' => "\u{ff15}", 'to' => '5'], // FULLWIDTH DIGIT FIVE
        ['from' => "\u{ff16}", 'to' => '6'], // FULLWIDTH DIGIT SIX
        ['from' => "\u{ff17}", 'to' => '7'], // FULLWIDTH DIGIT SEVEN
        ['from' => "\u{ff18}", 'to' => '8'], // FULLWIDTH DIGIT EIGHT
        ['from' => "\u{ff19}", 'to' => '9'], // FULLWIDTH DIGIT NINE
        ['from' => "\u{02d0}", 'to' => ' =>'], // MODIFIER LETTER TRIANGULAR COLON
        ['from' => "\u{02f8}", 'to' => ' =>'], // MODIFIER LETTER RAISED COLON
        ['from' => "\u{2982}", 'to' => ' =>'], // Z NOTATION TYPE COLON
        ['from' => "\u{a789}", 'to' => ' =>'], // MODIFIER LETTER COLON
        ['from' => "\u{fe13}", 'to' => ' =>'], // PRESENTATION FORM FOR VERTICAL COLON
        ['from' => "\u{ff1a}", 'to' => ' =>'], // FULLWIDTH COLON
        ['from' => "\u{204f}", 'to' => ';'], // REVERSED SEMICOLON
        ['from' => "\u{fe14}", 'to' => ';'], // PRESENTATION FORM FOR VERTICAL SEMICOLON
        ['from' => "\u{fe54}", 'to' => ';'], // SMALL SEMICOLON
        ['from' => "\u{ff1b}", 'to' => ';'], // FULLWIDTH SEMICOLON
        ['from' => "\u{fe64}", 'to' => '<'], // SMALL LESS-THAN SIGN
        ['from' => "\u{ff1c}", 'to' => '<'], // FULLWIDTH LESS-THAN SIGN
        ['from' => "\u{0347}", 'to' => '='], // COMBINING EQUALS SIGN BELOW
        ['from' => "\u{a78a}", 'to' => '='], // MODIFIER LETTER SHORT EQUALS SIGN
        ['from' => "\u{fe66}", 'to' => '='], // SMALL EQUALS SIGN
        ['from' => "\u{ff1d}", 'to' => '='], // FULLWIDTH EQUALS SIGN
        ['from' => "\u{fe65}", 'to' => '>'], // SMALL GREATER-THAN SIGN
        ['from' => "\u{ff1e}", 'to' => '>'], // FULLWIDTH GREATER-THAN SIGN
        ['from' => "\u{fe16}", 'to' => '?'], // PRESENTATION FORM FOR VERTICAL QUESTION MARK
        ['from' => "\u{fe56}", 'to' => '?'], // SMALL QUESTION MARK
        ['from' => "\u{ff1f}", 'to' => '?'], // FULLWIDTH QUESTION MARK
        ['from' => "\u{ff21}", 'to' => 'A'], // FULLWIDTH LATIN CAPITAL LETTER A
        ['from' => "\u{1d00}", 'to' => 'A'], // LATIN LETTER SMALL CAPITAL A
        ['from' => "\u{ff22}", 'to' => 'B'], // FULLWIDTH LATIN CAPITAL LETTER B
        ['from' => "\u{0299}", 'to' => 'B'], // LATIN LETTER SMALL CAPITAL B
        ['from' => "\u{ff23}", 'to' => 'C'], // FULLWIDTH LATIN CAPITAL LETTER C
        ['from' => "\u{1d04}", 'to' => 'C'], // LATIN LETTER SMALL CAPITAL C
        ['from' => "\u{ff24}", 'to' => 'D'], // FULLWIDTH LATIN CAPITAL LETTER D
        ['from' => "\u{1d05}", 'to' => 'D'], // LATIN LETTER SMALL CAPITAL D
        ['from' => "\u{ff25}", 'to' => 'E'], // FULLWIDTH LATIN CAPITAL LETTER E
        ['from' => "\u{1d07}", 'to' => 'E'], // LATIN LETTER SMALL CAPITAL E
        ['from' => "\u{ff26}", 'to' => 'F'], // FULLWIDTH LATIN CAPITAL LETTER F
        ['from' => "\u{a730}", 'to' => 'F'], // LATIN LETTER SMALL CAPITAL F
        ['from' => "\u{ff27}", 'to' => 'G'], // FULLWIDTH LATIN CAPITAL LETTER G
        ['from' => "\u{0262}", 'to' => 'G'], // LATIN LETTER SMALL CAPITAL G
        ['from' => "\u{ff28}", 'to' => 'H'], // FULLWIDTH LATIN CAPITAL LETTER H
        ['from' => "\u{029c}", 'to' => 'H'], // LATIN LETTER SMALL CAPITAL H
        ['from' => "\u{ff29}", 'to' => 'I'], // FULLWIDTH LATIN CAPITAL LETTER I
        ['from' => "\u{026a}", 'to' => 'I'], // LATIN LETTER SMALL CAPITAL I
        ['from' => "\u{ff2a}", 'to' => 'J'], // FULLWIDTH LATIN CAPITAL LETTER J
        ['from' => "\u{1d0a}", 'to' => 'J'], // LATIN LETTER SMALL CAPITAL J
        ['from' => "\u{ff2b}", 'to' => 'K'], // FULLWIDTH LATIN CAPITAL LETTER K
        ['from' => "\u{1d0b}", 'to' => 'K'], // LATIN LETTER SMALL CAPITAL K
        ['from' => "\u{ff2c}", 'to' => 'L'], // FULLWIDTH LATIN CAPITAL LETTER L
        ['from' => "\u{029f}", 'to' => 'L'], // LATIN LETTER SMALL CAPITAL L
        ['from' => "\u{ff2d}", 'to' => 'M'], // FULLWIDTH LATIN CAPITAL LETTER M
        ['from' => "\u{1d0d}", 'to' => 'M'], // LATIN LETTER SMALL CAPITAL M
        ['from' => "\u{ff2e}", 'to' => 'N'], // FULLWIDTH LATIN CAPITAL LETTER N
        ['from' => "\u{0274}", 'to' => 'N'], // LATIN LETTER SMALL CAPITAL N
        ['from' => "\u{ff2f}", 'to' => 'O'], // FULLWIDTH LATIN CAPITAL LETTER O
        ['from' => "\u{1d0f}", 'to' => 'O'], // LATIN LETTER SMALL CAPITAL O
        ['from' => "\u{ff30}", 'to' => 'P'], // FULLWIDTH LATIN CAPITAL LETTER P
        ['from' => "\u{1d18}", 'to' => 'P'], // LATIN LETTER SMALL CAPITAL P
        ['from' => "\u{ff31}", 'to' => 'Q'], // FULLWIDTH LATIN CAPITAL LETTER Q
        ['from' => "\u{ff32}", 'to' => 'R'], // FULLWIDTH LATIN CAPITAL LETTER R
        ['from' => "\u{0280}", 'to' => 'R'], // LATIN LETTER SMALL CAPITAL R
        ['from' => "\u{ff33}", 'to' => 'S'], // FULLWIDTH LATIN CAPITAL LETTER S
        ['from' => "\u{a731}", 'to' => 'S'], // LATIN LETTER SMALL CAPITAL S
        ['from' => "\u{ff34}", 'to' => 'T'], // FULLWIDTH LATIN CAPITAL LETTER T
        ['from' => "\u{1d1b}", 'to' => 'T'], // LATIN LETTER SMALL CAPITAL T
        ['from' => "\u{ff35}", 'to' => 'U'], // FULLWIDTH LATIN CAPITAL LETTER U
        ['from' => "\u{1d1c}", 'to' => 'U'], // LATIN LETTER SMALL CAPITAL U
        ['from' => "\u{ff36}", 'to' => 'V'], // FULLWIDTH LATIN CAPITAL LETTER V
        ['from' => "\u{1d20}", 'to' => 'V'], // LATIN LETTER SMALL CAPITAL V
        ['from' => "\u{ff37}", 'to' => 'W'], // FULLWIDTH LATIN CAPITAL LETTER W
        ['from' => "\u{1d21}", 'to' => 'W'], // LATIN LETTER SMALL CAPITAL W
        ['from' => "\u{ff38}", 'to' => 'X'], // FULLWIDTH LATIN CAPITAL LETTER X
        ['from' => "\u{ff39}", 'to' => 'Y'], // FULLWIDTH LATIN CAPITAL LETTER Y
        ['from' => "\u{028f}", 'to' => 'Y'], // LATIN LETTER SMALL CAPITAL Y
        ['from' => "\u{ff3a}", 'to' => 'Z'], // FULLWIDTH LATIN CAPITAL LETTER Z
        ['from' => "\u{1d22}", 'to' => 'Z'], // LATIN LETTER SMALL CAPITAL Z
        ['from' => "\u{02c6}", 'to' => '^'], // MODIFIER LETTER CIRCUMFLEX ACCENT
        ['from' => "\u{0302}", 'to' => '^'], // COMBINING CIRCUMFLEX ACCENT
        ['from' => "\u{ff3e}", 'to' => '^'], // FULLWIDTH CIRCUMFLEX ACCENT
        ['from' => "\u{1dcd}", 'to' => '^'], // COMBINING DOUBLE CIRCUMFLEX ABOVE
        ['from' => "\u{2774}", 'to' => '{'], // MEDIUM LEFT CURLY BRACKET ORNAMENT
        ['from' => "\u{fe5b}", 'to' => '{'], // SMALL LEFT CURLY BRACKET
        ['from' => "\u{ff5b}", 'to' => '{'], // FULLWIDTH LEFT CURLY BRACKET
        ['from' => "\u{2775}", 'to'  => '}'], // MEDIUM RIGHT CURLY BRACKET ORNAMENT
        ['from' => "\u{fe5c}", 'to'  => '}'], // SMALL RIGHT CURLY BRACKET
        ['from' => "\u{ff5d}", 'to'  => '}'], // FULLWIDTH RIGHT CURLY BRACKET
        ['from' => "\u{ff3b}", 'to' => '['], // FULLWIDTH LEFT SQUARE BRACKET
        ['from' => "\u{ff3d}", 'to' => ']'], // FULLWIDTH RIGHT SQUARE BRACKET
        ['from' => "\u{02dc}", 'to' => '~'], // SMALL TILDE
        ['from' => "\u{02f7}", 'to' => '~'], // MODIFIER LETTER LOW TILDE
        ['from' => "\u{0303}", 'to' => '~'], // COMBINING TILDE
        ['from' => "\u{0330}", 'to' => '~'], // COMBINING TILDE BELOW
        ['from' => "\u{0334}", 'to' => '~'], // COMBINING TILDE OVERLAY
        ['from' => "\u{223c}", 'to' => '~'], // TILDE OPERATOR
        ['from' => "\u{ff5e}", 'to' => '~'], // FULLWIDTH TILDE
        ['from' => "\u{00a0}", 'to' => '  '], // NO-BREAK SPACE
        ['from' => "\u{2000}", 'to' => '  '], // EN QUAD
        ['from' => "\u{2002}", 'to' => '  '], // EN SPACE
        ['from' => "\u{2003}", 'to' => '  '], // EM SPACE
        ['from' => "\u{2004}", 'to' => '  '], // THREE-PER-EM SPACE
        ['from' => "\u{2005}", 'to' => '  '], // FOUR-PER-EM SPACE
        ['from' => "\u{2006}", 'to' => '  '], // SIX-PER-EM SPACE
        ['from' => "\u{2007}", 'to' => '  '], // FIGURE SPACE
        ['from' => "\u{2008}", 'to' => '  '], // PUNCTUATION SPACE
        ['from' => "\u{2009}", 'to' => '  '], // THIN SPACE
        ['from' => "\u{200a}", 'to' => '  '], // HAIR SPACE
        ['from' => "\u{202f}", 'to' => '  '], // NARROW NO-BREAK SPACE
        ['from' => "\u{205f}", 'to' => '  '], // MEDIUM MATHEMATICAL SPACE
        ['from' => "\u{3000}", 'to' => '  '], // IDEOGRAHPIC SPACE
        ['from' => "\u{008d}", 'to' => '  '], // REVERSE LINE FEED (standard LF looks like \n, this looks like a space)
        ['from' => "\u{009f}", 'to' => '  '], // <control>
        ['from' => "\u{0080}", 'to' => '  '], // C1 CONTROL CODES
        ['from' => "\u{0090}", 'to' => '  '], // DEVICE CONTROL STRING
        ['from' => "\u{009b}", 'to' => '  '], // CONTROL SEQUENCE INTRODUCER
        ['from' => "\u{0010}", 'to' => ''], // ESCAPE, DATA LINK (not visible)
        ['from' => "\u{0009}", 'to' => '       '], // TAB (7 spaces based on print statement in Python interpreter)
        ['from' => "\u{0000}", 'to' => ''], // NULL
        ['from' => "\u{0003}", 'to' => ''], // END OF TEXT
        ['from' => "\u{0004}", 'to' => ''], // END OF TRANSMISSION
        ['from' => "\u{0017}", 'to' => ''], // END OF TRANSMISSION BLOCK
        ['from' => "\u{0019}", 'to' => ''], // END OF MEDIUM
        ['from' => "\u{0011}", 'to' => ''], // DEVICE CONTROL ONE
        ['from' => "\u{0012}", 'to' => ''], // DEVICE CONTROL TWO
        ['from' => "\u{0013}", 'to' => ''], // DEVICE CONTROL THREE
        ['from' => "\u{0014}", 'to' => ''], // DEVICE CONTROL FOUR
        ['from' => "\u{2060}", 'to' => ''], // WORD JOINER
        ['from' => "\u{2017}", 'to' => "'"], // Horizontal ellipsis
        ['from' => "\u{2014}", 'to' => '-'], // Single low-9 quotation mark
        ['from' => "\u{2013}", 'to' => '-'], // Single high-reversed-9 quotation mark
        ['from' => "\u{2039}", 'to' => '>'], // Single left-pointing angle quotation mark
        ['from' => "\u{203A}", 'to' => '<'], // Single right-pointing angle quotation mark
        ['from' => "\u{203C}", 'to' => '!!'], // Double exclamation mark
        ['from' => "\u{201E}", 'to' => '"'], // Double low line
        ['from' => "\u{2028}", 'to' => ' '], // Whitespace => Line Separator
        ['from' => "\u{2029}", 'to' => ' '], // Whitespace => Paragraph Separator
        ['from' => "\u{2026}", 'to' => '...'], // Whitespace => Narrow No-Break Space
        ['from' => "\u{2001}", 'to' => ' '], // Whitespace => Medium Mathematical Space
        ['from' => "\u{200b}", 'to' => ''], // ZERO WIDTH SPACE
        ['from' => "\u{3001}", 'to' => ','], // IDEOGRAPHIC COMMA
        ['from' => "\u{FEFF}", 'to' => ''], // ZERO WIDTH NO-BREAK SPACE
        ['from' => "\u{2022}", 'to' => '-'], // Bullet
    ];

    public static function encode(string $text): string
    {
        return implode('', array_map(function ($char) {
            return self::get($char) ?? $char;
        }, mb_str_split($text)));
    }
}