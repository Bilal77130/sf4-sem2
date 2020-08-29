<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Entity\Label;
use App\Entity\Note;
use App\Entity\Record;
use App\Repository\ArtistRepository;
use App\Repository\LabelRepository;
use App\Repository\RecordRepository;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\GiveNoteFormType;
use Symfony\Component\Security\Core\Security;


class RecordController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;
    public function __construct(Security $security, EntityManagerInterface $em)
    {
       $this->security = $security;
       $this->entityManager=$em;
    }


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
    public function recordPage(Record $record, Note $note, Request $request, NoteRepository $repository){

        $notes =  $repository->findAllByRecord($record->getId());
        $maNote = $repository->findOneByRecordAndAuthor($record->getId(),$this->security->getUser());
        $now = new \DateTime();
        // dd($request->query);

        $note = new Note();
        $note->setValue(10)
            ->setAuthor($this->security->getUser())
            ->setRecord($record)
                ->setRecord($record)
                ->setComment($request->get('comment'))
                ->setCreatedAt($now);



        // $maNote
                // ->setRecord($record)
            //    ->setValue(10)
            //    ->setComment($request->get('comment'))
            //    ->setCreatedAt($now);

        if(!is_null($maNote))
            $note =  $maNote;    

        $form = $this->createForm(GiveNoteFormType::class,$note);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success','La note à été mise à jour.');
            $this->entityManager->persist($note);
            $this->entityManager->flush();
        
        }

        return $this->render('record/record_page.html.twig',[
            'record'=>$record,
            'notation_form'=>$form->createView(),
            'form_action'=>'add_note',
            'list_notes'=>$notes
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

        return $this->render('label/label_list.html.twig',[
            'label_list'=>$repository->findAll()
        ]);
    }
}
