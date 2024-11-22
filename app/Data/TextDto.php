<?php

namespace App\Data;

use Spatie\LaravelData\Dto;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class TextDto extends Dto
{

    public int $id;
    public string $content;
}
