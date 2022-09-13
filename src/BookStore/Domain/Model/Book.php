<?php

declare(strict_types=1);

namespace App\BookStore\Domain\Model;

use App\BookStore\Domain\ValueObject\BookId;

class Book
{
    public BookId $id;

    public function __construct()
    {
        $this->id = new BookId();
    }
}
