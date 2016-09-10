<?php
namespace AppBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Tag;

class TagsFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $tagsList = array(
            'collections',
            'generics',
            'jdbc',
            'web',
            'angular',
            'patterns',
            'testing',
            'raspberry',
            'software engineer',
            'back-end',
            'engineer',
            'sass',
            'less',
            'nodejs',
            'symfony',
            'django',
            'oop'
        );
        foreach ($tagsList as $key => $name) {
            $Tag = new Tag();
            $Tag->setName($name);
            $manager->persist($Tag);
            $this->addReference('tag_'.$name, $Tag);
        }
        $manager->flush();
    }
    public function getOrder() {
        return 0;
    }
}
?>