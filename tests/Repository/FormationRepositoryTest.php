<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Repository;

use App\Entity\Formation;
use App\Entity\Playlist;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of FormationRepositoryTest
 *
 * @author donob
 */
class FormationRepositoryTest extends KernelTestCase {
    
    public function recupRepository(): FormationRepository 
    {
        self::bootKernel();
        $repository = self::getContainer()->get(FormationRepository::class);
        return $repository;
    }
    
      
    public function clearRepository($repository)
    {
        $formations = $repository->findAll();
        foreach($formations as $formation)
        {
            $repository->remove($formation);
        }
    }
    
    public function newFormation(): Formation 
    {
        $formation = (new Formation())
                    ->setTitle("FormationTest")
                    ->setDescription("Ceci est une formation test");
        
        return $formation;
    }
    
    public function testAddFormation() 
    {
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $nbFormations = $repository->count([]);
        $repository->add($formation);
        $this->assertEquals($nbFormations + 1, $repository->count([]), "erreur de l'ajout");        
    }
    
        
    public function testRemoveFormation() 
    {
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $repository->add($formation);
        $nbFormations = $repository->count([]);
        $repository->remove($formation);
        $this->assertEquals($nbFormations - 1, $repository->count([]), "erreur de la suppression");        
    }
    
    public function testFindByContainValue()
    {
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $repository->add($formation);
        $formations = $repository->findByContainValue("title", "FormationTest");
        $nbFormations = count($formations);
        $this->assertEquals(1, $nbFormations);
    }
    
    public function testFindAllOrderByASC()
    {
        $repository = $this->recupRepository();
        $this->clearRepository($repository);
        
        $formation1 = (new Formation())->setTitle("A");     
        $formation2 = (new Formation())->setTitle("B");    
        $formation3 = (new Formation())->setTitle("C");
        
        $repository->add($formation1);
        $repository->add($formation2);
        $repository->add($formation3);
        
        $results = $repository->findAllOrderBy('title', 'ASC');
        
        $this->assertCount(3, $results);
        $this->assertEquals("A", $results[0]->getTitle());
        $this->assertEquals("B", $results[1]->getTitle());
        $this->assertEquals("C", $results[2]->getTitle());
    }
    
        
    public function testFindAllOrderByDESC()
    {
        $repository = $this->recupRepository();
        $this->clearRepository($repository);
        
        $formation1 = (new Formation())->setTitle("A");     
        $formation2 = (new Formation())->setTitle("B");    
        $formation3 = (new Formation())->setTitle("C");
        
        $repository->add($formation1);
        $repository->add($formation2);
        $repository->add($formation3);
        
        $results = $repository->findAllOrderBy('title', 'DESC');
        
        $this->assertCount(3, $results);
        $this->assertEquals("C", $results[0]->getTitle());
        $this->assertEquals("B", $results[1]->getTitle());
        $this->assertEquals("A", $results[2]->getTitle());
    }
    
    public function testFindAllLasted()
    {
        $repository = $this->recupRepository();
        $this->clearRepository($repository);
        
        $formation1 = (new Formation())->setTitle("A")->setPublishedAt(new \DateTime());     
        $formation2 = (new Formation())->setTitle("B")->setPublishedAt(new \DateTime());  
        
        $repository->add($formation1);
        $repository->add($formation2);
        
        $results = $repository->findAllLasted(2);
        $this->assertCount(2, $results);
        $this->assertEquals("A", $results[0]->getTitle());
        $this->assertEquals("B", $results[1]->getTitle());
    }
    
    public function testFindAllForOnePlaylist()
    {
        $repository = $this->recupRepository();
        
        
        $formation1 = (new Formation())->setTitle("A");
        $formation2 = (new Formation())->setTitle("B");
        
        $repository->add($formation1);
        $repository->add($formation2);
        
        $playlist = (new Playlist())->setName("playlistTest")
                    ->addFormation($formation1)
                    ->addFormation($formation2);
        
        $repository->getEntityManager()->persist($playlist);
        $repository->getEntityManager()->flush();
        
        
        $results = $repository->findAllForOnePlaylist($playlist->getId());
        
        $this->assertCount(2, $results);
        $this->assertEquals("A", $results[0]->getTitle());
        $this->assertEquals("B", $results[1]->getTitle());
    }

}
