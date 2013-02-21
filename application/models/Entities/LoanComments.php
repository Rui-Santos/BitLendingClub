<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * LoanComments
 *
 * @Table(name="loanComments")
 * @Entity(repositoryClass="Repository_LoanComments")
 */
class Entity_LoanComments
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
     * @var \DateTime
     *
     * @Column(name="postedOn", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $postedOn;

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
     * @var string
     *
     * @Column(name="comment", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $comment;


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
     * Set postedOn
     *
     * @param \DateTime $postedOn
     * @return Investments
     */
    public function setPostedOn($postedOn)
    {
        $this->postedOn = $postedOn;

        return $this;
    }

    /**
     * Get postedOn
     *
     * @return \DateTime 
     */
    public function getPostedOn()
    {
        return $this->postedOn;
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
     * Set comment
     *
     * @param string $comment
     * @return Investments
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }
}
