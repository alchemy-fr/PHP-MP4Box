<?php

namespace MP4Box;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\ExecutableFinder;

class MP4Box
{

    protected $pathfile;
    protected $binary;

    /**
     *
     * @var \Monolog\Logger
     */
    protected $logger;

    public function __construct($binary, \Monolog\Logger $logger = null)
    {
        $this->binary = $binary;

        if ( ! $logger)
        {
            $logger = new \Monolog\Logger('default');
            $logger->pushHandler(new \Monolog\Handler\NullHandler());
        }

        $this->logger = $logger;
    }

    public function open($pathfile)
    {
        if ( ! file_exists($pathfile))
        {
            $this->logger->addError(sprintf('Request to open %s failed', $pathfile));

            throw new Exception\InvalidFileArgumentException(sprintf('File %s does not exists', $pathfile));
        }

        $this->logger->addInfo(sprintf('MP4Box opens %s', $pathfile));

        $this->pathfile = $pathfile;

        return $this;
    }

    public function process(Array $options = null, $outPathfile = null)
    {
        if ( ! $this->pathfile)
        {
            throw new Exception\LogicException('No file open');
        }

        $cmd = sprintf("%s -quiet -inter 0.5 %s"
          , $this->binary
          , escapeshellarg($this->pathfile)
        );

        if ($outPathfile)
        {
            $cmd .= sprintf(' -out %s', escapeshellarg($outPathfile));
        }
        
        try
        {
            $process = new Process($cmd);
            $process->run();
        }
        catch (\RuntimeException $e)
        {
            throw new Exception\RuntimeException(sprintf('Command %s failed', $cmd));
        }

        if ( ! $process->isSuccessful())
        {
            throw new Exception\RuntimeException(sprintf('Command %s failed', $cmd));
        }

        return $this;
    }

    public function close()
    {
        $this->pathfile = null;

        return $this;
    }

    public static function load(\Monolog\Logger $logger = null)
    {
        $finder = new ExecutableFinder();

        if (null === $binary = $finder->find('MP4Box'))
        {
            throw new Exception\BinaryNotFoundException('Binary not found');
        }

        return new static($binary, $logger);
    }

}
