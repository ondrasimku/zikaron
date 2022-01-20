<?php

class Post
{
    private string $header;
    private ?string $text;
    private int $id;
    private ?int $parentId;
    private ?string $latitude;
    private ?string $longitude;
    private ?string $link;


    /**
     * @param string $header
     * @param string|null $text
     * @param int $id
     * @param int|null $parentId
     */
    public function __construct(string $header, ?string $text, int $id, ?int $parentId, ?string $latitude, ?string $longitude, ?string $link)
    {
        $this->header = $header;
        $this->text = $text;
        $this->id = $id;
        $this->parentId = $parentId;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->link = $link;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        if($this->text === null)
            return "";
        return $this->text;
    }

    /**
     * @param string $text
     * @return Post
     */
    public function setText(string $text): Post
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Post
     */
    public function setId(int $id): Post
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getParentId(): int
    {
        return $this->parentId;
    }

    /**
     * @param int $parentId
     * @return Post
     */
    public function setParentId(int $parentId): Post
    {
        $this->parentId = $parentId;
        return $this;
    }

    /**
     * @return string
     */
    public function getHeader(): string
    {
        return $this->header;
    }

    /**
     * @param string $header
     * @return Post
     */
    public function setHeader(string $header): Post
    {
        $this->header = $header;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    /**
     * @param string|null $latitude
     * @return Post
     */
    public function setLatitude(?string $latitude): Post
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    /**
     * @param string|null $longitude
     * @return Post
     */
    public function setLongitude(?string $longitude): Post
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @param string|null $link
     * @return Post
     */
    public function setLink(?string $link): Post
    {
        $this->link = $link;
        return $this;
    }
}