<?php
/**
 * Light weight PHP HTTP client
 * Supports GET,POST,OPTIONS requests
 */

declare(strict_types=1);

namespace App\SimpleHttpClient;

use Exception;

/**
 * Class SimpleHttpClient
 */
class SimpleHttpClient
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var array
     */
    protected $header;

    /**
     * SimpleHttpClient constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->setUrl($url);
        $this->setDefaultHeader();
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

    /**
     * @return array
     */
    public function getHeader(): array
    {
        return $this->header;
    }

    /**
     * @param array $header
     */
    public function setHeader(array $header): void
    {
        if (is_array($this->header)) {
            $this->header = array_unique(
                array_merge($this->header, $header)
            );
        } else {
            $this->header = $header;
        }
    }

    /**
     * Setting default header
     */
    private function setDefaultHeader(): void
    {
        $this->setHeader([
            'Content-type' => 'application/json'
        ]);
    }

    /**
     * Format header array to header string
     *
     * @return string
     */
    public function formatHeader(): string
    {
        $headerString = '';
        foreach ($this->getHeader() as $key => $value) {
            $headerString .= $key.': '.$value."\r\n";
        }
        return $headerString;
    }

    /**
     * Get request
     *
     * @param $param
     *
     * @return array
     * @throws Exception
     */
    public function get($param): array
    {
        return $this->formatResponse(
            $this->request('GET', $param)
        );
    }

    /**
     * Post request
     *
     * @param $param
     *
     * @return array
     * @throws Exception
     */
    public function post($param): array
    {
        return $this->formatResponse(
            $this->request('POST', $param)
        );
    }

    /**
     * Options request
     *
     * @return array
     * @throws Exception
     */
    public function options(): array
    {
        return $this->formatResponse(
            $this->request('OPTIONS', [])
        );
    }

    /**
     * Request function
     *
     * @param $method
     * @param array $param
     *
     * @return array
     * @throws Exception
     */
    public function request($method, $param): ?array
    {
        $url  = $this->getUrl();

        if ($method === 'GET') {
            $url .= '?' . http_build_query($param);
        }

        $data = json_encode($param);

        $context = stream_context_create([
            'http' =>  [
                'method'  => $method,
                'header'  => $this->formatHeader() .
                'Content-Length: ' . strlen($data) . "\r\n",
                'content' => $data,
            ]
        ]);

        try {
            $stream = fopen($url, 'r', false, $context);
            return [
                'header'    => stream_get_meta_data($stream),
                'body'      => stream_get_contents($stream)
            ];
        } catch (Exception $e) {
            throw new Exception(
                sprintf('error %s: %s', $e->getCode(), $e->getMessage())
            );
        }
    }

    /**
     * Parse and format response array
     *
     * @param $responseArray
     *
     * @return array
     * @throws Exception
     */
    private function formatResponse($responseArray): array
    {
        $header = [];
        foreach($responseArray['header']['wrapper_data'] as $item) {
            $headerItem = explode(':', $item);
            if (count($headerItem) > 1) {
                $header[$headerItem[0]] = trim($headerItem[1]);
            }
        }

        try {
            $body = json_decode($responseArray['body'], true);
            return [
              'header'  => $header,
              'body'    => $body ?? $responseArray['body']
            ];
        } catch (Exception $e) {
            throw new Exception(
                sprintf('error: %s', $e->getMessage())
            );
        }
    }
}