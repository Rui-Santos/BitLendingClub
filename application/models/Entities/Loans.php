<?php



use Doctrine\ORM\Mapping as ORM;

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
     * @var float
     *
     * @Column(name="rate", type="decimal", precision=0, scale=0, nullable=false, unique=false)
     */
    private $rate;

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
     * @var Status
     *
     * @ManyToOne(targetEntity="Entity_Loanstatus")
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
     * Set rate
     *
     * @param float $rate
     * @return Loans
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return float 
     */
    public function getRate()
    {
        return $this->rate;
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
}