<?php

namespace Silktide\WappalyzerWrapper\Test\Result;

use PHPUnit\Framework\TestCase;
use Silktide\WappalyzerWrapper\Result\Result;
use Silktide\WappalyzerWrapper\Result\ResultFactory;
use Silktide\WappalyzerWrapper\Result\ResultProcessor;
use Silktide\WappalyzerWrapper\Result\TechnologyResult;
use Silktide\WappalyzerWrapper\Result\TechnologyResultFactory;

class ResultProcessorTest extends TestCase
{
    public function testResultProcessor()
    {
        $exampleResponse = '{"applications":[{"name":"FancyBox","confidence":"100","version":"2.1.5","website":"http://fancyapps.com/fancybox","categories":[{"12":"JavaScript Frameworks"}]},{"name":"Google Analytics","confidence":"100","version":"UA","icon":"Google Analytics.svg","website":"http://google.com/analytics","categories":[{"10":"Analytics"}]}]}';
        $responseJunk = "JQMIGRATE: Migrate is installed, version 1.4.1\n";
        $mockTechnologyResult1 = $this->getMockBuilder(TechnologyResult::class)->getMock();
        $mockTechnologyResult1->expects($this->atLeastOnce())->method('setName')->with('FancyBox');
        $mockTechnologyResult1->expects($this->atLeastOnce())->method('setVersion')->with('2.1.5');
        $mockTechnologyResult1->expects($this->never())->method('setIcon');
        $mockTechnologyResult1->expects($this->atLeastOnce())->method('setWebsite')->with('http://fancyapps.com/fancybox');
        $mockTechnologyResult1->expects($this->atLeastOnce())->method('setConfidence')->with('100');
        $mockTechnologyResult1->expects($this->atLeastOnce())->method('addCategory')->with("JavaScript Frameworks");

        $mockTechnologyResult2 = $this->getMockBuilder(TechnologyResult::class)->getMock();
        $mockTechnologyResult2->expects($this->atLeastOnce())->method('setName')->with('Google Analytics');
        $mockTechnologyResult2->expects($this->atLeastOnce())->method('setVersion')->with('UA');
        $mockTechnologyResult2->expects($this->atLeastOnce())->method('setIcon')->with('Google Analytics.svg');
        $mockTechnologyResult2->expects($this->atLeastOnce())->method('setWebsite')->with('http://google.com/analytics');
        $mockTechnologyResult2->expects($this->atLeastOnce())->method('setConfidence')->with('100');
        $mockTechnologyResult2->expects($this->atLeastOnce())->method('addCategory')->with("Analytics");

        $technologyResultFactory = $this->getMockBuilder(TechnologyResultFactory::class)->getMock();
        $technologyResultFactory->expects($this->exactly(2))->method('create')->willReturnOnConsecutiveCalls($mockTechnologyResult1, $mockTechnologyResult2);


        $mockResult = $this->getMockBuilder(Result::class)->getMock();
        $mockResult->expects($this->exactly(2))->method('addTechnologyResult')->withConsecutive($mockTechnologyResult1, $mockTechnologyResult2);

        $resultFactory = $this->getMockBuilder(ResultFactory::class)->getMock();
        $resultFactory->expects($this->exactly(1))->method('create')->willReturn($mockResult);

        $resultProcessor = new ResultProcessor($resultFactory, $technologyResultFactory);
        $actualResult = $resultProcessor->parse($responseJunk.$exampleResponse);

        $this->assertEquals($mockResult, $actualResult);




    }
}