<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    /**
     * @var KernelBrowser
     */
    private $client;

    /**
     * Method is called before every test.
     */
    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * Method is called after every test.
     */
    public function tearDown()
    {
    }

    /**
     * @dataProvider providerUrls
     */
    public function testPageIsSuccessfull($url, $bool)
    {
        $this->client->request('GET', $url);

        if ('/login' === $url) {
            $this->assertTrue($bool);
        } else {
            $this->assertFalse($bool);
        }

        $this->assertResponseIsSuccessful();
    }

    public function providerUrls()
    {
        return [
            ['/login', true],
            ['/register', false],
        ];
    }
}
