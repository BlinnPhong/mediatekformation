<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Repository;

use App\Entity\Formation;
use App\Entity\Playlist;
use App\Repository\FormationRepository;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of PlaylistRepositoryTest
 *
 * @author donob
 */
class PlaylistRepositoryTest extends KernelTestCase {
    
    public function recupRepository(): PlaylistRepository
    {
        self::bootKernel();
        $repository = self::getContainer()->get(PlaylistRepository::class);
        return $repository;
    }
    
    public function recupFormationRepository() : FormationRepository
    {
        self::bootKernel();
        $repository = self::getContainer()->get(FormationRepository::class);
        return $repository;
    }
    
    public function clearRepository($playlistRepository)
    {
        $formationRepository = $this->recupFormationRepository();
        $formations = $formationRepository->findAll();
        foreach($formations as $formation)
        {
            $formationRepository->remove($formation);
        }
        
        $playlists = $playlistRepository->findAll();
        foreach($playlists as $playlist)
        {
            $playlistRepository->remove($playlist);
        }
    }
    
    public function newPlaylist() : Playlist
    {
        $playlist = (new Playlist())->setName("Playlist Test Repository");
        
        return $playlist;
    }
    
    public function testAddPlaylist() 
    {
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $nbPlaylists = $repository->count([]);
        $repository->add($playlist);
        $this->assertEquals($nbPlaylists + 1, $repository->count([]), "erreur de l'ajout");        
    }
    
        
    public function testRemovePlaylist() 
    {
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $repository->add($playlist);
        $nbPlaylists = $repository->count([]);
        $repository->remove($playlist);
        $this->assertEquals($nbPlaylists - 1, $repository->count([]), "erreur de la suppression");        
    }
    
    public function testFindAllOrderByNameASC()
    {
        $repository = $this->recupRepository();
        
        $playlist1 = (new Playlist())->setName("AAA");     
        $playlist2 = (new Playlist())->setName("ZZZ");  
        
        $repository->add($playlist1);
        $repository->add($playlist2);
        
        $results = $repository->findAllOrderByName('ASC');
        
        $this->assertEquals("AAA", $results[0]->getName());
        $this->assertEquals("ZZZ", $results[count($results) - 1]->getName());
    }
    
    public function testFindAllOrderByNameDESC()
    {
        $repository = $this->recupRepository();
        
        $playlist1 = (new Playlist())->setName("AAA");     
        $playlist2 = (new Playlist())->setName("ZZZ");  
        
        $repository->add($playlist1);
        $repository->add($playlist2);
        
        $results = $repository->findAllOrderByName('DESC');
        
        $this->assertEquals("ZZZ", $results[0]->getName());
        $this->assertEquals("AAA", $results[count($results) - 1]->getName());
    }
    
    public function testFindAllOrderByFormationASC()
    {
        $repository = $this->recupRepository();
        $this->clearRepository($repository);
        
        $formation1 = (new Formation())->setTitle("Formation Test");
        
        $repository->getEntityManager()->persist($formation1);
        $repository->getEntityManager()->flush();
        
        $playlist1 = (new Playlist())
                    ->setName("A")
                    ->addFormation($formation1);
        
        $playlist2 = (new Playlist())->setName("B");
                
        $repository->add($playlist1);
        $repository->add($playlist2); 
        
        $results = $repository->findAllOrderByFormation('ASC');
        
        $this->assertCount(2, $results);
        $this->assertEquals("B", $results[0]->getName());
        $this->assertEquals("A", $results[1]->getName());
    }
    
    public function testFindAllOrderByFormationDESC()
    {
        $repository = $this->recupRepository();
        $this->clearRepository($repository);
        
        $formation1 = (new Formation())->setTitle("Formation Test");
        
        $repository->getEntityManager()->persist($formation1);
        $repository->getEntityManager()->flush();
        
        $playlist1 = (new Playlist())
                    ->setName("A")
                    ->addFormation($formation1);
        
        $playlist2 = (new Playlist())->setName("B");
                
        $repository->add($playlist1);
        $repository->add($playlist2); 
        
        $results = $repository->findAllOrderByFormation('DESC');
        
        $this->assertCount(2, $results);
        $this->assertEquals("A", $results[0]->getName());
        $this->assertEquals("B", $results[1]->getName());
    }
    
    public function testFindByContainValue()
    {
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $repository->add($playlist);
        $playlists = $repository->findByContainValue("name", "Playlist Test Repository");
        $nbPlaylists = count($playlists);
        $this->assertEquals(1, $nbPlaylists);
    }
}
