<?php

declare(strict_types=1);

namespace WalmartMarketplaceApi\Feeds;

use WalmartMarketplaceApi\Client\Core;
use WalmartMarketplaceApi\Interfaces\FeedsApiEndpointInterface;

/**
 * This class is technically listed beneath the Items API in Walmart's documentation,
 * but it uses the Feeds API endpoint. So I classified this API Request as a Feeds Request
 */
class BulkUpload extends Core implements FeedsApiEndpointInterface
{
    /**
     *
     */
    public function sendRequest(string $accessToken, string $file)
    {
        // Build the Auth headers for this request.
        $apiHeaders = $this->baseApiHeaders;
        $apiHeaders['headers']['Content-Type'] = 'multipart/formdata';
        $apiHeaders['headers']['Accept'] = 'application/xml';
        $apiHeaders['headers']['WM_SEC.ACCESS_TOKEN'] = $accessToken;

        // Set the query string params
        $apiHeaders['query'] = [
            'feedType' => 'item'
        ];

        // Attach the XML file
        $apiHeaders['body'] = file_get_contents($file);

        $response = $this->httpClient->request('POST', self::API_URL, $apiHeaders);

        $statusCode = $response->getStatusCode();

        switch ($statusCode)
        {
            case 200:
                return (string) $response->getBody();
                break;
        }
    } // End public function UploadFile
} // End class BulkUpload
