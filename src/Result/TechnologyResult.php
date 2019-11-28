<?php

namespace Silktide\WappalyzerWrapper\Result;

class TechnologyResult
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $confidence;

    /**
     * @var string|null
     */
    protected $version;

    /**
     * @var string|null
     */
    protected $website;

    /**
     * @var string
     */
    protected $icon;

    /**
     * @var string[]
     */
    protected $categories = [];

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getConfidence(): int
    {
        return isset($this->confidence) && is_numeric($this->confidence) ? intval($this->confidence) : 100;
    }

    /**
     * @param string $confidence
     */
    public function setConfidence(string $confidence)
    {
        $this->confidence = $confidence;
    }

    /**
     * @return string|null
     */
    public function getVersion(): ?string
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version)
    {
        $this->version = $version;
    }

    /**
     * @return string|null
     */
    public function getWebsite(): ?string
    {
        return $this->website;
    }

    /**
     * @param string $website
     */
    public function setWebsite(string $website)
    {
        $this->website = $website;
    }

    /**
     * @return \string[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @param \string[] $categories
     */
    public function setCategories(array $categories)
    {
        $this->categories = [];
        foreach ($categories as $category) {
            $this->addCategory($category);
        }
    }

    /**
     * @param string $category
     */
    public function addCategory(string $category)
    {
        $this->categories[] = $category;
    }

    /**
     * @return bool
     */
    public function hasIcon()
    {
        return !empty($this->icon);
    }

    /**
     * @return string|null
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     */
    public function setIcon(string $icon)
    {
        $this->icon = $icon;
    }


}
