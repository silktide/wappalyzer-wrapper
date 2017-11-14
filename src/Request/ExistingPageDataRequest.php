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
    protected $url;

    /**
     * @var string
     */
    protected $hostname;

    /**
     * @var string[]
     */
    protected $env = [];

    /**
     * @var string
     */
    protected $html;

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
    public function getEnv(): array
    {
        return $this->env;
    }

    /**
     * @param \string[] $env
     */
    public function setEnv(array $env)
    {
        $this->env = [];
        foreach ($env as $value) {
            $this->addEnv($value);
        }
    }

    /**
     * @param string $value
     */
    public function addEnv(string $value)
    {
        $this->env[] = $value;
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
            'env' => $this->env,
            'headers' => $this->headers,
            'url' => $this->url,
            'hostname' => $this->hostname,
            'html' => $this->html
        ];
    }

}