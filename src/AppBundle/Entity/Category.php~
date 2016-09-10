<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="categories")
 */
class Category extends AbstractTaxonomy
{
    /**
     * @ORM\OneToMany(
     *     targetEntity = "Post",
     *     mappedBy = "category"
     * )
     */
    protected $posts;


}
