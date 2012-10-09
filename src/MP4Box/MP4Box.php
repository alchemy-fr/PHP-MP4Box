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
use MP4Box\Exception\InvalidFileArgumentException;
use MP4Box\Exception\LogicException;
use MP4Box\Exception\RuntimeException;
use MP4Box\Exception\BinaryNotFoundException;
use Symfony\Component\Process\ProcessBuilder;
use Symfony\Component\Process\ExecutableFinder;

class MP4Box
{
    protected $pathfile;
    protected $binary;

    /**
     *
     * @var Logger
     */
    protected $logger;

    public function __construct($binary, Logger $logger = null)
    {
        if (!is_executable($binary)) {
            throw new BinaryNotFoundException(sprintf('`%s` does not seem to be executable', $binary));
        }

        $this->binary = $binary;

        if (!$logger) {
            $logger = new Logger('default');
            $logger->pushHandler(new NullHandler());
        }

        $this->logger = $logger;
    }

    public function open($pathfile)
    {
        if (!file_exists($pathfile)) {
            $this->logger->addError(sprintf('Request to open %s failed', $pathfile));

            throw new InvalidFileArgumentException(sprintf('File %s does not exists', $pathfile));
        }

        $this->logger->addInfo(sprintf('MP4Box opens %s', $pathfile));

        $this->pathfile = $pathfile;

        return $this;
    }

    public function process($outPathfile = null)
    {
        if (!$this->pathfile) {
            throw new LogicException('No file open');
        }

        $builder = ProcessBuilder::create(array(
            $this->binary, '-quiet', '-inter', '0.5', '-tmp', dirname($this->pathfile), $this->pathfile,
        ));

        if ($outPathfile) {
            $builder->add('-out')->add($outPathfile);
        }

        $process = $builder->getProcess();

        try {
            $process->run();
        } catch (\RuntimeException $e) {
            throw new RuntimeException(sprintf('Command %s failed', $process->getCommandline()));
        }

        if (!$process->isSuccessful()) {
            throw new RuntimeException(sprintf('Command %s failed', $process->getCommandline()));
        }

        return $this;
    }

    public function close()
    {
        $this->pathfile = null;

        return $this;
    }

    public static function load(Logger $logger = null)
    {
        $finder = new ExecutableFinder();

        if (null === $binary = $finder->find('MP4Box')) {
            throw new BinaryNotFoundException('Binary not found');
        }

        return new static($binary, $logger);
    }
}
