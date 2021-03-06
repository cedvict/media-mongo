<?php

namespace Cedvict\MediaLibrary\Downloaders;

use Cedvict\MediaLibrary\MediaCollections\Exceptions\UnreachableUrl;

class DefaultDownloader implements Downloader
{
    public function getTempFile(string $url): string
    {
        if (!$stream = @fopen($url, 'r')) {
            throw UnreachableUrl::create($url);
        }

        $temporaryFile = tempnam(sys_get_temp_dir(), 'media-libraryc');
        
        file_put_contents($temporaryFile, $stream);

        return $temporaryFile;
    }
}
