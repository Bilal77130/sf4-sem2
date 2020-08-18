<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

/**
 * Classe modèle pour les fixtures
 * On ne peut pas instancier une abstraction
 * 
 */
abstract class BaseFixture extends Fixture
{
    /** @var ObjectManager  */
    private $manager;
    /** @var Generator  */
    protected $faker;

    /**
     * Méthode à implémenter par les classes qui héritent pour generer les fausses données
     * 
     */
    abstract protected function loadData();

    /**
     * Méthode appelée par le système de fixtures
     */
    public function load(ObjectManager $manager)
    {
        // On enregistre le ObjectManager
        $this->manager = $manager;
        // On instancie Faker
        $this->faker = Factory::create('fr_FR');

        // On appelle loadData() pour avoir les fausses données
        $this->loadData();
        // On exécute l'enregistrement en base
        $this->manager->flush();
    }

    /**
     * Enregistré plusieurs entités
     * @param int $count nombre d'entités
     * @param callable $factory fonction qui génére l'entité
     */

     protected function createMany(int $count, callable $factory){
        for($i=0;$i<$count;$i++){
            // on execute $factory qui doit retourner l'entité généré
            $entity =  $factory();      
            // Vérifier que l'entité soit retournée 
            if($entity==null){
                throw new \LogicException('L\entité doit être retrounée');
            }

            // On prépare à l'enregistrement de l'entité
            $this->manager->persist($entity);
            $this->manager->flush();
        }
     }

}