<?php

namespace Ilya5445\PayeerApi\Response;

use Ilya5445\PayeerApi\Exception\InvalidJsonException;

class ApiResponse implements \ArrayAccess {

    protected $statusCode;
    protected $rawResponse;
    protected $response;

    public function __construct($statusCode, $responseBody = null, $dlFact = FALSE) {
        
        $this->statusCode = (int) $statusCode;
        $this->rawResponse = $responseBody;

        if (!empty($responseBody)) {
            if(!$dlFact) {
                $response = json_decode($responseBody, true);

                if (!$response && JSON_ERROR_NONE !== ($error = json_last_error())) {
                    throw new InvalidJsonException(
                        "Invalid JSON in the API response body. Error code #$error",
                        $error
                    );
                }
            } else $response = $responseBody;

            if (!$response['success']) {
                // throw new \Exception($response['error']);
            }

            $this->response = $response;
        }
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getResponseBody()
    {
        return $this->rawResponse;
    }

    public function isSuccessful()
    {
        return $this->statusCode < 400;
    }

    public function __call($name, $arguments) {
        $propertyName = strtolower(substr($name, 3, 1)) . substr($name, 4);

        if (!isset($this->response[$propertyName])) {
            throw new \InvalidArgumentException("Method \"$name\" not found");
        }

        return $this->response[$propertyName];
    }

    public function __get($name) {
        if (!isset($this->response[$name])) {
            throw new \InvalidArgumentException("Property \"$name\" not found");
        }

        return $this->response[$name];
    }

    public function __isset($name) {
        return isset($this->response[$name]);
    }
   
    public function offsetSet($offset, $value) {
        throw new \BadMethodCallException('This activity not allowed');
    }

    public function offsetUnset($offset) {
        throw new \BadMethodCallException('This call not allowed');
    }

    public function offsetExists($offset) {
        return isset($this->response[$offset]);
    }
   
    public function offsetGet($offset) {
        if (!isset($this->response[$offset])) {
            throw new \InvalidArgumentException("Property \"$offset\" not found");
        }

        return $this->response[$offset];
    }
}

