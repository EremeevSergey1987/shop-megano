<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{

    private SluggerInterface $slugger;
    private string $uploadsPath;

    public function __construct(string $uploadsPath, SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
        $this->uploadsPath = $uploadsPath;
    }

    public function uploadFile(UploadedFile $file){
        $fileName = $this->slugger
            ->slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
            ->append('-' . uniqid())
            ->append('.' . $file->guessExtension())
            ->toString()
        ;

        $newFile = $file->move($this->uploadsPath, $fileName);

        return $fileName;

    }
}