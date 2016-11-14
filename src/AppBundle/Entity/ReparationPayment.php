<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReparationPayment
 *
 * @ORM\Table(name="reparation_payment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReparationPaymentRepository")
 */
class ReparationPayment
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float")
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="concept", type="text")
     */
    private $concept;
    
    /**
     * @ORM\ManyToOne(targetEntity="Reparation", inversedBy="payments")
     * @ORM\JoinColumn(name="reparation_id", nullable=false, referencedColumnName="id")
     */
    private $reparation;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return ReparationPayment
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set amount
     *
     * @param float $amount
     *
     * @return ReparationPayment
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set concept
     *
     * @param string $concept
     *
     * @return ReparationPayment
     */
    public function setConcept($concept)
    {
        $this->concept = $concept;

        return $this;
    }

    /**
     * Get concept
     *
     * @return string
     */
    public function getConcept()
    {
        return $this->concept;
    }
    
    function getReparation() {
        return $this->reparation;
    }

    function setReparation($reparation) {
        $this->reparation = $reparation;
    }


}

