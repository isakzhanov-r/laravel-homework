<?php


namespace App\Services;


use GuzzleHttp\Client;
use Exception;

class WeatherService
{
    protected $client;

    protected $config;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function vendor(string $vendor)
    {
        $this->config = collect(config('weather.' . $vendor));

        return $this;
    }

    public function get()
    {
        $response = $this->getResponse();

        return json_decode($response->getContents());

    }

    protected function getUrl(): string
    {
        return $this->config->get('url');
    }

    protected function getHeaders(): array
    {
        return $this->config->get('headers');
    }

    protected function getQuery(): array
    {
        return $this->config->get('params');
    }

    protected function getResponse()
    {
        try {
            $result = $this->client->get($this->getUrl(), [
                'verify'  => false,
                'headers' => $this->getHeaders(),
                'query'   => $this->getQuery(),
            ]);

            return $result->getBody();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }
}
