<?php
namespace App\Classes;
use Illuminate\Support\Str;
use DateTime;
use DateTimeZone;


Class Utility {

    /**
     * 
     * replace string with an object 
     * @param string $string
     * 
     * @param Object $object
     * 
     * @return $string 
     */
    public static function replacePlaceholders($string, $object) {
        foreach ($object as $key => $val) {
            $string = preg_replace('/{' . $key . '}/', $val, $string);
        }
        return $string;
    }


    /**
     * $array is two dimentional array
     * value of $key is index of an array
     * replace string with an object 
     * @return array $keyColum and $valueColumn (is from inner array) pair
     */
    public static function getOptionsListFromInnerArray($array, $keyColumn, $valueColum, $key) {
        if (empty($array)) {
            return array();
        }
        $options = array();
        foreach ($array as $value) {
            if (is_array($value[$key])) {
                $options[] = $value[$key];
            }
        }
        return Utility::getOptionsList($options, $keyColumn, $valueColum);
    }

    public static function filterArrayByIndex($array, $values) {
        $newArray = array();
        $updateArray = array();
        foreach ($array as $key => $row) {
            if (in_array($key, $values)) {
                $newArray[$key] = $row;
            }
        }
        return $newArray;
    }

    public static function object_to_array($obj) {
        $arr = array();
        $arrObj = is_object($obj) ? get_object_vars($obj) : $obj;
        if ($arrObj) {
            foreach ($arrObj as $key => $val) {
                $val = (is_array($val) || is_object($val)) ? Utility::object_to_array($val) : $val;
                $arr[$key] = $val;
            }
        }
        return $arr;
    }

    public static function getFormattedAddress($data) {
        $add_str = '';
        if(@$data['address1']){
            $add_str =$data['address1'].', ';
        }
        if(@$data['address2']){
            $add_str .=$data['address2'].', ';
        }
        if(@$data['city']){
            $add_str .=$data['city'].', ';
        }
        if(@$data['state']){
            $add_str .=$data['state'].', ';
        }

        if(@$data['country']){
            $add_str .=$data['country'];
        }
       return $add_str;
    }

    public static function getGeocodingInfo($address) {
        $address = urlencode($address);
        $key = env('GoogleDeveloperKey');
        //$url = "https://maps.googleapis.com/maps/api/geocode/json?address=$address&sensor=false";
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$address&key=$key&sensor=false";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //curl_setopt($ch, CURLOPT_POST, 1);
        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //WARNING: this would prevent curl from detecting a 'man in the middle' attack
        //curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = json_decode(curl_exec($ch));
        curl_close($ch);
        //$response = json_decode(file_get_contents($url));
        //$location = @$response->results[0]->geometry->location;
        return $response->results[0];
    }

    public static function getCoordinateFromLocation($address, $api_type='')
    {
        $result = [];
        $address = urlencode($address);

        if($api_type == 'google')
        {
            $response =  self::getGeocodingInfo($address);
            $location = $response->geometry->location;
            if ($location) {
                $result['lat'] = @$location->lat;
                $result['long'] =  @$location->lng;

            }
        }else{
            $url = "https://search.mapzen.com/v1/search?text=$address&size=1&api_key=search-HKqtPUG";
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = json_decode(curl_exec($ch));
            curl_close($ch);
            if($response){
                $result = $response->features[0]->geometry->coordinates;
                $result['lat'] = $response->features[0]->geometry->coordinates[0];
                $result['long'] = $response->features[0]->geometry->coordinates[1];
            }else{
                $response =  self::getGeocodingInfo($address);
                $location = $response->geometry->location;
                if ($location) {
                    $result['lat'] = @$location->lat;
                    $result['long'] =  @$location->lng;
                }
            }

        }
        return (object)$result;
    }


    public static function getResponseFromUrl($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //curl_setopt($ch, CURLOPT_POST, 1);
        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //WARNING: this would prevent curl from detecting a 'man in the middle' attack
        //curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public static function getFloatValue($string) {
        return preg_replace("/[^0-9\.]/", "", $string);
    }

    /**
     * 
     * Parse the geocoded address returned by google geocode API, and return the part of the address desired
     * @param Object $googleGeoCodeApiResponse
     * @param String $addressSegment, Valid values- zip, city, state
     */
    public static function getAddressPart($googleGeoCodeApiResponse, $addressSegment, $format = 'short_name') {
        /* $formatted_address = $googleGeoCodeApiResponse->formatted_address;
          $parts = explode(",", $formatted_address);
          $stateZipParts = explode(" ", trim($parts[count($parts)-2])); */
        $components = $googleGeoCodeApiResponse->address_components;
        //var_dump($components);                exit();
        foreach ($components as $component) {
            if (in_array("locality", $component->types) && $addressSegment == 'city') {
                return $component->{$format};
            }
            if (in_array("administrative_area_level_2", $component->types) && $addressSegment == 'city') {
                return $component->{$format};
            }
            if (in_array("administrative_area_level_3", $component->types) && $addressSegment == 'city') {
                return $component->{$format};
            }
            if (in_array("administrative_area_level_1", $component->types) && $addressSegment == 'city') {
                return $component->{$format};
            }
            if (in_array("administrative_area_level_1", $component->types) && $addressSegment == 'state') {
                return $component->{$format};
            }
            if (in_array("postal_code", $component->types) && $addressSegment == 'zip') {
                return $component->{$format};
            }
        }
        //ob_end_clean();
        //print_r($googleGeoCodeApiResponse); exit();
        /* if($addressSegment == 'state'){
          return trim($stateZipParts[0]);
          }elseif($addressSegment == 'zip'){
          return trim($stateZipParts[1]);
          }elseif($addressSegment == 'city'){
          return trim($parts[count($parts)-3]);
          } */
    }

    //Delete folder function
    public static function rmdir($dir) {
        if (!file_exists($dir))
            return true;
        if (!is_dir($dir) || is_link($dir))
            return unlink($dir);
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..')
                continue;
            if (!Utility::rmdir($dir . "/" . $item)) {
                chmod($dir . "/" . $item, 0777);
                if (!Utility::rmdir($dir . "/" . $item))
                    return false;
            };
        }
        return rmdir($dir);
    }

    //get ip address
    public static function getip() {
        $v = '';
        $v = (!empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : ((!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : @getenv('REMOTE_ADDR'));
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $v = $_SERVER['HTTP_CLIENT_IP'];
        return htmlspecialchars($v, ENT_QUOTES);
    }

    public static function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public static function getDevice() {

        $agent = new Agent();
        if($agent->isDesktop()){
            $device_name = 'Computer';
        }elseif($agent->is('Windows')){
            $device_name = 'Windows Phone';
        }elseif($agent->isAndroidOS()){
            $device_name = 'Android';
        }elseif($agent->device()){
            $device_name = $agent->device();
        }
        return @$device_name;

    }

    public static function getBrowser() {

        $agent = new Agent();
        return $agent->browser();

    }
    public static function getOSVersion() {

        $userAgent =  $_SERVER['HTTP_USER_AGENT'];
        $parser = Parser::create();
        $result = $parser->parse($userAgent);
        $device_type = $result->device->family;
        $version = $result->os->toVersion();
        $version_details = self::getOSVersionDetail();

        $version = ($device_type == 'iPhone' || $device_type == 'iPad')?@$version.$version_details:$version;

        if($version)
        {
            return $version;
        }


    }
    public static function getOSVersionDetail() {

        $userAgent =  $_SERVER['HTTP_USER_AGENT'];
        if($userAgent)
        {
            $re = "/(?<=Mobile\\S).(\\w+)/";
            preg_match($re, $userAgent, $matches);

            return @$matches[0];

        }
    }
    public static function getDeviceModel() {

        $userAgent =  $_SERVER['HTTP_USER_AGENT'];
        $parser = Parser::create();
        $result = $parser->parse($userAgent);
        $device_model = $result->device->family;

        if($device_model !='Other')
        {
            return $device_model;
        }


    }

    public function getExecutionTime() {
        global $t;
        $t2 = microtime(true) - $t;
        echo "Script has executed in - " . number_format($t2, 2) . " sec";
        return $t2;
    }

    public static function saveImageFromURL($url, $folder) {
        $size = getimagesize($url);
        $extension = image_type_to_extension($size[2]);
        mkdir('uploads/' . $folder, 0777);
        $imgName = microtime() . $extension;
        $targetDir = "uploads/$folder/$imgName";
        file_put_contents($targetDir, file_get_contents($url));
        return $targetDir;
    }

    /**
     * Decodes a polyline that was encoded using the Google Maps method.
     *
     * The encoding algorithm is detailed here:
     * http://code.google.com/apis/maps/documentation/polylinealgorithm.html
     *
     * This function is based off of Mark McClure's JavaScript polyline decoder
     * (http://facstaff.unca.edu/mcmcclur/GoogleMaps/EncodePolyline/decode.js)
     * which was in turn based off Google's own implementation.
     *
     * This function assumes a validly encoded polyline.  The behaviour of this
     * function is not specified when an invalid expression is supplied.
     *
     * @param String $encoded the encoded polyline.
     * @return Array an Nx2 array with the first element of each entry containing
     *  the latitude and the second containing the longitude of the
     *  corresponding point.
     */
    function decodePolylineToArray($encoded) {
        $length = strlen($encoded);
        $index = 0;
        $points = array();
        $lat = 0;
        $lng = 0;

        while ($index < $length) {
            // Temporary variable to hold each ASCII byte.
            $b = 0;

            // The encoded polyline consists of a latitude value followed by a
            // longitude value.  They should always come in pairs.  Read the
            // latitude value first.
            $shift = 0;
            $result = 0;
            do {
                // The `ord(substr($encoded, $index++))` statement returns the ASCII
                //  code for the character at $index.  Subtract 63 to get the original
                // value. (63 was added to ensure proper ASCII characters are displayed
                // in the encoded polyline string, which is `human` readable)
                $b = ord(substr($encoded, $index++)) - 63;

                // AND the bits of the byte with 0x1f to get the original 5-bit `chunk.
                // Then left shift the bits by the required amount, which increases
                // by 5 bits each time.
                // OR the value into $results, which sums up the individual 5-bit chunks
                // into the original value.  Since the 5-bit chunks were reversed in
                // order during encoding, reading them in this way ensures proper
                // summation.
                $result |= ($b & 0x1f) << $shift;
                $shift += 5;
            }
            // Continue while the read byte is >= 0x20 since the last `chunk`
            // was not OR'd with 0x20 during the conversion process. (Signals the end)
            while ($b >= 0x20);

            // Check if negative, and convert. (All negative values have the last bit
            // set)
            $dlat = (($result & 1) ? ~($result >> 1) : ($result >> 1));

            // Compute actual latitude since value is offset from previous value.
            $lat += $dlat;

            // The next values will correspond to the longitude for this point.
            $shift = 0;
            $result = 0;
            do {
                $b = ord(substr($encoded, $index++)) - 63;
                $result |= ($b & 0x1f) << $shift;
                $shift += 5;
            } while ($b >= 0x20);

            $dlng = (($result & 1) ? ~($result >> 1) : ($result >> 1));
            $lng += $dlng;

            // The actual latitude and longitude values were multiplied by
            // 1e5 before encoding so that they could be converted to a 32-bit
            // integer representation. (With a decimal accuracy of 5 places)
            // Convert back to original values.
            $points[] = array($lat * 1e-5, $lng * 1e-5);
        }

        return $points;
    }

    /*
     * This function finds and removes specific character. eg=> '/' from end of the string
     */

    public static function removeCharacter($char = '', $string = '', $position = '') {
        if (!empty($char) && !empty($position) && !empty($string)) {
            if ($position == 'last') {
                $string2 = $string[strlen($string) - 1];
                if ($string2 == $char) {
                    $string = substr($string, 0, -1);
                }
                return $string;
            }
        }
        return $string;
    }

    public static function isValidPhone($string) {
        //$pattern = array("/(\s+|\(|\)|-)/");
        $pattern = "/\(\d{3}\) \d{3}-\d{4}/";
        return preg_match($pattern, $string);
    }

    public static function convertMilesToKM($distance) {
        return $distance * 1.609;
    }

    public static function _attachOperator($operator, $field) {
        $field = Str::lower($field);
        if (strtolower($operator) == 'like' || strtolower($operator) == 'ilike') {
            return "$operator '%$field%'";
        } else {
            return "= '$field'";
        }
    }

    function buildTree(array $elements, $parentId = 1) {
        $branch = array();

        foreach ($elements as $element) {
            if ($element->parent_id == $parentId) {
                $children = Utility::buildTree($elements, $element->id);
                if ($children) {
                    $element->children = $children;
                }
                $branch[$element->id] = $element;
            }
        }

        return $branch;
    }

    /*
     * below function is to create where condition for $columns based on operator.
     */

    public static function addMatchPattern($columns, $term, $request) {
        $term = QueryUtils::escape($term);
        $where = array();
        if (@$request["operator"]) {
            $operator = 'ILIKE';
            foreach ($columns as $column) {
                $where[] = $column . ' ' . Utility::_attachOperator($operator, $term);
            }
        } else {
            $tsquery = Inflector::slug($term, '&');
            foreach ($columns as $column) {
                $where[] = sprintf("to_tsvector('english', " . $column . ") @@ to_tsquery('%s')", $tsquery);
            }
        }
        return $where;
    }

    public static function isModified($before, $data, $fieldName) {
        $pattern = array('/[\W_]*/');
        $before = preg_replace($pattern, "", $before);
        $result = array();
        $after = preg_replace($pattern, "", $data[$fieldName]);
        if ($before == $after) {
            return false;
        }
        return true;
    }

    /*
     * Below function takes string in which if valid urls are found then it will be replaced with anchor tag
     * E.g => "This is a link to http://google.com".
     * above string will be replaced as: "This is a link to <a href='http://google.com' target='_blank'>http://google.com</a> "
     */

    public static function makeUrlToLink($text = '', $class = '', $style = '') {
        // The Regular Expression filter
        $text = trim($text);
        $reg_exUrl = "/((http|https|ftp|ftps)\:\/\/|(www.))[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
        // Check if there is a url in the text
        if (preg_match_all($reg_exUrl, $text, $url)) {
            // make the urls hyper links            	    
            foreach ($url[0] as $v) {

                //current position of the searached url		
                $curpos = strpos($text, ' ' . $v);
                //delete the url                
                $text = substr_replace($text, '', $curpos, strlen($v));
                //insert the link
                $link = str_replace('www', 'http://www', $v);
                $text = substr_replace($text, ' <a href="' . $link . '" target="_blank" class="' . $class . '" style="' . $style . '">' . $v . '</a>', $curpos, 0);
            }
            return $text;
        } else {
            // if no urls in the text just return the text
            return $text;
        }
    }




    public static function pageUrlCookie() {

        return Request::input('page_url', @$GLOBALS['page_url'], 'GET');
    }

    public static function formatNumber($number) {

        if (empty($number)) {
            return null;
        }
        return number_format($number);
    }

    public static function generatePlaceholders($array, $type = ''){
        if($type == 'int') { // type cast array values to int
            return implode(",", array_pad([], count($array), '?::int'));
        }
        return implode(",", array_pad([], count($array), '?'));
    }

    public static function getEmailLandingUrl($code){
        return route('email.landing',['code'=>$code]);
    }

    public static function makeViewResponse($params = [])
    {
        $data_request = $params['data_request'];
        $view_data = $params['view_data'];
        $breadcrumb = $params['breadcrumb'];
        if($data_request == 'ajax_load')
        {
            return response()->json(['data' => $view_data, 'breadcrumb' => $breadcrumb]);
        }
        else{
            return $view_data;
        }


    }

    public static function getFormatedDate($mysql_date = null, $options = [])
    {
        $format = 'd F, Y';
        if(isset($options['format'])){
            $format =  $options['format'];
        }
        if($mysql_date){

//            $mysql_date = self::convertTimeToUSERzone($mysql_date);
//
//            if(@$options['type'] == 'full'){
//                $format = 'd-m-Y (D - h:i A)';
//            }
            return date_format(date_create($mysql_date), $format);
        }
        return 'N/A';

    }

    //this function convert string to UTC time zone
    public static  function convertTimeToUTCzone($str, $userTimezone, $format = 'Y-m-d H:i:s'){

        $new_str = new DateTime($str, new DateTimeZone(  $userTimezone  ) );
        $new_str->setTimeZone(new DateTimeZone('UTC'));
        return $new_str->format( $format);
    }

//this function converts string from UTC time zone to current user timezone
    public static  function convertTimeToUSERzone($str, $format = 'Y-m-d H:i:s'){
        if(empty($str)){
            return '';
        }

        $new_str = new \DateTime($str, new DateTimeZone('UTC') );
        $new_str->setTimeZone(new \DateTimeZone( 'Asia/Calcutta' ));

        return $new_str->format($format);
    }

    public static function getDatesBetween($date1, $date2)
    {
        $period = new \DatePeriod(
            new DateTime($date1),
            new \DateInterval('P1D'),
            new DateTime($date2)
        );

        $dates = [];
        foreach ($period as $key => $value) {
            $dates[] = $value->format('Y-m-d');
        }
        return $dates;
    }
    // return in minute
    public static  function maxJobScheduleLimitMinute($value , $type)
    {
        $returnvalue= $value;
        if($type=='minute')
        {
            $returnvalue= $value;
        }
        elseif($type=='hour')
        {
            $returnvalue= $value*60;
        }
        elseif($type=='day')
        {
            $returnvalue= $value*60*24;
        }
        elseif($type=='month')
        {
            $returnvalue= $value*60*24*30;
        }
        elseif($type=='year')
        {
            $returnvalue= $value*60*24*30*365;
        }

        return $returnvalue;
    }


    public static function getTimeDifference($date1)
    {

        $date = new DateTime($date1);
        $now = new DateTime();
        $interval= $now->diff($date);
        if($interval->days >= 1){
            $str = $interval->days > 1?'days': 'days';
            return $interval->days .' d';
        }else if($interval->h >= 1){
            $str = $interval->h > 1?'hrs': 'hr';
            return $interval->h . ' h';
        }else {
            $str = $interval->m > 1 ? 'mins' : 'min';
            return $interval->m . ' m';
        }
    }
    // return in hour
    public static function minJobHour($value , $type)
    {
        $returnvalue= $value;
        if($type=='minute')
        {
            $returnvalue= $value/60;
        }
        elseif($type=='day')
        {
            $returnvalue= $value*24;
        }
        elseif($type=='month')
        {
            $returnvalue= $value*24*30;
        }
        elseif($type=='year')
        {
            $returnvalue= $value*24*30*365;
        }

        return $returnvalue;
    }

    public static function checkinTimeSecond($value , $type)
    {
        $returnvalue= $value;

        if($type=='minute')
        {
            $returnvalue= $value*60;
        }
         elseif($type=='hour')
        {
            $returnvalue= $value*60*60;
        }
        elseif($type=='day')
        {
            $returnvalue= $value*60*60*24;
        }
        elseif($type=='month')
        {
            $returnvalue= $value*60*60*24*30;
        }
        elseif($type=='year')
        {
            $returnvalue= $value*60*60*24*30*365;
        }
        return $returnvalue;
    }



    public static function slugifyString($text)
    {
        // replace " ' " by space

        $text = str_replace("'", '', $text);

        // replace non letter or digits by _
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public static function pr($var){
        ?><pre>
            <?php print_r($var) ?>
        </pre><?php
    }

    public static function getYoutubeEmbededUrl($youtubeUrl)
    {
        $video_id = explode("?v=", $youtubeUrl);
        $video_id = $video_id[1];
        return 'https://www.youtube.com/embed/'.$video_id;
    }
}
