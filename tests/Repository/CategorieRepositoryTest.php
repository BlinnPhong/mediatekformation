<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Repository;

use App\Entity\Categorie;
use App\Entity\Formation;
use App\Entity\Playlist;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of CategorieRepositoryTest
 *
 * @author donob
 */
class CategorieRepositoryTest extends KernelTestCase {

    public function recupRepository(): CategorieRepository 
    {
        self::bootKernel();
        $repository = self::getContainer()->get(CategorieRepository::class);
        return $repository;
    }
    
    public function newCategorie(): Categorie 
    {
        $categorie = (new Categorie())->setName("Categorie Test Repository");
        
        return $categorie;
    }
    
    public function testAddCategorie() 
    {
        $repository = $this->recupRepository();
        $categorie = $this->newCategorie();
        $nbCategories = $repository->count([]);
        $repository->add($categorie);
        $this->assertEquals($nbCategories + 1, $repository->count([]), "erreur de l'ajout");        
    }
        
    public function testRemoveCategorie() 
    {
        $repository = $this->recupRepository();
        $categorie = $this->newCategorie();
        $repository->add($categorie);
        $nbCategories = $repository->count([]);
        $repository->remove($categorie);
        $this->assertEquals($nbCategories - 1, $repository->count([]), "erreur de la suppression");        
    }
    
    public function testFindAllForOnePlaylist()
    {
        $repository = $this->recupRepository();
        
        $categorie = $this->newCategorie();
        $repository->add($categorie);
        
        $formation1 = (new Formation())->addCategory($categorie);
        
        $repository->getEntityManager()->persist($formation1);
        $repository->getEntityManager()->flush();
        
        $playlist = (new Playlist())->addFormation($formation1);
        
        $repository->getEntityManager()->persist($playlist);
        $repository->getEntityManager()->flush();
        
        
        $results = $repository->findAllForOnePlaylist($playlist->getId());
        
        $this->assertCount(1, $results);
    }
}
