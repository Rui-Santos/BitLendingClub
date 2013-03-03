<?php

use Doctrine\ORM\Mapping as ORM,
    Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 * Loans
 *
 * @Table(name="loans")
 * @Entity(repositoryClass="Repository_Loans")
 */
class Entity_Loans
{

    /**
     * @var integer
     *
     * @Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $title
     *
     * @Column(name="title", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $title;

    /**
     * @var float
     *
     * @Column(name="amount", type="decimal", precision=0, scale=0, nullable=false, unique=false)
     */
    private $amount;

    /**
     * @var integer
     *
     * @Column(name="term", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $term;

    /**
     * @var integer
     *
     * @Column(name="frequency", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $frequency;

    /**
     * @var \DateTime
     *
     * @Column(name="expirationDate", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $expirationDate;

    /**
     * @var integer
     *
     * @Column(name="purpose", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $purpose;

    /**
     * @var Status
     *
     * @OneToOne(targetEntity="Entity_Loanstatus")
     * @JoinColumns({
     *   @JoinColumn(name="statusId", referencedColumnName="id", nullable=true)
     * })
     */
    private $status;

    /**
     * @var text $description
     *
     * @Column(name="description", type="text", precision=0, scale=0, nullable=false, unique=false)
     */
    private $description;

    /**
     * @var User
     *
     * @ManyToOne(targetEntity="Entity_Users")
     * @JoinColumns({
     *   @JoinColumn(name="borrowerId", referencedColumnName="id", nullable=true)
     * })
     */
    private $borrower;

    /**
     * @var ArrayCollection $payments
     * 
     * @OneToMany(targetEntity="Entity_Payments", mappedBy="loan", cascade={"persist"})
     */
    private $payments;

    /**
     * @var ArrayCollection $investments
     * 
     * @OneToMany(targetEntity="Entity_Investments", mappedBy="loan", cascade={"persist"})
     */
    private $investments;

    /**
     * 
     */
    public function __construct()
    {
        $this->payments = new ArrayCollection();
        $this->investments = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set amount
     *
     * @param float $amount
     * @return Loans
     */
    public function setAmount($amount)
    {
        $this->amount = $amount; //($amount * 1e8);

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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set term
     *
     * @param integer $term
     * @return Loans
     */
    public function setTerm($term)
    {
        $this->term = $term;

        return $this;
    }

    /**
     * Get term
     *
     * @return integer 
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * Set frequency
     *
     * @param integer $frequency
     * @return Loans
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;

        return $this;
    }

    /**
     * Get frequency
     *
     * @return integer 
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * Set expirationdate
     *
     * @param \DateTime $expirationdate
     * @return Loans
     */
    public function setExpirationdate($expirationdate)
    {
        $this->expirationDate = $expirationdate;

        return $this;
    }

    /**
     * Get expirationdate
     *
     * @return \DateTime 
     */
    public function getExpirationdate()
    {
        return $this->expirationDate;
    }

    /**
     * Set status
     *
     * @param Entity_Loanstatus $status
     */
    public function setStatus(Entity_Loanstatus $status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return Entity_Loanstatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set user
     *
     * @param Entity_Users $user
     */
    public function setBorrower(Entity_Users $user)
    {
        $this->borrower = $user;
    }

    /**
     * Get user
     *
     * @return Entity_Users 
     */
    public function getBorrower()
    {
        return $this->borrower;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set purpose
     *
     * @param text $purpose
     */
    public function setPurpose($purpose)
    {
        $this->purpose = $purpose;
    }

    /**
     * Get purpose
     *
     * @return text 
     */
    public function getPurpose()
    {
        return $this->purpose;
    }

    /**
     *
     * @param type $payments 
     */
    public function addPayment($payment)
    {
        $this->payments[] = $payment;
    }

    /**
     *
     * @return type 
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     *
     * @param type $payments 
     */
    public function addInvestment($investment)
    {
        $this->investments[] = $investment;
    }

    /**
     *
     * @return type 
     */
    public function getInvestments()
    {
        return $this->investments;
    }

}
