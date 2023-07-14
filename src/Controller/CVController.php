<?php

namespace App\Controller;

use App\Entity\CV;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CVController extends AbstractController
{
    // listado general
    #[Route('/cv', name: 'app_cv')]
    public function index(Request $request, SerializerInterface $serializer): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        // recuperar solo el primer registro
        //$CV = $entityManager->getRepository(CV::class)->findOneById(1);
        // recuperar todos los registros
        $CV = $entityManager->getRepository(CV::class)->findAll();

        $json = $serializer->serialize($CV, 'json');
        return new Response($json, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
    // listado general
    #[Route('/cv/new', name: 'app_cv_new', methods:'GET')]
    public function new(Request $request, SerializerInterface $serializer, UserRepository $userRepository, EntityManagerInterface $em): Response
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
            //$userRepository->remove($user);
            //dump($user->getRoles()[0]);die;
            if($user->getRoles()[0] === 'ROLE_ADMIN'){
                // todo bien
                //dump($user->getRoles()[0]);die;
                $r = $this->getDoctrine()->getManager();

                

                $CV = new CV();
                
                $CV->setDe($request->query->get('de'));
                $CV->setPeriodo($request->query->get('periodo'));
                $CV->setTitulo($request->query->get('titulo'));
                $CV->setEmpresa($request->query->get('empresa'));
                $CV->setDescripcion($request->query->get('descripcion'));
                $check = false;
                if($request->query->get('logros') == "on"){
                    $check = true;
                }
                //dump($check);die;
                $CV->setLogros($check);
                $CV->setLogro1($request->query->get('logro1'));
                $CV->setLogro2($request->query->get('logro2'));
                //dump($user->getRoles()[0]);die;
                $json = $serializer->serialize(["estado:insertado"], 'json');
                $em->persist($CV);
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


    #[Route('/cv/del', name: 'app_cv_del', methods:'GET')]
    public function del(Request $request, SerializerInterface $serializer, UserRepository $userRepository, EntityManagerInterface $em): Response
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
            //$userRepository->remove($user);
            //dump($user->getRoles()[0]);die;
            if($user->getRoles()[0] === 'ROLE_ADMIN'){
                // todo bien
                //dump($user->getRoles()[0]);die;
                //$r = $this->getDoctrine()->getManager();

                
                $entityManager = $this->getDoctrine()->getManager();
                $CV = new CV();
                $CV = $entityManager->getRepository(CV::class)->findOneById($request->query->get('id'));

                //dump($user->getRoles()[0]);die;
                $json = $serializer->serialize(["estado:eliminado"], 'json');
                $em->remove($CV);
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
