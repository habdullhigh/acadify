<?php

namespace App\Services;

use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Asset\File;
use Illuminate\Container\Attributes\Auth;
use Stringable;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadService
{
    public UploadApi $uploadApi;
    public function __construct()
    {
        $this->uploadApi = new UploadApi();
    }

    /**
     * Upload a file to Cloudinary.
     *
     * @param UploadedFile $file, $Filetype
     *
     */
    public function uploadFile(UploadedFile $file, $filetype, $matricNo){

        $name = $this->namingConvention($matricNo, $filetype);
        // Upload the file to Cloudinary

        $response = $this->uploadApi->upload($file->getPathname(), [
            'public_id' => $name,
            'use_filename' => TRUE,
            'overwrite' => TRUE,
        ]);
        return $response;

    }
    public function namingConvention(string $matricNo, string $type): string
    {
        $timestamp = now()->format('Ymd_His');
        return "{$matricNo}_{$type}_{$timestamp}";
    }
}
