<?php

namespace App\Data;

use App\Models\User;
use Spatie\LaravelData\Dto;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class AnonUserDto extends Dto
{
    public function __construct(
        public int $id,
        public string $email,
    ) {
    }

    public static function fromModel(User $user): self
    {
        return new self(
            $user->id,
            $user->email,
        );
    }
}
