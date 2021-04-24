<?php

namespace Cedvict\MediaLibrary\ResponsiveImages\Events;

use Cedvict\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Queue\SerializesModels;

class ResponsiveImagesGenerated
{
    use SerializesModels;

    public Media $media;

    public function __construct(Media $media)
    {
        $this->media = $media;
    }
}
