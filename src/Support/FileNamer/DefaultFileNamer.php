<?php

namespace Cedvict\MediaLibrary\Support\FileNamer;

use Cedvict\MediaLibrary\Conversions\Conversion;

class DefaultFileNamer extends FileNamer
{
    public function conversionFileName(string $fileName, Conversion $conversion): string
    {
        $strippedFileName = pathinfo($fileName, PATHINFO_FILENAME);

        return "{$strippedFileName}-{$conversion->getName()}";
    }

    public function responsiveFileName(string $fileName): string
    {
        return pathinfo($fileName, PATHINFO_FILENAME);
    }
}
