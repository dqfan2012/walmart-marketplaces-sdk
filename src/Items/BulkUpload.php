<?php

declare(strict_types=1);

namespace WalmartMarketplaceApi\Items;

use WalmartMarketplaceApi\Client\Core;
use WalmartMarketplaceApi\Interfaces\ItemApiEndpointInterface;

class BulkUpload extends Core implements ItemApiEndpointInterface
{
    //const API_URL = 'https://marketplace.walmartapis.com/v3/feeds';

    public function UploadFile(string $file, string $accessToken)
    {
        // Finish building the Auth headers for this request.
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
    }
} // End class BulkUpload
