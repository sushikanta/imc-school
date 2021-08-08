<?php

namespace App\Http\Controllers;
use App\Classes\Image;
use App\User;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Exception;

class PostsController extends Controller
{

    /**
     * Display a listing of the posts.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $posts = Post::with('category','creator')->get();
        $posts->transform(function($item) {
            if($item->img_src && $decoded_img_src = json_decode($item->img_src, true))  {
                $item->img_src = $decoded_img_src;
            }
            return $item;
        });
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::where('published', true)->orderBy('title')->pluck('title','id')->all();
        $creators = User::pluck('name','id')->all();
        
        return view('posts.create', compact('categories','creators'));
    }

    /**
     * Store a new post in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            $data['created_by'] = Auth::Id();
            $post = Post::create($data);

            if($post->display_type == 'main'){
                Post::resetOldMainPoststoUnspecified($post->id);
            }
            return redirect()->route('posts.post.index')
                             ->with('success_message', 'Post was successfully added!');

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
     * Display the specified post.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $post = Post::with('category','creator')->findOrFail($id);

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified post.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if($post->img_src && $decoded_img_src = json_decode($post->img_src, true))  {
            $post->img_src = $decoded_img_src;
        }
        $categories = Category::where('published', true)->orderBy('title')->pluck('title','id')->all();
$creators = User::pluck('name','id')->all();

        return view('posts.edit', compact('post','categories','creators'));
    }

    /**
     * Update the specified post in the storage.
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
            
            $post = Post::findOrFail($id);
            $post->update($data);
            if($post->display_type == 'main'){
                Post::resetOldMainPoststoUnspecified($post->id);
            }
            return redirect()->route('posts.post.index')
                             ->with('success_message', 'Post was successfully updated!');

        } catch (Exception $exception) {
            $error_messages = ['unexpected_error' => 'Unexpected error occurred while trying to process your request!'];
             if($exception->validator){
                    $error_messages = $exception->validator;
              }
            return back()->withInput()
                         ->withErrors($error_messages);
        }        
    }

    /**
     * Remove the specified post from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);
            $post->delete();

            return redirect()->route('posts.post.index')
                             ->with('success_message', 'Post was successfully deleted!');

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
        $id = $request->id;
        $rules = [
            'category_id' => 'nullable',
            'title' => 'string|min:1|max:255|nullable',
            'description' => 'string|min:1|nullable',
            'img_src' => ['file','nullable'],
            'published' => 'nullable',
            'display_type' => 'nullable',
            'published_at' => 'date_format:Y-m-d H:i:s|nullable',
            'created_by' => 'nullable',
            'slug' => 'string|min:1|max:255|unique:posts,slug,'.$id,
            'meta_description' => 'string|min:5|max:160|nullable',
            'meta_keywords' => 'string|min:5|nullable',

        ];
        $messages = [
            'slug.unique' => 'The slug has already been taken for another post. Please use another slug/keyword'
        ];
        $data = $request->validate($rules, $messages);
        if ($request->has('custom_delete_img_src')) {
            $data['img_src'] = null;
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

    private function isPdf($filePath){
        $is_pdf = false;
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        /* get mime-type for a specific file */

        $mime = $finfo->file($filePath);
        if (in_array($mime, Image::$pdf_mimes)) {
            $is_pdf = true;
        }
        return $is_pdf;
    }
    private function isVideo($filePath){
        $is_video = false;
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        /* get mime-type for a specific file */

        $mime = $finfo->file($filePath);
        if (in_array($mime, Image::$video_mimes)) {
            $is_video = true;
        }
        return $is_video;
    }
    private function isDocFile($filePath){
        $isDocFile = false;
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        /* get mime-type for a specific file */

        $ext = pathinfo($filePath, PATHINFO_EXTENSION);

        $mime = $finfo->file($filePath);
        if (in_array($mime, Image::$word_mimes) || $ext == 'docx') {
            $isDocFile = true;
        }
        return $isDocFile;
    }
    private function isExcelFile($filePath){
        $isExcelFile = false;
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        /* get mime-type for a specific file */
        $ext = pathinfo($filePath, PATHINFO_EXTENSION);
        $mime = $finfo->file($filePath);
        if (in_array($mime, Image::$excel_mimes)  || $ext == 'xlsx') {
            $isExcelFile = true;
        }
        return $isExcelFile;
    }

    private function convertPdfToImage($pdfFile, $image_file_path){
        //-getting the file name without extension


        $im = new Imagick();
        //getting the first page of the pdf file
        $im->readimage($pdfFile.'[0]');
        $im->setImageFormat('jpeg');
        $im->writeImage($image_file_path);
        $im->clear();
        $im->destroy();
        return $image_file_path;
    }


    private function convertPngToJpg($pngFile, $image_file_path){
        $imageTmp=imagecreatefrompng($pngFile);
        imagejpeg($imageTmp, $image_file_path, 100);
        imagedestroy($imageTmp);
        return $image_file_path;
    }

    private function convertVideoToImage($videoFile, $image_file_path){
        //-getting the file name without extension

        $video = $videoFile;
        $cmd = "ffmpeg -i $video 2>&1";
        $second = 2;
        if (preg_match('/Duration: ((\d+):(\d+):(\d+))/s', `$cmd`, $time)) {
            $total = ($time[2] * 3600) + ($time[3] * 60) + $time[4];
            $second = rand(1, ($total - 1));
        }

        //$image  = md5(uniqid(rand(), true)).'.jpg';
        $cmd = "ffmpeg -i $video -deinterlace -an -ss $second -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg $image_file_path 2>&1";
        // $cmd = "ffmpeg -i $video -ss 00:00:14.435 -vframes 1 out.png";
        // $cmd = "ffmpeg -i $video -vf fps=1 outd.png";
        // $cmd = "ffmpeg -i $video -qscale:v 2 -vframes 1 $image_file_path";
        $do = `$cmd`;
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

    public function deletePost(Request $request)
    {
        if($request->delete_id){
            $post = Post::findOrFail($request->delete_id);
            $post->delete();
        }

        return ['status' => 'success'];
    }

}
