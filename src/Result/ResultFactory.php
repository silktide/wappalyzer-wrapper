<?php

namespace Silktide\WappalyzerWrapper\Result;

class ResultFactory
{
    /**
     * @return Result
     */
    public function create()
    {
        return new Result();
    }
}