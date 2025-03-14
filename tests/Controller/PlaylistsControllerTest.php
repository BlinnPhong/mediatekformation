<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of PlaylistsControllerTest
 *
 * @author donob
 */
class PlaylistsControllerTest extends WebTestCase {
   
    public function testTrisPlaylistNameASC()
    {
        $client = static::createClient();
        $client->request('GET', '/playlists/tri/name/ASC');
        $this->assertSelectorTextContains('h5', 'Bases de la programmation (C#)');
    }
    
    public function testTrisPlaylistNameDESC()
    {
        $client = static::createClient();
        $client->request('GET', '/playlists/tri/name/DESC');
        $this->assertSelectorTextContains('h5', 'Visual Studio 2019 et C#');
    }
    
    public function testTrisNbFormationsASC()
    {
        $client = static::createClient();
        $client->request('GET', '/playlists/tri/formation/ASC');
        $this->assertSelectorTextContains('h5', 'playlist test');
    }
    
    public function testTrisNbFormationsDESC()
    {
        $client = static::createClient();
        $client->request('GET', '/playlists/tri/formation/DESC');
        $this->assertSelectorTextContains('h5', 'Bases de la programmation (C#)');
    }
    
    public function testFiltrePlaylist()
    {
        $client = static::createClient();
        $client->request('GET', '/playlists');
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'Cours UML'
        ]);
        
        $this->assertCount(1, $crawler->filter('h5'));
        $this->assertSelectorTextContains('h5', 'Cours UML');
    }
    
    public function testVoirDétailLink()
    {
        $client = static::createClient();
        $client->request('GET', '/playlists');
        
        $client->clickLink('Voir détail');
        
        $response = $client->getResponse();
        
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        
        $this->assertEquals('/playlists/playlist/13', $uri);
        $this->assertSelectorTextContains('h4', 'Bases de la programmation (C#)');
    }
}
