<?php

function convertIntoWebP($imagesDirectory='', $imageName='', $imageExtenstion='.png', $quality=20)
{
    //  $imagesDirectory = 'images/';
    $quality = 100;
    $imagesDirectory = '';
    $imageName = '1 (1)';
    $imageExtenstion = '.jpg';
    $webpExtenstion = '.webp';


    $finalImageName = $imagesDirectory . $imageName . $imageExtenstion;
    $finalWebpImageName = $imagesDirectory . $imageName . $webpExtenstion;

    // imagecreatefromjpeg()

    // $gdImageInstance = imagecreatefrompng($imagesDirectory . $imageName);
    $gdImageInstance = imagecreatefromstring(file_get_contents($finalImageName));
    $conversionSuccess = imagewebp(
        $gdImageInstance,
        $finalWebpImageName,
        $quality
    );

    if ($conversionSuccess) {
        imagedestroy($gdImageInstance);

        echo 'Conversion successful!';
    }
}


// resize image and convert into webp using gd extenstion of php
function load_image($filename, $type) 
{
 if ($type == IMAGETYPE_JPEG) 
 {
  $image = imagecreatefromjpeg($filename);
 }
 elseif ($type == IMAGETYPE_PNG)
 {
  $image = imagecreatefrompng($filename);
 }
 elseif ($type == IMAGETYPE_GIF)
 {
  $image = imagecreatefromgif($filename);
 }
 return $image;
}

function resize_image($new_width, $new_height, $image, $width, $height) 
{
 $new_image = imagecreatetruecolor($new_width, $new_height);
 imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
 return $new_image;
}

function resize_to_width($new_width, $image, $width, $height) 
{
 $resize_ratio = $new_width / $width;
 $new_height = $height * $resize_ratio;
 return resize_image($new_width, $new_height, $image, $width, $height);
}


/////////////////
function convertImageIntoWeb( $image=null,$resize_width=null, $cropArea=null){

    $filename = $image['directory'] . $image['name'] . $image['extenstion'];
    // $filename = "images/imagename.jpg";
    list($width, $height, $type) = getimagesize($filename);

    // $extension = image_type_to_extension($type);

    $gd_image = load_image($filename, $type);

    if($resize_width){
        $gd_image = resize_to_width($resize_width, $gd_image, $width, $height);
    }



    if($cropArea){
       
        // (C) CROP IMAGE
        $gd_image = imagecrop($gd_image, $cropArea);
    }


    // save into folder code 

    // $outDir = '';

    // if(! $image['outDir']){
    //     $outDir = $image['directory'];
    // }

    $finalPathAndFileName = $image['outDir'] . $image['name'];

    echo $finalPathAndFileName;
    
    if($resize_width){
        $finalPathAndFileName = $finalPathAndFileName . '-' . $resize_width;
    }

    $finalPathAndFileName = $finalPathAndFileName . '.webp';

    $conversionSuccess = imagewebp(
            $gd_image,
            $finalPathAndFileName,
            $image['quality']
    );

    if($conversionSuccess){
        echo '<br>converted successfully and saved!!!';
    }
}
    




$image = [
    'quality' => 20,
    'directory' => 'humans/',
    'name' => '1 (7)',
    'extenstion' => '.jpg',
    'outDir' => 'humans/',
];

$filename = $image['directory'] . $image['name'] . $image['extenstion'];

// echo file_exists($filename);

$resize_width = 400; //in pixels

$cropArea = null;

//  $cropArea = [
//         "x" => 0, "y" => 0,
//         "width" => 150, "height" => 100
// ];
 $cropArea = [
        "x" => 0, "y" => 50,
        "width" => 400, "height" => 500
];



convertImageIntoWeb($image, $resize_width, $cropArea );

// echo 'width Conversion successful!';
// // print_r(getimagesize($filename));
// echo false || 'amir dynamic';
    