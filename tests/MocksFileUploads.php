<?php

namespace Tests;

use Illuminate\Http\UploadedFile;
use function pathinfo;
use const PATHINFO_BASENAME;

trait MocksFileUploads
{
    /**
     * Get a mocked file upload.
     * This would be inserted into request data during a test.
     */
    public function uploadedFile(string $path): UploadedFile
    {
        $this->assertFileExists($path);

        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($fileInfo, $path);
        $name = pathinfo($path, PATHINFO_BASENAME);

        return new UploadedFile(
            $path, $name, $mime, test: true
        );
    }
}
