<?php

declare(strict_types=1);

namespace App\Tests;

use function PHPUnit\Framework\assertEquals;
use PHPUnit\Framework\TestCase;
use App\SimpleHttpClient\SimpleHttpClient;

/**
 * Class SimpleHttpClientTest
 * @package App\Tests
 */
class SimpleHttpClientTest extends TestCase
{
    /**
     * @group Unit
     * @group Unit.Client
     */
    public function testConstructor(): void
    {
        $url = 'http://example.com';
        $header = [
            'Content-type' => 'application/json'
        ];
        $client = new SimpleHttpClient($url);
        self::assertEquals($url, $client->getUrl());
        self::assertEquals($header, $client->getHeader());
    }

    /**
     * @group Unit
     * @group Unit.Client
     * @group Unit.Client.Header
     */
    public function testGetSetHeader(): void
    {
        $header = [
          'Content-type' => 'text/xml'
        ];
        $client = new SimpleHttpClient('');
        $client->setHeader($header);
        self::assertEquals($header, $client->getHeader());
        $newHeader = [
            'Accept' => 'application/xml'
        ];
        $client->setHeader($newHeader);
        self::assertEquals(
            array_merge($header, $newHeader),
            $client->getHeader()
        );
    }

    /**
     * @group Unit
     * @group Unit.Client
     * @group Unit.Client.Header
     */
    public function testFormatHeader(): void
    {
        $header = [
            'Content-type' => 'text/xml',
            'Accept' => 'application/xml'
        ];

        $expected = "Content-type: text/xml\r\nAccept: application/xml\r\n";
        $client = new SimpleHttpClient('');
        $client->setHeader($header);
        self::assertEquals($expected, $client->formatHeader());
    }
}