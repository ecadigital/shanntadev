<?php
//error handler function
function ErrorMessage($errno, $errstr) {
  echo "<div class=\"error\"><b>Error:</b> [$errno] $errstr</div>";
}

//set error handler
set_error_handler("ErrorMessage", E_ALL);
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);



// PATH
define('__css__', 'css');
define('__js__', 'js');
define('__images__','img');
?>