<?php

namespace Tests\AppBundle\Libs;

use AppBundle\Libs\Utils;

class UtilsTest extends \PHPUnit_Framework_TestCase
{


    public function testSluggify()
    {
        $originalText = "Text to@ sluggify";

        $slugText = Utils::sluggify($originalText);

        $this->assertEquals("text-to-sluggify", $slugText);



    }
}
