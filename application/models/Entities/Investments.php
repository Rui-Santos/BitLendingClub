<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Investments
 *
 * @Table(name="investments")
 * @Entity
 */
class Investments
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
     * @var integer
     *
     * @Column(name="loanId", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $loanid;

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
     * @var integer
     *
     * @Column(name="investorId", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $investorid;

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
     * Set loanid
     *
     * @param integer $loanid
     * @return Investments
     */
    public function setLoanid($loanid)
    {
        $this->loanid = $loanid;

        return $this;
    }

    /**
     * Get loanid
     *
     * @return integer 
     */
    public function getLoanid()
    {
        return $this->loanid;
    }

    /**
     * Set amount
     *
     * @param float $amount
     * @return Investments
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
     * Set investorid
     *
     * @param integer $investorid
     * @return Investments
     */
    public function setInvestorid($investorid)
    {
        $this->investorid = $investorid;

        return $this;
    }

    /**
     * Get investorid
     *
     * @return integer 
     */
    public function getInvestorid()
    {
        return $this->investorid;
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
