<?php

namespace Silktide\WappalyzerWrapper\Test;

use mikehaertl\shellcommand\Command;
use Silktide\WappalyzerWrapper\Client;
use PHPUnit\Framework\TestCase;
use Silktide\WappalyzerWrapper\CommandFactory;
use Silktide\WappalyzerWrapper\Request\ExistingPageDataRequest;
use Silktide\WappalyzerWrapper\Request\JsonFileWriter;
use Silktide\WappalyzerWrapper\Result\Result;
use Silktide\WappalyzerWrapper\Result\ResultProcessor;

class ClientTest extends TestCase
{
    public function testClient()
    {
        $url = "http://demo.com";
        $json = '[{"json":"something"}]';

        $mockCommand = $this->getMockBuilder(Command::class)->getMock();
        $mockCommand->expects($this->atLeastOnce())->method('execute')->willReturn(true);
        $mockCommand->expects($this->atLeastOnce())->method('getOutput')->willReturn($json);

        $mockJsonFileWriter = $this->getMockBuilder(JsonFileWriter::class)->getMock();

        // Should use path relative to this test
        $path = realpath(__DIR__.'/../node_modules/wappalyzer/index.js');

        $mockCommandFactory = $this->getMockBuilder(CommandFactory::class)->getMock();
        $mockCommandFactory->expects($this->atLeastOnce())->method('create')->with('nodejs '.$path.' '.$url)->will($this->returnValue($mockCommand));

        $mockResult = $this->getMockBuilder(Result::class)->getMock();

        $resultProcessor = $this->getMockBuilder(ResultProcessor::class)->disableOriginalConstructor()->getMock();
        $resultProcessor->expects($this->exactly(1))->method('parse')->with($json)->willReturn($mockResult);

        $client = new Client($mockCommandFactory, $resultProcessor, $mockJsonFileWriter);
        $actualResult = $client->analyse($url);

        $this->assertEquals($mockResult, $actualResult);
    }

    public function testClientWithExistingData()
    {
        $tmpPath = '/tmp/filename.json';

        $examplePageDataRequest = $this->getMockBuilder(ExistingPageDataRequest::class)->getMock();

        $mockJsonFileWriter = $this->getMockBuilder(JsonFileWriter::class)->getMock();
        $mockJsonFileWriter->expects($this->any())->method('writeToTempFile')->with($examplePageDataRequest)->willReturn($tmpPath);

        $json = '[{"json":"something"}]';

        $mockCommand = $this->getMockBuilder(Command::class)->getMock();
        $mockCommand->expects($this->atLeastOnce())->method('execute')->willReturn(true);
        $mockCommand->expects($this->atLeastOnce())->method('getOutput')->willReturn($json);

        // Should use path relative to this test
        $path = realpath(__DIR__.'/../src/wappalyze.js');

        $mockCommandFactory = $this->getMockBuilder(CommandFactory::class)->getMock();
        $mockCommandFactory->expects($this->atLeastOnce())->method('create')->with('nodejs '.$path.' '.$tmpPath)->will($this->returnValue($mockCommand));

        $mockResult = $this->getMockBuilder(Result::class)->getMock();

        $resultProcessor = $this->getMockBuilder(ResultProcessor::class)->disableOriginalConstructor()->getMock();
        $resultProcessor->expects($this->exactly(1))->method('parse')->with($json)->willReturn($mockResult);

        $client = new Client($mockCommandFactory, $resultProcessor, $mockJsonFileWriter);
        $actualResult = $client->analyseFromExistingData($examplePageDataRequest);

        $this->assertEquals($mockResult, $actualResult);
    }
}