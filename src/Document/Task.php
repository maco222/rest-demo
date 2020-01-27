<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class Task
 * @MongoDB\Document
 */
class Task
{
    /**
     * @MongoDB\Id
     * @var int
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     * @var string
     */
    protected $title;

    /**
     * @MongoDB\Field(type="string")
     * @var string
     */
    protected $content;

    /**
     * @MongoDB\Field(type="date")
     * @var \DateTime
     */
    protected $created_at;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->created_at;
    }

    /**
     * @param \DateTime $created_at
     */
    public function setCreatedAt(\DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }
}
