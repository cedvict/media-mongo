<?php

namespace Cedvict\MediaLibrary\Conversions\Events;

use Cedvict\MediaLibrary\Conversions\Conversion;
use Cedvict\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Queue\SerializesModels;

class ConversionWillStart
{
    use SerializesModels;

    public Media $media;

    public Conversion $conversion;

    public string $copiedOriginalFile;

    public function __construct(Media $media, Conversion $conversion, string $copiedOriginalFile)
    {
        $this->media = $media;

        $this->conversion = $conversion;

        $this->copiedOriginalFile = $copiedOriginalFile;
    }
}
