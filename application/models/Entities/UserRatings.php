<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * User Ratings
 *
 * @Table(name="userRatings")
 * @Entity(repositoryClass="Repository_UserRatings")
 */
class Entity_UserRatings
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
     * @var text $comment
     *
     * @Column(name="comment", type="text", precision=0, scale=0, nullable=false, unique=false)
     */
    private $comment;

    /**
     * @var integer $rating
     *
     * @Column(name="rating", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $rating;

    /**
     * @var User
     *
     * @ManyToOne(targetEntity="Entity_Users")
     * @JoinColumns({
     *   @JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $user;

    /**
     * @var Commenter
     *
     * @ManyToOne(targetEntity="Entity_Users")
     * @JoinColumns({
     *   @JoinColumn(name="commenter_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $commenter;

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
     * Set comment
     *
     * @param float $comment
     * @return text
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return text 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set comment
     *
     * @param float $comment
     * @return text
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
        return $this;
    }

    /**
     * Get comment
     *
     * @return text 
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set user
     *
     * @param Entity_users $user
     * @return text
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return text 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set commenter
     *
     * @param Entity_users $commenter
     * @return text
     */
    public function setCommenter($commenter)
    {
        $this->commenter = $commenter;
        return $this;
    }

    /**
     * Get commenter
     *
     * @return text 
     */
    public function getCommenter()
    {
        return $this->commenter;
    }

}
