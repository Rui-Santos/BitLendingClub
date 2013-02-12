<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Wallets
 *
 * @Table(name="wallets")
 * @Entity(repositoryClass="Repository_Wallets")
 */
class Entity_Wallets
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
     * @var float
     *
     * @Column(name="balance", type="decimal", precision=0, scale=0, nullable=false, unique=false)
     */
    private $balance;

    /**
     * @var User
     *
     * @ManyToOne(targetEntity="Entity_Users")
     * @JoinColumns({
     *   @JoinColumn(name="userId", referencedColumnName="id", nullable=true)
     * })
     */
    private $user;


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
     * Set user
     *
     * @param Entity_Users $user
     */
    public function setUser(Entity_Users $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Entity_Users 
     */
    public function getUser()
    {
        return $this->user;
    }
    
}
