<?php

namespace Cedvict\MediaLibrary\Conversions\Jobs;

use Cedvict\MediaLibrary\Conversions\ConversionCollection;
use Cedvict\MediaLibrary\Conversions\FileManipulator;
use Cedvict\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PerformConversionsJob implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, Queueable;

    public $deleteWhenMissingModels = true;

    protected ConversionCollection $conversions;

    protected Media $media;

    protected bool $onlyMissing;

    public function __construct(ConversionCollection $conversions, Media $media, bool $onlyMissing = false)
    {
        $this->conversions = $conversions;

        $this->media = $media;

        $this->onlyMissing = $onlyMissing;
    }

    public function handle(FileManipulator $fileManipulator): bool
    {
        $fileManipulator->performConversions($this->conversions, $this->media, $this->onlyMissing);

        return true;
    }
}
