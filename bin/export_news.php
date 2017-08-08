#!/usr/bin/php -q
<?php
/**
Ёкспорт новостей с yandex
http://news.yandex.ru/travels.rss
*/

/*
$url = 'http://news.yandex.ru/travels.rss';

$data = file_get_contents($url);

echo '<pre>';
echo $data;

		<ul>
					<li><a href="http://www.holiday-rentals.co.uk/search/refined/world/region:1/Property+Type:condo" rel="nofollow">World condos</a> (20054)</li>
					<li><a href="http://www.holiday-rentals.co.uk/search/refined/world/region:1/Property+Type:cabin" rel="nofollow">World cabins</a> (2575)</li>

		</ul>
*/

 $file = "http://news.yandex.ru/travels.rss";
  $XML = file_get_contents($file);
  if(!$XML) continue;
  $ITEMS = GetXMLAllVal($XML, 'item');
 
 $i=0;
 $str ='';
  foreach($ITEMS as $item){
      if ($i == 5) 
          continue;
          $title = GetXMLFirstVal($item, 'title');
          $link = GetXMLFirstVal($item, 'link');
          $text = GetXMLFirstVal($item, 'description');
          $date = GetXMLFirstVal($item, 'pubDate');
          $title = html_entity_decode($title, ENT_QUOTES);
          $text = html_entity_decode($text, ENT_QUOTES);
         
          $str .= '<li><a href="'.$link.'" rel="nofollow">'.$title.'</a><br><i>'.$text.'</i><br>...<br></li>';
            $i++;
          //print("<em><a href=\"$link\" style=\"text-decoration: none\" >".$title."</a></em>   <i>".$date."<br /><hr color=\"#CCCCCC\" />".$text."<br /><hr color=\"#CCCCCC\" /><br /><br />");
  }

  function GetXMLFirstVal($r,$t) {
          if(preg_match_all('/<('.$t.')[^>]{0,}>(.*)<\/\\1>/Usi',$r,$o)) return $o[2][0];
          return '';
  }
  
  function GetXMLAllVal($r,$t) {
          if(preg_match_all('/<('.$t.')[^>]{0,}?>(.*)<\/\\1>/Usi',$r,$o)) return $o[2];
          return array();
  }

//echo $str;
    //echo iconv("UTF-8", "Windows-1251", $str);

//$xml = simplexml_load_string($data);
//print_r($xml);

define('PROJECT_ROOT', preg_replace("/[a-z]+\/$/i", '', dirname(realpath($_SERVER['SCRIPT_FILENAME'])).'/'));

file_put_contents(PROJECT_ROOT.'conf/news.txt', iconv("UTF-8", "Windows-1251", $str));


?>