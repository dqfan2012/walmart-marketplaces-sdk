<?php

declare(strict_types=1);

namespace WalmartMarketplaceApi\Feeds;

use WalmartMarketplaceApi\Client\Core;
//use WalmartMarketplaceApi\Interfaces\FeedsApiEndpointInterface;

class FeedStatus extends Core
{
    public function sendRequest($accessToken, $feedId, $includeDetails = false, $limit = null, $offset = null)
    {
        // Build the endpoint URL - This is hardcoded because it's the only request
        // in the Feeds API that uses v2 of the API. Will be replaced with the FeedsApiEndpointInterface
        // once the feed is officially using v3
        $url = 'https://marketplace.walmartapis.com/v2/feeds/' . urlencode($feedId);

        // Build the Auth headers for this request.
        $apiHeaders = $this->baseApiHeaders;
        $apiHeaders['headers']['Content-Type'] = 'multipart/formdata';
        $apiHeaders['headers']['Accept'] = 'application/xml';
        $apiHeaders['headers']['WM_SEC.ACCESS_TOKEN'] = $accessToken;

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

        $response = $this->httpClient->request('GET', $url, $apiHeaders);

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
