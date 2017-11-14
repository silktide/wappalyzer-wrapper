<?php

namespace Silktide\WappalyzerWrapper\Result;

class Result
{

    /**
     * @var TechnologyResult[]
     */
    protected $technologyResults = [];

    /**
     * @return TechnologyResult[]
     */
    public function getTechnologyResults(): array
    {
        return $this->technologyResults;
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