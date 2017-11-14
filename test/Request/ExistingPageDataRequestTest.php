<?php

namespace Silktide\WappalyzerWrapper\Test\Request;

use PHPUnit\Framework\TestCase;
use Silktide\WappalyzerWrapper\Request\ExistingPageDataRequest;

class ExistingPageDataRequestTest extends TestCase
{
    public function testExistingPageDataRequest()
    {
        $exampleHeaders = [
            'Content-Type' => 'text/json',
            'Content-Encoding' => 'gzip'
        ];

        $exampleEnv = [
            'jQuery',
            'ga'
        ];

        $exampleHostname = 'hostname.com';

        $exampleUrl = 'https://hostname.com/page.html?var=value';

        $exampleMarkup = '<html></html>';

        $request = new ExistingPageDataRequest();
        $request->setUrl($exampleUrl);
        $request->setEnv($exampleEnv);
        $request->setHeaders($exampleHeaders);
        $request->setHostname($exampleHostname);
        $request->setHtml($exampleMarkup);

        $this->assertEquals($exampleUrl, $request->getUrl());
        $this->assertEquals($exampleHostname, $request->getHostname());
        $this->assertEquals($exampleEnv, $request->getEnv());
        $this->assertEquals($exampleHeaders, $request->getHeaders());
        $this->assertEquals($exampleMarkup, $request->getHtml());

        $asArray = $request->toArray();

        $this->assertArrayHasKey('headers', $asArray);
        $this->assertArrayHasKey('env', $asArray);
        $this->assertArrayHasKey('hostname', $asArray);
        $this->assertArrayHasKey('url', $asArray);

        $this->assertEquals($asArray['url'], $request->getUrl());
        $this->assertEquals($asArray['hostname'], $request->getHostname());
        $this->assertEquals($asArray['env'], $request->getEnv());
        $this->assertEquals($asArray['headers'], $request->getHeaders());
        $this->assertEquals($asArray['html'], $request->getHtml());


    }
}