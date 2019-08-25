<?php

namespace PES;

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
    const SECRET_KEY = 'sk_025d17e97b5e4ee78a69af4db7153eed';
    const PUBLIC_KEY = 'pk_58d5a81de6b1482ebb2d94d830380c43';

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

    /**
     * Makes the request and handles any exceptions that the IEXTrading.com system might return.
     *
     * @param $method
     * @param $uri
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \DPRMC\IEXTrading\Exceptions\UnknownSymbol
     * @throws \Exception
     */
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

    public static function getPrice($ticker = null)
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

    public static function stockLogo($ticker)
    {
        $uri      = 'stock/' . $ticker . '/logo';
        $uri     .= '?token=' . self::PUBLIC_KEY;
        $response = self::makeRequest($uri);

        return $response['url'];
    }
}
