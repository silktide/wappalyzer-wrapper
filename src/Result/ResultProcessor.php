<?php

namespace Silktide\WappalyzerWrapper\Result;

class ResultProcessor
{
    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var TechnologyResultFactory
     */
    protected $technologyResultFactory;

    public function __construct(ResultFactory $resultFactory, TechnologyResultFactory $technologyResultFactory)
    {
        $this->resultFactory = $resultFactory;
        $this->technologyResultFactory = $technologyResultFactory;
    }

    /**
     * @param string $json
     * @return array
     * @throws \Exception
     */
    protected function extractJsonFromResponse(string $json)
    {
        // Straight up JSON
        $decoded = json_decode($json, true);

        if(!json_last_error()) {
            return $decoded;
        }

        $parts = explode("\n", $json);

        foreach ($parts as $part)
        {
            $decoded = json_decode($part, true);

            if(!json_last_error()) {
                return $decoded;
            }
        }

        throw new \Exception("Invalid JSON returned by Wappalyzer");
    }

    /**
     * @param string $json
     * @return Result
     */
    public function parse(string $json)
    {
        $decodedJson = $this->extractJsonFromResponse($json);

        $result = $this->resultFactory->create();

        foreach ($decodedJson as $technologyItem) {
            $technologyResult = $this->technologyResultFactory->create();
            $technologyResult->setName($technologyItem['name']);
            $technologyResult->setConfidence($technologyItem['confidence']);
            $technologyResult->setWebsite($technologyItem['website']);
            $technologyResult->setVersion($technologyItem['version']);
            if (isset($technologyItem['icon'])) {
                $technologyResult->setIcon($technologyItem['icon']);
            }
            foreach ($technologyItem['categories'] as $category) {
                $actualCategory = array_values($category);
                $technologyResult->addCategory($actualCategory[0]);
            }

            $result->addTechnologyResult($technologyResult);
        }

        return $result;
    }
}