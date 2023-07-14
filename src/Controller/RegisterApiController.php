<?php

namespace App\Controller;
use App\Security\EmailVerifier;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;


class RegisterApiController extends AbstractController
{
    private EmailVerifier $emailVerifier;   
    /**
     * @Route("/registration", name="app_registration", methods={"GET"})
     */
    public function registration(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $em): Response
    {
        $user = new User();
        //$form = $this->createForm(RegistrationFormType::class, $user);
        //$form->handleRequest($request);

        //$em = $this->getDoctrine()->getManager();
        $response = new Response();
     
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        if($request->query->get('mail')) {
            // encode the plain password
           
            $emailnew = $request->query->get('mail');
            $passwordnew = $request->query->get('password');
            $user->setEmail($emailnew);
            $user->setRoles(["ROLE_USER"]);
            //$user->setPassword($passwordnew);
            
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $passwordnew
                )
            );

            $em->persist($user);
            $em->flush();
            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('f5web@juancarlosmacias.es', 'JCMS'))
                    ->to($user->getEmail())
                    ->subject('Confirmación de registro')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            $response->setContent(json_encode([
                'registro' => "valido ",

            ]));
            
            $response->headers->set('pass', 'ok');
        }else{
            $response->headers->set('pass', 'not');
        }

        return $response; 
    }


}
