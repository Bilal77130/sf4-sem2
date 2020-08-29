<?php
namespace App\DataFixtures;

use App\Entity\Note;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class NoteFixtures extends BaseFixture implements DependentFixtureInterface{
    
    protected function loadData()
    {
        
        // Créer 50 notes
        $this->createMany(50,'note',function (){
         return (new Note())
                 
                 ->setAuthor($this->getRandomReference('user'))
                 ->setRecord($this->getRandomReference('record'))
                 ->setValue($this->faker->numberBetween(1,10))
                 ->setComment($this->faker->optional()->realText(250))
                 ->setCreatedAt($this->faker->dateTimeBetween( '1461067200','now'))
                 ;
                    
                });
    }  
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            RecordFixtures::class
        ];
    }
}