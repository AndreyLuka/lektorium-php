<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Router;

class SecurityControllerTest extends WebTestCase
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @var KernelBrowser
     */
    private $client;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->router = self::$container->get('router');
    }

    public function testLogin()
    {
        $this->client->request('GET', $this->router->generate('app_login'));

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Please sign in');
    }
}
