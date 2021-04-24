<?php

namespace Cedvict\MediaLibrary\ResponsiveImages\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Cedvict\MediaLibrary\MediaCollections\Models\Media;
use Cedvict\MediaLibrary\ResponsiveImages\ResponsiveImageGenerator;

class GenerateResponsiveImagesJob implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, Queueable;

    protected Media $media;

    public function __construct(Media $media)
    {
        $this->media = $media;
    }

    public function handle(): bool
    {
        /** @var \Cedvict\MediaLibrary\ResponsiveImages\ResponsiveImageGenerator $responsiveImageGenerator */
        $responsiveImageGenerator = app(ResponsiveImageGenerator::class);

        $responsiveImageGenerator->generateResponsiveImages($this->media);

        return true;
    }
}
