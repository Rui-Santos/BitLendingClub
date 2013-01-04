<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @Table(name="documents")
 * @Entity(repositoryClass="Repository_Documents")
 */
class Entity_Documents
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
     * @var string $documentPath
     *
     * @Column(name="documentPath", type="string", length=256, precision=0, scale=0, nullable=true, unique=false)
     */
    private $documentPath;
    
    
    /**
     * @var string $reviewComment
     *
     * @Column(name="reviewComment", type="string", length=256, precision=0, scale=0, nullable=true, unique=false)
     */
    private $reviewComment;

    /**
     * @var boolean $isReviewed
     * 
     * @Column(name="reviewed", type="boolean", precision=0, scale=0, nullable=false, unique=false)
     */
    private $isReviewed;

    /**
     * @var datetime $createdAt
     *
     * @Column(name="dateUploaded", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $createdAt;

   
    /**
     * @var DocumentType
     *
     * @ManyToOne(targetEntity="Entity_DocumentTypes")
     * @JoinColumns({
     *   @JoinColumn(name="documentTypeId", referencedColumnName="id", nullable=true)
     * })
     */
    private $documentType;
    
    /**
     * @var Reviewer
     *
     * @ManyToOne(targetEntity="Entity_Users")
     * @JoinColumns({
     *   @JoinColumn(name="reviewerId", referencedColumnName="id", nullable=true)
     * })
     */
    private $reviewer;
    
    /**
     * @var User
     *
     * @ManyToOne(targetEntity="Entity_Users")
     * @JoinColumns({
     *   @JoinColumn(name="userId", referencedColumnName="id", nullable=true)
     * })
     */
    private $user;


    public function __construct()
    {

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
     * Set documentPath
     *
     * @param string $documentPath
     */
    public function setDocumentPath($documentPath)
    {
        $this->documentPath = $documentPath;
    }

    /**
     * Get documentPath
     *
     * @return string 
     */
    public function getDocumentPath()
    {
        return $this->documentPath;
    }

     /**
     * Set reviewComment
     *
     * @param string $reviewComment
     */
    public function setReviewComment($reviewComment)
    {
        $this->reviewComment = $reviewComment;
    }

    /**
     * Get reviewComment
     *
     * @return string 
     */
    public function getReviewComment()
    {
        return $this->reviewComment;
    }
    
    /**
     * Set isReviewed
     *
     * @param boolean $isReviewed
     */
    public function setIsReviewed($isReviewed)
    {
        $this->isReviewed = $isReviewed;
    }

    /**
     * Get isReviewed
     *
     * @return boolean 
     */
    public function getIsReviewed()
    {
        return $this->isReviewed;
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
     * Set reviewer
     *
     * @param Entity_Users $reviewer
     */
    public function setReviewer(Entity_Users $reviewer)
    {
        $this->reviewer = $reviewer;
    }

    /**
     * Get reviewer
     *
     * @return Entity_Users 
     */
    public function getReviewer()
    {
        return $this->reviewer;
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
    
    /**
     * Set documentType
     *
     * @param Entity_DocumentTypes $user
     */
    public function setDocumentType(Entity_DocumentTypes $documentType)
    {
        $this->documentType = $documentType;
    }

    /**
     * Get documentType
     *
     * @return Entity_DocumentTypes
     */
    public function getDocumentType()
    {
        return $this->documentType;
    }


    /**
     *
     * @return type 
     */
    public function toArray()
    {
        $result = array(
            'document_path' => $this->getDocumentPath(),
            'documenttype_id' => $this->getDocumentType()->getId(),
            'reviewer_id' => $this->getReviewer()->getId(),
            'user_id' => $this->getUser()->getId(),
            'is_reviewed' => $this->getIsReviewed()
        );

        return $result;
    }

}