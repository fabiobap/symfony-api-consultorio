<?php

namespace App\Controller;

use App\Entity\Especialidade;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EspecialidadeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EspecialidadesController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em; 
    /**
    * @var EspecialidadeRepository
    */
    private $especialidadeRepository;
    
    public function __construct(EntityManagerInterface $em, EspecialidadeRepository $especialidadeRepository){
        $this->em = $em;
        $this->especialidadeRepository = $especialidadeRepository;
    }
    /**
     * @Route("/especialidades", methods={"POST"})
     */
    public function nova(Request $request): Response
    {
        
        $dadosRequest = $request->getContent();
        $dadosEmJson = json_decode($dadosRequest);
        
        $especialidade = new Especialidade();
        $especialidade->setDescricao($dadosEmJson->descricao);
        
        $this->em->persist($especialidade);
        $this->em->flush();
        
        return new JsonResponse($especialidade);
    }
    
     /**
    * @Route("/especialidades", methods={"GET"})
    */
    public function buscarTodas(): Response{
        
        $especialidadeList = $this->especialidadeRepository->findAll();
        
        return new JsonResponse($especialidadeList);
    }
    
     /**
    * @Route("/especialidades/{id}", methods={"GET"})
    */
    public function buscarUm(int $id): Response{
        
        return new JsonResponse($this->especialidadeRepository->find($id));
    }
    /**
    * @Route("/especialidades/{id}", methods={"PUT"})
    */
    public function atualiza(int $id, Request $request){
        
        $dadosRequest = $request->getContent();
        $dadosEmJson = json_decode($dadosRequest);
        
        $especialidade = $this->especialidadeRepository->find($id);
        $especialidade->setDescricao($dadosEmJson->descricao);
        
        $this->em->flush();
        
        return new JsonResponse($especialidade);
    }
    
    /**
    * @Route("/especialidades/{id}", methods={"DELETE"})
    */   
    public function remove(int $id): Response{
        
        $especialidade = $this->especialidadeRepository->find($id);
        
        $this->em->remove($especialidade);
        $this->em->flush();
        
        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
