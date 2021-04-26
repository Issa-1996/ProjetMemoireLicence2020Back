<?php

namespace App\Controller;

use App\Entity\Gerant;
use App\Entity\Membre;
use App\Entity\Tontine;
use App\Entity\Tour;
use App\Entity\Tresorier;
use App\Entity\User;
use App\Repository\ProfilRepository;
use App\Repository\TontineRepository;
use App\Repository\TourRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;

class TontineController extends AbstractController
{

    private $tokenStorage;
    public function __construct(UserPasswordEncoderInterface $encoder,TokenStorageInterface $tokenStorage){
        $this->tokenStorage = $tokenStorage;
        $this->encoder = $encoder;
    }

    /**
     * @Route(
     * name="addTontine",
     * path="api/admin/tontine",
     * methods={"POST"}
     * )
     */
    public function addTontine(ProfilRepository $profilRep, TourRepository $tourRep, SerializerInterface $serializer, TontineRepository $tontineRep, Request $request): Response
    {
        //dd("bonjour");
        $ajoutTontine=json_decode($request->getContent(),true);
        //dd($ajoutTontine);
        //$user=$this->tokenStorage->getToken()->getUser();
        //dd($ajoutTontine["users"]["0"]["email"]);
        //$profil=$profilRep->find($ajoutTontine["users"]["0"]["profil"]);
        //dd($profil);
        $tontine= new Tontine();
        $tour=new Tour();
       /* $user=new User();
        $user->setNom($ajoutTontine["users"]["0"]["nom"]);
        $user->setPrenom($ajoutTontine["users"]["0"]["prenom"]);
        $user->setEmail($ajoutTontine["users"]["0"]["email"]);
        $password=$ajoutTontine["users"]["0"]["password"];
        $user->setPassword($this->encoder->encodePassword($user,$password));
        $user->setGenre($ajoutTontine["users"]["0"]["Genre"]);
        $user->setAdresse($ajoutTontine["users"]["0"]["adresse"]);
        $user->setTelephone($ajoutTontine["users"]["0"]["telephone"]);
        $user->setCni($ajoutTontine["users"]["0"]["cni"]);
        $user->setRoles($ajoutTontine["users"]["0"]["roles"]);
        $user->setProfil($profil);*/
        //$user->setNom($ajoutTontine["users"]["0"]["nom"]);
        $tontine->setDateCreation(new \DateTime('now'));
        $tontine->setDateFin(new \DateTime('now'));
        $tontine->setArchivage("0");
        $tontine->setNom($ajoutTontine["nom"]);
        $tontine->setSession($ajoutTontine["session"]);
        $tontine->addTour($tour);
       // $tontine->addUser($user);

        /*$message = (new \Swift_Message('Coordonnées de connexion '))
        ->setFrom('issa.sarr@uadb.edu.sn')
        ->setTo($ajoutTontine["users"]["0"]["email"])
        ->setBody(
            $this->renderView(
                'base.html.twig',
                ['email' => $ajoutTontine["users"]["0"]["email"],
                'password'=>$ajoutTontine["users"]["0"]["password"]]
            ),
            'text/html'
        );
        //dd($message);
        $mailer->send($message);
    //return $this->render();
*/
        $ems=$this->getDoctrine()->getManager();
        //$ems->persist( $user);
        $ems->persist( $tontine);
        $ems->flush();
        return new JsonResponse("success");

    }
/*
    public function sendMail($name, \Swift_Mailer $mailer, $mail){
        $mail="sarraseydinaissasarr@gmail.com";
        $password="05091996";
        $message= (new \Swift_Message('helle email'))
        ->setFrom('issa.sarr@gmail.com')
        ->setTo($mail)
        ->setBody(
            $this->renderView(
                'email/registration.html.twig',
                ['mail'=>$mail, 'password'=>$password]
            ),
            'text/html'
        );
        $mailer->send($message);
    }
    */
}
