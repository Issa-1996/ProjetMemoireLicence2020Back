<?php

namespace App\Controller;

use App\Entity\Epargne;
use App\Entity\Tour;
use App\Repository\EpargneRepository;
use App\Repository\TontineRepository;
use App\Repository\TourRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;

class EpargneController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage){
        $this->tokenStorage = $tokenStorage;
    }
     /**
     * @Route("/api/admin/epargne", name="redEpargne")
     */
    public function redEpargne(EpargneRepository $epargneRepo, SerializerInterface $serializer){
        //dd($epargneRepo);
        $epargnes=$epargneRepo->findAll();
        //dd($users);
        //foreach ($epargnes as $epargne){
            //dd($user);
            $epargne =$serializer->serialize($epargnes,"json");
           // dd($epargne);
            return new JsonResponse($epargne,Response::HTTP_OK,[],true);
            /*if($user->getArchivage()==1){
                $tabUsers[]=$user;
            }*/
       // }


       // $user =$serializer->serialize($tabUsers,"json");
        //return new JsonResponse($user,Response::HTTP_OK,[],true);
    }
    /**
     * @Route("/api/admin/epargnes", name="addEpargne")
     */
    public function addEpargne(SerializerInterface $serializer,Request $request, TourRepository $tourRepo, TontineRepository $tontineRepo)
    {
        $epargnePostman=json_decode($request->getContent(), true);
        //dd($epargnePostman["interet"]);
        $isUser=$epargnePostman["user"];
        //$regionTab=$serializer->decode($epargnePostman,"json");
        //$regionObject=$serializer->denormalize($epargnePostman, 'App\Entity\Epargne');
        //$jsonContent = $serializer->serialize($epargnePostman, 'json');
        //dd($tontineRepo->find($epargnePostman['tontine']));
        $tontine=$tontineRepo->find($epargnePostman['tontine'])->getTour();
        $users=$tontineRepo->find($epargnePostman['tontine'])->getUsers();
        //dd($user);
        
        $tour=$tourRepo->find($epargnePostman['tour'])->getId();
        //dd($tour);
        foreach ($tontine as $key => $value) {
            //dd($value->getId());
            if($value->getId()===$tour){
                $tour=$tourRepo->find($epargnePostman['tour']);
                //$user=$this->tokenStorage->getToken()->getUser();
                foreach($users as $key=>$value){
                    //dd($value);
                    if($value->getId()==$isUser){
                        $tours=$tour->addUser($value);
                        $epargne=new Epargne();
                        $epargne->setMontant($epargnePostman["montant"]);
                        if($epargnePostman["interet"]==="avecinteret"){
                            $epargne->setInteret("200");
                        }else{
                            $epargne->setInteret("0");
                        }
                        //$epargne->setInteret("200");
                        $epargne->setDateEpargne(new \DateTime('now'));
                        $epargne->setArchivage("1");
                        $epargne->addTour($tours);
                        //$epargne->setU($user);
                        $ems=$this->getDoctrine()->getManager();
                        $ems->persist( $epargne);
                        $ems->flush();
                        return new JsonResponse("success");
                    }            
                }        
            }
        }
        //dd($tontine);

        $tour=$tourRepo->find($epargnePostman["tour"]);
        //dd($user);
    }

        /**
     * @Route("/api/admin/epargnes/{id}", name="updateEpargne")
     */
    public function updateEpargne(Request $request, TourRepository $tourRepo, EpargneRepository $epargneRepo, $id)
    {
        $epargnePostman=json_decode($request->getContent(),true);
        $epargne=$epargneRepo->find($id);

        $user=$this->tokenStorage->getToken()->getUser();

        //dd($epargne);
        if(isset($epargnePostman["montant"])){
            $epargne->setMontant($epargnePostman["montant"]);
        }
        if(isset($epargnePostman["interet"])){
            $epargne->setInteret($epargnePostman["interet"]);
        }
        if(isset($epargnePostman["user"])){
            $epargne->addUser($user);
        }
        if(isset($epargnePostman["tour"])){
            $tour=$tourRepo->find($epargnePostman["tour"]);
            $epargne->setTour($tour);
        }
        if(isset($epargnePostman["dateEpargne"])){
            $epargne->setDateEpargne(new \DateTime('now'));
        }
        if(isset($epargnePostman["archivage"])){
            $epargne->setArchivage($epargnePostman["archivage"]);
        }

        $ems=$this->getDoctrine()->getManager();
        $ems->persist( $epargne);
        $ems->flush();
        return new JsonResponse("Update success",Response::HTTP_OK,[],true);
        //dd($user);
    }

   
}
