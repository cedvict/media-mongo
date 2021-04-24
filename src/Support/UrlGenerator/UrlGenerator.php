<?php

namespace Cedvict\MediaLibrary\Support\UrlGenerator;

use Cedvict\MediaLibrary\Conversions\Conversion;
use Cedvict\MediaLibrary\MediaCollections\Models\Media;
use Cedvict\MediaLibrary\Support\PathGenerator\PathGenerator;
use DateTimeInterface;

interface UrlGenerator
{
    public function getUrl(): string;

    public function getPath(): string;

    public function setMedia(Media $media): self;

    public function setConversion(Conversion $conversion): self;

    public function setPathGenerator(PathGenerator $pathGenerator): self;

    public function getTemporaryUrl(DateTimeInterface $expiration, array $options = []): string;

    public function getResponsiveImagesDirectoryUrl(): string;
}
