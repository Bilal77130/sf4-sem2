<?php
namespace App\DataFixtures;

use App\Entity\Record;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RecordFixtures extends BaseFixture implements DependentFixtureInterface{
    protected function loadData()
    {
        // Créer 50 artistes 
        $this->createMany(50,'record',function (){
         return (new Record())
                 ->setTitle($this->faker->catchPhrase)
                 ->setReleasedAt($this->faker->dateTimeBetween('-2 years'))
                 ->setDescription($this->faker->optional()->realText(250))
                 ->setArtist($this->getRandomReference('artist'))
                 ;
                    
                });
    }  
    public function getDependencies()
    {
        return [
            ArtistFixtures::class
        ];
    }
}