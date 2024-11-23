<?php

namespace App\Data;

use App\Models\Media;
use DateTime;
use Spatie\LaravelData\Dto;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class MediaDto extends Dto
{
    public function __construct(
        public int $id,
        public string $humanReadableSize,
        public string $filename,
        public string $mimetype,
        public string $url,
        public DateTime $createdAt,
        public DateTime $updatedAt,
    ) {
    }

    public static function fromModel(Media $media): self
    {
        return new self(
            $media->id,
            $media->humanReadableSize,
            $media->file_name,
            $media->mime_type,
            $media->getTemporaryUrl(now()->addMinutes(10)),
            $media->created_at,
            $media->updated_at,
        );
    }
}
