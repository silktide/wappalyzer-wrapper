<?php

namespace Silktide\WappalyzerWrapper\Result;

class Result
{

    /**
     * @var TechnologyResult[]
     */
    protected $technologyResults = [];

    /**
     * @param int $minimumConfidenceLevel
     * @return array
     */
    public function getTechnologyResults($minimumConfidenceLevel = 1): array
    {
        $filteredResults = [];

        foreach ($this->technologyResults as $technologyResult) {

            $confidence = $technologyResult->getConfidence();

            if ($confidence < $minimumConfidenceLevel) {
                continue;
            }

            $filteredResults[] = $technologyResult;
        }

        return $filteredResults;
    }

    /**
     * @param TechnologyResult[] $technologyResults
     */
    public function setTechnologyResults(array $technologyResults)
    {
        $this->technologyResults = [];

        foreach ($technologyResults as $technologyResult) {
            $this->addTechnologyResult($technologyResult);
        }
    }

    /**
     * @param TechnologyResult $technologyResult
     */
    public function addTechnologyResult(TechnologyResult $technologyResult)
    {
        $this->technologyResults[] = $technologyResult;
    }

    /**
     * @param string $category
     * @return TechnologyResult[]
     */
    public function getTechnologyResultsByCategory(string $category)
    {
        $return = [];

        foreach ($this->technologyResults as $result) {
            if (in_array($category, $result->getCategories())) {
                $return[] = $result;
            }
        }

        return $return;
    }

}