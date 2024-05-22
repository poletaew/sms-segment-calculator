<?php

declare(strict_types=1);

namespace Poletaew\SmsSegmentCalculator\Tests;

use PHPUnit\Framework\TestCase;
use Poletaew\SmsSegmentCalculator\Constants\SizeInBits;
use Poletaew\SmsSegmentCalculator\Enums\SmsEncoding;
use Poletaew\SmsSegmentCalculator\Helpers\SmartEncodeMapper;
use Poletaew\SmsSegmentCalculator\Models\SegmentedMessage;

/**
 * @internal
 *
 * @covers \Poletaew\SmsSegmentCalculator\Models\SegmentedMessage
 */
class SegmentedMessageTest extends TestCase
{
    const GSM7_ESCAPE_CHARS = ['|', '^', '€', '{', '}', '[', ']', '~', '\\'];

    const TEST_DATA = [
        [
            'testDescription' => 'GSM-7 in one segment',
            'body' => '1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890',
            'encoding' => 'GSM-7',
            'segments' => 1,
            'messageSize' => 1120,
            'totalSize' => 1120,
            'characters' => 160,
            'unicodeScalars' => 160,
        ],
        [
            'testDescription' => 'GSM-7 in two segments',
            'body' => '12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901',
            'encoding' => 'GSM-7',
            'segments' => 2,
            'messageSize' => 1127,
            'totalSize' => 1223,
            'characters' => 161,
            'unicodeScalars' => 161,
        ],
        [
            'testDescription' => 'GSM-7 in three segments',
            'body' => '1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567',
            'encoding' => 'GSM-7',
            'segments' => 3,
            'messageSize' => 2149,
            'totalSize' => 2293,
            'characters' => 307,
            'unicodeScalars' => 307,
        ],
        [
            'testDescription' => 'UCS-2 message in one segment',
            'body' => '😜23456789012345678901234567890123456789012345678901234567890123456789',
            'encoding' => 'UCS-2',
            'segments' => 1,
            'messageSize' => 1120,
            'totalSize' => 1120,
            'characters' => 69,
            'unicodeScalars' => 69,
        ],
        [
            'testDescription' => 'UCS-2 message in two segments',
            'body' => '😜234567890123456789012345678901234567890123456789012345678901234567890',
            'encoding' => 'UCS-2',
            'segments' => 2,
            'messageSize' => 1136,
            'totalSize' => 1232,
            'characters' => 70,
            'unicodeScalars' => 70,
        ],
        [
            'testDescription' => 'UCS-2 message in three segments',
            'body' => '😜2345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234',
            'encoding' => 'UCS-2',
            'segments' => 3,
            'messageSize' => 2160,
            'totalSize' => 2304,
            'characters' => 134,
            'unicodeScalars' => 134,
        ],
        [
            'testDescription' => 'UCS-2 with two bytes extended characters in one segments boundary',
            'body' => '🇮🇹234567890123456789012345678901234567890123456789012345678901234567',
            'encoding' => 'UCS-2',
            'segments' => 1,
            'messageSize' => 1120,
            'totalSize' => 1120,
            'characters' => 67,
            'unicodeScalars' => 68,
        ],
        [
            'testDescription' => 'UCS-2 with extended characters in two segments boundary',
            'body' => '🇮🇹2345678901234567890123456789012345678901234567890123456789012345678',
            'encoding' => 'UCS-2',
            'segments' => 2,
            'messageSize' => 1136,
            'totalSize' => 1232,
            'characters' => 68,
            'unicodeScalars' => 69,
        ],
        [
            'testDescription' => 'UCS-2 with four bytes extended characters in one segments boundary',
            'body' => '🏳️‍🌈2345678901234567890123456789012345678901234567890123456789012345',
            'encoding' => 'UCS-2',
            'segments' => 1,
            'messageSize' => 1120,
            'totalSize' => 1120,
            'characters' => 65,
            'unicodeScalars' => 68,
        ],
        [
            'testDescription' => 'UCS-2 with four bytes extended characters in two segments boundary',
            'body' => '🏳️‍🌈23456789012345678901234567890123456789012345678901234567890123456',
            'encoding' => 'UCS-2',
            'segments' => 2,
            'messageSize' => 1136,
            'totalSize' => 1232,
            'characters' => 66,
            'unicodeScalars' => 69,
        ],
    ];

    //100% OK
    public function testSmartEncoding()
    {
        foreach (SmartEncodeMapper::MAP as $item) {
            $segmentedMessage = new SegmentedMessage($item['from'], 'auto', true);
            $result = implode('', $segmentedMessage->getGraphemes());
            $this->assertEquals($item['to'], $result);

            $segmentedMessage = new SegmentedMessage((string)$item['from'], 'auto', false);
            $result = implode('', $segmentedMessage->getGraphemes());
            $this->assertEquals($item['from'], $result);
        }

        $testString = implode('', array_column(SmartEncodeMapper::MAP, 'from'));
        $expected = implode('', array_column(SmartEncodeMapper::MAP, 'to'));

        $segmentedMessage = new SegmentedMessage($testString, 'auto', true);
        $this->assertEquals($expected, implode('', $segmentedMessage->getGraphemes()));
    }

