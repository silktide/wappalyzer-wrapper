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
        $mockTechnologyResult1->expects($this->any())->method("getConfidence")->willReturn(50);
        $mockTechnologyResult2 = $this->getMockBuilder(TechnologyResult::class)->getMock();
        $mockTechnologyResult2->expects($this->any())->method("getConfidence")->willReturn(50);
        $mockTechnologyResult3 = $this->getMockBuilder(TechnologyResult::class)->getMock();
        $mockTechnologyResult3->expects($this->any())->method("getConfidence")->willReturn(10);

        $result = new Result();
        $result->addTechnologyResult($mockTechnologyResult1);
        $result->addTechnologyResult($mockTechnologyResult2);

        $results = $result->getTechnologyResults(15);

        $this->assertEquals(2, count($results));
        $this->assertContains($mockTechnologyResult1, $results);
        $this->assertContains($mockTechnologyResult2, $results);
    }

    public function testGetByCategory()
    {
        $mockTechnologyResult1 = $this->getMockBuilder(TechnologyResult::class)->getMock();
        $mockTechnologyResult2 = $this->getMockBuilder(TechnologyResult::class)->getMock();
        $mockTechnologyResult3 = $this->getMockBuilder(TechnologyResult::class)->getMock();

        $mockTechnologyResult1->expects($this->any())->method('getCategories')->willReturn(["Analytics", "Ecommerce"]);
        $mockTechnologyResult2->expects($this->any())->method('getCategories')->willReturn(["Ecommerce"]);
        $mockTechnologyResult3->expects($this->any())->method('getCategories')->willReturn(["Analytics"]);

        $result = new Result();
        $result->addTechnologyResult($mockTechnologyResult1);
        $result->addTechnologyResult($mockTechnologyResult2);
        $result->addTechnologyResult($mockTechnologyResult3);

        $results = $result->getTechnologyResultsByCategory('Analytics');

        $this->assertContains($mockTechnologyResult1, $results);
        $this->assertContains($mockTechnologyResult3, $results);
        $this->assertNotContains($mockTechnologyResult2, $results);
    }
}