<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller\admin;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AdminCategoriesController
 *
 * @author donob
 */
class AdminCategoriesController extends AbstractController {
    
    /**
     * 
     * @var CategorieRepository
     */
    private $repository;
    
    /**
     * 
     * @param CategorieRepository $repository
     */
    public function __construct(CategorieRepository $repository) {
        $this->repository = $repository;
    }
    
    /**
     * 
     * @return Response
     */
    #[Route('/admin/categories', name: 'admin.categories')]
    public function index(): Response {
        $categories = $this->repository->findAll();
        return $this->render("admin/admin.categories.html.twig", [
            'categories' => $categories
        ]);
    }
        
    /**
     * 
     * @param int $id
     * @return Response
     */
    #[Route('/admin/categorie/suppr/{id}', name: 'admin.categorie.suppr')]
    public function suppr(int $id): Response {
        $categorie = $this->repository->find($id);
        if($categorie->getFormations()->isEmpty())
        {
            $this->repository->remove($categorie);
        }
        
        return $this->redirectToRoute('admin.categories');
    }
    
    /**
     * 
     * @param Request $request
     * @return Response
     */     
    #[Route('/admin/categorie/ajout', name: 'admin.categorie.ajout')]
    public function ajout(Request $request): Response {
        $nomCategorie = $request->get("nom");
        $categorie = new Categorie();
        $categorie->setName($nomCategorie);
        if(!$this->repository->findOneBy(['name' => $nomCategorie])) { 
            $this->repository->add($categorie);
        }
        return $this->redirectToRoute('admin.categories');
    }
}
