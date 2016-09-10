<?php
/**
 * Created by PhpStorm.
 * User: x
 * Date: 10/09/16
 * Time: 20:30
 */

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PagesControllerTest extends WebTestCase
{
    public function testAbout()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/about');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('About the author', $crawler->filter('h2.left-side')->text());


    }



}
