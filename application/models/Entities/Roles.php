<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Roles
 *
 * @Table(name="roles")
 * @Entity(repositoryClass="Repository_Roles")
 */
class Entity_Roles
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
     * @var string $name
     *
     * @Column(name="name", type="string", length=256, precision=0, scale=0, nullable=true, unique=false)
     */
    private $name;
    
    /**
     * @var string $description
     *
     * @Column(name="description", type="string", length=256, precision=0, scale=0, nullable=true, unique=false)
     */
    private $description;

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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    
    /**
     *
     * @return type 
     */
    public function toArray()
    {
        $result = array(
            'name' => $this->getName(),
            'description' => $this->getDescription()
        );

        return $result;
    }

}