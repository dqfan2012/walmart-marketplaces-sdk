<?php

declare(strict_types=1);

namespace WalmartMarketplaceApi\Feeds;

use WalmartMarketplaceApi\Client\Core;
use WalmartMarketplaceApi\Interfaces\FeedsApiEndpointInterface;

class AllFeedStatuses extends Core implements FeedsApiEndpointInterface
{
    private function sanitizeFeedId($feedId)
    {
        return urlencode($feedId);
    } // End private function sanitizeFeedId


    public function sendRequest($accessToken, $feedId, $includeDetails = false, $limit = null, $offset = null)
    {
        // Build the Auth headers for this request.
        $apiHeaders = $this->baseApiHeaders;
        $apiHeaders['headers']['Content-Type'] = 'multipart/formdata';
        $apiHeaders['headers']['Accept'] = 'application/xml';
        $apiHeaders['headers']['WM_SEC.ACCESS_TOKEN'] = $accessToken;

        // Sanitize the feedId
        if (is_array($feedId) === true)
        {
            $feedId = array_map(array('FeedItemStatus', 'sanitizeFeedId'), $feedId);
        } else {
            $feedId = $this->sanitizeFeedId($feedId);
        }

        // Set the query string params
        $apiHeaders['query']['feedId'] = $feedId;

        // The includeDetails parameter isn't directly documented for this API call. However,
        // limit and offset are documented for this API call and they make a reference to this
        // parameter. So, I'm assuming that this parameter should be documented and included with
        // this call if we want additional details.
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
} // End class AllFeedStatuses
