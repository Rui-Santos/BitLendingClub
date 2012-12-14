<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Wallets
 *
 * @Table(name="roles")
 * @Entity(repositoryClass="Repository_Wallets")
 */
class Entity_Wallets {

    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $name
     *
     * @Column(name="walletPath", type="string", length=256, precision=0, scale=0, nullable=true, unique=false)
     */
    private $walletPath;

    /**
     * @var boolean $isEncrypted
     * 
     * @Column(name="isEncrypted", type="boolean", precision=0, scale=0, nullable=false, unique=false)
     */
    private $isEncrypted;

    /**
     * @var decimal $balance
     *
     * @Column(name="balance", type="decimal", precision=0, scale=0, nullable=true, unique=false)
     */
    private $balance;

    /**
     * @var Users
     *
     * @ManyToOne(targetEntity="Entity_Users")
     * @JoinColumns({
     *   @JoinColumn(name="userId", referencedColumnName="id", nullable=true)
     * })
     */
    private $user;

    public function __construct() {
        
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set walletPath
     *
     * @param string $walletPath
     */
    public function setWalletPath($walletPath) {
        $this->walletPath = $walletPath;
    }

    /**
     * Get walletPath
     *
     * @return string 
     */
    public function getWalletPath() {
        return $this->walletPath;
    }

    /**
     * Set isEncrypted
     *
     * @param boolean $isEncrypted
     */
    public function setIsEncrypted($isEncrypted) {
        $this->isEncrypted = $isEncrypted;
    }

    /**
     * Get isEncrypted
     *
     * @return boolean 
     */
    public function getIsEncrypted() {
        return $this->isEncrypted;
    }

    /**
     * Set user
     *
     * @param Entity_Users $user
     */
    public function setUser(Entity_Users $user) {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Entity_Users
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Set balance
     *
     * @param decimal $balance
     */
    public function setBalance($balance) {
        $this->balance = $balance;
    }

    /**
     * Get balance
     *
     * @return decimal 
     */
    public function getBalance() {
        return $this->balance;
    }

    /**
     *
     * @return type 
     */
    public function toArray() {
        $result = array(
            'wallet_path' => $this->getWalletPath(),
            'is_encrypted' => $this->getIsEncrypted(),
            'user_id' => $this->getUser()->getId(),
            'balance' => $this->getBalance()
        );

        return $result;
    }

}