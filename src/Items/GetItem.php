<?php

declare(strict_types=1);

namespace WalmartMarketplaceApi\Items;

use WalmartMarketplaceApi\Client\Core;
use WalmartMarketplaceApi\Interfaces\ItemsApiEndpointInterface;

class GetItem extends Core implements ItemsApiEndpointInterface
{
    public function sendRequest(string $accessToken, string $sku)
    {
        $url = self::API_URL . "/{$sku}";

        // Build the Auth headers for this request.
        $apiHeaders = $this->baseApiHeaders;
        $apiHeaders['headers']['Content-Type'] = 'application/xml';
        $apiHeaders['headers']['Accept'] = 'application/xml';
        $apiHeaders['headers']['WM_SEC.ACCESS_TOKEN'] = $accessToken;

        $response = $this->httpClient->request('GET', $url, $apiHeaders);

        $statusCode = $response->getStatusCode();

        switch ($statusCode)
        {
            case 200:
                return (string) $response->getBody();
                break;
        }
    }
} // End class GetItem
