# wappalyzer-wrapper
A simple PHP wrapper for Wappalyzer technology detection

## Simple usage

    $resultFactory = new \Silktide\WappalyzerWrapper\Result\ResultFactory();
    $technologyResultFactory = new \Silktide\WappalyzerWrapper\Result\TechnologyResultFactory();
    
    $parser = new \Silktide\WappalyzerWrapper\Result\ResultProcessor($resultFactory, $technologyResultFactory);
    
    $commandFactory = new \Silktide\WappalyzerWrapper\CommandFactory();
    
    $client = new \Silktide\WappalyzerWrapper\Client($commandFactory, $parser);
    
    $result = $client->analyse('https://silktide.com');
    
    foreach ($result->getTechnologyResults() as $technologyResult) {
        echo "\nFound ".$technologyResult->getName();
    }
