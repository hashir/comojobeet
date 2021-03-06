<?php

namespace Como\JobeetBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends EntityRepository
{
    public function getWithJobs()
  {
    $query = $this->getEntityManager()->createQuery(
      'SELECT c FROM ComoJobeetBundle:Category c LEFT JOIN c.jobs j WHERE j.expires_at > :date AND j.is_activated = :activated'
    ) ->setParameter('date', date('Y-m-d H:i:s', time()))->setParameter('activated', 1);
 
    return $query->getResult();
        
  }
  /**
   * searchByQuery is for Ajax search
   */
  public function searchByQuery($query)
  {
//        $query = '"%'.$query.'%"';
        $qry = $this->getEntityManager()->createQuery(
          "SELECT c.name FROM ComoJobeetBundle:Category c WHERE c.name LIKE '%{$query}%'")
//        ->setParameter('query',$query)
                ;

        return $qry->getResult();
  }
}
