<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="notifications")
 */
class Notification
{
    /**
     * @MongoDB\Id
     */
    protected mixed $_id;

    /**
     * @MongoDB\ReferenceOne(targetDocument=User::class, inversedBy="notifications", storeAs="id")
     */
    protected User $user;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $title = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $message = null;

    /**
     * @MongoDB\Field(type="bool")
     */
    protected bool $isRead = false;

    /**
     * @return mixed
     */
    public function getId(): mixed
    {
        return $this->_id;
    }

    /**
     * @param mixed $id
     */
    public function setId(mixed $id): void
    {
        $this->_id = $id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     */
    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return bool
     */
    public function isRead(): bool
    {
        return $this->isRead;
    }

    /**
     * @param bool $isRead
     */
    public function setIsRead(bool $isRead): void
    {
        $this->isRead = $isRead;
    }

    public function toArray(): array
    {
        return [
          'id' => $this->getId(),
          'title' => $this->getTitle(),
          'message' => $this->getMessage(),
          'isRead' => $this->isRead(),
        ];
    }
}