<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Swagger\Annotations as SWG;

/**
 * Class Task
 * @MongoDB\Document
 */
class Task
{
    /**
     * @MongoDB\Id
     * @SWG\Property(type="integer")
     * @var int
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     * @SWG\Property(type="string")
     * @var string
     * @Assert\NotBlank()
     */
    protected $title;

    /**
     * @MongoDB\Field(type="string")
     * @SWG\Property(type="string")
     * @var string
     */
    protected $content;

    /**
     * @MongoDB\Field(type="boolean")
     * @SWG\Property(type="boolean")
     * @var boolean
     */
    protected $is_done;

    /**
     * @MongoDB\Field(type="date")
     * @SWG\Property(type="string", format="date-time")
     * @var \DateTime
     */
    protected $created_at;

    /**
     * Task constructor.
     */
    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setIsDone(false);
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
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
    public function getContent(): ?string
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

    /**
     * @return bool
     */
    public function isIsDone(): bool
    {
        return $this->is_done;
    }

    /**
     * @param bool $is_done
     */
    public function setIsDone(bool $is_done): void
    {
        $this->is_done = $is_done;
    }


}
