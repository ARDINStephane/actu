<?php

namespace App\Api\TheTvDbApi\Login;


use App\Api\TheTvDbApi\Client;
use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class TheTvDbApiLogger
 */
class TheTvDbApiLogger
{
    /**
     * @var ParameterBagInterface
     */
    private $params;
    /**
     * @var TokenManager
     */
    private $tokenManager;

    public function __construct(
        ParameterBagInterface $params,
        TokenManager $tokenManager

    ) {
        $this->params = $params;
        $this->tokenManager = $tokenManager;
    }

    /**
     * @throws Exception
     */
    public function loginToGetToken(Client $client): void
    {
        $data = [
            'apikey' => $this->params->get('apikey'),
            'userkey' => $this->params->get('userkey'),
            'username' => $this->params->get('username')
        ];

        $response = $client->performApiCall(Client::POSTMethod, '/login', [
            'body' => json_encode($data),
        ]);

        if ($response->getStatusCode() === 200) {
            try {
                $contents = $response->getContent();
            } catch (\RuntimeException $e) {
                throw new Exception('connection échouée');
            }
            $contents = json_decode($contents, true);
            if (!array_key_exists('token', $contents)) {
                throw new Exception('token non récupéré');
            }
            $this->tokenManager->set($contents['token']);
        } else {
            throw new Exception('Une erreur est survenue lors de la connection');
        }
    }
}