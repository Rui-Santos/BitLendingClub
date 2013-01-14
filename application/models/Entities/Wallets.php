<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Wallets
 *
 * @Table(name="wallets")
 * @Entity
 */
class Wallets
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
     * @var string
     *
     * @Column(name="walletPath", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $walletpath;

    /**
     * @var boolean
     *
     * @Column(name="isEncrypted", type="boolean", precision=0, scale=0, nullable=false, unique=false)
     */
    private $isencrypted;

    /**
     * @var float
     *
     * @Column(name="balance", type="decimal", precision=0, scale=0, nullable=false, unique=false)
     */
    private $balance;

    /**
     * @var integer
     *
     * @Column(name="userId", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $userid;


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
     * Set walletpath
     *
     * @param string $walletpath
     * @return Wallets
     */
    public function setWalletpath($walletpath)
    {
        $this->walletpath = $walletpath;

        return $this;
    }

    /**
     * Get walletpath
     *
     * @return string 
     */
    public function getWalletpath()
    {
        return $this->walletpath;
    }

    /**
     * Set isencrypted
     *
     * @param boolean $isencrypted
     * @return Wallets
     */
    public function setIsencrypted($isencrypted)
    {
        $this->isencrypted = $isencrypted;

        return $this;
    }

    /**
     * Get isencrypted
     *
     * @return boolean 
     */
    public function getIsencrypted()
    {
        return $this->isencrypted;
    }

    /**
     * Set balance
     *
     * @param float $balance
     * @return Wallets
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * Get balance
     *
     * @return float 
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Set userid
     *
     * @param integer $userid
     * @return Wallets
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return integer 
     */
    public function getUserid()
    {
        return $this->userid;
    }
}
