<?php

namespace Cedvict\MediaLibrary\MediaCollections\Events;

use Cedvict\MediaLibrary\HasMedia;
use Illuminate\Queue\SerializesModels;

class CollectionHasBeenCleared
{
    use SerializesModels;

    public HasMedia $model;

    public string $collectionName;

    public function __construct(HasMedia $model, string $collectionName)
    {
        $this->model = $model;

        $this->collectionName = $collectionName;
    }
}
