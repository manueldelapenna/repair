<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * RepairState
 *
 * @ORM\Table(name="repair_state")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RepairStateRepository")
 * @UniqueEntity("name")
 */
class RepairState
{
    const PENDIENTE_PRESUPUESTACION = 1;
    const PENDIENTE_APROBACION = 2;
    const EN_REPARACION = 3;
    const REPARADO_RETIRAR = 4;
    const ENTREGADO = 5;
    const RECHAZADO_ANULADO = 6;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;
    
    /**
     * @ORM\OneToMany(targetEntity="Reparation", mappedBy="state")
     */
    private $reparations;
    
    public function __construct()
    {
        $this->reparations = new ArrayCollection();
    }
    
    public function __toString() {
        
        return $this->name;
        
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return RepairState
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Get reparations
     *
     * @return Array Reparation
     */
    public function getReparations()
    {
        return $this->reparations;

    }
}

