# wappalyzer-wrapper
A simple PHP wrapper for Wappalyzer technology detection

## Simple usage

```php
//Build required classes (can also use DI)
$resultFactory = new \Silktide\WappalyzerWrapper\Result\ResultFactory();
$technologyResultFactory = new \Silktide\WappalyzerWrapper\Result\TechnologyResultFactory();
$parser = new \Silktide\WappalyzerWrapper\Result\ResultProcessor($resultFactory, $technologyResultFactory);
$commandFactory = new \Silktide\WappalyzerWrapper\CommandFactory();
$jsonFileWriter = new \Silktide\WappalyzerWrapper\Request\JsonFileWriter();

// Create client
$client = new \Silktide\WappalyzerWrapper\Client($commandFactory, $parser, $jsonFileWriter);

// Get the analysis results for a site
$result = $client->analyse('https://silktide.com');

// Output all technologies found
foreach ($result->getTechnologyResults() as $technologyResult) {
    echo "\nFound ".$technologyResult->getName();
}

// Output just something from a specific category
foreach ($result->getTechnologyResultsByCategory('Analytics') as $technologyResult) {
    echo "\nFound ".$technologyResult->getName();
}
```
    
## Usage with existing data
This client can also be used with existing page data you already have.  You will need the hostname, URL, response headers, HTML and env vars.  Wappalyzer env vars should be a list of keys from the window object of the page visited, e.g. jQuery, ga.

```php

//Build required classes (can also use DI)
$resultFactory = new \Silktide\WappalyzerWrapper\Result\ResultFactory();
$technologyResultFactory = new \Silktide\WappalyzerWrapper\Result\TechnologyResultFactory();
$parser = new \Silktide\WappalyzerWrapper\Result\ResultProcessor($resultFactory, $technologyResultFactory);
$commandFactory = new \Silktide\WappalyzerWrapper\CommandFactory();
$jsonFileWriter = new \Silktide\WappalyzerWrapper\Request\JsonFileWriter();

// Set up request from existing page data
$existingPageDataRequest = new \Silktide\WappalyzerWrapper\Request\ExistingPageDataRequest();

$existingPageDataRequest->setHostname('example.com');
$existingPageDataRequest->setUrl('https://example.com');
$existingPageDataRequest->addHeader('Content-Type', 'application/json');
$existingPageDataRequest->addEnv('ga');
$existingPageDataRequest->setHtml('<html><head><meta name="generator" content="Amiro"></head><body></body></html>');

// Create client
$client = new \Silktide\WappalyzerWrapper\Client($commandFactory, $parser, $jsonFileWriter);

// Get the analysis results for a site
$result = $client->analyseFromExistingData($existingPageDataRequest);

// Output all technologies found
foreach ($result->getTechnologyResults() as $technologyResult) {
    echo "\nFound ".$technologyResult->getName();
}

// Output just something from a specific category
foreach ($result->getTechnologyResultsByCategory('Analytics') as $technologyResult) {
    echo "\nFound ".$technologyResult->getName();
}


```