<?php

namespace WalmartMarketplaceApi\Prices;

use WalmartMarketplaceApi\Client\Core;
use WalmartMarketplaceApi\Interfaces\PricesApiEndpointInterface;

class UpdatePrice extends Core implements PricesApiEndpointInterface
{
    public function sendRequest($accessToken, $updateFile)
    {
        // Build the Auth headers for this request.
        $apiHeaders = $this->baseApiHeaders;
        $apiHeaders['headers']['Content-Type'] = 'application/xml';
        $apiHeaders['headers']['Accept'] = 'application/xml';
        $apiHeaders['headers']['WM_SEC.ACCESS_TOKEN'] = $accessToken;

        $apiHeaders['body'] = file_get_contents($updateFile);

        $response = $this->httpClient->request('PUT', self::API_URL, $apiHeaders);

        $statusCode = $response->getStatusCode();

        switch ($statusCode)
        {
            case 200:
                return (string) $response->getBody();
                break;
        }
    } // End public function sendRequest
} // End class UpdatePrice
