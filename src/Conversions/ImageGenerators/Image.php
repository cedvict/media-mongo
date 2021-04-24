<?php

namespace Cedvict\MediaLibrary\Conversions\ImageGenerators;

use Illuminate\Support\Collection;
use Cedvict\MediaLibrary\Conversions\Conversion;

class Image extends ImageGenerator
{
    public function convert(string $path, Conversion $conversion = null): string
    {
        return $path;
    }

    public function requirementsAreInstalled(): bool
    {
        return true;
    }

    public function supportedExtensions(): Collection
    {
        return collect(['png', 'jpg', 'jpeg', 'gif']);
    }

    public function supportedMimeTypes(): Collection
    {
        return collect(['image/jpeg', 'image/gif', 'image/png']);
    }
}
