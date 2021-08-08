<?php

namespace App\Http\Controllers;

use App\Models\Videos;
use App\Classes\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class VideosController extends Controller
{

    /**
     * Display a listing of the videos.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $videosObjects = Videos::get();
        $videosObjects->transform(function($item) {
            if($item->img_src && $decoded_img_src = json_decode($item->img_src, true))  {
                $item->img_src = $decoded_img_src;
            }
            return $item;
        });
        return view('videos.index', compact('videosObjects'));
    }

    /**
     * Show the form for creating a new videos.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('videos.create');
    }

    /**
     * Store a new videos in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            Videos::create($data);

            return redirect()->route('videos.videos.index')
                             ->with('success_message', 'Videos was successfully added!');

        } catch (Exception $exception) {
            $error_messages = ['unexpected_error' => 'Unexpected error occurred while trying to process your request!'];
             if(@$exception->validator){
                    $error_messages = $exception->validator;
              }
            return back()->withInput()
                         ->withErrors($error_messages);
        }
    }

    /**
     * Display the specified videos.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $videos = Videos::findOrFail($id);

        return view('videos.show', compact('videos'));
    }

    /**
     * Show the form for editing the specified videos.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $videos = Videos::findOrFail($id);
        if($videos->img_src && $decoded_img_src = json_decode($videos->img_src, true))  {
            $videos->img_src = $decoded_img_src;
        }

        return view('videos.edit', compact('videos'));
    }

    /**
     * Update the specified videos in the storage.
     *
     * @param  int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            $videos = Videos::findOrFail($id);
            $videos->update($data);

            return redirect()->route('videos.videos.index')
                             ->with('success_message', 'Videos was successfully updated!');

        } catch (Exception $exception) {
            $error_messages = ['unexpected_error' => 'Unexpected error occurred while trying to process your request!'];
            dd($exception);
             if($exception->validator){
                    $error_messages = $exception->validator;
              }
            return back()->withInput()
                         ->withErrors($error_messages);
        }        
    }

    /**
     * Remove the specified videos from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $videos = Videos::findOrFail($id);
            $videos->delete();

            return redirect()->route('videos.videos.index')
                             ->with('success_message', 'Videos was successfully deleted!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    
    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request 
     * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
            'title' => 'string|min:1|max:255|nullable',
            'youtube_url' => 'string|min:1|nullable',
            'img_src' => ['file','nullable'],
            'description' => 'string|min:1|max:1000|nullable',
            'display_type' => 'string|min:1|nullable',
     
        ];
        
        $data = $request->validate($rules);
        if ($request->has('custom_delete_img_src')) {
            $data['img_src'] = null;
        }
        if ($request->hasFile('img_src')) {
            $data['img_src'] = $this->moveFile($request->file('img_src'));
        }


        if ($request->hasFile('img_src')) {
            $img_json_data = $this->savePostedFiles(['type' => 'post', 'control_name'=> 'img_src']);
            //  $data['img_src'] = $this->moveFile($request->file('img_src'));
            $data['img_src'] = json_encode($img_json_data);
        }

        return $data;
    }
  
    /**
     * Moves the attached file to the server.
     *
     * @param Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return string
     */
    protected function moveFile($file)
    {
        if (!$file->isValid()) {
            return '';
        }
        
        $path = config('codegenerator.files_upload_path', 'uploads');
        $saved = $file->store('public/' . $path, config('filesystems.default'));

        return substr($saved, 7);
    }


    function savePostedFiles($options = []){
        $filterOriginalFilePath = null;
        $preset = $options['type'];
        $control_name = @$options['control_name']?$options['control_name']:'name';
        $uploadFileType = 'image';

        if (!empty($_FILES)) {
            $fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : null;
            if(!$fileName && @$_FILES[$control_name]['name']){
                $fileName = $_FILES[$control_name]['name'];
            }


            $originalFileName = $fileName;

            $randomHash = substr(md5(rand(1, 99999)), 0, 4);
            $folder = $randomHash . "-" . date("YmdHis");
            $targetDir = base_path('public/uploads/' . $preset);
            $fileName = $folder . "_" . preg_replace('/[^\w\._]+/', '_', $fileName);
            $filePath = $targetDir . DS . $fileName;
            //-----
            $ext = strrpos($fileName, '.');
            $fileName_a = substr($fileName, 0, $ext);
            $thumbs_path  = $targetDir . DS . $fileName_a;
            $file_path  = $targetDir . DS . $fileName;

            // Check if file has been uploaded
            if ($this->uploadFile($control_name, $fileName, $targetDir)) {
                if ($this->isImage($filePath)) {
                    // -- converting png files to jpg as some png images aren't able to display in ios mail
                    if(isset($_REQUEST['convert_png_to_jpg']) && $this->isPngImage($filePath)){
                        $fileName = str_ireplace('.png', '.jpg', $fileName);
                        $filePath = $this->convertPngToJpg($filePath, $targetDir.'/'.$fileName);
                    }

                    $this->resizeImage($filePath);
                    $info = getimagesize($filePath);
                }
                $generateThumbs = true;
            }
        }
        else {
            $generateThumbs = Request::input('generate_thumbs');
            $filePath = Request::input('filePath');

            $position = strrpos($filePath, ".");
            $folderPosition = explode("/", substr($filePath, 0, $position));
            $folder = end($folderPosition);
            $fileNamePath = explode("/", $filePath);
            $fileName = end($fileNamePath);
            $originalFileName = $fileName;
            $is_image = true;
            // $targetDir = base_path('public/'.config('app.prefix').'/uploads/' . $preset);
            $targetDir = base_path('public\uploads\clients');
            $img = new Image();
            $img->load($filePath);
            // Create target dir
            if (!file_exists($targetDir))
                @mkdir($targetDir);

            $img->save($targetDir . "/" . $fileName);

            $filePath = $targetDir . "/" . $fileName;
            $info = getimagesize($filePath);
            //Remove thumbnails


            Utility::rmdir($targetDir . "/" . $folder);
        }


        if ($generateThumbs) {
            if (isset($_REQUEST["rect"]) && $_REQUEST["rect"] !='undefined') {
                $rect = (array) json_decode(@$_REQUEST["rect"]);

                if(isset($_REQUEST['aspect_ratio_cropping'])){
                    $img->crop(@$rect["x"], @$rect["y"], @$rect["x"] + $rect['width'], @$rect["y"] + $rect['height']);
                    $croppedFileName = "cropped_" . $fileName;
                    $img->best_fit($rect['width'], $rect['height']);
                    $img->save($targetDir . '/'.$croppedFileName);

                    if (config('filesystems.default') == 's3') {
                        try {
                            (new AmazonUploader())->uploadFile($preset . "/" . $croppedFileName);
                        } catch (Exception $exc) {
                            throw new Exception('line no: 175');
                        }

                    }
                }

            } else {
                $rect = array('x' => 0, 'y' => 0, 'width' => $info[0], 'height' => $info[1]);
            }
            if ((isset($_REQUEST["width"]) || isset($rect["width"])) && $info) {
                $config = array(
                    'x' => @$rect["x"],
                    'y' => @$rect["y"],
                    'width' => isset($rect["width"]) ? @$rect["width"] : @$_REQUEST["width"],
                    'height' => isset($rect["height"]) ? @$rect["height"] : @$_REQUEST["height"],

                    'info' => $info
                );
            }
            $thumbs = $this->generateThumbs($filePath, $targetDir, @$config);


            //$originalFilePath = str_replace($targetDir, asset('uploads/'.$preset), $fileName);
            $originalFilePath = asset('uploads/'.$preset). '/' .$fileName;
            if(isset($_REQUEST['aspect_ratio_cropping'])){
                $croppedFilePath = str_replace($targetDir, asset('uploads/' . $preset), $targetDir . '/'. $croppedFileName);
            }



            $response = [
                'thumbs_path' => $thumbs_path,
                'file_path' => $file_path,
                'file_name' => $originalFileName,
                'file_url' => @$filterOriginalFilePath? $filterOriginalFilePath: $originalFilePath,
                'type'  => $uploadFileType,
                'src' => @$config,
                'thumbs' => @$thumbs
            ];
            if(@$croppedFilePath){
                $response['croppedFilePath'] = $croppedFilePath;
            }
            return ($response);
        }
    }

    private function uploadFile($ctrlName, $fileName, $targetDir){
        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 5 * 3600; // Temp file age in seconds
// 5 minutes execution time
        @set_time_limit(5 * 60);

// Uncomment this one to fake upload time
// usleep(5000);
// Clean the fileName for security reasons


        // Get parameters
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;

// Make sure the fileName is unique but only if chunking is disabled
        if ($chunks < 2 && file_exists($targetDir . DS . $fileName)) {
            $ext = strrpos($fileName, '.');
            $fileName_a = substr($fileName, 0, $ext);
            $fileName_b = substr($fileName, $ext);

            $count = 1;
            while (file_exists($targetDir . DS . $fileName_a . '_' . $count . $fileName_b))
                $count++;

            $fileName = $fileName_a . '_' . $count . $fileName_b;
        }

        $filePath = $targetDir . DS . $fileName;

// Create target dir
        if (!file_exists($targetDir))
            mkdir($targetDir, 0777);

// Remove old temp files
        if ($cleanupTargetDir && is_dir($targetDir) && ($dir = opendir($targetDir))) {
            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DS . $file;

                // Remove temp file if it is older than the max age and is not the current file
                if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge) && ($tmpfilePath != "{$filePath}.part")) {
                    @unlink($tmpfilePath);
                }
            }

            closedir($dir);
        } else
            die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');


