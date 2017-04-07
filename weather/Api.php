<?php
namespace app\weather;

use yii\httpclient\Client;

class Api
{
    const VERSION = 1;
    const URI = 'https://api.weathersource.com';

    private $access_token;

    /**
     * Api constructor.
     * @param $access_token
     */
    public function __construct($access_token)
    {
        $this->access_token = $access_token;
    }

    /**
     * Can make query to api
     *
     * @param $method
     * @param $format
     * @param array $params
     * @return array
     * @throws ApiException
     */
    public function query($method, $format, $params = [])
    {
        $client = new Client();

        $uri = implode('/', [
            self::URI,
            'v' . self::VERSION,
            $this->access_token,
            $method . '.' . $format . '?' . http_build_query($params)
        ]);

        $request = $client->createRequest()
            ->setMethod('GET')
            ->setUrl($uri);

        $response = $request->send();

        if ($response->isOk)
        {
            return $response->data;
        }
        else
        {
            throw new ApiException($response->statusCode . '. ' . $response->data['message'] . ' Request Uri: ' . $uri);
        }
    }
}