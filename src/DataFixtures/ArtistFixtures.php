<?php

namespace App\DataFixtures;

use App\Entity\Artist;

class ArtistFixtures extends BaseFixture
{
   protected function loadData()
   {
       // Créer 50 artistes 
       $this->createMany(50,function (){
        return (new Artist())
                ->setNom($this->faker->name)
                ->setPrenom($this->faker->name)
                ->setDescription($this->faker->optional()->realText(50));
       });
   }
}
