<?php

namespace Silktide\WappalyzerWrapper\Test\Request;

use PHPUnit\Framework\TestCase;
use Silktide\WappalyzerWrapper\Request\ExistingPageDataRequest;
use Silktide\WappalyzerWrapper\Request\JsonFileWriter;

class JsonFileWriterTest extends TestCase
{
    public function testWriter()
    {
        $exampleData = [
            'key' => 'value',
            'another' => [
                'something',
                'else'
            ]
        ];

        $examplePageDataRequest = $this->getMockBuilder(ExistingPageDataRequest::class)->getMock();
        $examplePageDataRequest->expects($this->any())->method('toArray')->willReturn($exampleData);

        $writer = new JsonFileWriter();
        $filename = $writer->writeToTempFile($examplePageDataRequest);

        $contents = file_get_contents($filename);

        $json = json_decode($contents, true);

        $this->assertEquals($exampleData, $json);

    }
}