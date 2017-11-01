<?php

namespace Silktide\WappalyzerWrapper\Test\Result;

use PHPUnit\Framework\TestCase;
use Silktide\WappalyzerWrapper\Result\TechnologyResult;

class TechnologyResultTest extends TestCase
{
    public function testTechResult()
    {
        $name = "FancyBox";
        $confidence = "100";
        $version = "2.1.5";
        $website = "http://fancyapps.com/fancybox";
        $categories = ["JavaScript Frameworks", "Analytics"];

        $result = new TechnologyResult();
        $result->setName($name);
        $result->setVersion($version);
        $result->setConfidence($confidence);
        $result->setWebsite($website);
        $result->setCategories($categories);

        $this->assertEquals($name, $result->getName());
        $this->assertEquals($version, $result->getVersion());
        $this->assertEquals($confidence, $result->getConfidence());
        $this->assertEquals($website, $result->getWebsite());
        $this->assertEquals($categories, $result->getCategories());

        $result->setCategories([]);
        foreach ($categories as $category) {
            $result->addCategory($category);
        }

        $this->assertEquals($categories, $result->getCategories());
    }
}