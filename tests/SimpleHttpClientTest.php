<?php

declare(strict_types=1);

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\SimpleHttpClient\SimpleHttpClient;

/**
 * Class SimpleHttpClientTest
 * @package App\Tests
 */
class SimpleHttpClientTest extends TestCase
{
    public function testConstructor(): void
    {
        $url = 'http://example.com';
        $client = new SimpleHttpClient($url);
        self::assertEquals($url, $client->getUrl());
    }
}