<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of FormationsControllerTest
 *
 * @author donob
 */
class FormationsControllerTest extends WebTestCase {

    public function testTrisFormationTitleASC()
    {
        $client = static::createClient();
        $client->request('GET', '/formations/tri/title/ASC');
        $this->assertSelectorTextContains('h5', 'Android Studio (complément n°1) : Navigation Drawer et Fragment');
    }
    
    public function testTrisFormationTitleDESC()
    {
        $client = static::createClient();
        $client->request('GET', '/formations/tri/title/DESC');
        $this->assertSelectorTextContains('h5', 'UML : Diagramme de paquetages');
    }
    
    public function testTrisPlaylistNameASC()
    {
        $client = static::createClient();
        $client->request('GET', '/formations/tri/name/ASC/playlist');
        $this->assertSelectorTextContains('h5', 'Bases de la programmation n°74 - POO : collections');
    }
    
    public function testTrisPlaylistNameDESC()
    {
        $client = static::createClient();
        $client->request('GET', '/formations/tri/name/DESC/playlist');
        $this->assertSelectorTextContains('h5', 'C# : ListBox en couleur');
    }
    
    public function testTrisPublishedAtASC()
    {
        $client = static::createClient();
        $client->request('GET', '/formations/tri/publishedAt/ASC');
        $this->assertSelectorTextContains('h5', "Cours UML (1 à 7 / 33) : introduction et cas d'utilisation");
    }
    
    public function testTrisPublishedAtDESC()
    {
        $client = static::createClient();
        $client->request('GET', '/formations/tri/publishedAt/DESC');
        $this->assertSelectorTextContains('h5', "Eclipse n°8 : Déploiement");
    }
    
    public function testFiltreFormation()
    {
        $client = static::createClient();
        $client->request('GET', '/formations');
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'Eclipse n°8 : Déploiement'
        ]);
        
        $this->assertCount(1, $crawler->filter('h5'));
        $this->assertSelectorTextContains('h5', 'Eclipse n°8 : Déploiement');
    }
    
    public function testImageLink()
    {
        $client = static::createClient();
        $client->request('GET', '/formations');
        
        $client->clickLink('formation image miniature');
        
        $response = $client->getResponse();
        
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        
        $this->assertEquals('/formations/formation/1', $uri);
        $this->assertSelectorTextContains('h4', 'Eclipse n°8 : Déploiement');
    }
}
