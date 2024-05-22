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

echo $segmentedMessage.getRealEncodingName() . PHP_EOL; // "GSM-7"
echo $segmentedMessage.getSegmentsCount(); // "1"
```

## Documentation
### `SegmentedMessage` class

This is the main class exposed by the package

#### [`constructor(message, encoding)`](https://github.com/TwilioDevEd/message-segment-calculator/blob/403313a44ed406b3669cf3c57f32ca98fd92b1e1/src/libs/SegmentedMessage.ts#L37)
Arguments:
* `message`: Body of the SMS
* `encoding`: Optional: encoding. It can be `SmsEncoding` enum value or `auto`. Default value: `auto`

##### `getRealEncodingName()`

Returns the name of the calculated encoding for the message: `GSM-7` or `UCS-2`

#### `getTotalSize()`

Total size of the message in bits (including User Data Header if present)

#### [`messageSize`](https://github.com/TwilioDevEd/message-segment-calculator/blob/403313a44ed406b3669cf3c57f32ca98fd92b1e1/src/libs/SegmentedMessage.ts#L172)

Total size of the message in bits (excluding User Data Header if present)

#### [`segmentsCount`](https://github.com/TwilioDevEd/message-segment-calculator/blob/403313a44ed406b3669cf3c57f32ca98fd92b1e1/src/libs/SegmentedMessage.ts#L184)

Number of segment(s)

### [`getNonGsmCharacters()`]

Return an array with the non GSM-7 characters in the body. It can be used to replace character and reduce the number of segments

## Try the library

If you want to test the library you can use the script provided in `playground/index.js`. Install the dependencies (`npm install`) and then run:

```shell
$ node playground/index.js "👋 Hello World 🌍"
```

## Contributing

This code is open source and welcomes contributions. All contributions are subject to our [Code of Conduct](https://github.com/twilio-labs/.github/blob/master/CODE_OF_CONDUCT.md).

The source code for the library is all contained in the `src` folder. Before submitting a PR:

* Run linter using `npm run lint` command and make sure there are no linter error
* Compile the code using `npm run build` command and make sure there are no errors
* Execute the test using `npm test` and make sure all tests pass
* Transpile the code using `npm run webpack` and test the web page in `docs/index.html`

## License

[MIT](http://www.opensource.org/licenses/mit-license.html)

## Disclaimer

No warranty expressed or implied. Software is as is.

[twilio]: https://www.twilio.com