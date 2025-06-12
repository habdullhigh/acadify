<?php

namespace App\Services;
use Cloudinary\Cloudinary;

use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Asset\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log ;


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
            'use_filename' => true,
            'overwrite' => TRUE,
        ]);

        Log::channel('user')->info('User has performed an action', [

            'action' => 'uploaded a file',
            'response' => $response,
            'link' => $response['secure_url'],
        ]);
        return $response['secure_url'];

    }
    public function namingConvention(string $matricNo, string $type): string
    {
        $timestamp = now()->format('Ymd_His');
        return "{$matricNo}_{$type}_{$timestamp}";
    }
}
