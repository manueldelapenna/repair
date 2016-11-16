<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reparation
 *
 * @ORM\Table(name="reparation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReparationRepository")
 */
class Reparation
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
     * @var string
     *
     * @ORM\Column(name="brand", type="string", length=255, nullable=true)
     */
    private $brand;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=255, nullable=true)
     */
    private $model;

    /**
     * @var string
     *
     * @ORM\Column(name="series", type="string", length=255, nullable=true)
     */
    private $series;

    /**
     * @var int
     *
     * @ORM\Column(name="joystick", type="integer", nullable=true)
     */
    private $joystick;

    /**
     * @var bool
     *
     * @ORM\Column(name="battery", type="boolean")
     */
    private $battery;

    /**
     * @var bool
     *
     * @ORM\Column(name="charger", type="boolean")
     */
    private $charger;

    /**
     * @var string
     *
     * @ORM\Column(name="diagnostic", type="text", nullable=true)
     */
    private $diagnostic;

    /**
     * @var string
     *
     * @ORM\Column(name="client_description", type="text", nullable=true)
     */
    private $clientDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="technical_report", type="text", nullable=true)
     */
    private $technicalReport;

    /**
     * @var float
     *
     * @ORM\Column(name="budget", type="float", nullable=true)
     */
    private $budget;
    
    /**
     * @var float
     *
     * @ORM\Column(name="payment", type="float", nullable=true)
     */
    private $payment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="entry_date", type="datetime")
     */
    private $entryDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="estimate_delivery_date", type="datetime", nullable=true)
     */
    private $estimateDeliveryDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="effective_delivery_date", type="datetime", nullable=true)
     */
    private $effectiveDeliveryDate;
    
    /**
     * @var string
     *
     * @ORM\Column(name="observations", type="text", nullable=true)
     */
    private $observations;
    
    /**
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="reparations")
     * @ORM\JoinColumn(name="customer_id", nullable=false, referencedColumnName="id")
     */
    private $customer;
    
    /**
     * @ORM\ManyToOne(targetEntity="RepairState", inversedBy="reparations")
     * @ORM\JoinColumn(name="state_id", nullable=false, referencedColumnName="id")
     */
    private $state;
    
    
    
//    public function __toString() {
//        return "Reparacion Nº" . $this->id . " - " . $this->customer;
//        
//    }

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
     * Set brand
     *
     * @param string $brand
     *
     * @return Reparation
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set model
     *
     * @param string $model
     *
     * @return Reparation
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set series
     *
     * @param string $series
     *
     * @return Reparation
     */
    public function setSeries($series)
    {
        $this->series = $series;

        return $this;
    }

    /**
     * Get series
     *
     * @return string
     */
    public function getSeries()
    {
        return $this->series;
    }

    /**
     * Set joystick
     *
     * @param integer $joystick
     *
     * @return Reparation
     */
    public function setJoystick($joystick)
    {
        $this->joystick = $joystick;

        return $this;
    }

    /**
     * Get joystick
     *
     * @return int
     */
    public function getJoystick()
    {
        return $this->joystick;
    }

    /**
     * Set battery
     *
     * @param boolean $battery
     *
     * @return Reparation
     */
    public function setBattery($battery)
    {
        $this->battery = $battery;

        return $this;
    }

    /**
     * Get battery
     *
     * @return bool
     */
    public function getBattery()
    {
        return $this->battery;
    }

    /**
     * Set charger
     *
     * @param boolean $charger
     *
     * @return Reparation
     */
    public function setCharger($charger)
    {
        $this->charger = $charger;

        return $this;
    }

    /**
     * Get charger
     *
     * @return bool
     */
    public function getCharger()
    {
        return $this->charger;
    }

    /**
     * Set diagnostic
     *
     * @param string $diagnostic
     *
     * @return Reparation
     */
    public function setDiagnostic($diagnostic)
    {
        $this->diagnostic = $diagnostic;

        return $this;
    }

    /**
     * Get diagnostic
     *
     * @return string
     */
    public function getDiagnostic()
    {
        return $this->diagnostic;
    }

    /**
     * Set clientDescription
     *
     * @param string $clientDescription
     *
     * @return Reparation
     */
    public function setClientDescription($clientDescription)
    {
        $this->clientDescription = $clientDescription;

        return $this;
    }

    /**
     * Get clientDescription
     *
     * @return string
     */
    public function getClientDescription()
    {
        return $this->clientDescription;
    }

    /**
     * Set technicalReport
     *
     * @param string $technicalReport
     *
     * @return Reparation
     */
    public function setTechnicalReport($technicalReport)
    {
        $this->technicalReport = $technicalReport;

        return $this;
    }

    /**
     * Get technicalReport
     *
     * @return string
     */
    public function getTechnicalReport()
    {
        return $this->technicalReport;
    }

    /**
     * Set budget
     *
     * @param float $budget
     *
     * @return Reparation
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * Get budget
     *
     * @return float
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * Set payment
     *
     * @param float $payment
     *
     * @return Reparation
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * Get payment
     *
     * @return float
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set entryDate
     *
     * @param \DateTime $entryDate
     *
     * @return Reparation
     */
    public function setEntryDate($entryDate)
    {
        $this->entryDate = $entryDate;

        return $this;
    }

    /**
     * Get entryDate
     *
     * @return \DateTime
     */
    public function getEntryDate()
    {
        return $this->entryDate;
    }

    /**
     * Set estimateDeliveryDate
     *
     * @param \DateTime $estimateDeliveryDate
     *
     * @return Reparation
     */
    public function setEstimateDeliveryDate($estimateDeliveryDate)
    {
        $this->estimateDeliveryDate = $estimateDeliveryDate;

        return $this;
    }

    /**
     * Get estimateDeliveryDate
     *
     * @return \DateTime
     */
    public function getEstimateDeliveryDate()
    {
        return $this->estimateDeliveryDate;
    }

    /**
     * Set effectiveDeliveryDate
     *
     * @param \DateTime $effectiveDeliveryDate
     *
     * @return Reparation
     */
    public function setEffectiveDeliveryDate($effectiveDeliveryDate)
    {
        $this->effectiveDeliveryDate = $effectiveDeliveryDate;

        return $this;
    }

    /**
     * Get effectiveDeliveryDate
     *
     * @return \DateTime
     */
    public function getEffectiveDeliveryDate()
    {
        return $this->effectiveDeliveryDate;
    }
    
     /**
     * Get observations
     *
     * @return string
     */
    function getObservations() {
        return $this->observations;
    }

    /**
     * Set observations
     *
     * @param string $observations
     *
     * @return Reparation
     */
    function setObservations($observations) {
        $this->observations = $observations;
    }
    
    /**
     * Get customer
     *
     * @return Customer
     */
    
    function getCustomer() {
        return $this->customer;
    }


    /**
     * Set customer
     *
     * @param \AppBundle\Entity\Customer $customer
     *
     * @return Reparation
     */
    public function setCustomer(\AppBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }
    
    /**
     * Get state
     *
     * @return RepairState
     */
    
    function getState() {
        return $this->state;
    }


    /**
     * Set customer
     *
     * @param \AppBundle\Entity\RepairState $state
     *
     * @return Reparation
     */
    public function setState(\AppBundle\Entity\Repairstate $state = null)
    {
        $this->state = $state;

        return $this;
    }

}

