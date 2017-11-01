<?php

namespace Silktide\WappalyzerWrapper\Test;

use mikehaertl\shellcommand\Command;
use Silktide\WappalyzerWrapper\Client;
use PHPUnit\Framework\TestCase;
use Silktide\WappalyzerWrapper\CommandFactory;
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

        $mockCommandFactory = $this->getMockBuilder(CommandFactory::class)->getMock();
        $mockCommandFactory->expects($this->atLeastOnce())->method('create')->with('node node_modules/wappalyzer/index.js '.$url)->will($this->returnValue($mockCommand));

        $mockResult = $this->getMockBuilder(Result::class)->getMock();

        $resultProcessor = $this->getMockBuilder(ResultProcessor::class)->disableOriginalConstructor()->getMock();
        $resultProcessor->expects($this->exactly(1))->method('parse')->with($json)->willReturn($mockResult);

        $client = new Client($mockCommandFactory, $resultProcessor);
        $actualResult = $client->analyse($url);

        $this->assertEquals($mockResult, $actualResult);
    }
}