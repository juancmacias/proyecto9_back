<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
    
class LoginTest extends ApiTestCase
{
    public function testSomething(): void
    {
        $response = self::createClient()->request(
            'POST',
            '/api/login_check', [
            'headers' => [
                'Content-Type' => 'application/json'
                        ],
            'json' => [
                'username' => 'juan@juan.com',
                'password' => '1234567'
            ]
            ]);
            $this->assertResponseStatusCodeSame(200);
    }
}
