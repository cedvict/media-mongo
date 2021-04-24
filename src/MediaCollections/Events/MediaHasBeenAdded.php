<?php

namespace Cedvict\MediaLibrary\MediaCollections\Events;

use Cedvict\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Queue\SerializesModels;

class MediaHasBeenAdded
{
    use SerializesModels;

    public Media $media;

    public function __construct(Media $media)
    {
        $this->media = $media;
    }
}
