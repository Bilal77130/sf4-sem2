<?php
namespace App\DataFixtures;

use App\Entity\Label;
use App\Entity\Record;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LabelFixtures extends BaseFixture{
    protected function loadData()
    {
        // Créer 10 labels
        $this->createMany(50,'label',function (){
         return (new Label())
                 ->setName($this->faker->name)
                //  ->addRelation($this->getRandomReference('record'))
                 ;
                    
                });
    }  
  
}