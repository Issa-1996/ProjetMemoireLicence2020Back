<?php

namespace App\Controller;

use App\Entity\Tour;
use App\Service\AddUser;
use App\Repository\UserRepository;
use App\Repository\ProfilRepository;
use App\Repository\TontineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserController extends AbstractController
{
    
        public function  __construct(EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, 
    SerializerInterface $serializer, ProfilRepository $profilRepo, ValidatorInterface $validator)
    {
        $this->manager = $manager;
        $this->encoder = $encoder;
        $this->serialize = $serializer;
        $this->profilRepo = $profilRepo;
        $this->validator = $validator;
    }
    /**
     * @Route(
     *      path="/api/admin/users", 
     *      name="user",
     *      methods="POST",
     * )
     */
    public function addUser(TontineRepository $tontineRepo,ProfilRepository $profilRepo ,UserPasswordEncoderInterface $encoder,Request $request,SerializerInterface $serializer, \Swift_Mailer $mailer)
    {
        //dd("hgjhkjl");
        $don = $request->request->all();
        //dd($request->files->get("avatar"));
        //$epargnePostman=json_decode($request->getContent(), true);
        //  dd($don["user"]);
         $user=$serializer->decode($don["user"], "json") ;
         unset($user["avatar"]);
        //  dd($user["avatar"]);
        $profilObjet=$profilRepo->find($user["profil"]);
        //dd($profilObjet->getLibelle());
        $TontineObjet=$tontineRepo->find($user["tontine"]);
        
        $profilLibelle = trim($profilObjet->getLibelle());
        //dd($profilLibelle);
        $profil="App\\Entity\\$profilLibelle";
        //dd($profil);    
        if(class_exists(($profil))){
            //dd($profil);
            $tab=[];
            $tab["prenom"]=$user["prenom"];
            $tab["nom"]=$user["nom"];
            $tab["email"]=$user["email"];
            $tab["telephone"]=$user["prenom"];
            $tab["adresse"]=$user["adresse"];
            $tab["password"]=$user["password"];
            $tab["Genre"]=$user["Genre"];
            $tab["roles"][]=$user["roles"];
            //$tab["status"]=$user["status"];
            $tab["cni"]=$user["cni"];
            // $tab["avatar"]=$request->files->get("avatar");
            $user = $this->serialize->denormalize($tab,$profil);
            $avatar = $request->files->get("avatar");
            $avatar = fopen($avatar->getRealPath(),"rb");
            //dd($avatar);
            $user->setAvatar($avatar);
            $email=$user->getEmail();
            $password = $user->getPassword();
            $user->setPassword($this->encoder->encodePassword($user,$password));
            $user->setProfil($profilObjet);
            $user->addTontine($TontineObjet);
            //dd($user);
            $message = (new \Swift_Message('Coordonnées de connexion '))
                ->setFrom('issa.sarr@uadb.edu.sn')
                ->setTo($email)
                ->setBody(
                    $this->renderView(
                        'base.html.twig',
                        ['email' => $email,
                        'password'=>$password]
                    ),
                    'text/html'
                );
                //dd($message);
            $mailer->send($message);
            //return $this->render('base.html.twig');
            $this->manager->persist($user);
            $this->manager->flush();
            if($avatar){
                fclose($avatar);
            }
            return new JsonResponse("success", Response::HTTP_OK);
        }
        return "le profil ne connait pas";
    }
    
    /**
     * @Route(
     *      path="/api/admin/users/{id}", 
     *      name="update",
     *      methods="POST",
     * )
     */
    public function updateUser(Request $request,AddUser $addUser, $id, UserRepository $userRep, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        //dd($request->request->all());
        $donnes=$request->request->all();
        //dd($donnes);
        $userUpdate=$userRep->find($id);
        if(isset($donnes['prenom'])){
            $userUpdate->setPrenom($donnes['prenom']);
        }
        if(isset($donnes['nom'])){
            $userUpdate->setNom($donnes['nom']);
        }
        if(isset($donnes['email'])){
            $userUpdate->setEmail($donnes['email']);
        }
        
        if(isset($donnes['password'])){
            if(!empty($donnes['password'])){
                $userUpdate->setPassword($encoder->encodePassword($userUpdate,$donnes['password']));
            }
        }
        if(isset($donnes['telephone'])){
            $userUpdate->setTelephone($donnes['telephone']);
        }
        if(isset($donnes['adresse'])){
            $userUpdate->setAdresse($donnes['adresse']);
        }
                
        if(isset($donnes['genre'])){
            $userUpdate->setGenre($donnes['genre']);
        }
        $avatar = $request->files->get("avatar");
        //$avatar = fopen($avatar->getRealPath(),"r+");
        if($avatar){
            $avatar = fopen($avatar->getRealPath(),"r+");
            $userUpdate->setAvatar($avatar);
        }
        //$this->denyAccessUnlessGranted("ROLE_ADMIN", null, "Vous n'avez acces a ce resource");
    
        $manager->persist($userUpdate);
        $manager->flush();
        if($avatar){
        fclose($avatar);
        }

        //if( $addUser->traitement($request)==true){
        return new JsonResponse("success", Response::HTTP_OK);
    //}
    //return new JsonResponse("error", Response::HTTP_OK);
    }
    /**
    * @Route(
    * name="addTour",
    * path="api/admin/tours",
    * methods={"POST"}
    * )
    */
    function addTour(TontineRepository $tontineRepo,Request $request, UserRepository $userRep){
        $ajoutTour=json_decode($request->getContent(),true);
        //dd($ajoutTour);
        $TontineObjet=$tontineRepo->find($ajoutTour["tontine"]);
        //$user->addTontine($TontineObjet);
        $tour=new Tour();
        $tour->setNom($ajoutTour["nom"]);
        $tour->setTontine($TontineObjet);
        $tour->setDate(new \DateTime('now'));
        $this->manager->persist($tour);
        $this->manager->flush();
        return new JsonResponse("success", Response::HTTP_OK);
       
        // $users=count($userRep->findAll());
        // $random = random_int(1, $users);
        // return new JsonResponse($random,Response::HTTP_OK,[],true);
    }
     /**
     * @Route("/api/admin/tirage", name="tirage")
     */
    public function tirage(SerializerInterface $serializer,Request $request, UserRepository $userRep){
        $users=count($userRep->findAll());
        $random = random_int(1, $users);
        //dd($random);
        $users=$userRep->find($random);
        //$sortant=$userRep->find($users);
        //dd($users);
        if($users==null){
            $users=1;
            $user =$serializer->serialize($users,"json");
            // dd($user);
             return new JsonResponse($user,Response::HTTP_OK,[],true);
        }else{
            $user =$serializer->serialize($users,"json");
            // dd($user);
             return new JsonResponse($user,Response::HTTP_OK,[],true);
        }
      
    }

    /**
     * @Route("/api/admin/currentUser", name="currentUser")
     */
    public function currentUser(SerializerInterface $serializer,TokenStorageInterface $tokenStorage){
        //dd("ok");
        $userConnect=$this->getUser();
        //dd($userConnect);
        $user =$serializer->serialize($userConnect,"json");
        return new JsonResponse($user,Response::HTTP_OK,[],true);
       
    }

}
