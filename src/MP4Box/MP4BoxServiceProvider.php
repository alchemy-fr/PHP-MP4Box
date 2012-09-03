<?php

/*
 * This file is part of PHP-MP4Box.
 *
 * (c) Alchemy <info@alchemy.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MP4Box;

use Monolog\Logger;
use Monolog\Handler\NullHandler;
use Silex\Application;
use Silex\ServiceProviderInterface;

class MP4BoxServiceProvider implements ServiceProviderInterface
{

    public function register(Application $app)
    {
        $app['mp4box.binary'] = null;

        $app['mp4box'] = $app->share(function(Application $app) {

            if (isset($app['monolog'])) {
                $logger = $app['monolog'];
            } else {
                $logger = new Logger('mp4box');
                $logger->pushHandler(new NullHandler());
            }

            if (! $app['mp4box.binary']) {
                return MP4Box::load($logger);
            } else {
                return new MP4Box($app['mp4box.binary'], $logger);
            }
        });
    }

    public function boot(Application $app)
    {

    }
}
