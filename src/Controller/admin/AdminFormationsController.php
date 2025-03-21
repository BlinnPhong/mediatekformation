<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller\admin;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Description of AdminFormationsController
 *
 * @author donob
 */
class AdminFormationsController extends AbstractController {
    
    /**
     *
     * @var FormationRepository
     */
    private $formationRepository;
    

    /**
     *
     * @var CategorieRepository
     */
    private $categorieRepository;
    
    /**
    * Chemin vers la vue admin formations
    */
    private const CHEMIN_VUE_ADMIN_FORMATIONS = "admin/admin.formations.html.twig";
    
    public function __construct(FormationRepository $formationRepository, CategorieRepository $categorieRepository)
    {
        $this->formationRepository = $formationRepository;
        $this->categorieRepository= $categorieRepository;
    }
    
    /**
     * 
     * @return Response
     */
    #[Route('/admin', name: 'admin.formations')]
    public function index(): Response
    {
        $formations = $this->formationRepository->findAll();
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::CHEMIN_VUE_ADMIN_FORMATIONS, [
            'formations' => $formations,
            'categories' => $categories
        ]);
    }
    
    /**
     * 
     * @param type $champ
     * @param type $ordre
     * @param type $table
     * @return Response
     */
    #[Route('/admin/formations/tri/{champ}/{ordre}/{table}', name: 'admin.formations.sort')]
    public function sort($champ, $ordre, $table=""): Response
    {
        $formations = $this->formationRepository->findAllOrderBy($champ, $ordre, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::CHEMIN_VUE_ADMIN_FORMATIONS, [
            'formations' => $formations,
            'categories' => $categories
        ]);
    }
    
    /**
     * 
     * @param type $champ
     * @param Request $request
     * @param type $table
     * @return Response
     */
    #[Route('/admin/formations/recherche/{champ}/{table}', name: 'admin.formations.findallcontain')]
    public function findAllContain($champ, Request $request, $table=""): Response
    {
        $valeur = $request->get("recherche");
        $formations = $this->formationRepository->findByContainValue($champ, $valeur, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::CHEMIN_VUE_ADMIN_FORMATIONS, [
            'formations' => $formations,
            'categories' => $categories,
            'valeur' => $valeur,
            'table' => $table
        ]);
    }
    
    /**
     * 
     * @param int $id
     * @return Response
     */
    #[Route('/admin/suppr/{id}', name: 'admin.formation.suppr')]
    public function suppr(int $id): Response
    {
        $formation = $this->formationRepository->find($id);
        $this->formationRepository->remove($formation);
        return $this->redirectToRoute('admin.formations');
    }
    
    /**
     * 
     * @param int $id
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/edit/{id}', name: 'admin.formation.edit')]
    public function edit(int $id, Request $request): Response
    {
        $formation = $this->formationRepository->find($id);
        $formFormation = $this->createForm(FormationType::class, $formation);
        
        $formFormation->handleRequest($request);
        if($formFormation->isSubmitted() && $formFormation->isValid()) 
        {
            $this->formationRepository->add($formation);
            return $this->redirectToRoute('admin.formations');
        }
        
        return $this->render("admin/admin.formation.edit.html.twig", [
            'formation' => $formation,
            'formformation' => $formFormation->createView()
        ]);
    }
    
    /**
     * 
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/ajout', name: 'admin.formation.ajout')]
    public function ajout(Request $request): Response
    {
        $formation = new Formation();
        $formFormation = $this->createForm(FormationType::class, $formation);
        
        $formFormation->handleRequest($request);
        if($formFormation->isSubmitted() && $formFormation->isValid()) 
        {
            $this->formationRepository->add($formation);
            return $this->redirectToRoute('admin.formations');
        }
        
        return $this->render("admin/admin.formation.ajout.html.twig", [
            'formation' => $formation,
            'formformation' => $formFormation->createView()
        ]);
    }
}
