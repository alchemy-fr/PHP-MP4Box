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

use Silex\Application;
use Silex\ServiceProviderInterface;

class MP4BoxServiceProvider implements ServiceProviderInterface
{

    public function register(Application $app)
    {
        $app['mp4box.binary'] = null;
        $app['mp4box.logger'] = null;
        $app['mp4box.timeout'] = 0;

        $app['mp4box'] = $app->share(function(Application $app) {
            if (null !== $app['mp4box.logger']) {
                $logger = $app['mp4box.logger'];
            } else {
                $logger = null;
            }

            if (null === $app['mp4box.binary']) {
                return MP4Box::create($logger, array('timeout' => $app['mp4box.timeout']));
            } else {
                return MP4Box::load($app['mp4box.binary'], $logger, array('timeout' => $app['mp4box.timeout']));
            }
        });
    }

    public function boot(Application $app)
    {
    }
}
