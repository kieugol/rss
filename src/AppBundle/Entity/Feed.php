<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="feed")
 */
class Feed
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $link;

    /**
     * @ORM\Column(type="datetime")
     */
    private $pub_date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $guid;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $category;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     *
     * @return self
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGuid($guid)
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     *
     * @return self
     */
    public function setGuid($guid)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPubDate()
    {
        return $this->pub_date;
    }

    /**
     * @param mixed $pub_date
     *
     * @return self
     */
    public function setPubDate($pub_date)
    {
        $this->pub_date = $pub_date;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     *
     * @return self
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     *
     * @return self
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * [getListColumnName description]
     * @return [type] [description]
     */
    public function getListColumnName()
    {
        return [
            'title',
            'description',
            'link',
            'guid',
            'category',
            'comment',
            'pub_date'
        ];
    }

    /**
     * Get table name
     *
     * @return string table name
     */
    public function getTableName()
    {
        return 'feed';
    }

    /**
     * [insert description]
     * 
     * @param  [type] $arrData [description]
     * @return [type]          [description]
     */
    public function insert($arrData) 
    {
        
    }

    public function update($arrData) 
    {
        
    }

    public function delete($arrData) 
    {
        
    }
}
