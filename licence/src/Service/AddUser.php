<?php

namespace App\Service;

use App\Repository\ProfilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AddUser
{
    /*private $manager;
    private $encoder;
    private $serializer;
    private $profilRepo;
    private $validator;

    public function  __construct(EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, 
    SerializerInterface $serializer, ProfilRepository $profilRepo, ValidatorInterface $validator)
    {
        $this->manager = $manager;
        $this->encoder = $encoder;
        $this->serialize = $serializer;
        $this->profilRepo = $profilRepo;
        $this->validator = $validator;
    }
    public function traitement(Request $request, \Swift_Mailer $mailer)
    {
        $user = $request->request->all();
        $avatar = $request->files->get("avatar");
        $avatar = fopen($avatar->getRealPath(),"r+");
        $user["avatar"] = $avatar;
        $profilLibelle = trim($user['role']);
        $profil="App\\Entity\\$profilLibelle";
        if(class_exists(($profil))){
            //dd($user);
            $user = $this->serialize->denormalize($user,$profil);
            //dd($user);
            $password = $user->getPassword();
            $user->setPassword($this->encoder->encodePassword($user,$password));
            $profilObjet=$this->profilRepo->findOneBy(['libelle'=>$profilLibelle]);
            $errors =$this->validator->validate($user);
            $user->setProfil($profilObjet);
            if (count($errors)){
                $errors = $this->serialize->serialize($errors,"json");

                $message = (new \Swift_Message('Coordonnées de connexion '))
                ->setFrom('issa.sarr@uadb.edu.sn')
                ->setTo($user['email'])
                ->setBody(
                    $this->renderView(
                        //templates/emails/registration.html.twig
                        'base.html.twig',
                        ['name' => $user['email'],
                        'password'=>$password]
                    ),
                    'text/html'
                );
                $mailer->send($message);


                return new JsonResponse($errors,Response::HTTP_BAD_REQUEST,[],true);
            }
            $this->manager->persist($user);
            $this->manager->flush();
            return new JsonResponse("success", Response::HTTP_OK);
        }
    }*/
}