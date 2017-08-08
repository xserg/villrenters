<?php
phpinfo();
exit;
// utf-8 is required to display characters properly
header('Content-Type: text/html; charset=utf-8');

require_once('google.translator.php');

// translate apple from english to portuguese
$str = Google_Translate_API::translate('Apple', 'en', 'pt');

// view the translated string
var_dump($str);

?>
