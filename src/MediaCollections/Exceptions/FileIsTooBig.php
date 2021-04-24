<?php

namespace Cedvict\MediaLibrary\MediaCollections\Exceptions;

use Spatie\MediaLibrary\Support\File;

class FileIsTooBig extends FileCannotBeAdded
{
    public static function create(string $path, int $size = null): self
    {
        $fileSize = File::getHumanReadableSize($size ?: filesize($path));

        $maxFileSize = File::getHumanReadableSize(config('media-libraryc.max_file_size'));

        return new static("File `{$path}` has a size of {$fileSize} which is greater than the maximum allowed {$maxFileSize}");
    }
}
