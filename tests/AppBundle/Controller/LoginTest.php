<?php

namespace Tests\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

class LoginTest extends AbstractControllerTest
{
    public function testLoginAction()
    {
        $crawler = $this->client->request('GET', '/login');

        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );
    }
}