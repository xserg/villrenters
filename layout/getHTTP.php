<?php
/**
 * @package villarenters.ru
 * @description Запрос и получение данных
 */

require_once ('HTTP/Request2.php');


/**
 * 
 */
class GetHTTP
{

    /**
     * PEAR HTTP_Request Object
     *
     * @var object
     */
    public $req;

    /**
     * server response
     *
     * @var array
     */
    public $response;    
    
    
    public $cookies_jar;

    /**
     * constructor
     *
     * @param string $url
     */
     
    function __construct()
    {
        $this->req = &new HTTP_Request2('', HTTP_Request2::METHOD_GET, 
            array('proxy_host' => PROXY_HOST, 'proxy_port' => PROXY_PORT, 'follow_redirects' => 1));
        //$this->req->setConfig(array('follow_redirects' => 1));
        $this->req->setCookieJar(true);
        //HTTP_Request2_CookieJar::usePublicSuffixList();
    }
    
    /**
     * post vars to server and return response
     *
     * @param array $vars

        array('url' => $url, 'params' => array());

     * @return array
     */
    function request($vars=array())
    { 
        $this->req->setHeader(array(
            'user-agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0',
            'Referer'    =>  $vars['host'].$vars['url'],
            'Connection' => 'keep-alive'

            ));


        $url_obj       = new Net_URL2(($vars['host'] ? $vars['host'] : DATA_HOST).$vars['url']);
        
        if ($vars['method'] == 'post') {
            $this->req->setMethod(HTTP_Request2::METHOD_POST);

            if ($this->cookies_jar) {
                $this->req->setCookieJar($this->cookies_jar);
            }
            $this->req->addPostParameter($vars['params']);




        } else {
            $url_obj->setQueryVariables($vars['params']);
        }



        ///////////////////////////////////////
        if ($vars['cookies']) {
            foreach ($vars['cookies'] as $k => $cookie) {
                //$this->req->addCookie($cookie['name'], $cookie['value']);
            }
        }

        $this->req->setUrl($url_obj);
        $this->response = $this->req->send();
        


        //HTTP_Request2_CookieJar::addCookiesFromResponse();

        //$cookies = HTTP_Request2_CookieJar::getAll();
        
        $this->cookies_jar = $this->req->getCookieJar();
        //echo '<pre>';
        //print_r($this->req);
        

        if (DEBUG == 1) {
            //echo "\n POST TO: ".$this->req->getUrl()."\n";
            echo '<pre>';
            echo "Status ".$this->response->getStatus();
            print_r($this->req);
        }

        $body = $this->response->getBody();
        //$header = $this->response->getHeader();
        return $body;
    }

    
    /**

    
    /**
     * Read directory content
     *
     * @param string $dir
     * @return string
     */
    public static function getFiles($dir)
    {
        if ($handle = opendir($dir)) {
            while (false !== ($file = readdir($handle))) { 
                if ($file != "." && $file != "..") { 
                    $str .= "<a href=?file=$file>$file</a><br>"; 
                } 
            }
            closedir($handle); 
            return $str;
        }
    }


    function putFile($file)
    {
        $f = fopen($file,'a+');
        fwrite($f,$content,strlen($content));
        fclose($f); 
    }
}

?>