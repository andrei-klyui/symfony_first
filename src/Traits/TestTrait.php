<?php

namespace App\Traits;

use GuzzleHttp\Client;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait TestTrait
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function loginToApi()
    {
        $http = new Client();
        $response = $http->post('https://apptest.wearepentagon.com/devInterview/API/en/access-token', [
            'form_params' => [
                'client_id' => 'devtask',
                'client_secret' => 'Ye97T%c!CGZ*7$52',
            ],
        ]);

        $responseStatus = $response->getStatusCode();

        if ($responseStatus !== 200) {
            throw new HttpException(400, "Error receiving the token, please try again after some time!");
        }

        $response = json_decode((string) $response->getBody(), true);

        return $token = $response['access_token'];
    }

    public function decodeGetPars($token): array
    {
        $http = new Client();
        $response = $http->post('https://apptest.wearepentagon.com/devInterview/API/en/get-random-test-feed', [
            'headers' => [
                'Authorization' => $token,
            ],
        ]);

        $responseStatus = $response->getStatusCode();

        if ($responseStatus !== 200) {
            throw new HttpException(400, "Error get string, please try again after some time!");
        }

        $new = json_decode((string) $response->getBody(), true);
        $new2 = explode( ':', $new);
        $new3 = explode('||', $new2[1]);
        $items = [];

        foreach ($new3 as $item) {
            preg_match('/(.*?)\{(.*)\}.*/i', $item, $match);
            $items[$match[1]] = $match[2];
        }

        return array($new2[0], $items);
    }
}