<?php

namespace Cedvict\MediaLibrary\Support;

use Cedvict\MediaLibrary\MediaCollections\Exceptions\FunctionalityNotAvailable;
use Cedvict\MediaLibraryPro\Models\TemporaryUpload;

class MediaLibraryPro
{
    public static function ensureInstalled()
    {
        if (! class_exists(TemporaryUpload::class)) {
            throw FunctionalityNotAvailable::mediaLibraryProRequired();
        }
    }

    public static function isInstalled(): bool
    {
        return class_exists(TemporaryUpload::class);
    }
}
