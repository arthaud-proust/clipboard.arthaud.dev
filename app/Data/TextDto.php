<?php

namespace App\Data;

use App\Models\Text;
use DateTime;
use Spatie\LaravelData\Dto;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class TextDto extends Dto
{
    public function __construct(
        public int $id,
        public string $content,
        public DateTime $createdAt,
        public DateTime $updatedAt,
    ) {
    }

    public static function fromModel(Text $text): self
    {
        return new self(
            $text->id,
            $text->content,
            $text->created_at,
            $text->updated_at,
        );
    }

}
