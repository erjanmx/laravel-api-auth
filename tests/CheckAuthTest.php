<?php

namespace Tests\Unit;

use Mockery\Mock;
use phpmock\MockBuilder;
use Apiauth\Laravel\Middleware\CheckAuth;


class CheckAuthTest extends \PHPUnit_Framework_TestCase
{
    const TEST_TOKEN = 'test-token';
    const TEST_SERVICE = 'test_service';
    const TEST_TOKEN_NAME = 'api_token';


    public function setUp()
    {
        parent::setUp();

        $this->auth_client = $this->getMockBuilder(CheckAuth::class)
                                  ->setMethods(['getConfigs'])
                                  ->getMock();

        $this->request_mock = \Mockery::mock();
    }

    public function prepareMock($params)
    {
        $this->auth_client->expects($this->once())
            ->method('getConfigs')
            ->with(self::TEST_SERVICE)
            ->willReturn([
                'token' => isset($params['token']) ? $params['token'] : 'test-token',
                'tokenName' => isset($params['tokenName']) ? $params['tokenName'] : 'api_token',
                'allowJsonToken' => isset($params['allowJsonToken']) ? $params['allowJsonToken'] : false,
                'allowBearerToken' => isset($params['allowBearerToken']) ? $params['allowBearerToken'] : false,
                'allowRequestToken' => isset($params['allowRequestToken']) ? $params['allowRequestToken'] : false,
            ]);
    }

    public function testRequestToken()
    {
        $this->prepareMock(['allowRequestToken' => true]);

        $this->request_mock->shouldReceive('get')->with(self::TEST_TOKEN_NAME)->andReturn(self::TEST_TOKEN);

        $this->assertTrue($this->isAuthorized());
    }

    public function testBearerToken()
    {
        $this->prepareMock(['allowBearerToken' => true]);

        $this->request_mock->shouldReceive('bearerToken')->andReturn(self::TEST_TOKEN);

        $this->assertTrue($this->isAuthorized());
    }

    public function testJsonToken()
    {
        $this->prepareMock(['allowJsonToken' => true]);

        $this->request_mock->shouldReceive('input')->with(self::TEST_TOKEN_NAME)->andReturn(self::TEST_TOKEN);

        $this->assertTrue($this->isAuthorized());
    }

    private function isAuthorized()
    {
        return $this->auth_client->authorized($this->request_mock, self::TEST_SERVICE);
    }
}
