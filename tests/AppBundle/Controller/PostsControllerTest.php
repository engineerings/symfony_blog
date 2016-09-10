<?php
/**
 * Created by PhpStorm.
 * User: x
 * Date: 10/09/16
 * Time: 22:09
 */

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PostsControllerTest extends WebTestCase
{


    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertContains('Recent posts', $crawler->filter('.left-side')->text());
        $this->assertGreaterThan(0, $crawler->filter('.post')->count());

    }

    public function testPost()
    {
        $client = static::createClient();

        $client->request('GET', '/');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $crawler = $client->getCrawler();

        $postLinks =$crawler->filter('.post > header > a');

        foreach ($postLinks->links() as $i => $link) {

            $crawler = $client->click($link);
            $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
            $this->assertEquals(trim($postLinks->eq($i)->text()), trim($crawler->filter('.post > header > a'))->text());
        }

        $client->request('GET', '/post-not-exist-test');
        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());

    }


}
