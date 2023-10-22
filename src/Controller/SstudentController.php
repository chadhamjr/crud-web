<?php

namespace App\Controller;


use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\ClassroomRepository;
use App\Repository\sitory;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SstudentController extends AbstractController
{
    #[Route('/sstudent', name: 'app_sstudent')]
    public function index(): Response
    {
        return $this->render('sstudent/index.html.twig', [
            'controller_name' => 'SstudentController',
        ]);
    }
    #[Route('/fetch', name: 'fetch')]
    public function fetch(StudentRepository $repo): Response /*StudentRepositery fih les methodes de recuperation hachetna bih lel affichage*/
    {
        $result = $repo->findAll();
        return $this->render("student/test.html.twig", [
            "response" => $result

        ]);
    }
    /* #[Route('/add', name: 'add')]
    public function add(ManagerRegistry $mr, ClassroomRepository $repo): Response /*managerRegistery lel ajout
    {
        $c = $repo->find(1);
        $s = new Student();
        $s->setName('baba');
        $s->setAge(10);
        $s->setEmail("baba@baba.baba");
        $s->setClassroom($c);
        $em = $mr->getManager();
        $em->persist($s);
        $em->flush();

        return $this->redirectToRoute('fetch');
    }*/
    #[Route('/addF', name: 'addF')]
    public function addF(ManagerRegistry $mr, Request $req): Response /*managerRegistery lel ajout*/
    {

        $s = new Student();/*etape 1 instance*/
        $form = $this->createForm(StudentType::class, $s); //2-creation form+ recuperation des donnees
        $form->handleRequest($req); //recuperation des donnees
        if ($form->isSubmitted()) {
            $em = $mr->getManager(); //3-persisit+flush
            $em->persist($s); //3-persisit+flush
            $em->flush();
            return $this->redirectToRoute('fetch');
        }




        return $this->render(
            'student/add.html.twig',
            ['f' => $form->createView()]
        );
    }
    #[Route('/remove/{id}', name: 'remove')]
    public function remove($id, ManagerRegistry $mr, StudentRepository $repo): Response
    {
        $student = $repo->find($id);
        $em = $mr->getManager();
        $em->remove($student);
        $em->flush();
        return $this->redirectToRoute('list');
    }
    #[Route('/modif/{id}', name: 'modif')]
    public function modif($id, ManagerRegistry $mr, StudentRepository $repo, Request $req): Response
    {
        $s = $repo->find($id);
        $form = $this->createForm(StudentType::class, $s);
        $form->handleRequest($req);
        if ($form->isSubmitted()) {
            $em = $mr->getManager();
            $em->persist($s);
            $em->flush();
            return $this->redirectToRoute('fetch');
        }
        return $this->render('sstudent/modif.html.twig', ['f' => $form->createView(),]);
    }
}
