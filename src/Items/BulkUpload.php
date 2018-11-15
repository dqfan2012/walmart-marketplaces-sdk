<?php

declare(strict_types=1);

namespace WalmartMarketplaceApi\Items;

use GuzzleHttp\ClientInterface;
use WalmartMarketplaceApi\Client\Core;
use WalmartMarketplaceApi\Interfaces\ItemApiEndpointInterface;

class BulkUpload extends Core implements ItemApiEndpointInterface
{
    //const API_URL = 'https://marketplace.walmartapis.com/v3/feeds';

    public function UploadFile(string $file, string $accessToken)
    {
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

        $response = $this->httpClient->request('POST', self::API_URL, $this->baseApiHeaders);

        $statusCode = $response->getStatusCode();

        switch ($statusCode)
        {
            case 200:
                return (string) $response->getBody();
                break;
        }
    }
} // End class BulkUpload
