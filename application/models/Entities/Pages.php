<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @Table(name="pages")
 * @Entity(repositoryClass="Repository_Pages")
 */
class Entity_Pages
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
     * @var string $title
     *
     * @Column(name="title", type="string", length=256, precision=0, scale=0, nullable=true, unique=false)
     */
    private $title;
    
    
    /**
     * @var string $slug
     *
     * @Column(name="slug", type="string", length=256, precision=0, scale=0, nullable=true, unique=false)
     */
    private $slug;
    
    /**
     * @var string $metaKeywords
     *
     * @Column(name="metaKeywords", type="string", length=256, precision=0, scale=0, nullable=true, unique=false)
     */
    private $metaKeywords;
    
    /**
     * @var string $metaDescription
     *
     * @Column(name="metaDescription", type="string", length=256, precision=0, scale=0, nullable=true, unique=false)
     */
    private $metaDescription;

     /**
     * @var text $content
     *
     * @Column(name="content", type="text", precision=0, scale=0, nullable=false, unique=false)
     */
    private $content;

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
     * Set metaKeywords
     *
     * @param string $metaKeywords
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;
    }

    /**
     * Get metaKeywords
     *
     * @return string 
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }     
    
    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;
    }

    /**
     * Get metaDescription
     *
     * @return string 
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }    
    
    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    /**
     * Set content
     *
     * @param text $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return text 
     */
    public function getContent()
    {
        return $this->content;
    }   

    

    /**
     *
     * @return type 
     */
    public function toArray()
    {
        $result = array(
            'title' => $this->getTitle(),
            'content' => $this->getContent(),
            'slug' => $this->getSlug(),
            'meta_keywords' => $this->getMetaKeywords(),
            'meta_description' => $this->getMetaDescription(),
        );
        
        return $result;
    }

}