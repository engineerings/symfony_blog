<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Libs\Utils;

use AppBundle\Entity\Post;

class PostTest extends \PHPUnit_Framework_TestCase
{


    public function testSetTitle()
    {
        $Post = new Post();

        $title = "Test for Entity Post title";
        $Post->setTitle($title);

        $this->assertEquals($title, $Post->getTitle());
        $this->assertEquals('test-for-entity-post-title', $Post->getSlug());

        $Post->setSlug('Test For @@ set Slug');
        $this->assertEquals('test-for-set-slug', $Post->getSlug());

    }
}
