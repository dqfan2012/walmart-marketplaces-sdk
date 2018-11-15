<?php

declare(strict_types=1);

namespace WalmartMarketplaceApi\Client;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use WalmartMarketplaceApi\Interfaces\TokenApiEndpointInterface;

abstract class Core implements TokenApiEndpointInterface
{
    /**
     * @var array
     */
    protected $baseApiHeaders;

    /**
     * @var Interface
     */
    protected $httpClient;

    /**
     *
     */
    public function __construct($client_id, $client_secret, $consumer_id, $channel_type, ?ClientInterface $httpClient = null)
    {
        $credentials = \base64_encode($client_id . ':' . $client_secret);

        $this->baseApiHeaders = [
            'headers' => [
                'Authorization' => ['Basic ' . $credentials],
                'WM_SVC.NAME' => 'Walmart Marketplace',
                'WM_QOS.CORRELATION_ID' => \uniqid(),
                'WM_CONSUMER.ID' => $consumer_id,
                'WM_CONSUMER.CHANNEL.TYPE' => $channel_type
            ]
        ];

        $this->httpClient = $httpClient !== null && $httpClient instanceof ClientInterface ? $httpClient : new Client();
    } // End public function __construct


    /**
     *
     */
    public function getAccessToken()
    {
        $retrieveTokenHeaders = $this->baseApiHeaders;

        $retrieveTokenHeaders['headers']['Content-Type'] = 'application/x-www-form-urlencoded';
        $retrieveTokenHeaders['headers']['Accept'] = 'application/json';

        $retrieveTokenHeaders['form_params'] = [
            'grant_type' => 'client_credentials'
        ];

        $response = $this->httpClient->request('POST', self::TOKEN_API_URL, $retrieveTokenHeaders);

        $statusCode = $response->getStatusCode();

        switch ($statusCode)
        {
            case 200:
                $resArr = json_decode((string) $response->getBody(), true);
                return $resArr['access_token'];
                break;
            case 400:
                throw new \Exception('One or more request headers are invalid.');
                break;
            case 401:
                throw new \Exception('Bad client credentials.');
                break;
            case 406:
                throw new \Exception('Accept type is invalid.');
                break;
        }
    } // End public function getAccessToken
} // End abstract class Core
