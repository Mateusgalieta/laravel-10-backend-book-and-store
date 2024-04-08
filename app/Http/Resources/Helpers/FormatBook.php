<?php

namespace App\Http\Resources\Helpers;

class FormatBook
{
    public static function execute($book): array
    {
        dd($book);

        return [
            'id' => $book->id,
            'name' => $book->name,
            'isbn' => $book->isbn,
            'value' => $book->value,
            'created_at' => $book->created_at,
            'updated_at' => $book->updated_at,
        ];
    }
}
