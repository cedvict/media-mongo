<?php

namespace Cedvict\MediaLibrary\Support;

use Cedvict\TemporaryDirectory\TemporaryDirectory as BaseTemporaryDirectory;
use Illuminate\Support\Str;

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
