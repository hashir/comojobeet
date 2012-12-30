<?php

namespace Como\SearchBundle\Utils;

class Search
{    
      static protected $zendLoaded = false;
 
      static public function registerZend()
      {
        if (self::$zendLoaded)
        {
          return;
        }
       
        set_include_path(get_include_path().PATH_SEPARATOR.__DIR__.'/../');
        require_once  __DIR__.'/../Zend/Loader/Autoloader.php';
        \Zend_Loader_Autoloader::getInstance();
        self::$zendLoaded = true;
      }
      
    static public function getLuceneIndex($name)
    {
      self::registerZend();

      if (file_exists($index = self::getLuceneIndexFile($name)))
      {
        return \Zend_Search_Lucene::open($index);
      }

      return \Zend_Search_Lucene::create($index);
    }

    static public function getLuceneIndexFile($name)
    {       
      return __DIR__.'/../Zend/indexes/'.$name.'.index';
    }
    
    public function updateLuceneIndex($entity, $name, $args, $index_flag)
    {   
      $index = self::getLuceneIndex($name);

      /**
       *  remove existing entries
       */
      foreach ($index->find('pk:'.$entity->getId()) as $hit)
      {
        $index->delete($hit->id);
      }
      
      if(!$index_flag) return;
      /**
       *  don't index expired and non-activated result
       *
          if ($this->isExpired() || !$this->getIsActivated())
          {
            return;
          }
       *
       * 
       */
      $doc = new \Zend_Search_Lucene_Document();

      /**
       *  store primary key to identify it in the search results
       */
      $doc->addField(\Zend_Search_Lucene_Field::Keyword('pk', $entity->getId()));

      /**
       *  index entity fields
       */
      foreach($args as $arg){
          $method = 'get'.str_replace(' ','',  ucwords(str_replace('_', ' ', $arg)));
          $doc->addField(\Zend_Search_Lucene_Field::UnStored($arg, $entity->$method(), 'utf-8'));
      }
      
      // add to the index
      $index->addDocument($doc);
      $index->commit();
    }
 
}
