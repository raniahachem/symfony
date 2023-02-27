<?php

namespace App\Controller;
use App\Entity\Classroom;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ClassroomRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ClassroomController extends AbstractController
{
    #[Route('/classroo', name: 'app_classroo')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }
    #[Route('/classroom', name: 'app_classroom')]
    public function list(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine -> getRepository(Classroom::class);
        $classroom = $repo ->findAll();
        return $this->render('classroom/list.html.twig', [
            'controller_name' => 'ClassroomController',
            'classroom' => $classroom
        ]);
}


#[Route('/addclassroom', name: 'add_classroom')]
public function addClassroom(Request $request, ManagerRegistry $doctrine)
{
    $classroom = new Classroom();

    $form = $this->createFormBuilder($classroom)
        ->add('name', TextType::class)
        ->add('save', SubmitType::class, ['label' => 'Create Classroom'])
        ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $doctrine->getManager()->persist($classroom);
        $doctrine->getManager()->flush();
        return $this->redirectToRoute('app_classroom');
    }

    return $this->render('classroom/index.html.twig', [
        'form' => $form->createView(),
    ]);
}
#[Route('/deleteclassroom/{id}', name: 'delete_classroom')]
public function deleteclassroom($id,ManagerRegistry $doctrine ){
  $classroom = $doctrine->getRepository(Classroom::class)->find($id);
  $em = $doctrine->getManager();
  $em->remove($classroom);
  $em->flush();
  return $this->redirectToRoute('app_classroom');
}

#[Route('/updateclassroom/{id}', name: 'update_classroom')]
public function updateClassroom(Request $request, ManagerRegistry $doctrine, int $id)
{
    $classroom = $doctrine->getRepository(Classroom::class)->find($id);

    $form = $this->createFormBuilder($classroom)
    ->add('name', TextType::class)
        ->add('save', SubmitType::class, ['label' => 'Update classroom'])
        ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $doctrine->getManager()->flush();
        return $this->redirectToRoute('app_classroom');
    }

    return $this->render('classroom/update.html.twig', [
        'form' => $form->createView(),
    ]);
}










}