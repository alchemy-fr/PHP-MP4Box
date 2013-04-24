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

use Alchemy\BinaryDriver\AbstractBinary;
use Alchemy\BinaryDriver\ConfigurationInterface;
use MP4Box\Exception\InvalidFileArgumentException;
use MP4Box\Exception\RuntimeException;
use Psr\Log\LoggerInterface;

class MP4Box extends AbstractBinary
{
    public function process($inputFile = null, $outputFile = null)
    {
        if (!file_exists($inputFile) || !is_readable($inputFile)) {
            $this->logger->addError(sprintf('Request to open %s failed', $inputFile));
            throw new InvalidFileArgumentException(sprintf('File %s does not exist or is not readable', $inputFile));
        }

        $arguments = array(
            '-quiet',
            '-inter',
            '0.5',
            '-tmp',
            dirname($inputFile),
            $inputFile,
        );

        if ($outputFile) {
            $arguments[] = '-out';
            $arguments[] = $outputFile;
        }

        $process = $this->factory->create($arguments);

        try {
            $process->run();
        } catch (\RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'MP4Box failed to process %s', $inputFile
            ), $e->getCode(), $e);
        }

        if (!$process->isSuccessful()) {
            throw new RuntimeException(sprintf(
                'MP4Box failed to process %s, command %s is not successful',
                $inputFile,
                $process->getCommandline()
            ));
        }

        return $this;
    }

    /**
     * Creates an MP4Box binary adapter
     *
     * @param null|LoggerInterface $logger
     * @param array|ConfigurationInterface $conf
     *
     * @return MP4Box
     */
    public static function create(LoggerInterface $logger = null, $conf = array())
    {
        return static::load('MP4Box', $logger, $conf);
    }
}
