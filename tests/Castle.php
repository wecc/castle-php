<?php

abstract class Castle_TestCase extends \PHPUnit\Framework\TestCase
{
    public function setUp(): void
    {
        Castle::setApiKey('secret');
    }

    public function assertRequest($method, $url, $headers = null)
    {
        $request = Castle_RequestTransport::getLastRequest();
        $this->assertEquals($method, $request['method']);
        $this->assertEquals(Castle_Request::apiUrl($url), $request['url']);
        if (is_array($headers)) {
            foreach ($headers as $key => $value) {
                $this->assertArrayHasKey($key, $request['headers']);
                $this->assertEquals($request['headers'][$key], $value);
            }
        }
        return $request;
    }
}

require(dirname(__FILE__) . '/../src/Castle/Castle.php');
require(dirname(__FILE__) . '/../src/Castle/Errors.php');
require(dirname(__FILE__) . '/CookieStore.php');
require(dirname(__FILE__) . '/../src/RestModel/Resource.php');
require(dirname(__FILE__) . '/../src/RestModel/Model.php');
require(dirname(__FILE__) . '/../src/Castle/Models/Authenticate.php');
require(dirname(__FILE__) . '/../src/Castle/Models/Review.php');
require(dirname(__FILE__) . '/../src/Castle/Models/Context.php');
require(dirname(__FILE__) . '/TestTransport.php');
require(dirname(__FILE__) . '/../src/Castle/RequestContext.php');
require(dirname(__FILE__) . '/../src/Castle/Request.php');
