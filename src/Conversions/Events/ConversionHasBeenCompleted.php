<?php

namespace Cedvict\MediaLibrary\Conversions\Events;

use Cedvict\MediaLibrary\Conversions\Conversion;
use Cedvict\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Queue\SerializesModels;

class ConversionHasBeenCompleted
{
    use SerializesModels;

    public Media $media;

    public Conversion $conversion;

    public function __construct(Media $media, Conversion $conversion)
    {
        $this->media = $media;

        $this->conversion = $conversion;
    }
}
