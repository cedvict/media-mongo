<?php

namespace Cedvict\MediaLibrary\Support;

use Spatie\Image\Image;

class ImageFactory
{
    public static function load(string $path): Image
    {
        return Image::load($path)->useImageDriver(config('media-libraryc.image_driver'));
    }
}
