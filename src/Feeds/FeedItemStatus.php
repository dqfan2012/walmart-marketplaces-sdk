<?php

declare(strict_types=1);

namespace WalmartMarketplaceApi\Feeds;

use WalmartMarketplaceApi\Client\Core;
use WalmartMarketplaceApi\Interfaces\FeedsApiEndpointInterface;

class FeedItemStatus extends Core implements FeedsApiEndpointInterface
{



    public function sendRequest($accessToken, $feedId, $includeDetails = false, $limit = null, $offset = null)
    {
        // Build the Auth headers for this request.
        $apiHeaders = $this->baseApiHeaders;
        $apiHeaders['headers']['Content-Type'] = 'multipart/formdata';
        $apiHeaders['headers']['Accept'] = 'application/xml';
        $apiHeaders['headers']['WM_SEC.ACCESS_TOKEN'] = $accessToken;

        // Set the query string params
        $apiHeaders['query']['feedId'] = urlencode($feedId);

        // Set the query string params
        if ($includeDetails === true)
        {
            $apiHeaders['query']['includeDetails'] = $includeDetails;
        }

        // Only use limit if includeDetails is set to true
        if (is_null($limit) === false)
        {
            $apiHeaders['query']['limit'] = $limit;
        }

        // Only use offset if includeDetails is set to true
        if (is_null($offset) === false)
        {
            $apiHeaders['query']['offset'] = $offset;
        }

        $response = $this->httpClient->request('GET', self::API_URL, $apiHeaders);

        $statusCode = $response->getStatusCode();

        /**
         * Successful request returns XML
         */
        switch ($statusCode)
        {
            case 200:
                return (string) $response->getBody();
                break;
        }
    } // End public function sendRequest
} // End class FeedStatus
