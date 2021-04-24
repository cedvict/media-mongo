<?php

namespace Cedvict\MediaLibrary\Downloaders;

interface Downloader
{
    public function getTempFile(string $url): string;
}
