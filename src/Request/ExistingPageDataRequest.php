<?php

namespace Silktide\WappalyzerWrapper\Request;

class ExistingPageDataRequest
{
    /**
     * @var string[]
     */
    protected $headers = [];

    /**
     * @var string
     */
    protected $url = '';

    /**
     * @var string
     */
    protected $hostname = '';

    /**
     * Wappalyzer requires a list of keys from the window object of the browser
     *
     * @var string[]
     */
    protected $windowObjectKeys = [];

    /**
     * @var string
     */
    protected $html = '';

    /**
     * @return \string[]
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param \string[] $headers
     */
    public function setHeaders(array $headers)
    {
        $this->headers = [];
        foreach ($headers as $key => $value) {
            $this->addHeader($key, $value);
        }
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function addHeader(string $key, string $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getHostname(): string
    {
        return $this->hostname;
    }

    /**
     * @param string $hostname
     */
    public function setHostname(string $hostname)
    {
        $this->hostname = $hostname;
    }

    /**
     * @return \string[]
     */
    public function getWindowObjectKeys(): array
    {
        return $this->windowObjectKeys;
    }

    /**
     * Wappalyzer requires a list of keys from the window object of the browser
     *
     * @param array $windowObjectKeys
     */
    public function setWindowObjectKeys(array $windowObjectKeys)
    {
        $this->windowObjectKeys = [];
        foreach ($windowObjectKeys as $windowObjectKey) {
            $this->addWindowObjectKey($windowObjectKey);
        }
    }

    /**
     * Wappalyzer requires a list of keys from the window object of the browser
     *
     * @param string $windowObjectKey
     */
    public function addWindowObjectKey(string $windowObjectKey)
    {
        $this->windowObjectKeys[] = $windowObjectKey;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return $this->html;
    }

    /**
     * @param string $html
     */
    public function setHtml(string $html)
    {
        $this->html = $html;
    }


    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'env' => $this->windowObjectKeys,
            'headers' => $this->headers,
            'url' => $this->url,
            'hostname' => $this->hostname,
            'html' => $this->html
        ];
    }

}