<?php

namespace PR\VitrineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="PR\VitrineBundle\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Title", type="string", length=255)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date", type="datetime")
     */
    private $date;

    /**
     * @var bool
     *
     * @ORM\Column(name="published", type="boolean" , options={"default":0})
     */
    private $published;

    /**
     * @var string
     *
     * @ORM\Column(name="Content", type="text")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="editor", type="string", length=255)
     */
    private $editor;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Article
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set fKMenu
     *
     * @param integer $fKMenu
     *
     * @return Article
     */
    public function setFKMenu($fKMenu)
    {
        $this->fKMenu = $fKMenu;

        return $this;
    }

    /**
     * Get fKMenu
     *
     * @return int
     */
    public function getFKMenu()
    {
        return $this->fKMenu;
    }

    /**
     * Set editor
     *
     * @param string $editor
     *
     * @return Article
     */
    public function setEditor($editor)
    {
        $this->editor = $editor;

        return $this;
    }

    /**
     * Get editor
     *
     * @return string
     */
    public function getEditor()
    {
        return $this->editor;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Article
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }
}
