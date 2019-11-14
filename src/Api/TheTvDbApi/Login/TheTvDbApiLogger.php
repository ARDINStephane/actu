<?php

namespace App\Api\TheTvDbApi\Login;


use App\Api\TheTvDbApi\Provider\ApiProvider;
use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Response\CurlResponse;

/**
 * Class TheTvDbApiLogger
 */
class TheTvDbApiLogger
{
    const API_BASE_URI = 'https://api.thetvdb.com';
    /**
     * @var TokenManager
     */
    private $tokenManager;
    /**
     * @var ApiProvider
     */
    private $apiProvider;
    /**
     * @var ParameterBagInterface
     */
    private $params;
    /**
     * @type HttpClient
     */
    private $httpClient;

    public function __construct(
        ParameterBagInterface $params,
        TokenManager $tokenManager,
        ApiProvider $apiProvider
    ) {
        $this->tokenManager = $tokenManager;
        $this->apiProvider = $apiProvider;
        $this->params = $params;
        $this->initHttpClient();
    }

    /**
     * Initialize Client
     *
     * @return void
     */
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
    public function loginToGetToken(): void
    {


        $data = [
            'apikey' => $this->params->get('apikey'),
            'userkey' => $this->params->get('userkey'),
            'username' => $this->params->get('username')
        ];

        $response = $this->performApiCall('POST', '/login', [
            'body' => json_encode($data),
        ]);

        if ($response->getStatusCode() === 200) {
            try {
                $contents = $response->getContent();
            } catch (\RuntimeException $e) {
                throw new Exception('connection échouée');
            }
            $contents = (array) json_decode($contents);
            if (!array_key_exists('token', $contents)) {
                throw new Exception('token non récupéré');
            }
            $this->tokenManager->set($contents['token']);
        } else {
            throw new Exception('Une erreur est survenue lors de la connection');
        }
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

        return array_merge_recursive(
            [
                'headers' => $headers,
            ],
            $options
        );
    }
}