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
     * List of JS scripts referenced
     *
     * @var string[]
     */
    protected $scripts = [];

    /**
     * List of cookies
     *
     * @var Cookie[]
     */
    protected $cookies = [];

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
        // A key of just "window" seems to break some detections - ignore it
        if ($windowObjectKey === "window") {
            return;
        }

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
     * @return string[]
     */
    public function getScripts(): array
    {
        return $this->scripts;
    }

    /**
     * @param string[] $scripts
     */
    public function setScripts(array $scripts)
    {
        $this->scripts = [];
        foreach ($scripts as $script) {
            $this->addScript($script);
        }
    }

    /**
     * @param string $script
     */
    public function addScript(string $script)
    {
        $this->scripts[] = $script;
    }

    /**
     * @return Cookie[]
     */
    public function getCookies(): array
    {
        return $this->cookies;
    }

    /**
     * @param Cookie[] $cookies
     */
    public function setCookies(array $cookies)
    {
        $this->cookies = [];
        foreach ($cookies as $cookie) {
            $this->addCookie($cookie);
        }
    }

    public function addCookie(Cookie $cookie)
    {
        $this->cookies[] = $cookie;
    }


    /**
     * @return array
     */
    public function toArray()
    {
        $serialisedCookies = [];

        foreach ($this->cookies as $cookie) {
            $serialisedCookies[] = $cookie->toArray();
        }

        return [
            'env' => $this->windowObjectKeys,
            'headers' => $this->headers,
            'url' => $this->url,
            'hostname' => $this->hostname,
            'html' => $this->html,
            'scripts' => $this->scripts,
            'cookies' => $serialisedCookies
        ];
    }

}
