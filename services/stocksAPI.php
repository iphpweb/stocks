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

    const STOCK_LOGO_FOLDER = '/static/stock_logo/';

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
            return 00.00;

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
            return 00.00;

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

        $logo_name = strtoupper($ticker) . '.png';
        $logo_path = self::STOCK_LOGO_FOLDER . $logo_name;

        if (file_exists($logo_path)) {
            return $logo_path;
        }

        $uri      = 'stock/' . $ticker . '/logo';
        $uri     .= '?token=' . self::PUBLIC_KEY;
        $response = self::makeRequest($uri);

        $jsonString = (string)$response->getBody();
        $response   = \GuzzleHttp\json_decode($jsonString, true);

        file_put_contents(DOCUMENT_ROOT . self::STOCK_LOGO_FOLDER . $logo_name, file_get_contents((string) $response['url']));

        return $logo_path;
    }
}
