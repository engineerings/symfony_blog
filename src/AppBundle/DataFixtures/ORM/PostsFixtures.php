<?php
namespace AppBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Post;
class PostsFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $postsList = array(
            array(
                'title' => 'Java (programming language)',
                'content' => '<p>Java is a general-purpose computer programming language that is concurrent, class-based, object-oriented,[14] and specifically designed to have as few implementation dependencies as possible. It is intended to let application developers "write once, run anywhere" (WORA),[15] meaning that compiled Java code can run on all platforms that support Java without the need for recompilation.</p>',
                'category' => 'java',
                'tags' => array('oop', 'patterns', 'testing', 'back-end'),
                'author' => 'mike',
                'createDate' => '2016-01-01 12:12:12',
                'publishedDate' => NULL,
            ),
            array(
                'title' => 'PHP is a server-side scripting language designed primarily for web',
                'content' => '<p>PHP is a server-side scripting language designed primarily for web development but is also used as a general-purpose programming language. Originally created by Rasmus Lerdorf in 1994, the PHP reference implementation is now produced by The PHP Group. PHP originally stood for Personal Home Page, but it now stands for the recursive acronym PHP: Hypertext Preprocessor.',
                'category' => 'php',
                'tags' => array('web', 'symfony', 'raspberry'),
                'author' => 'jim',
                'createDate' => '2016-05-01 11:11:12',
                'publishedDate' => '2016-05-01 11:11:12',
            ),
            array(
                'title' => 'Python is a clear and powerful object-oriented programming language',
                'content' => '<p>Python is a widely used high-level, general-purpose, interpreted, dynamic programming language.[24][25] Its design philosophy emphasizes code readability, and its syntax allows programmers to express concepts in fewer lines of code than possible in languages such as C++ or Java. The language provides constructs intended to enable clear programs on both a small and large scale.</p>',
                'category' => 'python',
                'tags' => array('web', 'generics', 'collections', 'django'),
                'author' => 'ali',
                'createDate' => '2015-05-05 14:12:12',
                'publishedDate' => '2015-05-05 14:12:12',
            ),
            array(
                'title' => 'JavaScript is a high-level, dynamic, untyped, and interpreted programming language.',
                'content' => '<p>JavaScript is a high-level, dynamic, untyped, and interpreted programming language. It has been standardized in the ECMAScript language specification. Alongside HTML and CSS, it is one of the three core technologies of World Wide Web content production; the majority of websites employ it and it is supported by all modern Web browsers without plug-ins. JavaScript is prototype-based with first-class functions, making it a multi-paradigm language, supporting object-oriented, imperative, and functional programming styles. It has an API for working with text, arrays, dates and regular expressions, but does not include any I/O, such as networking, storage, or graphics facilities, relying for these upon the host environment in which it is embedded.</p>',
                'category' => 'javascript',
                'tags' => array('patterns', 'web', 'angular'),
                'author' => 'eric',
                'createDate' => '2014-05-05 14:10:12',
                'publishedDate' => '2015-05-05 14:12:12',
            ),
            array(
                'title' => 'Cascading Style Sheets',
                'content' => '<p>Cascading Style Sheets (CSS) is a style sheet language used for describing the presentation of a document written in a markup language.[1] Although most often used to set the visual style of web pages and user interfaces written in HTML and XHTML, the language can be applied to any XML document, including plain XML, SVG and XUL, and is applicable to rendering in speech, or on other media. Along with HTML and JavaScript, CSS is a cornerstone technology used by most websites to create visually engaging webpages, user interfaces for web applications, and user interfaces for many mobile applications.</p>',
                'category' => 'css',
                'tags' => array('sass', 'less'),
                'author' => 'mike',
                'createDate' => '2014-05-05 14:10:12',
                'publishedDate' => NULL,
            ),
            array(
                'title' => 'HTML5 is a markup language used for structuring and presenting content on the World Wide Web.',
                'content' => '<p>HTML5 is a markup language used for structuring and presenting content on the World Wide Web. It was published in October 2014 by the World Wide Web Consortium (W3C) to improve the language with support for the latest multimedia, while keeping it both easily readable by humans and consistently understood by computers and devices such as web browsers, parsers, etc. HTML5 is intended to subsume not only HTML 4, but also XHTML 1 and DOM Level 2 HTML.</p>',
                'category' => 'html5',
                'tags' => array('testing', 'web'),
                'author' => 'ric',
                'createDate' => '2014-05-05 14:10:12',
                'publishedDate' => '2015-05-05 14:12:12',
            ),
        );
        foreach ($postsList as $idx => $details) {
            $Post = new Post();
            $Post->setTitle($details['title'])
                ->setContent($details['content'])
                ->setAuthor($details['author'])
                ->setCreateDate(new \DateTime($details['createDate']));
            if(null !== $details['publishedDate']){
                $Post->setPublishDate(new \DateTime($details['publishedDate']));
            }
            $Post->setCategory($this->getReference('category_'.$details['category']));
            foreach($details['tags'] as $tagName){
                $Post->addTag($this->getReference('tag_'.$tagName));
            }
            $manager->persist($Post);
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
        return 2;
    }
}

?>