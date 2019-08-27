<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class StocksAPI
{
    const ENDPOINT_URL = 'https://cloud.iexapis.com/';
    const ENDPOINT_VERSION = 'stable'; // beta // v1
    const ENDPOINT_REQUEST_METHOD = 'GET';

    /**
     * iex api cloud keys
     * secret & public
     */
    const SECRET_KEY = SECRET_IEX_KEY;
    const PUBLIC_KEY = PUBLIC_IEX_KEY;

    private static $url = self::ENDPOINT_URL . self::ENDPOINT_VERSION . '/';

    /**
     * Set up and return a GuzzleHttp Client with some default settings.
     * @return \GuzzleHttp\Client
     */
    protected static function getClient()
    {
        return new Client([
            'verify'   => false,
            'base_uri' => self::$url,
        ]);
    }

    protected static function makeRequest($uri)
    {
        $client = self::getClient();

        try {
            return $client->request(self::ENDPOINT_REQUEST_METHOD, $uri);
        } catch (ClientException $clientException) {
            if ('Unknown symbol' == $clientException->getResponse()->getBody()) {
                throw new Exception(__CLASS__ . " replied with: " . $clientException->getResponse()->getBody());
            }

            throw $clientException;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public static function getPrice(string $ticker = null) : float
    {
        if ($ticker == null)
            return false;

        $uri        = 'stock/' . $ticker . '/price';
        $uri       .= '?token=' . self::PUBLIC_KEY;
        $response   = self::makeRequest($uri);

        $jsonString = (string)$response->getBody();
        $price      = \GuzzleHttp\json_decode($jsonString, true);

        return (float)$price;
    }

    public static function getQuote(string $ticker = null) : float
    {
        if ($ticker == null)
            return false;

        $uri      = 'stock/' . $ticker . '/quote';
        $uri     .= '?token=' . self::PUBLIC_KEY;
        $response = self::makeRequest($uri);

        $jsonString = (string)$response->getBody();
        $response   = \GuzzleHttp\json_decode($jsonString, true);

        return (float)$response['latestPrice'];
    }

    public static function getLogo(string $ticker = null) : string
    {
        if ($ticker == null)
            return false;

        $uri      = 'stock/' . $ticker . '/logo';
        $uri     .= '?token=' . self::PUBLIC_KEY;
        $response = self::makeRequest($uri);

        $jsonString = (string)$response->getBody();
        $response   = \GuzzleHttp\json_decode($jsonString, true);

        return (string)$response['url'];
    }
}
