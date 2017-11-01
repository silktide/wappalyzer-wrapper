<?php

namespace Silktide\WappalyzerWrapper\Test\Result;

use PHPUnit\Framework\TestCase;
use Silktide\WappalyzerWrapper\Result\Result;
use Silktide\WappalyzerWrapper\Result\TechnologyResult;

class ResultTest extends TestCase
{
    public function testResult()
    {
        $mockTechnologyResult1 = $this->getMockBuilder(TechnologyResult::class)->getMock();
        $mockTechnologyResult2 = $this->getMockBuilder(TechnologyResult::class)->getMock();

        $result = new Result();
        $result->addTechnologyResult($mockTechnologyResult1);
        $result->addTechnologyResult($mockTechnologyResult2);

        $results = $result->getTechnologyResults();

        $this->assertEquals(2, count($results));
        $this->assertContains($mockTechnologyResult1, $results);
        $this->assertContains($mockTechnologyResult2, $results);

    }
}