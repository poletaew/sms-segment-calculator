# SMS Segment Calculator

A PHP library that enables you to calculate the message segments used for sending a message on the GSM network. A port of [Twillio's Segment Calculator](https://github.com/TwilioDevEd/message-segment-calculator).

## Usage

### Installation
```shell
composer require poletaew/sms-segment-calculator
```

### Sample usage

```php
use Poletaew\SmsSegmentCalculator\Models\SegmentedMessage;

$segmentedMessage = new SegmentedMessage('Hello World');

echo $segmentedMessage->getRealEncodingName() . PHP_EOL; // "GSM-7"
echo $segmentedMessage->getSegmentsCount(); // "1"
```

## Documentation
### `SegmentedMessage` class

This is the main class exposed by the package

#### [`__construct($message, $encoding, $smartEncoding)`](https://github.com/poletaew/sms-segment-calculator/blob/bbde70b37ce18def7649a3d8330b393d0e3af8e7/src/Models/SegmentedMessage.php#L31C21-L31C117)
Arguments:
* `$message`: Body of the SMS
* `$encoding`: Optional: encoding. It can be `SmsEncoding` enum value or `auto`. Default value: `auto`
* `$smartEncoding`: Optional: if smart encoding enabled. Default value: `false`

##### [`getRealEncodingName()`](https://github.com/poletaew/sms-segment-calculator/blob/bbde70b37ce18def7649a3d8330b393d0e3af8e7/src/Models/SegmentedMessage.php#L67)

Returns the name of the calculated encoding for the message: `GSM-7` or `UCS-2`

#### [`getTotalSize()`](https://github.com/poletaew/sms-segment-calculator/blob/bbde70b37ce18def7649a3d8330b393d0e3af8e7/src/Models/SegmentedMessage.php#L72)

Total size of the message in bits (including User Data Header if present)

#### [`getMessageSize()`](https://github.com/poletaew/sms-segment-calculator/blob/bbde70b37ce18def7649a3d8330b393d0e3af8e7/src/Models/SegmentedMessage.php#L77C21-L77C35)

Total size of the message in bits (excluding User Data Header if present)

#### [`getSegmentsCount`](https://github.com/poletaew/sms-segment-calculator/blob/bbde70b37ce18def7649a3d8330b393d0e3af8e7/src/Models/SegmentedMessage.php#L82C21-L82C37)

Number of segment(s)

#### [`getNonGsmCharacters()`](https://github.com/poletaew/sms-segment-calculator/blob/bbde70b37ce18def7649a3d8330b393d0e3af8e7/src/Models/SegmentedMessage.php#L87C21-L87C40)

Return an array with the non GSM-7 characters in the body. It can be used to replace character and reduce the number of segments

#### [`getNumberOfUnicodeScalars()`](https://github.com/poletaew/sms-segment-calculator/blob/bbde70b37ce18def7649a3d8330b393d0e3af8e7/src/Models/SegmentedMessage.php#L92C21-L92C46)

Number of Unicode scalars

#### [`getNumberOfCharacters()`](https://github.com/poletaew/sms-segment-calculator/blob/bbde70b37ce18def7649a3d8330b393d0e3af8e7/src/Models/SegmentedMessage.php#L97C21-L97C42)

Number of characters

## Contributing

This code is open source and welcomes contributions.

The source code for the library is all contained in the `src` folder. 
Before submitting a PR run Unit test in the directory `test/Unit` and make sure all tests pass.

## License

[MIT](http://www.opensource.org/licenses/mit-license.html)

## Disclaimer

No warranty expressed or implied. Software is as is.
