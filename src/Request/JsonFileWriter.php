<?php

namespace Silktide\WappalyzerWrapper\Request;

class JsonFileWriter
{
    protected $basePath = '/tmp/';

    /**
     * @param string $basePath
     */
    protected function setBasePath(string $basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @return string
     */
    protected function getRandomFilename()
    {
        return $this->basePath."wappalyzer_".md5(uniqid()).".json";
    }

    /**
     * @param ExistingPageDataRequest $request
     * @return string
     */
    public function writeToTempFile(ExistingPageDataRequest $request)
    {
        $tmpFilename = $this->getRandomFilename();

        $content = json_encode($request->toArray());
        file_put_contents($tmpFilename, $content);

        return $tmpFilename;
    }
}