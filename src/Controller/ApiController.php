<?php

namespace App\Controller;

use App\Entity\Crud;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine){}
    
    

    #[Route('/api', name: 'app_api')]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiController.php',
        ]);
    }

    #[Route('/api/post_api', name: 'post_api', methods: ['POST'])]
    public function post_api(Request $request): Response
    {
        $crud = new Crud();
        $parameter = json_decode($request->getContent(), true);
        $crud->setTitle($parameter['title']);
        $crud->setContent($parameter['content']);

        $em = $this->doctrine->getManager();
        $em->persist($crud);
        $em->flush();
        return $this->json('Inserted successfully');
    }
}
