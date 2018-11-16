<?php

namespace WalmartMarketplaceApi\Items;

use WalmartMarketplaceApi\Client\Core;
use WalmartMarketplaceApi\Interfaces\ItemsApiEndpointInterface;

class GetAllItems extends Core Implements ItemsApiEndpointInterface
{
    public function sendRequest(string $accessToken, string $sku = null, string $nextCursor = '*')
    {
        // Build the Auth headers for this request.
        $apiHeaders = $this->baseApiHeaders;
        $apiHeaders['headers']['Content-Type'] = 'application/xml';
        $apiHeaders['headers']['Accept'] = 'application/xml';
        $apiHeaders['headers']['WM_SEC.ACCESS_TOKEN'] = $accessToken;

        if (is_null($sku))
        {
            // We're getting multiple items. The first call will use the * value for
            // nextCursor. Each subsequent call will use a different nextCursor value
            // so that we can browse through the paginated results.
            $apiHeaders['query'] = [
                'nextCursor' => $nextCursor,
            ];
        } else {
            // We're getting a single item
            $apiHeaders['query'] = [
                'nextCursor' => '*',
                'sku' => $sku,
                'offset' => 0,
                'limit' => 20
            ];
        }

        $response = $this->httpClient->request('GET', self::API_URL, $apiHeaders);

        $statusCode = $response->getStatusCode();

        switch ($statusCode)
        {
            case 200:
                return (string) $response->getBody();
                break;
        }
    } // End public function sendRequest
} // End class GetAllItems
