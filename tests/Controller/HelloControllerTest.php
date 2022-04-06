<?php

namespace App\Tests\Controller;

use App\Controller\HelloController;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HelloControllerTest extends WebTestCase
{

    public function testHelloManyTimes()
    {
        $client = static::createClient();

        $client->request('GET', '/hello/bob');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(3, $client->getCrawler()->filter('p'));

    }
}
