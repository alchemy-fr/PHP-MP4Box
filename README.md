#PHP MP4Box

[![Build Status](https://secure.travis-ci.org/alchemy-fr/PHP-MP4Box.png?branch=master)](http://travis-ci.org/alchemy-fr/PHP-MP4Box)

PHP driver for MP4Box

## Example

```php
use MP4Box\MP4Box;

$mp4box = MP4Box::load();
$mp4box->open('video.mp4')
       ->process()
       ->close();

```

## License

MIT licensed

