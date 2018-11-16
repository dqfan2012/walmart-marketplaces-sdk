<?php

namespace Test\Client;

use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use WalmartMarketplaceApi\Feeds\BulkUpload;

/**
 * We're using the Item API > Bulk Uploads Request to test the Access Token API. It'll work
 * the same regardless of the API being used.
 */
class AccessTokenTest extends TestCase
{
    /**
     *
     */
    public function testWeCanGetAnAccessToken()
    {
        $channel_type  = getenv('WALMART_CHANNEL_TYPE');
        $client_id     = getenv('WALMART_CLIENT_ID');
        $client_secret = getenv('WALMART_CLIENT_SECRET');
        $consumer_id   = getenv('WALMART_CONSUMER_ID');

        $mockClient = \Mockery::mock(ClientInterface::class);

        $mockClient->shouldReceive('request')->andReturns(new \GuzzleHttp\Psr7\Response(200, [],'{
            "access_token": "eyJraWQiOiJkZDk2MDZiNC0wNjVkLTQ5YmQtYTc5OC1kNWFmNzJlM2M5YTAiLCJlbmMiOiJBMjU2R0NNIiwiYWxnIjoiZGlyIn0..-XYkTSspnM3OzBP_.L1HjV3G4mLB81_B2FkkkXMZ3ySQeUZb0Yp0omxEsjttTgmRPYUUVFzevuOYae2wjDTUW__MwKCbwjQzmgrxgyz2-A5U1aIVdkfE4vSGHJ4NwSIC_yn2kxXlz9LZ9-_oz7aBEJijqGQieuhAzzZ8dt-Mu6YmfvqC9iqRWausRE4g29SI4T25BcV9UduU5h5IFBy88AW45Lt3hVaRmjjnq1KU9zCslhvLzdXadSokbGJHyWSgYli-5oKsiDKIm5Iv_aY73MFfiOYYXAePTpKhB8KRvb4FEohHYjZJyZUuOB9r14R7a-eo140I0z1yhhH_5FW4FaWUdc6AWFtjsfAJ2p0r8zLF-uFZ_fGYuOFFdQajiPAT0BQCTEneXUSEH_Lez82U1FVfCPe4Mj17IfdN6cbbPWD60JmaB9uaaVrJ2sRovlm-0p0MP9LYYpCfxyj-hRkebRge4cFkkfGHgcHVYEWdUAD7YKXPPuP_q1dkxFgzH63d1LAckUvg8CGuWwbaREizSUFtfQtwjPHb7sT2P8XoNPWkg-Ej_-tUSzazZDVk4ejp5b4RbltV5dfA9p4pGKO4TRs8mhoSTJWY6f8JVKWamUj0uqti8IzjtMQw5c5yFMwd3m3Q3h1x8TOwtuo8yy3Cws2ZdjkTAn3oQcA0c0_7Jl1G253ews8bFoWPxEh6nxsdeTNgMNY1crK1I.BETgkXDP8wp6bdnGy0UE6g",
            "token_type": "Bearer",
            "expires_in": 900
        }'));

        $bulkUpload = new BulkUpload($client_id, $client_secret, $consumer_id, $channel_type, $mockClient);

        $this->assertNotEmpty($bulkUpload->getAccessToken());
    }


    /**
     *
     */
    public function testAuthIsMissingClientIdHeader()
    {
        $channel_type  = getenv('WALMART_CHANNEL_TYPE');
        $client_id     = null;
        $client_secret = getenv('WALMART_CLIENT_SECRET');
        $consumer_id   = getenv('WALMART_CONSUMER_ID');

        $mockClient = \Mockery::mock(ClientInterface::class);

        $mockClient->shouldReceive('request')->andReturns(new \GuzzleHttp\Psr7\Response(401, [],'{
            "error": "invalid_client",
            "error_description": "Bad client credentials"
        }'));

        $bulkUpload = new BulkUpload($client_id, $client_secret, $consumer_id, $channel_type, $mockClient);

        $this->expectException(\Exception::class);

        $accessToken = $bulkUpload->getAccessToken();
    }


    /**
     *
     */
    public function testAuthHasInvalidHeaders()
    {
        $channel_type  = getenv('WALMART_CHANNEL_TYPE');
        $client_id     = getenv('WALMART_CLIENT_ID');
        $client_secret = getenv('WALMART_CLIENT_SECRET');
        $consumer_id   = getenv('WALMART_CONSUMER_ID');

        $mockClient = \Mockery::mock(ClientInterface::class);

        $mockClient->shouldReceive('request')->andReturns(new \GuzzleHttp\Psr7\Response(400, [],'{
            "error": [
                {
                    "code": "INVALID_REQUEST_HEADER.GMP_GATEWAY_API",
                    "field": "WM_QOS.CORRELATION_ID",
                    "description": "WM_QOS.CORRELATION_ID set blank or null",
                    "info": "One or more request headers are invalid.",
                    "severity": "ERROR",
                    "category": "DATA",
                    "causes": [],
                    "errorIdentifiers": {}
                }
            ]
        }'));

        $bulkUpload = new BulkUpload($client_id, $client_secret, $consumer_id, $channel_type, $mockClient);

        $this->expectException(\Exception::class);

        $accessToken = $bulkUpload->getAccessToken();
    }
} // End class BulkUpload
