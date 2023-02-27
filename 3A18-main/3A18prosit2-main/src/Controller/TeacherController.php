<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    #[Route('/teacher', name: 'app_teacher')]
    public function index(): Response
    {
        return $this->render('teacher/index.html.twig', [
            'controller_name' => 'TeacherController',
        ]);
    }
    /**
     * @Route("/showTeacher/{name}",name="showTeacher")
     */
    function showTeacher($name){
        return new Response('Bonjour '.$name) ;
    }

    function goToIndex(){
        return $this->render('showTeacher.html.twig', ['name'=>$name]);
    }
}
