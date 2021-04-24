<?php

namespace Cedvict\MediaLibrary\Support;

use Illuminate\Support\Str;
use Cedvict\TemporaryDirectory\TemporaryDirectory as BaseTemporaryDirectory;

class TemporaryDirectory
{
    public static function create(): BaseTemporaryDirectory
    {
        return new BaseTemporaryDirectory(static::getTemporaryDirectoryPath());
    }

    protected static function getTemporaryDirectoryPath(): string
    {
        $path = config('media-libraryc.temporary_directory_path') ?? storage_path('media-libraryc/temp');

        return $path.DIRECTORY_SEPARATOR.Str::random(32);
    }
}
