<?php

namespace Silktide\WappalyzerWrapper;

use mikehaertl\shellcommand\Command;

class CommandFactory
{
    /**
     * @param string $command
     * @return Command
     */
    public function create($command)
    {
        return new Command($command);
    }
}