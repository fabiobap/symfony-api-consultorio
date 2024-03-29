<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 *@ORM\Table(name="medicos")
 */
class Medico implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $crm;
    /**
     * @ORM\Column(type="string")
     */
    private $nome;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Especialidade")
     * @ORM\JoinColumn(nullable=false)
     */
    private $especialidade;

    public function getEspecialidade(): ?Especialidade
    {
        return $this->especialidade;
    }

    public function setEspecialidade(?Especialidade $especialidade): self
    {
        $this->especialidade = $especialidade;

        return $this;
    }
    
    public function getId(): ?int{
        return $this->id;
    }
        
    public function getCrm(): ?int{
        return $this->crm;
    }
    
    public function setCrm($crm): self{
        $this->crm = $crm;
        return $this;
    } 
    
    public function setNome($nome): self{
        $this->nome = $nome;
        return $this;
    }   
    
    public function getNome(): ?string{
        return $this->nome;
    }
    
    public function jsonSerialize(){

        return [
            'id' => $this->getId(),
            'crm' => $this->getCrm(),
            'nome' => $this->getNome(),
            'especialidadeId' => $this->getEspecialidade()->getId(),
            'especialidadeNome' => $this->getEspecialidade()->getDescricao(),
        ];
    }   
}
