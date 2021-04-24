<?php

namespace Cedvict\MediaLibrary\Conversions\ImageGenerators;

use Cedvict\MediaLibrary\Conversions\Conversion;
use Illuminate\Support\Collection;

class Pdf extends ImageGenerator
{
    public function convert(string $file, Conversion $conversion = null): string
    {
        $imageFile = pathinfo($file, PATHINFO_DIRNAME).'/'.pathinfo($file, PATHINFO_FILENAME).'.jpg';

        $pageNumber = $conversion ? $conversion->getPdfPageNumber() : 1;

        (new \Cedvict\PdfToImage\Pdf($file))->setPage($pageNumber)->saveImage($imageFile);

        return $imageFile;
    }

    public function requirementsAreInstalled(): bool
    {
        if (! class_exists('Imagick')) {
            return false;
        }

        if (! class_exists('\\Cedvict\\PdfToImage\\Pdf')) {
            return false;
        }

        return true;
    }

    public function supportedExtensions(): Collection
    {
        return collect('pdf');
    }

    public function supportedMimeTypes(): Collection
    {
        return collect(['application/pdf']);
    }
}
