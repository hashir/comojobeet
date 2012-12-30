<?php

namespace Como\JobeetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategoryAffiliate
 */
class CategoryAffiliate
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Como\JobeetBundle\Entity\Category
     */
    private $category;

    /**
     * @var \Como\JobeetBundle\Entity\Affiliate
     */
    private $affiliate;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set category
     *
     * @param \Como\JobeetBundle\Entity\Category $category
     * @return CategoryAffiliate
     */
    public function setCategory(\Como\JobeetBundle\Entity\Category $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return \Como\JobeetBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set affiliate
     *
     * @param \Como\JobeetBundle\Entity\Affiliate $affiliate
     * @return CategoryAffiliate
     */
    public function setAffiliate(\Como\JobeetBundle\Entity\Affiliate $affiliate = null)
    {
        $this->affiliate = $affiliate;
    
        return $this;
    }

    /**
     * Get affiliate
     *
     * @return \Como\JobeetBundle\Entity\Affiliate 
     */
    public function getAffiliate()
    {
        return $this->affiliate;
    }
}
