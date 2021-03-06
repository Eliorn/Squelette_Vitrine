<?php

namespace PR\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 *
 * @ORM\Table(name="menuAdmin")
 * @ORM\Entity(repositoryClass="PR\AdminBundle\Repository\MenuAdminRepository")
 */
class MenuAdmin
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
     * @var bool
     *
     * @ORM\Column(name="showMenu", type="boolean")
     */
    private $showMenu;

    /**
     * @var string
     *
     * @ORM\Column(name="caption", type="string", length=255)
     */
    private $caption;

    /**
     * @var string
     *
     * @ORM\Column(name="pathname", type="string", length=255)
     */
    private $pathname;

    /**
     * @var string
     *
     * @ORM\Column(name="icontype", type="string", length=255)
     */
    private $icontype;

    /**
     * @var int
     *
     * @ORM\Column(name="order", type="integer")
     */
    private $order;

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
     * @return Menu
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
     * Set showMenu
     *
     * @param boolean $showMenu
     *
     * @return Menu
     */
    public function setShowMenu($showMenu)
    {
        $this->showMenu = $showMenu;

        return $this;
    }

    /**
     * Get showMenu
     *
     * @return bool
     */
    public function getShowMenu()
    {
        return $this->showMenu;
    }

    /**
     * Set caption
     *
     * @param string $caption
     *
     * @return Menu
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * Get caption
     *
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }



    /**
     * Set order
     *
     * @param \int $order
     *
     * @return Menu
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set pathname
     *
     * @param string $pathname
     *
     * @return Menu
     */
    public function setPathname($pathname)
    {
        $this->pathname = $pathname;

        return $this;
    }

    /**
     * Get pathname
     *
     * @return string
     */
    public function getPathname()
    {
        return $this->pathname;
    }

    /**
     * Set icontype
     *
     * @param string $icontype
     *
     * @return Menu
     */
    public function setIcontype($icontype)
    {
        $this->icontype = $icontype;

        return $this;
    }

    /**
     * Get icontype
     *
     * @return string
     */
    public function getIcontype()
    {
        return $this->icontype;
    }
}
