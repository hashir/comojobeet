<?php

namespace Como\JobeetBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
 
class UserAdminController extends Controller
{
 
    public function createAction()
    {
        
            $this->get('session')->setFlash('sonata_flash_error', 'Sorry, this part is not yet implemented');
            return $this->listAction();
    }
}