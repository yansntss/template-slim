<?php 
    namespace App\Utilities;

    use Slim\Http\UploadedFile;

    class UtilFunctions{
        public function moveUploadedFile($directory, UploadedFile $uploadedFile): string
        {
            $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
            $basename = bin2hex(random_bytes(8).uniqid());
            $filename = sprintf('%s.%0.8s', $basename, $extension);

            $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);
            
            return $filename;
        }
    }