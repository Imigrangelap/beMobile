<?php

namespace App\Services;

use Cloudinary\Cloudinary;

class CloudinaryService
{
    protected $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary(env('CLOUDINARY_URL'));
    }

    public function uploadImage($file)
    {
        $upload = $this->cloudinary->uploadApi()->upload($file->getRealPath());
        return $upload['secure_url']; // atau ['public_id'] jika ingin simpan ID
    }
}
