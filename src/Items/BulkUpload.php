<?php

declare(strict_types=1);

namespace WalmartMarketplaceApi\Items;

use GuzzleHttp\ClientInterface;
use WalmartMarketplaceApi\Client\Core;

class BulkUpload extends Core
{
    private $url;

    public function __construct($client_id, $client_secret, $consumer_id, $channel_type, ?ClientInterface $httpClient = null)
    {
        parent::__construct($client_id, $client_secret, $consumer_id, $channel_type, $httpClient);

        // Set the apiUrl
        $this->apiUrl = 'https://marketplace.walmartapis.com/v3/feeds';
    }

    public function getAccessToken()
    {
        $this->retrieveTokenHeaders['form_params'] = [
            'grant_type' => 'client_credentials'
        ];

        $response = $this->httpClient->request('POST', self::TOKEN_API_URL, $this->retrieveTokenHeaders);

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
    }

    public function UploadFile($file)
    {
        $accessToken = $this->getAccessToken($this->baseApiHeaders, $this->httpClient);

        // Finish building the Auth headers for this request.
        $this->baseApiHeaders['headers']['Content-Type'] = 'multipart/formdata';
        $this->baseApiHeaders['headers']['Accept'] = 'application/xml';
        $this->baseApiHeaders['headers']['WM_SEC.ACCESS_TOKEN'] = $accessToken;

        // Set the query string params
        $this->baseApiHeaders['query'] = [
            'feedType' => 'item'
        ];

        // Attach the XML file
        $this->baseApiHeaders['body'] = file_get_contents($file);

        $response = $this->httpClient->request('POST', $this->apiUrl, $this->baseApiHeaders);

        $statusCode = $response->getStatusCode();

        switch ($statusCode)
        {
            case 200:
                return (string) $response->getBody();
                break;
        }
    }
} // End class BulkUpload
