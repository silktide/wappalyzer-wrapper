<?php

namespace Silktide\WappalyzerWrapper;

use Silktide\WappalyzerWrapper\Result\Result;
use Silktide\WappalyzerWrapper\Result\ResultProcessor;

class Client
{

    /**
     * @var CommandFactory
     */
    protected $commandFactory;

    /**
     * @var ResultProcessor
     */
    protected $resultProcessor;

    /**
     * Client constructor.
     * @param CommandFactory $commandFactory
     * @param ResultProcessor $resultProcessor
     */
    public function __construct(CommandFactory $commandFactory, ResultProcessor $resultProcessor)
    {
        $this->commandFactory = $commandFactory;
        $this->resultProcessor = $resultProcessor;
    }

    /**
     * @param string $url
     * @return Result
     * @throws \Exception
     */
    public function analyse(string $url)
    {

        $path = realpath(__DIR__.'/../node_modules/wappalyzer/index.js');

        $command = $this->commandFactory->create('nodejs '.$path.' '.$url);

        if (!$command->execute()) {
            throw new \Exception("Failed to execute");
        }

        $jsonOutput = $command->getOutput();
        $result = $this->resultProcessor->parse($jsonOutput);

        return $result;

    }
}