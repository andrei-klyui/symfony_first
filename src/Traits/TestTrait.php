<?php

namespace App\Traits;

use GuzzleHttp\Client;

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