<?php

namespace App\Tests\Controller;

use App\Controller\BrowseController;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BrowseControllerTest extends WebTestCase
{

    public function testArtists()
    {
        $client = static::createClient();

        $client->request("GET","/browse/artists");

        $this->assertEquals(200,$client->getResponse()->getStatusCode());
        //$this->assertPageTitleContains("Liste les artistes");
        $this->assertEquals("A Perfect Circle",$client->getCrawler()->filter("li")->first()->text());
        $this->assertEquals("ZZ Top",$client->getCrawler()->filter("li")->last()->text());
    }


    public function testAlbums(){

        $client = static::createClient();

        $client->request("GET","/browse/albums/17");
        $this->assertEquals(200,$client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains("h1","Liste des albums de Metallica");
        $this->assertEquals(18,$client->getCrawler()->filter("li")->count());
    }

    public function testLienAlbum(){

        $client = static::createClient();
        $client->request("GET","/browse/artists");

        $client->clickLink("Metallica");
        $this->assertEquals(18,$client->getCrawler()->filter("li")->count());
    }

    public function testTrack(){
        $client = static::createClient();

        $client->request("GET","/browse/albums/28");
        $client->clickLink("Stigmata");
        $this->assertEquals("Beast Of Man",$client->getCrawler()->filter("li")->first()->text());
    }


}
