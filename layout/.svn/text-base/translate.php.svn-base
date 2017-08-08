<?
/**
* Translating language with Google API
* @author GANJAR icq:993770 http://mytu.ru/
*/
class Google_Translate_API {
    /**
    * Translate a piece of text with the Google Translate API
    * @return String
    * @param $original_text String
    * @param $inp_lan String[optional] Original language of $original_text. An empty String will let google decide the language of origin
    * @param $out_lan String[optional] Language to translate $original_text to
    */
    //private $url = "translate.google.ru/translate_a/t?client=x&text=hello&sl=en&tl=ru";

    static function google_api_translate($original_text, $inp_lan, $out_lan){

        //$url = "http://ajax.googleapis.com/ajax/services/language/translate?v=1.0&q=".urlencode ($original_text)."&langpair=".urlencode ($inp_lan.'|'.$out_lan);
        $url = "http://translate.google.ru/translate_a/t?client=x&text=".rawurlencode($original_text)."&sl=".$inp_lan.'&tl='.$out_lan;

        $agent = "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 1.1.4322)" ;
        $header [] = "Accept: text/html;" ;
        $header [] = "Accept-Charset: utf-8,*;q=0.7";
        $header [] = "Accept_encoding: identity";
        $header [] = "Accept_language: en-us";
        $header [] = "Connection: Keep-Alive";
        $c = curl_init ();
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ( $c , CURLOPT_VERBOSE , 0 );
        curl_setopt ( $c , CURLOPT_USERAGENT , $agent );
        curl_setopt ( $c , CURLOPT_HTTPHEADER , $header );
        curl_setopt ( $c , CURLOPT_FOLLOWLOCATION , 1 );

        $b = curl_exec($c);
        curl_close($c);

        //echo '<pre>';
        $json = json_decode($b, true);
        //echo '<pre>';
        //print_r($json);
        //exit;
        return $json['sentences'][0]['trans'];

        //return iconv("UTF-8", "Windows-1251", $json['sentences'][0]['trans']);

        if ($json['responseStatus'] != 200)return false;
        return $json['responseData']['translatedText'];
    }
    //перевод
    static function google_translate($original_text, $inp_lan = '', $out_lan){
        if($inp_lan==$out_lan) return $original_text;
        $in_arr = array(
                        '{N}',
                        '{R}',
                        '{T}'
                        );
        $out_arr =  array(
                            "\n",
                            "\r",
                            "\t"
                            );
        $original_text = str_replace($out_arr , $in_arr, $original_text);
        $output_text = ''; //Значение на вывод
        if(mb_strlen($original_text ,'UTF-8')>300){
            preg_match_all('!.{1,200}[\n\s\.]!us', $original_text.' ', $text);
            foreach($text[0] AS $key=>$value){
                //echo 'next<br><br>';
                if(!preg_match('![А-я]!', $value) AND in_array($inp_lan, array('ru', 'uk'))){
                    $output_text .= $value.' ';
                    continue;
                }
                $trans_text = self::google_api_translate($value, $inp_lan, $out_lan);
                if ($trans_text !== false) {
                    $output_text .= $trans_text.' ';
                } elseif(!empty($value) && empty($trans_text)) {
                    header("Content-Type: content=text/html; charset=utf-8");
                    //echo $output_text.'<br />';
                    exit('Ошибка: нет ответа от Google');
                    return FALSE;
                }
            }
        } else {
            $trans_text = self::google_api_translate($original_text, $inp_lan, $out_lan);
            if ($trans_text !== false) {
                $output_text = $trans_text;
            } elseif(!empty($original_text) && empty($trans_text)) {
                    return $original_text;
            }
        }
        $output_text = preg_replace('!\{\s?([^\s]*)\s?\}!U', '{\1}', $output_text);
        $output_text = str_replace('{R} {N} ', '{R}{N}',$output_text);
        $output_text = str_ireplace($in_arr, $out_arr, $output_text);
 
        return iconv("UTF-8", "Windows-1251", $output_text);


        return str_replace('  ', ' ',str_replace('<br>', "\n",str_replace('\n', ' ',str_replace('\r', ' ',$output_text))));
    }
 
    //перевод текста смешаного с html
    static function translate_html($text, $inp_lan = '', $out_lan){
        $html_replace = FALSE;
        if(!preg_match('[<>]', $text)){
            $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
            $html_replace = TRUE;
        }
        preg_match_all('!<.*>!U', $text, $text_html_tag);
        foreach($text_html_tag[0] AS $k=>$v){
            $text = str_replace($v, '{%'.$k.'%}', $text);
        }
        $text = self::google_transl($text, $inp_lan, $out_lan);
        foreach($text_html_tag[0] AS $k=>$v){
            $text = preg_replace('!{\s*%\s*'.$k.'\s*%\s*}!', $v, $text);
        }
        if($html_replace===TRUE){
            $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
        }
        return $text;
    }
}
?>