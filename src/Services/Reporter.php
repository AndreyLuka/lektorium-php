<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class Reporter
{
    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var SlugService
     */
    private $slugService;

    public function __construct(HttpClientInterface $httpClient, SlugService $slugService)
    {
        $this->httpClient = $httpClient;
        $this->slugService = $slugService;
    }

    public function reportNewRegistration($userId)
    {
        // Some logic...

        $this->slugService->slugify('test-text');

        $this->httpClient->request('POST', 'http://example.com', [
            'body' => ['user_id' => $userId]
        ]);
    }

    public function slugifyForReport($text)
    {
        return $this->slugService->slugify($text);
    }
}