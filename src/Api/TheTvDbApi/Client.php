<?php

namespace App\Api\TheTvDbApi;


use App\Api\TheTvDbApi\Login\TheTvDbApiLogger;
use App\Api\TheTvDbApi\Login\TokenManager;
use Exception;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Response\CurlResponse;

class Client
{
    const POSTMethod = 'POST';
    const GETTMethod = 'GET';
    const API_BASE_URI = 'https://api.thetvdb.com';
    /**
     * @type HttpClient
     */
    private $httpClient;
    /**
     * @type string
     */
    private $token;
    /**
     * @type string
     */
    private $language = 'fr';
    /**
     * @var TokenManager
     */
    private $tokenManager;
    /**
     * @var TheTvDbApiLogger
     */
    private $apiLogger;

    public function __construct(
        TokenManager $tokenManager,
        TheTvDbApiLogger $apiLogger
    ) {
        $this->tokenManager = $tokenManager;
        $this->apiLogger = $apiLogger;
        $this->initHttpClient();
        $this->setToken();
    }

    protected function initHttpClient(): void
    {
        $this->httpClient = HttpClient::create(
            [
                'base_uri' => self::API_BASE_URI,
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]
        );
    }

    /**
     * @throws Exception
     */
    protected function setToken(): void
    {
        if (empty($this->tokenManager->get())) {
            $this->apiLogger->loginToGetToken($this);
        }
        $this->token = $this->tokenManager->get();
    }

    /**
     * @param string $method
     * @param string $path
     * @param array $options
     * @return CurlResponse
     */
    public function performApiCall(string $method, string $path, array $options = []): CurlResponse
    {
        $options = $this->getDefaultHttpClientOptions($options);
        $response = $this->httpClient->request($method, $path, $options);

        return $response;
    }

    /**
     * @param array $options
     * @return array
     */
    private function getDefaultHttpClientOptions(array $options = []): array
    {
        $headers = [];

        if ($this->token !== null) {
            $headers['Authorization'] = 'Bearer ' . $this->token;
        }
        if ($this->language !== null) {
            $headers['Accept-Language'] = $this->language;
        }

        return array_merge_recursive(
            [
                'headers' => $headers,
            ],
            $options
        );
    }

    /**
     * @param string $method
     * @param string $path
     * @param array $options
     * @return string
     * @throws Exception
     */
    public function performApiCallWithJsonResponse(string $method, string $path, array $options = []): array
    {
        $response = $this->performApiCall($method, $path, $options);
        if ($response->getStatusCode() === 200) {
            try {
                $contents = $response->getContent();
            } catch (\RuntimeException $e) {
                $contents = '';
                throw new Exception('informations non récupérées');
            }

            return json_decode($contents, true);
        } else {
            throw new Exception(
                sprintf(
                    'status code %d pour le path %s',
                    $response->getStatusCode(),
                    $path
                )
            );
        }
    }
}