<?php

namespace Como\JobeetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Como\JobeetBundle\Utils\Jobeet as Jobeet;

/**
 * Como\JobeetBundle\Entity\Category
 */
class Category
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $slug
     */
    private $slug;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $jobs;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $category_affiliates;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->jobs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->category_affiliates = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set name
     *
     * @param string $name
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Category
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add jobs
     *
     * @param Como\JobeetBundle\Entity\Job $jobs
     * @return Category
     */
    public function addJob(\Como\JobeetBundle\Entity\Job $jobs)
    {
        $this->jobs[] = $jobs;
    
        return $this;
    }

    /**
     * Remove jobs
     *
     * @param Como\JobeetBundle\Entity\Job $jobs
     */
    public function removeJob(\Como\JobeetBundle\Entity\Job $jobs)
    {
        $this->jobs->removeElement($jobs);
    }

    /**
     * Get jobs
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getJobs()
    {
        return $this->jobs;
    }

    /**
     * Add category_affiliates
     *
     * @param Como\JobeetBundle\Entity\CategoryAffiliate $categoryAffiliates
     * @return Category
     */
    public function addCategoryAffiliate(\Como\JobeetBundle\Entity\CategoryAffiliate $categoryAffiliates)
    {
        $this->category_affiliates[] = $categoryAffiliates;
    
        return $this;
    }

    /**
     * Remove category_affiliates
     *
     * @param Como\JobeetBundle\Entity\CategoryAffiliate $categoryAffiliates
     */
    public function removeCategoryAffiliate(\Como\JobeetBundle\Entity\CategoryAffiliate $categoryAffiliates)
    {
        $this->category_affiliates->removeElement($categoryAffiliates);
    }

    /**
     * Get category_affiliates
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCategoryAffiliates()
    {
        return $this->category_affiliates;
    }
    /**
     * @ORM\PrePersist
     */
    public function setSlugValue()
    {
        // Add your code here
	$this->slug = Jobeet::slugify($this->getName());
    }
    /**
     *   
     */
    public function __toString(){
       return $this->getName();
    }
    
    private $active_jobs;
 
  // ...
 
  public function setActiveJobs($jobs)
  {
    $this->active_jobs = $jobs;
  }
 
  public function getActiveJobs()
  {
    return $this->active_jobs;
  }
  
    private $more_jobs;
 
    // ...
 
    public function setMoreJobs($jobs)
    {
      $this->more_jobs = $jobs >=  0 ? $jobs : 0;
    }

    public function getMoreJobs()
    {
      return $this->more_jobs;
    }
}