    //Failed on "😜23456789012345678901234567890123456789012345678901234567890123456789"
    public function testBasic()
    {
        foreach (self::TEST_DATA as $testMessage) {
            $segmentedMessage = new SegmentedMessage($testMessage['body']);

            $this->assertEquals($testMessage['encoding'], $segmentedMessage->getRealEncodingName());
            $this->assertCount($testMessage['segments'], $segmentedMessage->getSegments());
            $this->assertEquals($testMessage['segments'], $segmentedMessage->getSegmentsCount());
            $this->assertEquals($testMessage['messageSize'], $segmentedMessage->getMessageSize());
            $this->assertEquals($testMessage['totalSize'], $segmentedMessage->getTotalSize());
            $this->assertEquals($testMessage['unicodeScalars'], $segmentedMessage->getNumberOfUnicodeScalars());
            $this->assertEquals($testMessage['characters'], $segmentedMessage->getNumberOfCharacters());
        }
    }

    //100% OK
    public function testGSM7EscapeChars()
    {
        foreach (self::GSM7_ESCAPE_CHARS as $escapeChar) {
            $message = "{$escapeChar}12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678";
            $segmentedMessage = new SegmentedMessage($message);
            $this->assertEquals(SmsEncoding::GSM7->value, $segmentedMessage->getRealEncodingName());
            $this->assertCount(1, $segmentedMessage->getSegments());
            $this->assertEquals(1, $segmentedMessage->getSegmentsCount());
            $this->assertEquals(SizeInBits::MAX_MESSAGE_SIZE, $segmentedMessage->getMessageSize());
            $this->assertEquals(SizeInBits::MAX_MESSAGE_SIZE, $segmentedMessage->getTotalSize());

            $message = "{$escapeChar}123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789";
            $segmentedMessage = new SegmentedMessage($message);
            $this->assertEquals(SmsEncoding::GSM7->value, $segmentedMessage->getRealEncodingName());
            $this->assertCount(2, $segmentedMessage->getSegments());
            $this->assertEquals(2, $segmentedMessage->getSegmentsCount());
            $this->assertEquals(1127, $segmentedMessage->getMessageSize());
            $this->assertEquals(1223, $segmentedMessage->getTotalSize());
        }
    }

    //100% OK
    public function testOneGraphemeUCS2Characters()
    {
        $testCharacters = ['Á', 'Ú', 'ú', 'ç', 'í', 'Í', 'ó', 'Ó'];
        foreach ($testCharacters as $character) {
            $testMessage = str_repeat($character, 70);
            $segmentedMessage = new SegmentedMessage($testMessage);
            $this->assertEquals(1, $segmentedMessage->getSegmentsCount());

            foreach ($segmentedMessage->getEncodedChars() as $encodedChar) {
                $this->assertFalse($encodedChar->isGSM7());
            }

            $testMessage = str_repeat($character, 71);
            $segmentedMessage = new SegmentedMessage($testMessage);
            $this->assertEquals(2, $segmentedMessage->getSegmentsCount());
            foreach ($segmentedMessage->getEncodedChars() as $encodedChar) {
                $this->assertFalse($encodedChar->isGSM7());
            }
        }
    }

    //Failed on "😀]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]"
    public function testSpecial()
    {
        $testMessage = '😀]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]';
        $segmentedMessage = new SegmentedMessage($testMessage);
        $this->assertEquals(1, $segmentedMessage->getSegmentsCount());

        $testMessage = '😀]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]';
        $segmentedMessage = new SegmentedMessage($testMessage);
        $this->assertEquals(2, $segmentedMessage->getSegmentsCount());
    }

    //100% OK
    public function testLineBreakStyles()
    {
        $testMessage = "\rabcde\r\n123";
        $segmentedMessage = new SegmentedMessage($testMessage);
        $this->assertEquals(11, $segmentedMessage->getNumberOfCharacters());

        $testMessage = "\nabcde\n\n123\n";
        $segmentedMessage = new SegmentedMessage($testMessage);
        $this->assertEquals(12, $segmentedMessage->getNumberOfCharacters());

        $testMessage = 'é́́';
        $segmentedMessage = new SegmentedMessage($testMessage);
        $this->assertEquals(1, $segmentedMessage->getNumberOfCharacters());
        $this->assertEquals(4, $segmentedMessage->getNumberOfUnicodeScalars());

        $testMessage = 'é́́aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $segmentedMessage = new SegmentedMessage($testMessage);
        $this->assertEquals(1, $segmentedMessage->getSegmentsCount());

        $testMessage = 'é́́aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $segmentedMessage = new SegmentedMessage($testMessage);
        $this->assertEquals(2, $segmentedMessage->getSegmentsCount());
    }
}
