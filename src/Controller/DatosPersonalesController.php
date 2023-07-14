<?php

namespace App\Controller;

use App\Entity\DatosPersonales;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DatosPersonalesController extends AbstractController
{
    #[Route('/personales', name: 'app_datos_personales')]
    public function index(Request $request, SerializerInterface $serializer,): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        // recuperar solo el primer registro
        $DatosPersonales = $entityManager->getRepository(DatosPersonales::class)->findOneById(1);
        // recuperar todos los registros
        //$DatosPersonales = $entityManager->getRepository(DatosPersonales::class)->findAll();

        $json = $serializer->serialize($DatosPersonales, 'json');
        return new Response($json, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }


    #[Route('/personales/edit', name: 'app_edit_personales', methods:'GET')]
    public function edit(Request $request, SerializerInterface $serializer,  UserRepository $userRepository, EntityManagerInterface $em) : Response
    {
        //dump($request->query->get('bearer'));die;
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
            //$userRepository->remove($user);
            //dump($user->getRoles()[0]);die;
            if($user->getRoles()[0] === 'ROLE_ADMIN'){
                // todo bien
                //dump($user->getRoles()[0]);die;
                $r = $this->getDoctrine()->getManager();

                $DatosPersonales = $r->getRepository(DatosPersonales::class)->findOneById(1);

                // = new DatosPersonales();
                
                $DatosPersonales->setNombre($request->query->get('nombre'));
                $DatosPersonales->setApellidoUno($request->query->get('apellido_uno'));
                $DatosPersonales->setApellidoDos($request->query->get('apellido_dos'));
                $DatosPersonales->setTelefono($request->query->get('telefono'));
                $DatosPersonales->setCorreo($request->query->get('correo'));
                $DatosPersonales->setEnlace1([$request->query->get('porfolio')]);
                $DatosPersonales->setEnlace2([$request->query->get('linkedin')]);
                $DatosPersonales->setEnlace3([$request->query->get('otros')]);
                $DatosPersonales->setDefinicionCorta($request->query->get('titulo'));
                $DatosPersonales->setDefinicionLarga($request->query->get('texto'));
                

                $json = $serializer->serialize(["estado:actulizado"], 'json');
                $em->persist($DatosPersonales);
                $em->flush();
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
}
