<?php

namespace Cedvict\MediaLibrary\MediaCollections\Events;

use Illuminate\Queue\SerializesModels;
use Cedvict\MediaLibrary\HasMedia;

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
