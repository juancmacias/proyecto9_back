<?php

namespace App\Controller;

use App\Entity\FormularioContacto;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class FomularioContactoController extends AbstractController
{
    #[Route('/formulario', name: 'app_formulario_contacto')]
    public function index(Request $request, SerializerInterface $serializer, UserRepository $userRepository): Response
    {
        if($request->query->get('bearer')) {
            $token = $request->query->get('bearer');
        }else {
            return $this->redirectToRoute('app_login');
        }

        $tokenParts = explode(".", $token);  
        $tokenHeader = base64_decode($tokenParts[0]);
        $tokenPayload = base64_decode($tokenParts[1]);
        $jwtHeader = json_decode($tokenHeader);
        $jwtPayload = json_decode($tokenPayload);
        if(isset($jwtPayload->username)){
            $user = $userRepository->findOneByEmail($jwtPayload->username);
            //dump($user);die;
            $userRepository->remove($user);
            //dump($user->getRoles()[0]);die;
            if($user->getRoles()[0] === 'ROLE_ADMIN'){
                // todo bien
                //dump($user->getRoles()[0]);die;
                $entityManager = $this->getDoctrine()->getManager();
                $registros = $entityManager->getRepository(FormularioContacto::class)->findAll();
            
                $json = $serializer->serialize($registros, 'json');
            }else{
                // todo mal
                $json = $serializer->serialize(['error:error'], 'json');
            }
        }else{
            //dump("Error en la carga de username");die;
            $json = $serializer->serialize(['error:error'], 'json');
        }
        
        

        return new Response($json, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
    #[Route('/formulario/nuevo', name: 'app_fomulario_contacto', methods:'GET')]
    public function nuevo(Request $request, EntityManagerInterface $em, MailerInterface $mailer): Response
    {
        $formulario = new FormularioContacto();
        $response = new Response();
        $date = new \DateTime('@'.strtotime('now'));
        $formulario->setCorreo($request->query->get('email'));
        $formulario->setNombre($request->query->get('nombre'));
        $formulario->setMotivo($request->query->get('texto'));
        $formulario->setFecha($date);
        $em->persist($formulario);
        $em->flush();

        $email = (new TemplatedEmail())
            ->from(new Address('f5web@juancarlosmacias.es', 'JCMS'))
            ->to($request->query->get('email'))
            ->subject('Tu formulario de contacto')
            ->htmlTemplate('registration/contacto_email.html.twig');

        $mailer->send($email);

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->setContent(json_encode([
            'registro' => "valido ",

        ]));
        return $response;
    }
}
