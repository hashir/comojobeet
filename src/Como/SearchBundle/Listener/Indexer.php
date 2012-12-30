<?php

namespace Como\SearchBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Como\SearchBundle\Utils\Search as Search;

class Indexer {
    protected $Search;
    protected $args;
    protected $constraint;
    public function __construct(\Como\SearchBundle\Utils\Search $Search, array $entity_names, array $const){
        foreach($entity_names as $ent):
           $this->SearchEntities[] = key($ent);   
           $this->args[key($ent)] = $ent[key($ent)];
        endforeach;
        foreach($const as $ent):   
           $this->constraint[key($ent)] = $ent[key($ent)];
        endforeach;
        $this->Search = $Search;
//        $this->constraint = $const;
    }
    public function postPersist(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $ent = explode('\\', get_class($entity));
        $ent = $ent[count($ent)-1];
        $index_flag = false;
        
        if (in_array($ent,$this->SearchEntities)) { 
            $index_flag = true;
            
            if(in_array($ent, array_keys($this->constraint))){
               $constraints = $this->constraint[$ent];
               foreach ($constraints as $c=> $r){
                   
                   $method = 'get'.str_replace(' ','',  ucwords(str_replace('_', ' ', $c)));
                   if(!method_exists($entity, $method) || $r != $entity->$method())
                     $index_flag = false;  
               }
            }            
        }
         if($index_flag)
         $this->Search->updateLuceneIndex($entity, $ent, $this->args[$ent],$index_flag); 
         
   }
   
   public function postUpdate(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $ent = explode('\\', get_class($entity));
        $ent = $ent[count($ent)-1];
        $index_flag = false;
        
        if (in_array($ent,$this->SearchEntities)) { 
            $index_flag = true;
            
            if(in_array($ent, array_keys($this->constraint))){
               $constraints = $this->constraint[$ent];
               foreach ($constraints as $c=> $r){
                   
                   $method = 'get'.str_replace(' ','',  ucwords(str_replace('_', ' ', $c)));
                   if($r != $entity->$method())
                     $index_flag = false;  
               }
            }            
        }
         if($index_flag)
         $this->Search->updateLuceneIndex($entity, $ent, $this->args[$ent],$index_flag); 
   }
    
}
