<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @Table(name="users")
 * @Entity(repositoryClass="Repository_Users")
 */
class Entity_Users
{

    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $username
     *
     * @Column(name="userName", type="string", length=150, precision=0, scale=0, nullable=true, unique=false)
     */
    private $username;

    /**
     * @var string $email
     *
     * @Column(name="email", type="string", length=150, precision=0, scale=0, nullable=false, unique=false)
     */
    private $email;

    /**
     * @var string $password
     *
     * @Column(name="password", type="string", length=32, precision=0, scale=0, nullable=true, unique=false)
     */
//    private $password;

    /**
     * @var boolean $isActive
     * 
     * @Column(name="is_active", type="boolean", precision=0, scale=0, nullable=false, unique=false)
     */
//    private $isActive;

    /**
     * @var string $firstname
     *
     * @Column(name="firstName", type="string", length=100, precision=0, scale=0, nullable=false, unique=false)
     */
    private $firstname;

    /**
     * @var string $lastname
     *
     * @Column(name="lastName", type="string", length=100, precision=0, scale=0, nullable=false, unique=false)
     */
    private $lastname;

    /**
     * @var bigint $fbUserId
     *
     * @Column(name="fb_user_id", type="bigint", precision=0, scale=0, nullable=true, unique=false)
     */
//    private $fbUserId;

    /**
     * @var datetime $createdAt
     *
     * @Column(name="dateRegistered", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $createdAt;

   
//    /**
//     * @var UserRoles
//     *
//     * @ManyToOne(targetEntity="Entity_UserRoles")
//     * @JoinColumns({
//     *   @JoinColumn(name="role_id", referencedColumnName="id", nullable=true)
//     * })
//     */
//    private $role;

    /**
     * @var text $address
     *
     * @Column(name="address", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $address;

    /**
     * @var string $twitterAccessToken
     *
     * @Column(name="twitter_access_token", type="string", length=400, precision=0, scale=0, nullable=true, unique=false)
     */
//    private $twitterAccessToken;

    /**
     * @var string $twitterAccessTokenSecret
     *
     * @Column(name="twitter_access_token_secret", type="string", length=400, precision=0, scale=0, nullable=true, unique=false)
     */
 //   private $twitterAccessTokenSecret;

    public function __construct()
    {
 //       $this->isActive = 1;
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
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

//    /**
//     * Set password
//     *
//     * @param string $password
//     */
//    public function setPassword($password)
//    {
//        $this->password = $password;
//    }
//
//    /**
//     * Get password
//     *
//     * @return string 
//     */
//    public function getPassword()
//    {
//        return $this->password;
//    }
//
//    /**
//     * Set isActive
//     *
//     * @param boolean $isActive
//     */
//    public function setIsActive($isActive)
//    {
//        $this->isActive = $isActive;
//    }
//
//    /**
//     * Get isActive
//     *
//     * @return boolean 
//     */
//    public function getIsActive()
//    {
//        return $this->isActive;
//    }

    /**
     * Set firstname
     *
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

//    /**
//     * Set fbUserId
//     *
//     * @param bigint $fbUserId
//     */
//    public function setFbUserId($fbUserId)
//    {
//        $this->fbUserId = $fbUserId;
//    }
//
//    /**
//     * Get fbUserId
//     *
//     * @return bigint 
//     */
//    public function getFbUserId()
//    {
//        return $this->fbUserId;
//    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     *
     * @return type 
     */
    public function getFullname()
    {
        return $this->getFirstname() . ' ' . $this->getLastname();
    }

    /**
     * Set address
     *
     * @param text $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Get address
     *
     * @return text 
     */
    public function getAddress()
    {
        return $this->address;
    }

//    /**
//     *
//     * @param type $token 
//     */
//    public function setTwitterAccessToken($token)
//    {
//        $this->twitterAccessToken = $token;
//    }
//
//    /**
//     *
//     * @return type 
//     */
//    public function getTwitterAccessToken()
//    {
//        return $this->twitterAccessToken;
//    }
//
//    /**
//     *
//     * @param type $tokenSecret 
//     */
//    public function setTwitterAccessTokenSecret($tokenSecret)
//    {
//        $this->twitterAccessTokenSecret = $tokenSecret;
//    }
//
//    /**
//     *
//     * @return type 
//     */
//    public function getTwitterAccessTokenSecret()
//    {
//        return $this->twitterAccessTokenSecret;
//    }

    /**
     *
     * @return type 
     */
    public function toArray()
    {
        $result = array(
            'email' => $this->getEmail(),
            'firstname' => $this->getFirstname(),
            'lastname' => $this->getLastname(),
           // 'role_id' => $this->getRole()->getId(),
            //'fb_user_id' => $this->getFbUserId(),
            'address' => $this->getAddress(),
            'username' => $this->getUsername(),
            //'twitterAccessToken' => $this->getTwitterAccessToken(),
            //'twitterAccessTokenSecret' => $this->getTwitterAccessTokenSecret(),
        );

        return $result;
    }

}