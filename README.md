# wappalyzer-wrapper
A simple PHP wrapper for Wappalyzer technology detection

## Simple usage

    //Build required classes (can also use DI)
    $resultFactory = new \Silktide\WappalyzerWrapper\Result\ResultFactory();
    $technologyResultFactory = new \Silktide\WappalyzerWrapper\Result\TechnologyResultFactory();
    $parser = new \Silktide\WappalyzerWrapper\Result\ResultProcessor($resultFactory, $technologyResultFactory);
    $commandFactory = new \Silktide\WappalyzerWrapper\CommandFactory();
    
    // Create client
    $client = new \Silktide\WappalyzerWrapper\Client($commandFactory, $parser);
    
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
    
    
