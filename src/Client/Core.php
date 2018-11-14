<?php

declare(strict_types=1);

namespace WalmartMarketplaceApi\Client;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

abstract class Core
{
    /**
     * @var string
     */
    protected $apiUrl;

    /**
     * @var array
     */
    protected $baseApiHeaders;

    /**
     * @var string
     */
    protected $credentials;

    /**
     * @var Interface
     */
    protected $httpClient;

    /**
     * @var array
     */
    protected $retrieveTokenHeaders;

    const TOKEN_API_URL = 'https://marketplace.walmartapis.com/v3/token';

    /**
     *
     */
    public function __construct($client_id, $client_secret, $consumer_id, $channel_type, ?ClientInterface $httpClient = null)
    {
        $this->credentials = \base64_encode($client_id . ':' . $client_secret);

        $this->baseApiHeaders = [
            'headers' => [
                'Authorization' => ['Basic ' . $this->credentials],
                'WM_SVC.NAME' => 'Walmart Marketplace',
                'WM_QOS.CORRELATION_ID' => \uniqid(),
                'WM_CONSUMER.ID' => $consumer_id,
                'WM_CONSUMER.CHANNEL.TYPE' => $channel_type
            ]
        ];

        $this->retrieveTokenHeaders = $this->baseApiHeaders;

        $this->retrieveTokenHeaders['headers']['Content-Type'] = 'application/x-www-form-urlencoded';
        $this->retrieveTokenHeaders['headers']['Accept'] = 'application/json';

        $this->httpClient = $httpClient !== null && $httpClient instanceof ClientInterface ? $httpClient : new Client();
    } // End public function __construct


    /**
     *
     */
    abstract function getAccessToken();
} // End abstract class Core
