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
     * @Column(name="username", type="string", length=150, precision=0, scale=0, nullable=true, unique=false)
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
    private $password;

    /**
     * @var boolean $isEmailConfirmed
     *
     * @Column(name="is_email_confirmed", type="boolean", precision=0, scale=0, nullable=false, unique=false)
     */
    private $isEmailConfirmed;

    /**
     * @var boolean $isAgreeTermsConditions
     * 
     * @Column(name="is_agree_terms_conditions", type="boolean", precision=0, scale=0, nullable=false, unique=false)
     */
    private $isAgreeTermsConditions;

    /**
     * @var boolean $isActive
     * 
     * @Column(name="is_active", type="boolean", precision=0, scale=0, nullable=false, unique=false)
     */
    private $isActive;

    /**
     * @var string $firstname
     *
     * @Column(name="firstname", type="string", length=100, precision=0, scale=0, nullable=false, unique=false)
     */
    private $firstname;

    /**
     * @var string $lastname
     *
     * @Column(name="lastname", type="string", length=100, precision=0, scale=0, nullable=false, unique=false)
     */
    private $lastname;

    /**
     * @var text $title
     *
     * @Column(name="title", type="string", length=10, precision=0, scale=0, nullable=false, unique=false)
     */
    private $title;

    /**
     * @var bigint $fbUserId
     *
     * @Column(name="fb_user_id", type="bigint", precision=0, scale=0, nullable=true, unique=false)
     */
    private $fbUserId;

    /**
     * @var integer $loginCount
     *
     * @Column(name="login_count", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $loginCount;

    /**
     * @var datetime $createdAt
     *
     * @Column(name="created_at", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $createdAt;

    /**
     * @var datetime $updatedAt
     *
     * @Column(name="updated_at", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $updatedAt;

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
     * @var decimal $debitAmount
     *
     * @Column(name="debit_amount", type="decimal", precision=8, scale=2, nullable=false, unique=false)
     */
    private $debitAmount;

    /**
     * @var string $avatar
     *
     * @Column(name="avatar", type="string", length=100, precision=0, scale=0, nullable=true, unique=false)
     */
    private $avatar;

    /**
     * @var date $birthDate
     *
     * @Column(name="birthdate", type="date", precision=0, scale=0, nullable=true, unique=false)
     */
    private $birthDate;

    /**
     * @var text $address
     *
     * @Column(name="address", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $address;

    /**
     * @var Entity_Countries
     *
     * @ManyToOne(targetEntity="Entity_Countries")
     * @JoinColumns({
     *   @JoinColumn(name="country_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $country;

//    /**
//     * @var Entity_Cities
//     *
//     * @ManyToOne(targetEntity="Entity_Cities")
//     * @JoinColumns({
//     *   @JoinColumn(name="city_id", referencedColumnName="id", nullable=true)
//     * })
//     */
//    private $city;

//    /**
//     * @var Entity_Municipalities
//     *
//     * @ManyToOne(targetEntity="Entity_Municipalities")
//     * @JoinColumns({
//     *   @JoinColumn(name="municipality_id", referencedColumnName="id", nullable=true)
//     * })
//     */
//    private $municipality;

    /**
     * @var string $gender
     *
     * @Column(name="gender", type="string", length=1, precision=0, scale=0, nullable=true, unique=false)
     */
    private $gender;

    /**
     * @var string $twitterAccessToken
     *
     * @Column(name="twitter_access_token", type="string", length=400, precision=0, scale=0, nullable=true, unique=false)
     */
    private $twitterAccessToken;

    /**
     * @var string $twitterAccessTokenSecret
     *
     * @Column(name="twitter_access_token_secret", type="string", length=400, precision=0, scale=0, nullable=true, unique=false)
     */
    private $twitterAccessTokenSecret;

    /**
     * @var string $confirmationKey
     *
     * @Column(name="confirmation_key", type="string", length=32, precision=0, scale=0, nullable=true, unique=false)
     */
    private $confirmationKey;

    /**
     * @var integer $socialAccountType
     *
     * @Column(name="social_account_type", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $socialAccountType;

//    /**
//     * @var ArrayCollection $friends
//     * @OneToMany(targetEntity="Entity_Friends", mappedBy="userA")
//     */
//    private $friends;

