<?php

namespace Como\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ComoUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
