<?php

namespace Como\JobeetBundle\Utils;

class Jobeet
{

    static public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('#[^\\pL\d]+#u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        if (function_exists('iconv'))
        {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('#[^-\w]+#', '', $text);

        if (empty($text))
        {
            return 'n-a';
        }

        return $text;
    }
    
    
    
    public static function getTypes(){
        return array('full-time' => 'Full time', 'part-time' => 'Part time', 'freelance' => 'Freelance');
    }
    
    public static function getTypesValues(){
        return array_keys(self::getTypes());
    }
    
    
      static protected $zendLoaded = false;
 
      static public function registerZend()
      {
        if (self::$zendLoaded)
        {
          return;
        }

        set_include_path(get_include_path().PATH_SEPARATOR.'/home/hashir/projects/comojobeet/src/Como/JobeetBundle');
        require_once '/home/hashir/projects/comojobeet/src/Como/JobeetBundle/Zend/Loader/Autoloader.php';
        \Zend_Loader_Autoloader::getInstance();
        self::$zendLoaded = true;
      }
      
    static public function getLuceneIndex()
    {
      self::registerZend();

      if (file_exists($index = self::getLuceneIndexFile()))
      {
        return \Zend_Search_Lucene::open($index);
      }

      return \Zend_Search_Lucene::create($index);
    }

    static public function getLuceneIndexFile()
    {       
      return __DIR__.'/../Zend/job.dev.index';
    }
    
    public function updateLuceneIndex($job)
    {   
      $index = self::getLuceneIndex();

      // remove existing entries
      foreach ($index->find('pk:'.$job->getId()) as $hit)
      {
        $index->delete($hit->id);
      }

      // don't index expired and non-activated jobs
//      if ($this->isExpired() || !$this->getIsActivated())
//      {
//        return;
//      }

      $doc = new \Zend_Search_Lucene_Document();

      // store job primary key to identify it in the search results
      $doc->addField(\Zend_Search_Lucene_Field::Keyword('pk', $job->getId()));

      // index job fields
      $doc->addField(\Zend_Search_Lucene_Field::UnStored('position', $job->getPosition(), 'utf-8'));
      $doc->addField(\Zend_Search_Lucene_Field::UnStored('company', $job->getCompany(), 'utf-8'));
      $doc->addField(\Zend_Search_Lucene_Field::UnStored('location', $job->getLocation(), 'utf-8'));
      $doc->addField(\Zend_Search_Lucene_Field::UnStored('description', $job->getDescription(), 'utf-8'));

      // add job to the index
      $index->addDocument($doc);
      $index->commit();
    }
    
   public function getForLuceneQuery($query)
    {
      $hits = self::getLuceneIndex()->find($query);

      $pks = array();
      foreach ($hits as $hit)
      {
        $pks[] = $hit->pk;
      }

      if (empty($pks))
      {
        return array();
      }

      $q = $this->createQuery('j')
        ->whereIn('j.id', $pks)
        ->limit(20);

      $q = $this->addActiveJobsQuery($q);

      return $q->execute();
    }
}
