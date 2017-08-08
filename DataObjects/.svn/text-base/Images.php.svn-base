<?php
/**
 * Table Definition for images
 */


require_once 'DB/DataObject.php';

class DBO_Images extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'images';                          // table name
    public $_database = 'rurenter';                          // database name (used with database_{*} config)
    public $id;                              // int(4)  primary_key not_null
    public $villa_id;                        // int(4)   not_null
    public $file_name;                       // varchar(255)  
    public $size;                            // varchar(32)   not_null
    public $caption;                         // varchar(255)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DBO_Images',$k,$v); }

    function table()
    {
         return array(
             'id' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'villa_id' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'file_name' =>  DB_DATAOBJECT_STR,
             'size' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_NOTNULL,
             'caption' =>  DB_DATAOBJECT_STR,
         );
    }

    function keys()
    {
         return array('id');
    }

    function sequenceKey() // keyname, use native, native name
    {
         return array('id', true, false);
    }

    function defaults() // column default values 
    {
         return array(
             '' => null,
         );
    }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    public $main_image;

    function insertImages($villa_id, $img_arr, $villa_obj=null)
    {
        unset($this->main_image);

        foreach ($img_arr[0] as $k => $arr) {
            
            $this->villa_id = $villa_id;
            //print_r($arr);
            //exit;
            //$this->caption = $arr->ImageCaption;
            $url = VILLARENTERS_IMAGE_URL.$img_arr[1][$k];
            
            preg_match("![^/]+$!", $url, $m);
            $name = $m[0];
            $path = PROJECT_ROOT.'WWW'.VILLA_IMAGE_URL.$villa_id.'/';
            //echo $path.$name.'<br>';
            
            @mkdir ($path);
            //exit;
            
            /*
            $this->saveImage($url, $path.$name);

                if (!$this->main_image) {
                    $this->main_image = $path.$name;
                }
                

            $url1 = str_replace('_thm', '_main', $url);
            $url = str_replace('_thm', '', $url);
            preg_match("![^/]+$!", $url, $m);
            $name = $m[0];
            */
            if ($this->saveImage($url, $path.$name)) {
                $this->file_name = $villa_id.'/'.$name;
                $this->insert();
                if (!$this->main_image) {
                    $url_main = str_replace("840x560", "200x133", $url);
                    $name = "200x133_".$name;
                    $this->main_image = $villa_id.'/'.$name;
                    $this->saveImage($url_main, $path.$name);
                    if ($villa_obj) {
                        $villa_obj->main_image = $villa_id.'/'.$name;
                        $villa_obj->update();
                    }
                }
            } 
        }
    }

    function saveImage($url, $path)
    {
        $req_obj = new GetXML;
        //echo "Image ".$url.'<br>';
        
        $req_obj->req->setUrl(strval($url));
        $response = $req_obj->req->send();

        $headers = $response->getHeader();

        if ($headers['content-type'] == 'text/html') {
            return false;
        }


        $img = $response->getBody();
        if ($img) {
            file_put_contents  ($path, $img);
            return true;
        }
        return false;
    }

    function preDelete($path)
    {
        unlink($path);
    }

    function getRandomImage()
    {
    }

    function insertImagesDB($villa_id, $img_arr)
    {
        $this->villa_id = $villa_id;

        //echo $this->villa_id;
        unset($this->main_image);

        foreach ($img_arr as $k => $arr) {
            //print_r($arr);
            //exit;
            $this->caption = $arr->ImageCaption;
            $url = $arr->ImageURL;
            //preg_match("![^/]+$!", $url, $m);
            $m = explode('/', $url);
            //print_r($m);
            //$name = $m[0];
            $name = $m[5].'/'.$m[6];
            //echo $name.'<br>';
            
            if (!$this->main_image) {
                $this->main_image = $name;
            }

            //$url1 = str_replace('_thm', '_main', $url);
            //$url = str_replace('_thm', '', $url);
            //preg_match("![^/]+$!", $url, $m);
            //$name = $m[0];

            $pattern = '/'.$villa_id.'_thm.jpg$/';

            if (preg_match($pattern, $name)) {
                $name = str_replace('_thm.jpg', '_thm_1.jpg', $name);
            }
            
            $this->file_name = str_replace('_thm', '', $name);
            $this->insert();
        }
    }

    function getImageUrl()
    {
        return 'http://www.rentalsystems.com/data/images/';
    }

    function insertImagesDB_Click($villa_id, $img_arr)
    {
        $this->villa_id = $villa_id;
        unset($this->main_image);

        foreach ($img_arr[0] as $k => $arr) {
            //print_r($arr);
            //exit;
            //$this->caption = $img_arr[1][$k];
            $this->file_name = $img_arr[1][$k];
            $this->insert();
        }
    }

}
