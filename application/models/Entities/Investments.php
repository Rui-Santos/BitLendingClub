<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Investments
 *
 * @Table(name="investments")
 * @Entity(repositoryClass="Repository_Investments")
 */
class Entity_Investments
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
     * @var Loan
     *
     * @ManyToOne(targetEntity="Entity_Loans")
     * @JoinColumns({
     *   @JoinColumn(name="loanId", referencedColumnName="id", nullable=true)
     * })
     */
    private $loan;

    /**
     * @var float
     *
     * @Column(name="amount", type="decimal", precision=0, scale=0, nullable=false, unique=false)
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @Column(name="dateInvested", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $dateinvested;

    /**
     * @var User
     *
     * @ManyToOne(targetEntity="Entity_Users")
     * @JoinColumns({
     *   @JoinColumn(name="investorId", referencedColumnName="id", nullable=true)
     * })
     */
    private $investor;

    /**
     * @var float
     *
     * @Column(name="rate", type="decimal", precision=0, scale=0, nullable=false, unique=false)
     */
    private $rate;
    
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
     * @var string
     *
     * @Column(name="investmentAddress", type="string", length=34, precision=0, scale=0, nullable=false, unique=false)
     */
    private $investmentaddress;


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
     * Set loan
     *
     * @param Entity_Loans $loan
     */
    public function setLoan(Entity_Loans $loan)
    {
        $this->loan = $loan;
    }

    /**
     * Get loan
     *
     * @return Entity_Loans 
     */
    public function getLoan()
    {
        return $this->loan;
    }

    /**
     * Set amount
     *
     * @param float $amount
     * @return Investments
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
     * Set dateinvested
     *
     * @param \DateTime $dateinvested
     * @return Investments
     */
    public function setDateinvested($dateinvested)
    {
        $this->dateinvested = $dateinvested;

        return $this;
    }

    /**
     * Get dateinvested
     *
     * @return \DateTime 
     */
    public function getDateinvested()
    {
        return $this->dateinvested;
    }

     /**
     * Set user
     *
     * @param Entity_Users $user
     */
    public function setInvestor(Entity_Users $user)
    {
        $this->investor = $user;
    }

    /**
     * Get user
     *
     * @return Entity_Users 
     */
    public function getInvestor()
    {
        return $this->investor;
    }

    /**
     * Set investmentaddress
     *
     * @param string $investmentaddress
     * @return Investments
     */
    public function setInvestmentaddress($investmentaddress)
    {
        $this->investmentaddress = $investmentaddress;

        return $this;
    }

    /**
     * Get investmentaddress
     *
     * @return string 
     */
    public function getInvestmentaddress()
    {
        return $this->investmentaddress;
    }
}
