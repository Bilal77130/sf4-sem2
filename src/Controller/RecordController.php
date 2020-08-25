<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Entity\Label;
use App\Entity\Record;
use App\Repository\ArtistRepository;
use App\Repository\LabelRepository;
use App\Repository\RecordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class RecordController extends AbstractController
{
    /**
     * Liste des artistes
     * @Route("/artist", name="artist_list")
     */
    public function index(ArtistRepository $repository)
    {
        return $this->render('record/artist_list.html.twig', [
            'artist_list' => $repository->findAll(),
           
        ]);
    }
    /**
     * Page d'un artiste
     * @Route("/artist/{id}", name="artist_page")
     */
    public function artistPage(Artist $artist ){
        return $this->render('record/artist_page.html.twig', [
            'artist' => $artist
           
        ]);
    }

    /**
     * Page d'un album
     * @Route("/record/{id}", name="record_page")
     */
    public function recordPage(Record $record){
        return $this->render('record/record_page.html.twig',[
            'record'=>$record
        ]);
    }

    /**
     * Nouveau albums
     * @Route("/news", name="record_news")
     * 
     */
    
    public function recordNews(RecordRepository $repository){
      
        return $this->render('record/record_news.html.twig',[
            'record_news'=>$repository->findNews()
        ]);
    }

    /**
     * Nouveau albums
     * @Route("/label/{id}", name="label_page")
     */
    public function label(Label $label){
      
        return $this->render('label/label_page.html.twig',[
            'label'=>$label
        ]);
    }
       /**
     * Nouveau albums
     * @Route("/label", name="label_list")
     */
    public function labels(LabelRepository $repository){
        $res = $repository->findAll();

        // dd($res);
      
        return $this->render('label/label_list.html.twig',[
            'label_list'=>$repository->findAll()
        ]);
    }
}
