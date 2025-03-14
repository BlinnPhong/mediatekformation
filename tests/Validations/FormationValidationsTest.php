<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Validations;

use App\Entity\Formation;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Description of FormationValidationsTest
 *
 * @author donob
 */
class FormationValidationsTest extends KernelTestCase {
    
    public function getFormation(): Formation {
        return (new Formation())
                ->setTitle("FormationTest")
                ->setDescription("Ceci est une formation test");
    }
    
    public function testValidDateFormation() 
    {
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);

        $formation = $this->getFormation();
        $formation->setPublishedAt((new \DateTime())->setTime(0, 0, 0)); // Aujourd'hui

        $violations = $validator->validate($formation);
    
        $this->assertCount(0, $violations, "La validation ne devrait pas échouer pour aujourd'hui.");
    }
    
    public function testNonValidDateFormation()
    {       
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);

        $formation = $this->getFormation();
        $formation->setPublishedAt((new \DateTime())->modify('+1 day')); // Date Future

        $violations = $validator->validate($formation);

        $this->assertGreaterThan(0, count($violations), "La validation aurait dû échouer pour une date future.");
    }
}
