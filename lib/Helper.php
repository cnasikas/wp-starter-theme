<?php

namespace App\Helper;

class Helper{

    protected static $instance = null;

	protected function __construct() {
        
    }

    public function init() {
        
    }

    public static function getInstance() {

        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function getToken(){
    
        return bin2hex(secure_random_bytes());
    
    }

    public function startsWith($haystack, $needle){
         $length = strlen($needle);
         return (substr($haystack, 0, $length) === $needle);
    }

    public function endsWith($haystack, $needle){
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    public function hasText(&$str) {

        return isset($str) && ($str != NULL) && (trim($str) != '');
    }

    public function safe_value($str) {

        return sanitize_text_field(mysql_real_escape_string(trim(filter_var($str, FILTER_SANITIZE_STRING))));

    }

    public function trimContentByCharLenght($charlength = false, $content = '') {

        if($charlength === false){
            return $content;
        } 

        $trimedContent = '';

        $charlength++;

        if ( mb_strlen( $content ) > $charlength ) {
            $subex = mb_substr( $content, 0, $charlength - 5 );
            $exwords = explode( ' ', $subex );
            $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
            if ( $excut < 0 ) {
                $trimedContent .= mb_substr( $subex, 0, $excut );
            } else {
                $trimedContent .= $subex;
            }

            $trimedContent .= '[...]';

        } else {
            $trimedContent .= $content;
        }

        return $trimedContent;
    }

    public function checkHTTP($str){
        $str = $str;
        if(strpos($str, '://') === FALSE){ return 'http://' . $str; }
        else return $str;
    }

    public function force_download($url) {

        set_time_limit(0);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $r = curl_exec($ch);
        curl_close($ch);
        header('Expires: 0'); // no cache
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
        header('Cache-Control: private', false);
        header('Content-Type: application/force-download');
        header('Content-Disposition: attachment; filename="' . basename($url) . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($r)); // provide file size
        header('Connection: close');
        echo $r;

    }

    public function getFileType($filename) {

        if(strpos($filename, 'youtube.com') !== FALSE || strpos($filename, 'youtu.be') !== FALSE ){ return 'youtube'; }
        elseif(strpos($filename, 'vimeo.com') !== FALSE){ return 'vimeo'; }

        $filename = strtolower(basename($filename));
        $pos = strrpos($filename, '.');

        if($pos === false) {

           return false;

        } else {

         $exten = substr(strrchr($filename,'.'),1);
         if($exten === 'pdf' || $exten === 'doc' || $exten === 'txt' || $exten === 'zip' || $exten === 'rar') return 'file';
         elseif($exten === 'flv' || $exten === 'f4v' || $exten === 'mp4') return 'video';
         elseif($exten === 'mp3' || $exten === 'wav') return 'audio';
         else if($exten === 'swf') return 'swf';
         else return 'image';

       }
    }

    public function getYoutubeID($url) {
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches);
        return $matches[0];
    }

    public function getYoutubeThumb($url){   
        return 'http://img.youtube.com/vi/' . $this->getYoutubeID($url) . '/0.jpg';
    }

    public function getVimeoID($url){

      $result = preg_match('/(\d+)/', $url, $matches);

      if ($result) {
        return $matches[0];
      }

      return false;
    }

    public function getVimeoThumb($url){

      $thumb = '';
      $imgid = $this->getVimeoID($url);

      if($imgid != false){
        $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$imgid.php"));
        $thumb = $hash[0]['thumbnail_medium'];
      }

      return $thumb;
    }

    public function getVideoProvider($url = ''){

        $parsed = parse_url($url);
        $host = $parsed['host'];

        if (strpos($host, 'youtube') > 0) {
            return 'youtube';
        } elseif (strpos($host, 'vimeo') > 0) {
            return 'vimeo';
        } else {
            return 'video';
        }

    }

    public function getBrowser() 
    { 
        $u_agent = $_SERVER['HTTP_USER_AGENT']; 
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        }
        elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        }
        elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }
        
        // Next get the name of the useragent yes seperately and for good reason
        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
        { 
            $bname = 'Internet Explorer'; 
            $ub = "MSIE"; 
        } 
        elseif(preg_match('/Firefox/i',$u_agent)) 
        { 
            $bname = 'Mozilla Firefox'; 
            $ub = "Firefox"; 
        } 
        elseif(preg_match('/Chrome/i',$u_agent)) 
        { 
            $bname = 'Google Chrome'; 
            $ub = "Chrome"; 
        } 
        elseif(preg_match('/Safari/i',$u_agent)) 
        { 
            $bname = 'Apple Safari'; 
            $ub = "Safari"; 
        } 
        elseif(preg_match('/Opera/i',$u_agent)) 
        { 
            $bname = 'Opera'; 
            $ub = "Opera"; 
        } 
        elseif(preg_match('/Netscape/i',$u_agent)) 
        { 
            $bname = 'Netscape'; 
            $ub = "Netscape"; 
        } 
        
        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }
        
        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                $version= $matches['version'][0];
            }
            else {
                $version= $matches['version'][1];
            }
        }
        else {
            $version= $matches['version'][0];
        }
        
        // check if we have a number
        if ($version==null || $version=="") {$version="?";}
        
        return array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'    => $pattern
        );
    } 

    public function isAJAX(){

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) // wp-admin AJAX
            return TRUE;

        if( ! empty( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) &&
            strtolower( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ]) == 'xmlhttprequest' ) {
            return TRUE;
        }

        return FALSE;
    }

    public function hex2rgb( $color ) {
        
        $color = trim( $color, '#' );

        if ( strlen( $color ) == 3 ) {
            $r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
            $g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
            $b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );
        } else if ( strlen( $color ) == 6 ) {
            $r = hexdec( substr( $color, 0, 2 ) );
            $g = hexdec( substr( $color, 2, 2 ) );
            $b = hexdec( substr( $color, 4, 2 ) );
        } else {
            return array();
        }

        return array( 'red' => $r, 'green' => $g, 'blue' => $b );
    }

    public function modifyHTMLiframe($iframe = '', $attributes = array(), $params = array()){

        //http://www.advancedcustomfields.com/resources/oembed/

        // use preg_match to find iframe src
        preg_match('/src="(.+?)"/', $iframe, $matches);
        $src = $matches[1];


        // add extra params to iframe src

        $new_src = add_query_arg($params, $src);

        $iframe = str_replace($src, $new_src, $iframe);


        // add extra attributes to iframe html
        foreach ($attributes as $key => $attribute) {
            $iframe = str_replace('></iframe>', ' ' . $key . '="' . $attribute . '"></iframe>', $iframe);
        }

        return $iframe;
    }

}

?>