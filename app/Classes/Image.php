<?php
namespace App\Classes;
Class Image extends MyImage {

    public static $image_mimes = array(
        'image/gif',
        'image/jpeg',
        'image/pjpeg',
        'image/png',
    );
    public static $pdf_mimes = array(
        'application/pdf',
        'application/x-pdf'
    );
    public static $video_mimes = array(
        'video/mp4',
        'video/webm',
        'video/ogg',
        'application/ogg',
        'audio/ogg'
    );
    public static $video_extention = array(
        '.mp4',
        '.ogv',
        '.webm'
    );
    public static $word_mimes = array(
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    );
    public static $excel_mimes = array(
        'application/vnd.ms-office',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    );
    public static $presets = array(
        "user_avatar" => array(
            "30W_SQUARECROP" => array(//header {user_avatar}
                "width" => 30,
                "crop_to_square" => 1
            ),
            "46W_SQUARECROP" => array(//Collection_list's  {user_avatar}
                "width" => 46, // also used at a place of size 43, 44, 46
                "crop_to_square" => 1
            ),
            "100W_SQUARECROP" => array(//userProfilePopup {user_avatar}
                "width" => 100, // also used at a place of size 100, 101
                "crop_to_square" => 1
            ),
            "160W_SQUARECROP" => array(//userProfilePopup {user_avatar}
                "width" => 160,
                "crop_to_square" => 1
            ),
            "740W_NONSQUARECROP" => array(//HomeViewer{main Image}{user_avatar}
                "width" => 740,
                "height" => NULL,
                "crop_to_square" => 0
            ),
        ),
        "listing_cover" => array(
            "100W_SQUARECROP" => array(
                "width" => 100,
                "crop_to_square" => 1
            ),
            "270W_NONSQUARECROP" => array(
                "width" => 270,
                "height" => NULL,
                "crop_to_square" => 0
            ),
            "162W_NONSQUARECROP" => array(
                "width" => 162,
                "height" => NULL,
                "crop_to_square" => 0
            ),
            "851W_NONSQUARECROP" => array(
                "width" => 851,
                "height" => NULL,
                "crop_to_square" => 0
            ),
            "914W_NONSQUARECROP" => array(//HomeViewer{main Image, socialLanding}
                "width" => 914,
                "height" => NULL,
                "crop_to_square" => 0
            ),
        ),
        "listing_image" => array(
            "40W_SQUARECROP" => array(//MyProfile_MyProfile_Notification_List
                "width" => 40, // also used at a place of size 31
                "crop_to_square" => 1
            ),
            "77W_SQUARECROP" => array(//thingsToDo(photos_list)DetailsCover {listing_image} //backend
                "width" => 77, //myRoadTrip(photos_list) 
                "crop_to_square" => 1                   //myProfile(photos_list)
            //also used at a place of size 60
            ),
            "100W_SQUARECROP" => array(//also from this stop, place, category{homeViewer}
                "width" => 100, //public thingsToDo right, likes added
                "crop_to_square" => 1                   //also used at a place of size 91
            ),
            "150W_NONSQUARECROP" => array(//photos (PhotoAlbums_List)
                "width" => 150, //also used at a place of size 150(113), 152, 157
                "height" => NULL,
                "crop_to_square" => 0
            ),
            "150W_1.55RATIO_NONSQUARECROP" => array(//thingsToDo, myProfile scrapbooks(photosVertical_list) 157W_1.24RATIO_NONSQUARECROP (old)
                "width" => 150, //myRoadTrip scrapbooks(photosVertical_list)
                "aspect_ratio" => 1.55,
                "height" => NULL,
                "crop_to_square" => 0
            ),
            "150W_1.34RATIO_NONSQUARECROP" => array(
                "width" => 150, //scrapbooks
                "aspect_ratio" => 1.34,
                "height" => NULL,
                "crop_to_square" => 0
            ),
            "306W_NONSQUARECROP" => array(//thingsToDo, myroadTrip_scrap,myprofile_scrap(photosView_list) 305W_NONSQUARECROP(old)
                "width" => 306, //Home(Home_list)
                "height" => NULL, //also used at a place of size 273, 300
                "crop_to_square" => 0
            ),
            "306W_1.24RATIO_NONSQUARECROP" => array(//scrapBookOverview 273W_1.24RATIO_NONSQUARECROP(old)
                "width" => 306,
                "aspect_ratio" => 1.24,
                "height" => NULL,
                "crop_to_square" => 0
            ),
            "740W_NONSQUARECROP" => array(//HomeViewer{main Image}
                "width" => 740,
                "height" => NULL,
                "crop_to_square" => 0
            ),
            "914W_NONSQUARECROP" => array(//HomeViewer{main Image, socialLanding}
                "width" => 914,
                "height" => NULL,
                "crop_to_square" => 0
            ),
        ),
        "interest_icon" => array(
            "39W_SQUARECROP" => array(//also used at a place of size 25, 30, 36, 39
                "width" => 39,
                "crop_to_square" => 1
            ),
            "100W_SQUARECROP" => array(
                "width" => 100,
                "crop_to_square" => 1
            )
        ),
        "interest_small_icon" => array(
            "39W_SQUARECROP" => array(//also used at a place of size 25, 30, 36, 39
                "width" => 39,
                "crop_to_square" => 1
            ),
            "100W_SQUARECROP" => array(
                "width" => 100,
                "crop_to_square" => 1
            )
        ),
        "interest_type_icon" => array(
            "46W_SQUARECROP" => array(//also used at a place of size 33, 36, 39
                "width" => 46,
                "crop_to_square" => 1
            ),
            "100W_SQUARECROP" => array(
                "width" => 100,
                "crop_to_square" => 1
            ),
            "133W_NONSQUARECROP" => array(
                "width" => 133,
                "height" => NULL,
                "crop_to_square" => 0
            ),
        ),
        "listing_category_icon" => array(
            "46W_SQUARECROP" => array(//also used at a place of size 26, 37, 44
                "width" => 46,
                "crop_to_square" => 1
            ),
            "100W_SQUARECROP" => array(//also used at a place of size 94
                "width" => 100,
                "crop_to_square" => 1
            ),
            "400W_SQUARECROP_Food_Dining" => array(
                "width" => 400,
                "crop_to_square" => 1,
                "background_color" => '#5D8570'
            ),
            "400W_SQUARECROP_Adventure_Extreme" => array(
                "width" => 400,
                "crop_to_square" => 1,
                "background_color" => '#467375'
            ),
            "400W_SQUARECROP_Culture_Hist_Heritage" => array(
                "width" => 400,
                "crop_to_square" => 1,
                "background_color" => '#57575A'
            ),
            "400W_SQUARECROP_Entertainment_Leisure" => array(
                "width" => 400,
                "crop_to_square" => 1,
                "background_color" => '#C1B499'
            ),
            "400W_SQUARECROP_Health_Indoor_Fitness" => array(
                "width" => 400,
                "crop_to_square" => 1,
                "background_color" => '#ba9717'
            ),
            "400W_SQUARECROP_Outdoor_Recreation" => array(
                "width" => 400,
                "crop_to_square" => 1,
                "background_color" => '#70513A'
            ),
            "400W_SQUARECROP_Travel_Services" => array(
                "width" => 400,
                "crop_to_square" => 1,
                "background_color" => '#765459'
            ),
            "400W_SQUARECROP_Water_Recreation" => array(
                "width" => 400,
                "crop_to_square" => 1,
                "background_color" => '#79a1bb'
            ),
            "400W_SQUARECROP_Winter_Recreation" => array(
                "width" => 400,
                "crop_to_square" => 1,
                "background_color" => '#A6A9AB'
            ),
            "400W_SQUARECROP_Lodging" => array(
                "width" => 400,
                "crop_to_square" => 1,
                "background_color" => '#CC7902'
            ),
            "400W_SQUARECROP_Festivals_Events" => array(
                "width" => 400,
                "crop_to_square" => 1,
                "background_color" => '#596976'
            ),
            "400W_SQUARECROP_Shopping" => array(
                "width" => 400,
                "crop_to_square" => 1,
                "background_color" => '#844211'
            ),
        ),
        "ad_creative" => array(
            "330W_NONSQUARECROP" => array(
                "width" => 330,
                "height" => NULL, //"height" => 110,
                "crop_to_square" => 0
            ),
            "186W_NONSQUARECROP" => array(
                "width" => 186,
                "height" => NULL, //'height' => 62
                "crop_to_square" => 0
            ),
        ),
        "listing_categories" => array(
            "100W_SQUARECROP" => array(
                "width" => 100,
                "height" => NULL, //"height" => 110,
                "crop_to_square" => 1
            ),
            "46W_SQUARECROP" => array(
                "width" => 46,
                "height" => NULL,
                "crop_to_square" => 1
            )
        ),
        "feed_upload" => array(
            "400W_SQUARECROP" => array(
                "width" => 400,
                "crop_to_square" => 1
            )
        ),
        "image_attachment" => array(
            "100W_SQUARECROP" => array(//userProfilePopup {user_avatar}
                "width" => NULL, // also used at a place of size 100, 101
                "height" => 100,
                "crop_to_square" => FALSE
            ),
            "250W_NONSQUARECROP" => array(
                "width" => 250,
                "height" => 250,
                "crop_to_square" => 0
        ),
            "350W_NONSQUARECROP" => array(
                "width" => 350,
                "height" => NULL,
                "crop_to_square" => 0
            ),
            "740W_NONSQUARECROP" => array(
                "width" => 740,
                "height" => NULL,
                "crop_to_square" => 0
            ),
        ),
        "image_attachment_social" => array(
            "100W_SQUARECROP" => array(//userProfilePopup {user_avatar}
                "width" => 100, // also used at a place of size 100, 101
                "height" => NULL,
                "crop_to_square" => 1
            ),
            "550W_NONSQUARECROP" => array(
                "width" => 550,
                "height" => NULL,
                "crop_to_square" => 0
            ),
        ),
        "employee_files" => array(
            "100W_SQUARECROP" => array(
                "width" => 100,
                "crop_to_square" => 1
            ),
            "250W_NONSQUARECROP" => array(
                "width" => 250,
                "height" => 250,
                "crop_to_square" => 0
            ),
            "350W_NONSQUARECROP" => array(
                "width" => 350,
                "height" => NULL,
                "crop_to_square" => 0
            ),
        ),
    );
    public static $my_width;
    public static $my_height;

    public static function generateThumbs($filePath, $preset, $config = null) {
        if (!$config) {
            $info = getimagesize($filePath);
            $config = array(
                'x' => 0,
                'y' => 0,
                'width' => $info[0],
                'height' => $info[1],
                'info' => $info
            );
        }
        $thumbs = NULL;
        if (@Image::$presets[$preset]) {
            foreach (Image::$presets[$preset] as $key => $thumb_config) {
                $img_config = array_merge(array(
                    'src' => $config,
                    'preset_name' => $key
                        ), $thumb_config);
                $path = Image::getThumbnail($filePath, $img_config);
                $width = Image::$my_width;
                $height = Image::$my_height;
                $thumbs[$key] = array('path' => $path, 'width' => $width, 'height' => $height);
            }
        }
        return $thumbs;
    }

    public static function getCropDimensionsForDesiredRatio($imageWidth, $imageHeight, $desiredAspectRatio) {
        if ($desiredAspectRatio < 1) { // "tall" crop
            $cropWidth = min($imageHeight * $desiredAspectRatio, $imageWidth);
            $cropHeight = $cropWidth / $desiredAspectRatio;
        } else { // "wide" or square crop
            $cropHeight = min($imageWidth / $desiredAspectRatio, $imageHeight);
            $cropWidth = $cropHeight * $desiredAspectRatio;
        }
        if ($imageWidth > $cropWidth) {
            $cropX = ($imageWidth - $cropWidth) / 2;
            $cropY = 0;
        } else {
            $cropX = 0;
            $cropY = ($imageHeight - $cropHeight) / 2;
        }
        return array(($cropX), ($cropY), ($cropWidth), ($cropHeight));
    }

//Code below determines crop begin point (x, y) based upon image dimensions and crop dimensions.
//Basically we want to take out a slice of the original image from the center.
// So if the original image is 100 pixels wide, and we want to get a crop 50 pixels wide, the function will return x = 25, so that 25 pixels gets discarded from both sides of the image.
//However, if the image itself if 25 pixels wide, and the crop required is 50 pixels, then this will return x = 0, and modify the crop width to 25 as well.
//Same logic is applied for height as well
    public static function _getCropParamtersFromImageCenter($imageWidth, $imageHeight, $desiredCropWidth, $desiredCropHeight, $crop_dimensions = false, $square_dimensions = false) {
        if ($crop_dimensions == 'maximum') {
            $desiredCropWidth = $imageWidth;
            $desiredCropHeight = $imageHeight;
        }


        if ($square_dimensions) {
            if ($desiredCropWidth > $desiredCropHeight) {
                $desiredCropWidth = $desiredCropHeight;
            } else {
                $desiredCropHeight = $desiredCropWidth;
            }
        }
        if ($imageWidth > $desiredCropWidth) {
            $cropX = ($imageWidth - $desiredCropWidth) / 2;
            $cropWidth = $desiredCropWidth;
        } else {
            $cropX = 0;
            $cropWidth = $imageWidth;
        }

        if ($imageHeight > $desiredCropHeight) {
            $cropY = ($imageHeight - $desiredCropHeight) / 2;
            $cropHeight = $desiredCropHeight;
        } else {
            $cropY = 0;
            $cropHeight = $imageHeight;
        }
        return array(($cropX), ($cropY), ($cropWidth), ($cropHeight));
    }

    /**

     * The purpose of this function is to  -
     * 1. first optionally slice out a certain portion of the image (based upon src parameters) and 
     * 2. then perform certain operations on that cropped part of the image OR the original image, as the case may be
     * 
     * * Src can be used in one of the following ways-
     * 4 properties scenario - x, y, width, height. (x,y) is the point from where cropping will begin. Width, Height are the dimensions of the crop. This is generally used when the user has manually chosen the crop dimensions from the JS cropper tool
     * 3 properties scenario- crop_from_center, width, height. In this case, (x,y) are determined from the center of the original image, based upon a comparison of the original image dimensions and crop dimensions. This is used when the image is fetched remotely, and we do not have any user input on the exact crop dimensions.
     * 2 properties scenario- crop from center, crop_dimensions  (possible values- 'maximum'), square_dimensions (boolean). 
     * crop_dimensions = 
     *      'maximum' will imply that image dimensions will be used as the desired crop dimensions, so that the maximum possible crop can be achieved
     *      'aspect_ratio' will imply that crop dimnensions will be used as the width:height ratio, to extract the maximum possible crop from the image
     * square_dimensions = true will mean that the dimensions must be square.
     * width, height values passed in the functions (the ones which are not part of the src variable) are meant for the resizing to be done in stage 2 of this function (after the cropping has been done)
     * @param type $pathToImage If this is a string with http://, the code will try to fetch the image from the url
     * @param type $config
     * @param type $additionalOptions
     * @return type
     */
    public static function getThumbnail($pathToImage, $config = array(), $additionalOptions = NULL, $img = NULL) {
        if (!$pathToImage) {
            return;
        }

        $defaults = array(
            'src' => null,
            'width' => NULL,
            'height' => NULL,
            'crop_to_square' => true
        );
        $config = array_merge($defaults, $config);
//HtmlHelper::printR($config);
        if (isset($config['src']) && !is_object(@$config['src'])) {
            if (is_array($config['src'])) {
                $config['src'] = (object) $config['src'];
            } else {
                $config['src'] = json_decode($config['src']);
            }
        }

// open the directory	
        if (@$additionalOptions['use_filename']) {
            $thumbNailPath = $additionalOptions['use_filename'];
        } else {
            if (isset($config['preset_name'])) {
                $uid = $config['preset_name'] . "_" . time();
            } else {
                $uid = Image::getUniqueId($config);
            }

            $thumbNailPath = Image::getThumbName($pathToImage, $uid);
        }



        //if (!file_exists($thumbNailPath) || @$additionalOptions['output'] == 'direct') {


        if (!$img) {
            $img = new MyImage();
//$img->load($pathToImage, @$config['src']['info']);
            $img->load($pathToImage);
        }
        
        if (@in_array($config['src']->rotation, array(90, -90, 270, -270))) {
            //switch values of config src- width/height, and x/y
            //switch config width/height
            $imageWidth = $img->get_height();
            $imageHeight = $img->get_width();
//            $tempConfig = $config;
//            $config['src']->width = $tempConfig['src']->height;
//            $config['src']->height = $tempConfig['src']->width;
//            $config['src']->x = $tempConfig['src']->y;
//            $config['src']->y = $tempConfig['src']->x;
//            $config['width'] = $tempConfig['height'];
//            $config['height'] = $tempConfig['width'];
        } else {
            $imageWidth = $img->get_width();
            $imageHeight = $img->get_height();
        }


        if (isset($config['aspect_ratio'])) {
            if (@$image_enlargement_not_allowed) {
                list($cropX, $cropY, $cropWidth, $cropHeight) = Image::getCropDimensionsForDesiredRatio(
                                isset($config['src']->width) ? @$config['src']->width : $imageWidth, isset($config['src']->height) ? @$config['src']->height : $imageHeight, $config['aspect_ratio']
                );
            } else {
                list($cropX, $cropY, $cropWidth, $cropHeight) = Image::getCropDimensionsForDesiredRatio($config['src']->width, $config['src']->height, $config['aspect_ratio']);
            }

            $config['src'] = (object) array(
                        'x' => $config['src']->x + $cropX,
                        'y' => $config['src']->y + $cropY,
                        'width' => $cropWidth,
                        'height' => $cropHeight,
            );
        }
        extract($config);
        if (isset($src->rotation)) {

            $img->rotate($src->rotation);
        }
        $crop = $src; //src basically provides the parameters to be used for cropping. So, if we have anything inside src, it implies that we want this image to be cropped before any other operation is performed on it.
//Stage1 of this function is to crop the original image according to the src parameters
        if ($crop) {
            if (@$crop->crop_from_center) {//See documention of the function above. When used with 'crop_from_center', src only needs 3 properties, namely- crop_from_center, width and height
                list($cropX, $cropY, $cropWidth, $cropHeight) = Image::_getCropParamtersFromImageCenter($imageWidth, $imageHeight, @$crop->width, @$crop->height, @$crop->crop_dimensions, @$crop->square_dimensions);
                $img->crop($cropX, $cropY, $cropX + $cropWidth, $cropY + $cropHeight);
            } else {
//Crop the original image based upon src,that is, crop, parameters (x, y, width, height)
                $img->crop($crop->x, $crop->y, $crop->x + $crop->width, $crop->y + $crop->height);
            }
        }

//Stage2 of this function is meant to resize the image based upon the values of width, height
//Operations below are meant to be performed upon-
//the original image- if there is nothing in the src parameter,
//or on the cropped portion of the original image, if src parameter was passed
        if (@$crop_to_square) {
// Trim the image to a square
//Square crop function crops the image to a square from the horizontal and vertical centers, and then resize that squared image to the given dimensions. Height is IGNORED in this case.
//Known issue- If the image is snaller than the required size, it scales the image up.
            $img->square_crop($width);
        } else {
//If crop to square is false, then we should resize the images proportionally, depending upon the width height values that are passed
            if ($width && !$height) {
// Shrink the image to the specified width while maintaining proportion (width)

                if ($crop && @$image_enlargement_not_allowed) {
                    $width = $width < $crop->width ? $width : $crop->width;
                }
                $img->fit_to_width($width);
            } elseif (!$width && $height) {
// Shrink the image to the specified width while maintaining proportion (width)
                if ($crop && @$image_enlargement_not_allowed) {
                    $height = $height < $crop->height ? $height : $crop->height;
                }
                $img->fit_to_height($height);
            } elseif ($width && $height) {
// Shrink the image proportionally to fit inside a 500x500 box
                if ($crop && @$image_enlargement_not_allowed) {
                    $width = $width < $crop->width ? $width : $crop->width;
                    $height = $height < $crop->height ? $height : $crop->height;
                }
                $img->best_fit($width, $height);
            }
        }

//Stage3 is to apply a watermark if required
        if (@$use_watermark) {
            $watermark = new MyImage();
            $img->load($watermark_path)->best_fit(120, 120);
// Overlay watermark.png at 50% opacity at the bottom-right of the image with a 10 pixel horizontal and vertical margin
            $img->overlay($watermark_path, 'bottom right', .5, -10, -10);
        }
        if(@$background_color){
            $img->backgroundFill($background_color);
        }
        Image::$my_height = $img->height;
        Image::$my_width = $img->width;
//Stage4 is to return the output of the image, either directly to the browser, or store it to a file
        if (@$additionalOptions['output'] == 'direct') {
            $img->output();
        } else {
            $img->save($thumbNailPath);
            @chmod($thumbNailPath, 0777);
        }
        //}



        if (@$config['return'] == 'absolute_path') {
            return $thumbNailPath;
        } else {
            return asset($thumbNailPath);
        }
    }



    public static function getUniqueId($config = array()) {
        return md5(json_encode($config));
    }

    public static function getThumbName($pathToImage, $uniqueId = NULL) {
        if (!$uniqueId) {
            $uniqueId = microtime();
        }
        $pathParts = explode(".", $pathToImage);
        $extension = end($pathParts);
        if (stristr($pathToImage, 'http://') || stristr($pathToImage, 'https://')) {
            $pathToDir = 'uploads';
            $thumbnailName = $uniqueId . "." . $extension;
        } else {
            $position = strrpos($pathToImage, ".");  // set position "/"
            $pathToDir = substr($pathToImage, 0, $position);

            if (is_array($uniqueId)) {
                $thumbnailName = implode('', $uniqueId) . "." . $extension;
            } else {
                $thumbnailName = $uniqueId . "." . $extension;
            }
        }
        if (!is_dir($pathToDir)) {
            mkdir($pathToDir, 0777);
            chmod($pathToDir, 0777);
        }

        return $pathToDir . DS . $thumbnailName;
    }

}
