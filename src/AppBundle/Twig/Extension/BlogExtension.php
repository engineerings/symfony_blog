<?php


namespace AppBundle\Twig\Extension;

class BlogExtension extends \Twig_Extension
{
    /**
     * @var \Doctrine\Bundle\DoctrineBundle\Registry
     */
    private $doctrine;

    /**
     * @var \Twig_Environment
     */
    private $environment;

    private $categoriesList;

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return "app_blog_extension";
    }

    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    function __construct(\Doctrine\Bundle\DoctrineBundle\Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('printCategoriesList',
                array($this, 'printCategoriesList'),
                array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('printMainMenu',
                array($this, 'printMainMenu'),
                array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('printTagsCloud',
                array($this, 'tagsCloud'),
                array('is_safe' => array('html'))),
        );
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('ab_shorten', array($this, 'shorten'), array('is_safe' => array('html')))
        );
    }

    public function printCategoriesList()
    {
        if (!isset($this->categoriesList)) {
            $categoryRepo = $this->doctrine->getRepository('AppBundle:Category');
            $this->categoriesList = $categoryRepo->findAll();
        }
        return $this->environment->render('template/categoriesList.html.twig', array(
            'categoriesList' => $this->categoriesList
        ));
    }

    public function printMainMenu()
    {
        $mainMenu = array(
            'home' => 'blog_index',
            'about me' => 'blog_about',
            'contact' => 'blog_contact'
        );

        return $this->environment->render('template/mainMenu.html.twig', array(
            'mainMenu' => $mainMenu
        ));
    }

    public function tagsCloud($limit = 40, $minFontSize = 1, $maxFontSize = 3.5)
    {
        $tagRepo = $this->doctrine->getRepository('AppBundle:Tag');
        $tagsList = $tagRepo->getTagsListOcc();
        $tagsList = $this->prepareTagsCloud($tagsList, $limit, $minFontSize, $maxFontSize);

        return $this->environment->render('template/tagsCloud.html.twig', array(
            'tagsList' => $tagsList
        ));
    }

    protected function prepareTagsCloud($tagsList, $limit, $minFontSize, $maxFontSize)
    {
        $occs = array_map(function ($row) {
            return (int)$row['occ'];
        }, $tagsList);
        $minOcc = min($occs);
        $maxOcc = max($occs);
        $spread = $maxOcc - $minOcc;
        $spread = ($spread == 0) ? 1 : $spread;
        usort($tagsList, function ($a, $b) {
            $ao = $a['occ'];
            $bo = $b['occ'];
            if ($ao === $bo) return 0;
            return ($ao < $bo) ? 1 : -1;
        });
        $tagsList = array_slice($tagsList, 0, $limit);
        shuffle($tagsList);
        foreach ($tagsList as &$row) {
            $row['fontSize'] = round(($minFontSize + ($row['occ'] - $minOcc) * ($maxFontSize - $minFontSize) / $spread), 2);
        }
        return $tagsList;
    }

    public function shorten($text, $length = 200, $wrapTag = 'p')
    {
        $text = strip_tags($text);
        $text = substr($text, 0, $length) . '[...]';
        $openTag = "<{$wrapTag}>";
        $closeTag = "</{$wrapTag}>";
        return $openTag . $text . $closeTag;
    }

    public function recentCommented($limit = 3)
    {
        $PostRepo = $this->doctrine->getRepository('AppBundle:Post');
        $postsList = $PostRepo->getRecentCommented($limit);
        return $this->environment->render('template/recentCommented.html.twig', array(
            'postsList' => $postsList
        ));
    }
}