//    /**
//     * @var ArrayCollection $profileAccessSettings
//     * @OneToMany(targetEntity="Entity_ProfileAccess", mappedBy="user")
//     */
//    private $profileAccessSettings;
//
//    /**
//     * @var ArrayCollection $subscriptions
//     * @OneToMany(targetEntity="Entity_UserSubscriptions", mappedBy="user")
//     */
//    private $subscriptions;
//
//    /**
//     * @var ArrayCollection $affiliates
//     * @OneToMany(targetEntity="Entity_Affiliate", mappedBy="user")
//     */
//    private $affiliates;
//    
//    /**
//     *
//     * @OneToMany(targetEntity="Entity_Transactions", mappedBy="user")
//     */
//    private $transactions;
//    
//    /**
//     * @var ArrayCollection $badges
//     * @OneToMany(targetEntity="Entity_UserBadges", mappedBy="user")
//     */
//    private $userBadges;
//    
//    /**
//     * @var ArrayCollection $comments
//     * @OneToMany(targetEntity="Entity_Comments", mappedBy="user")
//     */
//    private $comments;

    public function __construct()
    {
        $this->loginCount = 0;
        $this->debitAmount = 0.00;
        $this->isEmailConfirmed = 0;
        $this->isActive = 1;
        $this->socialAccountType = Model_User::PUBLIC_AND_FRIEND;
        $this->friends = new \Doctrine\Common\Collections\ArrayCollection();
        $this->profileAccessSettings = new Doctrine\Common\Collections\ArrayCollection();
        $this->subscriptions = new Doctrine\Common\Collections\ArrayCollection();
        $this->affiliates = new Doctrine\Common\Collections\ArrayCollection();
        $this->transactions = new Doctrine\Common\Collections\ArrayCollection();
        $this->userBadges = new Doctrine\Common\Collections\ArrayCollection();
        $this->comments = new Doctrine\Common\Collections\ArrayCollection();
        
        $this->isAgreeTermsConditions = true;
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

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set isEmailConfirmed
     *
     * @param boolean $isEmailConfirmed
     */
    public function setIsEmailConfirmed($isEmailConfirmed)
    {
        $this->isEmailConfirmed = $isEmailConfirmed;
    }

    /**
     * Get isEmailConfirmed
     *
     * @return boolean 
     */
    public function getIsEmailConfirmed()
    {
        return $this->isEmailConfirmed;
    }

    /**
     * Set isAgreeTermsConditions
     *
     * @param boolean $isAgreeTermsConditions
     */
    public function setIsAgreeTermsConditions($isAgreeTermsConditions)
    {
        $this->isAgreeTermsConditions = $isAgreeTermsConditions;
    }

    /**
     * Get isAgreeTermsConditions
     *
     * @return boolean 
     */
    public function getIsAgreeTermsConditions()
    {
        return $this->isAgreeTermsConditions;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

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

    /**
     * Set title
     *
     * @param text $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return text 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set fbUserId
     *
     * @param bigint $fbUserId
     */
    public function setFbUserId($fbUserId)
    {
        $this->fbUserId = $fbUserId;
    }

    /**
     * Get fbUserId
     *
     * @return bigint 
     */
    public function getFbUserId()
    {
        return $this->fbUserId;
    }

    /**
     * Set loginCount
     *
     * @param integer $loginCount
     */
    public function setLoginCount($loginCount)
    {
        $this->loginCount = $loginCount;
    }

    /**
     * Get loginCount
     *
     * @return integer 
     */
    public function getLoginCount()
    {
        return $this->loginCount;
    }

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
     * Set updatedAt
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updatedAt
     *
     * @return datetime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    

    /**
     * Set country
     *
     * @param Entity_Countries $country
     */
    public function setCountry(Entity_Countries $country = null)
    {
        $this->country = $country;
    }

    /**
     * Get country
     *
     * @return Entity_Countries
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set city
     *
     * @param Entity_Cities $city
     */
    public function setCity(Entity_Cities $city = null)
    {
        $this->city = $city;
    }

    /**
     * Get city
     *
     * @return Entity_Cities
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set municipality
     *
     * @param Entity_Municipalities $municipality
     */
    public function setMunicipality(Entity_Municipalities $municipality = null)
    {
        $this->municipality = $municipality;
    }

    /**
     * Get municipality
     *
     * @return Entity_Municipality
     */
    public function getMunicipality()
    {
        return $this->municipality;
    }

    /**
     * Set gender
     *
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set debitAmount
     *
     * @param decimal $debitAmount
     */
    public function setDebitAmount($debitAmount)
    {
        $this->debitAmount = $debitAmount;
    }

    /**
     * Get debitAmount
     *
     * @return decimal 
     */
    public function getDebitAmount()
    {
        return $this->debitAmount;
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
     *
     * @param type $avatar 
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     *
     * @return type 
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set birthDate
     *
     * @param date $birthDate
     */
    public function setBirthDate($date)
    {
        $this->birthDate = $date;
    }

    /**
     * Get birthDate
     *
     * @return date 
     */
    public function getBirthDate()
    {
        $result = null;
        if ($this->birthDate) {
            $result = $this->birthDate->format('d/m/Y');
        }

        return $result;
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

    /**
     *
     * @param type $token 
     */
    public function setTwitterAccessToken($token)
    {
        $this->twitterAccessToken = $token;
    }

    /**
     *
     * @return type 
     */
    public function getTwitterAccessToken()
    {
        return $this->twitterAccessToken;
    }

    /**
     *
     * @param type $tokenSecret 
     */
    public function setTwitterAccessTokenSecret($tokenSecret)
    {
        $this->twitterAccessTokenSecret = $tokenSecret;
    }

    /**
     *
     * @return type 
     */
    public function getTwitterAccessTokenSecret()
    {
        return $this->twitterAccessTokenSecret;
    }

    /**
     * Set confirmationKey
     *
     * @param string $confirmationKey
     */
    public function setConfirmationKey($confirmationKey)
    {
        $this->confirmationKey = $confirmationKey;
    }

    /**
     * Get confirmationKey
     *
     * @return string 
     */
    public function getConfirmationKey()
    {
        return $this->confirmationKey;
    }

    /**
     * Set socialAccountType
     *
     * @param boolean $socialAccountType
     */
    public function setSocialAccountType($socialAccountType)
    {
        $this->socialAccountType = $socialAccountType;
    }

    /**
     * Get socialAccountType
     *
     * @return boolean 
     */
    public function getSocialAccountType()
    {
        return $this->socialAccountType;
    }

    /**
     *
     * @return type 
     */
    public function getFriends()
    {
        return $this->friends;
    }

    /**
     *
     * @param Entity_Friends $friend 
     */
    public function addFriend(Entity_Friends $friend)
    {
        $this->friends[] = $friend;
    }

    /**
     *
     * @return type 
     */
    public function getProfileAccessSettings()
    {
        return $this->profileAccessSettings;
    }

    /**
     *
     * @param Entity_ProfileAccess $setting 
     */
    public function addProfileAccessSetting(Entity_ProfileAccess $setting)
    {
        $this->profileAccessSettings[] = $setting;
    }

    /**
     *
     * @return type 
     */
    public function addSubscription($subscription)
    {
        $this->subscriptions[] = $subscription;
    }

    /**
     *
     * @return type 
     */
    public function getSubscriptions()
    {
        return $this->subscriptions;
    }

    /**
     *
     * @return type 
     */
    public function addAffiliate($affiliate)
    {
        $this->affiliates[] = $affiliate;
    }

    /**
     *
     * @return type 
     */
    public function getAffiliates()
    {
        return $this->affiliates;
    }
    
    /**
     *
     * @return transactions
     */
    public function addTransaction($transaction)
    {
    	$this->transactions[] = $transaction;
    }
    
    /**
     *
     * @return transactions
     */
    public function getTransactions()
    {
    	return $this->transactions;
    }
    
    /**
     *
     * @return badges
     */
    public function addUserBadge($userBadge)
    {
    	$this->userBadges[] = $userBadge;
    }
    
    /**
     *
     * @return transactions
     */
    public function getUserBadges()
    {
    	return $this->userBadges;
    }
    
    /**
     *
     * @return comments
     */
    public function getComments()
    {
    	return $this->comments;
    }
    /**
     *
     * @param comments $comemnts
     */
    public function addComments($comment)
    {
    	$this->comment[] = $comment;
    }
    
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
            'title' => $this->getTitle(),
            'role_id' => $this->getRole()->getId(),
            'fb_user_id' => $this->getFbUserId(),
            'birthDate' => $this->getBirthDate(),
            'avatar' => $this->getAvatar(),
            'address' => $this->getAddress(),
            'username' => $this->getUsername(),
            'twitterAccessToken' => $this->getTwitterAccessToken(),
            'twitterAccessTokenSecret' => $this->getTwitterAccessTokenSecret(),
            'gender' => $this->getGender(),
            'socialAccountType' => $this->getSocialAccountType(),
        );

        if ($this->getCountry()) {
            $result['country_id'] = $this->getCountry()->getId();
        }

        if ($this->getMunicipality()) {
            $result['municipality_id'] = $this->getMunicipality()->getId();
        }

        if ($this->getCity()) {
            $result['city_id'] = $this->getCity()->getId();
        }

        return $result;
    }

}