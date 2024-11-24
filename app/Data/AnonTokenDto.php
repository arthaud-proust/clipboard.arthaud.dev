<?php

namespace App\Data;

use App\Models\AnonUserToken;
use Spatie\LaravelData\Dto;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class AnonTokenDto extends Dto
{
    public function __construct(
        public int $id,
        public string $token,
    ) {
    }

    public static function fromModel(AnonUserToken $anonUserToken): self
    {
        return new self(
            $anonUserToken->id,
            $anonUserToken->token,
        );
    }
}
