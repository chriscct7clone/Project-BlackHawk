<?php
// TODO block direct access
// TODO validate gets

$path=$_GET["path"];
$name=$_GET["name"];
if ($name == '' || $path == ''){
exit;
}

header('Location: http://www.example.com/');
  





?>