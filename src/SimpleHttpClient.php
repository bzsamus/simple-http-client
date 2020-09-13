<?php
/**
 * Light weight PHP HTTP client
 *
 */

declare(strict_types=1);

namespace App\SimpleHttpClient;

/**
 * Class SimpleHttpClient
 */
class SimpleHttpClient
{
    protected $url;


    /**
     * SimpleHttpClient constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
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
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}