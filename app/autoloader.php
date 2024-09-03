<?php

// require 'Hello.php';
// require 'ArrayUtil/ArrayUtil.php';

function __autoload($className) {
  $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
  $filename = __DIR__ . DIRECTORY_SEPARATOR . $className . '.php';

  if (is_readable($filename)) {
    require_once($filename);
    echo "\n######### $filename\n";
  }
}

?>
