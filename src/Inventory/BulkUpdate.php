<?php

declare(strict_types=1);

namespace WalmartMarketplaceApi\Inventory;

use WalmartMarketplaceApi\Client\Core;
use WalmartMarketplaceApi\Interfaces\InventoryApiEndpointInterface;

/**
 * This class is technically listed beneath the Items API in Walmart's documentation,
 * but it uses the Feeds API endpoint. So I classified this API Request as a Feeds Request
 */
class BulkUpdate extends Core implements InventoryApiEndpointInterface
{
    /**
     *
     */
    public function sendRequest(string $accessToken, string $feedFile)
    {
        // Build the Auth headers for this request.
        $apiHeaders = $this->baseApiHeaders;
        $apiHeaders['headers']['Content-Type'] = 'multipart/formdata';
        $apiHeaders['headers']['Accept'] = 'application/xml';
        $apiHeaders['headers']['WM_SEC.ACCESS_TOKEN'] = $accessToken;

        $apiHeaders['query'] = [
            'feedType' => 'inventory'
        ];

        $apiHeaders['body'] = file_get_contents($feedFile);

        $response = $this->httpClient->request('GET', self::API_URL, $apiHeaders);

        $statusCode = $response->getStatusCode();

        switch ($statusCode)
        {
            case 200:
                return (string) $response->getBody();
                break;
        }
    } // End public function sendRequest
} // End class BulkUpdate
