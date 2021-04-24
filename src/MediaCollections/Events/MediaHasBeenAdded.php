<?php

namespace Cedvict\MediaLibrary\MediaCollections\Events;

use Illuminate\Queue\SerializesModels;
use Cedvict\MediaLibrary\MediaCollections\Models\Media;

class MediaHasBeenAdded
{
    use SerializesModels;

    public Media $media;

    public function __construct(Media $media)
    {
        $this->media = $media;
    }
}
