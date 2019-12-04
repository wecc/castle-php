<?php

class Castle_RequestTransport
{
    public $rBody;
    public $rHeaders;
    public $rStatus;
    public $rError;
    public $rMessage;

    private static $params = [];

    private static $lastRequest = [];

    public function send($method, $url, $payload)
    {
        if (empty(self::$params)) {
            self::setResponse(200, '{}');
        }
        $headers = ['Content-Type' => 'application/json'];
        $headers_array = [];
        foreach ($headers as $header) {
            preg_match('#(.*?)\:\s(.*)#', $header, $matches);
            if (!empty($matches[1])) {
                $headers_array[$matches[1]] = $matches[2];
            }
        }
        $body = empty($payload) ? null : $payload;
        self::$lastRequest[] = [
        'method'  => $method,
        'headers' => $headers_array,
        'params'  => $body,
        'url'     => $url
        ];
        $params = array_pop(self::$params);
        $this->rBody = $params['body'];
        $this->rStatus = $params['code'];
        $this->rHeaders = $params['headers'];
    }

    public static function getLastRequest()
    {
        return array_pop(self::$lastRequest);
    }

    public static function reset()
    {
        self::$lastRequest = [];
        self::$params = [];
    }

    public static function setResponse($code = 200, $body = '', $headers = [])
    {
        if (is_array($body)) {
            $body = json_encode($body, true);
        }
        self::$params[] = [
        'body' => $body,
        'code' => $code,
        'headers' => $headers
        ];
    }
}
