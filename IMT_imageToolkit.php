<?
/*
 * IMT_imageToolkit.php
 *
 * created.....: 2007-03-19 (Wed) 15:21
 *
 * In this file, you can find functions for conveniently resizing big images to
 * a maximum size or creating thumnails of a fixed format.
 */


/*
 * This method is suitable for creating thumbnail images.
 *
 * This function returns a resized version of the specified image. The resized
 * image will be of the specified size, retaining its aspect ratio. To make it
 * fit, parts of the image may be cut off.
 * In the case of failure, the function dies with an appropriate error message.
 */
function IMT_getImageCutToSize($im, $width, $height) {
    $srcW = imagesx($im);
    $srcH = imagesy($im);

    //calculate size of resulting image before cutoff
    if ($srcW / $width < $srcH / $height)
        $resizeFactor = $width  / $srcW;
    else
        $resizeFactor = $height / $srcH;

    $scaledW = $srcW * $resizeFactor;
    $scaledH = $srcH * $resizeFactor;

    //calculate cropping are
    $cropSrcW = $width  / $resizeFactor;
    $cropSrcH = $height / $resizeFactor;
    $srcX     = ($srcW - $cropSrcW) / 2;
    $srcY     = ($srcH - $cropSrcH) / 2;

    //crop and save
    $dstIm = imagecreatetruecolor($width, $height);

    $result = imagecopyresampled(
     $dstIm, $im,
     0, 0,               //dst upper left corner
     $srcX, $srcY,       //src upper left corner
     $width, $height,
     $cropSrcW, $cropSrcH
    );

    if (! $result)
        die("couldn't resample image.\n");

    return $dstIm;
}


/*
 * This method is suited for shrinking images to save storage space.
 *
 * This function returns a resized version of the specified image. The resized
 * image will fit into a rectagular space of size $maxWidth x $maxHeight pixels,
 * retaining its aspect ratio.
 * In the case of failure, the function dies with an appropriate error message.
 */
function IMT_getImageFitToSize($im, $maxWidth, $maxHeight) {
    $width  = imagesx($im); //dst dim is based on src dim
    $height = imagesy($im);

    $ratio = $width / $height; //e.g. 1.333333 for 4:3 images like 1024x768

    if ($width  > $maxWidth) {
        $width  = $maxWidth;
        $height = $maxWidth / $ratio;
    }

    if ($height > $maxHeight) {
        $height = $maxHeight;
        $width  = $maxHeight * $ratio;
    }

    return IMT_getResizedImage($im, $width, $height);
}


/*
 * Resizes the specified image to size ($width, $height) and returns the result.
 * In any success case, the returned result will be another resource, even if
 * the destination size is identical to the source image's size.
 * In the case of failure, the function dies with an appropriate error message.
 */
function IMT_getResizedImage($im, $width, $height) {
    if (! is_resource($im))
        die("\$im is not a resource.\n");

    $width  = (int)$width ;
    $height = (int)$height;
    if ($width  <= 0) die("\$width may not be <= 0.\n");
    if ($height <= 0) die("\$height may not be <= 0.\n");

    $dstIm = imagecreatetruecolor($width, $height);

    $srcW = imagesx($im);
    $srcH = imagesy($im);

    $result = imagecopyresampled(
     $dstIm, $im,
     0, 0,               //dst upper left corner
     0, 0,               //src upper left corner
     $width, $height,
     $srcW, $srcH
    );

    if (! $result)
        die("resample function of gd library failed.\n");

    return $dstIm;
}


/*
 * This function saves the specified image resource to the specified file. The
 * format of the destination image is defined by the file extension. The file
 * extensions png, jpg, jpeg, and gif are supported. The check for file
 * extensions is case insensitive, meaning that you can also use .Jpg or .JPG in
 * your filenames.
 * This function returns TRUE on success and dies on failure.
 */
function IMT_saveImage($im, $filename) {
    if (! is_resource($im))
        die("\$im is not a resource.\n");

    $extension = IMT_getFileExtension($filename);
    if ($extension === FALSE)
        die("can't find filename extension in filename '$filename'.\n");

    if (! in_array($extension, array('png', 'jpg', 'jpeg', 'gif')))
        die("file extension '$extension' not supported.\n");

    if      ($extension == 'png')
        $result = imagepng ($im, $filename);
    else if ($extension == 'jpg' || $extension == 'jpeg')
        $result = imagejpeg($im, $filename, 85);
    else if ($extension == 'gif')
        $result = imagegif ($im, $filename);
    //else is not needed, because checked before

    if (! $result)
        die("couldn't successfully save image to '$filename'.\n");

    return TRUE;
}


/*
 * This function loads an image from the specified file and returns the resource
 * for the loaded image.
 * In the case of failure, the function dies with an appropriate error message.
 */
function IMT_loadImage($filename) {
    $imageInfo = getimagesize($filename);

    if (! $imageInfo)
        die("couldn't determine format of image file '$filename'.\n");

    $imageType = $imageInfo[2];

    if      ($imageType == 1) {
        $im = imagecreatefromgif ($filename);
    }
    else if ($imageType == 2) {
        $im = imagecreatefromjpeg($filename);
    }
    else if ($imageType == 3) {
        $im = imagecreatefrompng ($filename);
    }
    else {
        die("unknown image type code: $imageType\n");
    }

    if (! $im)
        die("couldn't load image from file '$filename'.\n");

    return $im;
}


/*
 * Returns the file extension of the provided filename, or FALSE if there is no
 * file extension. The file may have a leading path. If $autoLowerCase evaluates
 * to TRUE, the returned file extension is automatically converted to lower
 * case. If the extension can't be determined, FALSE is returned.
 */
function IMT_getFileExtension($filename, $autoLowerCase = TRUE) {
    $bname = basename($filename);

    $p = strrpos($bname, '.');
    if ($p === FALSE)
        return FALSE;

    $ext = substr($bname, $p + 1);

    if ($autoLowerCase)
        return strtolower($ext);
    else
        return $ext;
}


?>
