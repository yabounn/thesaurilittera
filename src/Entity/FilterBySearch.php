<?php

namespace App\Entity;

class FilterBySearch
{
    /**
     * @var string|null
     */
    private $category;
    /**
     * @var string|null
     */
    private $bookTitle;
    /**
     * @var string|null
     */
    private $bookAuthor;


    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string|null $category
     * @return void
     */
    public function setCategory(?string $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBookTitle(): ?string
    {
        return $this->bookTitle;
    }

    /**
     * @param string|null $bookTitle
     * @return FilterBySearch
     */
    public function setBookTitle(?string $bookTitle): FilterBySearch
    {
        $this->bookTitle = $bookTitle;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBookAuthor(): ?string
    {
        return $this->bookAuthor;
    }

    /**
     * @param string|null $bookAuthor
     * @return FilterBySearch
     */
    public function setBookAuthor(?string $bookAuthor): FilterBySearch
    {
        $this->bookAuthor = $bookAuthor;

        return $this;
    }
}
