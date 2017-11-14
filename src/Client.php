<?php

namespace Silktide\WappalyzerWrapper;

use Silktide\WappalyzerWrapper\Request\ExistingPageDataRequest;
use Silktide\WappalyzerWrapper\Request\JsonFileWriter;
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
     * @var JsonFileWriter
     */
    protected $jsonFileWriter;

    /**
     * Client constructor.
     * @param CommandFactory $commandFactory
     * @param ResultProcessor $resultProcessor
     * @param JsonFileWriter $jsonFileWriter
     */
    public function __construct(CommandFactory $commandFactory, ResultProcessor $resultProcessor, JsonFileWriter $jsonFileWriter)
    {
        $this->commandFactory = $commandFactory;
        $this->resultProcessor = $resultProcessor;
        $this->jsonFileWriter = $jsonFileWriter;
    }

    /**
     * @param string $command
     * @return Result
     * @throws \Exception
     */
    protected function executeCommandAndReturnResult(string $command)
    {
        $command = $this->commandFactory->create($command);

        if (!$command->execute()) {
            throw new \Exception("Failed to execute");
        }

        $jsonOutput = $command->getOutput();
        $result = $this->resultProcessor->parse($jsonOutput);

        return $result;
    }

    /**
     * @param string $url
     * @return Result
     */
    public function analyse(string $url)
    {

        $path = realpath(__DIR__.'/../node_modules/wappalyzer/index.js');
        return $this->executeCommandAndReturnResult('nodejs '.$path.' '.$url);
    }

    /**
     * @param ExistingPageDataRequest $request
     * @return Result
     */
    public function analyseFromExistingData(ExistingPageDataRequest $request)
    {
        $path = realpath(__DIR__.'/../src/wappalyze.js');
        $filename = $this->jsonFileWriter->writeToTempFile($request);
        return $this->executeCommandAndReturnResult('nodejs '.$path.' '.$filename);
    }
}