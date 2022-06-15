<?php

namespace Ilya5445\PayeerApi\Http;

use Ilya5445\PayeerApi\Exception\CurlException;
use Ilya5445\PayeerApi\Exception\InvalidJsonException;
use Ilya5445\PayeerApi\Exception\LimitException;
use Ilya5445\PayeerApi\Response\ApiResponse;

class Request {

    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    protected $url;
    private $secret_key;
    private $api_id;

    public function __construct($url, $api_id, $secret_key) {

        if (false === stripos($url, 'https://')) {
            throw new \InvalidArgumentException(
                'API schema requires HTTPS protocol'
            );
        }

        $this->url = $url;
        $this->api_id = $api_id;
        $this->secret_key = $secret_key;
        
    }

    /**
     * Отправка запроса
     *
     * @param [type] $path
     * @param [type] $method
     * @param array $parameters
     * @param boolean $fullPath
     * @return void
     */
    public function makeRequest(
        $path,
        $method,
        array $parameters = [],
        $fullPath = false
    ) {
        $allowedMethods = [self::METHOD_GET, self::METHOD_POST];

        if (!in_array($method, $allowedMethods, false)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Method "%s" is not valid. Allowed methods are %s',
                    $method,
                    implode(', ', $allowedMethods)
                )
            );
        }

        $url = $fullPath ? $path : $this->url . $path;

        $parameters['ts'] = round(microtime(true) * 1000);
        $json_parameters = json_encode($parameters);

        $sign = hash_hmac('sha256', $path.$json_parameters, $this->secret_key);

        if (self::METHOD_GET === $method && count($parameters)) {
            $url .= '?' . http_build_query($parameters, '', '&');
        }

        $curlHandler = curl_init();
        curl_setopt($curlHandler, CURLOPT_URL, $url);
        curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandler, CURLOPT_FAILONERROR, false);
        curl_setopt($curlHandler, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curlHandler, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curlHandler, CURLOPT_HEADER, false);

        if (self::METHOD_POST === $method) {
            curl_setopt($curlHandler, CURLOPT_POST, true);
            curl_setopt($curlHandler, CURLOPT_POSTFIELDS, $json_parameters);
        }

        curl_setopt($curlHandler, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "API-ID: ".$this->api_id,
            "API-SIGN: ".$sign
        ));
        
        $responseBody = curl_exec($curlHandler);
        $statusCode = curl_getinfo($curlHandler, CURLINFO_HTTP_CODE);

        if ($statusCode == 503) {
            throw new LimitException("Service temporary unavailable");
        }

        $errno = curl_errno($curlHandler);
        $error = curl_error($curlHandler);

        curl_close($curlHandler);

        if ($errno) {
            throw new CurlException($error, $errno);
        }

        return new ApiResponse($statusCode, $responseBody, false);
    }

}
