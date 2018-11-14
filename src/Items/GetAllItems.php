<?php

namespace WalmartMarketplaceApi\Items;

use GuzzleHttp\ClientInterface;
use WalmartMarketplaceApi\Client\Core;

class GetAllItems extends Core
{
    public function __construct($client_id, $client_secret, $consumer_id, $channel_type, ?ClientInterface $httpClient = null)
    {
        parent::__construct($client_id, $client_secret, $consumer_id, $channel_type, $httpClient);
    }
} // End class BulkUpload
