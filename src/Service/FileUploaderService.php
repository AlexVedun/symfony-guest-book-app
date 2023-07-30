<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploaderService
{
    public function __construct(
        private SluggerInterface $slugger,
        private LoggerInterface $logger
    ){}

    public function upload(UploadedFile $file, string $targetDirectory): string
    {
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFileName = $this->slugger->slug($originalFileName);
        $uniqueId = uniqid();
        $fileName = "{$safeFileName}-{$uniqueId}.{$file->guessExtension()}";

        try {
            $file->move($targetDirectory, $fileName);
        } catch (FileException $exception) {
            $this->logger->error($exception->getMessage());
            $this->logger->debug($exception->getTraceAsString());

            $fileName = '';
        }

        return $fileName;
    }
}
