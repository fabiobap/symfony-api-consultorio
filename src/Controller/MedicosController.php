<?php

namespace App\Controller;

use App\Entity\Medico;
use App\Helper\MedicoFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedicosController extends AbstractController{
    
    /**
     * @var EntityManagerInterface
     */
    private $em;    
    /**
     * @var MedicoFactory
     */
    private $medicoFactory;
    
    public function __construct(EntityManagerInterface $em, MedicoFactory $medicoFactory){
        $this->em = $em;
        $this->medicoFactory = $medicoFactory;
    }
    
    /**
    * @Route("/medicos", methods={"POST"})
    */
    public function novo(Request $request): Response{
      
        $corpoRequisicao = $request->getContent();
        
        $medico = $this
            ->medicoFactory
            ->criarMedico($corpoRequisicao);
        
        $this->em->persist($medico);
        $this->em->flush();
        
        return new JsonResponse($medico);
    }
    /**
    * @Route("/medicos", methods={"GET"})
    */
    public function buscarTodos(): Response{
        
        $repositorio = $this
            ->getDoctrine()
            ->getRepository(Medico::class);
        
        $list = $repositorio->findAll();
        
        return new JsonResponse($list);
    }
    /**
    * @Route("/medicos/{id}", methods={"GET"})
    */
    public function buscarUm(int $id): Response{
        
        $medico = $this->buscaMedico($id);
        
        $codigoRetorno = is_null($medico) ? Response::HTTP_NO_CONTENT : 200;
        
        return new JsonResponse($medico, $codigoRetorno);
    }
    
    /**
    * @Route("/medicos/{id}", methods={"PUT"})
    */   
    public function atualiza(int $id, Request $request): Response{
        
        $corpoRequisicao = $request->getContent();

        $medicoEnviado = $this
            ->medicoFactory
            ->criarMedico($corpoRequisicao);

        $medicoExistente = $this->buscaMedico($id);
        
        if(is_null($medicoExistente)){
            return new Response("You suck", Response::HTTP_NOT_FOUND);
        }
        
        $medicoExistente
            ->setCrm($medicoEnviado->getCrm())
            ->setNome($medicoEnviado->getNome())
            ->setEspecialidade($medicoEnviado->getEspecialidade());
        
        $this->em->flush();
        return new JsonResponse($medicoExistente);
    }
    
    /**
    * @Route("/medicos/{id}", methods={"DELETE"})
    */   
    public function remove(int $id): Response{
        
        $medico = $this->buscaMedico($id);
        
        $this->em->remove($medico);
        $this->em->flush();
        
        return new Response('', Response::HTTP_NO_CONTENT);
    }
    
    
    public function buscaMedico(int $id){
        
        $repositorio = $this
            ->getDoctrine()
            ->getRepository(Medico::class);
        
        $medico = $repositorio->find($id);
        
        return $medico;
    }
}