#PHP MP4Box

[![Build Status](https://secure.travis-ci.org/alchemy-fr/PHP-MP4Box.png?branch=master)](http://travis-ci.org/alchemy-fr/PHP-MP4Box)

PHP driver for MP4Box

## API usage

To instantiate MP4Box driver, the easiest way is :

```php
$mp4box = MP4Box\MP4Box::create();
```

You can customize your driver by passing a `Psr\Log\LoggerInterface` or
configuration options.

Available options are :

 - timeout : the timeout for the underlying process

```php
$mp4box = MP4Box\MP4Box::create($logger, array('timeout' => 42));
```

To process a mp4 file, use the `process` method :

```php
$mp4box->process('video.mp4');
```

If you do not want to process file in place, you can write the output in another
file :

```php
$mp4box->process('video.mp4', 'output.mp4');
```

## Silex Service Provider :

A [Silex](silex.sensiolabs.org) Service Provider is available, all parameters are optionals :

```php
$app = new Silex\Application();
$app->register(new MP4Box\MP4BoxServiceProvider(), array(
    'mp4box.logger'  => $app->share(function () { return $app['monolog']; }), // use Monolog service provider
    'mp4box.binary'  => '/path/to/custom/binary',
    'mp4box.timeout' => 42,
));
```

## License

MIT licensed

