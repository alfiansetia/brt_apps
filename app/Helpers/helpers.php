<?php

use Intervention\Image\Laravel\Facades\Image;

function hrg($angka)
{
    return number_format($angka, 0, ',', '.');
}


function scaleDown($file, int $size = 800)
{
    $image = Image::read($file);
    $image->orient();
    $image->scaleDown($size);
    return $image;
}