// Look for the content type header
        if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
            $contentType = $_SERVER["HTTP_CONTENT_TYPE"];

        if (isset($_SERVER["CONTENT_TYPE"]))
            $contentType = $_SERVER["CONTENT_TYPE"];

// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
        if (strpos($contentType, "multipart") !== false) {
            if (isset($_FILES[$ctrlName]['tmp_name']) && is_uploaded_file($_FILES[$ctrlName]['tmp_name'])) {
                // Open temp file
                $out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
                if ($out) {
                    // Read binary input stream and append it to temp file
                    $in = fopen($_FILES[$ctrlName]['tmp_name'], "rb");

                    if ($in) {
                        while ($buff = fread($in, 4096))
                            fwrite($out, $buff);
                    } else
                        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
                    fclose($in);
                    fclose($out);
                    @unlink($_FILES[$ctrlName]['tmp_name']);
                } else
                    die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
            } else
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
        } else {
            // Open temp file
            $out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
            if ($out) {
                // Read binary input stream and append it to temp file
                $in = fopen("php://input", "rb");

                if ($in) {
                    while ($buff = fread($in, 4096))
                        fwrite($out, $buff);
                } else
                    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');

                fclose($in);
                fclose($out);
            } else
                die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }
        if (!$chunks || $chunk == $chunks - 1) {
            // Strip the temp .part suffix off
            rename("{$filePath}.part", $filePath);
            chmod($filePath, 0777);
            return true;
        }

    }

    private function isImage($filePath){
        $is_image = false;
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        /* get mime-type for a specific file */

        $mime = $finfo->file($filePath);
        if (in_array($mime, Image::$image_mimes)) {
            $is_image = true;
        }
        return $is_image;
    }

    private function isPngImage($filePath) {
        $is_png = false;
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($filePath);
        if (in_array($mime, ['image/png'])) {
            $is_png = true;
        }
        return $is_png;
    }


    private function convertPngToJpg($pngFile, $image_file_path){
        $imageTmp=imagecreatefrompng($pngFile);
        imagejpeg($imageTmp, $image_file_path, 100);
        imagedestroy($imageTmp);
        return $image_file_path;
    }

    private function resizeImage($filePath){
        $info = getimagesize($filePath);
        $resizedImage = Image::getThumbName($filePath, Image::getUniqueId(array(
            'crop_to_square' => FALSE,
            'width' => 2048,
            'height' => 2048
        )));
        $config = [
            'crop_to_square' => FALSE,
            'width' => 2048,
            'height' => 2048
        ];
        $rect = (array) json_decode(@$_REQUEST["rect"]);
        if(@($rect['rotation'])){
            $config['src'] = (object)[
                'rotation' => @$rect['rotation'],
                'x' => 0,
                'y' => 0,
                'width' => $info[1],
                'height' => $info[0]
            ];
        }
        Image::getThumbnail($filePath, $config, array(
            'use_filename' => $resizedImage
        ));
        unlink($filePath);
        rename($resizedImage, $filePath);
    }

    private function generateThumbs($filePath, $targetDir, $config){

        // $preset = Request::input("preset");
        $preset = 'user_avatar';
        $thumbs = Image::generateThumbs($filePath, $preset, $config);
        // $thumbs = new GenerateThumbs($filePath, $preset, $config);
        $env = config('app.environment');
        foreach ($thumbs as $key => $thumb) {
            if (config('filesystems.default') == 's3') {
                $thumbs[$key]['path'] = str_replace(asset().$targetDir, "https://s3.amazonaws.com/" . config
                    ('filesystems.disks.s3.bucket').'/'.$preset, $thumb['path']);
            }else{
                $thumbs[$key]['path'] = str_replace(base_path('public'), '', $thumb['path']);
            }

        }

        if (config('filesystems.default') == 's3') {

            $position = strrpos($filePath, ".");  // set position "/"
            $filePathParts = explode("/", substr($filePath, 0, $position));
            $thumbDirectory = end($filePathParts);
            try {
                (new AmazonUploader())->uploadDirectory($preset . "/" . $thumbDirectory);
            } catch (Exception $ex) {
                throw new Exception('line no: 237');
            }


            unlink($filePath);
            Utility::rmdir($targetDir . "/" . $thumbDirectory);
        }
        return $thumbs;

    }

}
