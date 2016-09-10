<?php
namespace AppBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Category;
class CategoriesFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $categoriesList = array(
            'java' => 'Java',
            'php' => 'PHP',
            'python' => 'Python',
            'javascript' => 'JavaScript',
            'css' => 'Cascading Style Sheets (CSS)',
            'html5' => 'HTML5'
        );
        foreach ($categoriesList as $key => $name) {
            $Category = new Category();
            $Category->setName($name);
            $manager->persist($Category);
            $this->addReference('category_'.$key, $Category);
        }
        $manager->flush();
    }
    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}
?>