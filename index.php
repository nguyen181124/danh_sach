<?php

$url =  strtok($_SERVER['REQUEST_URI'],'?');
if ($url == '/list') {
  include 'list.php';
} elseif ($url == '/add') {
  include 'add.php';
} elseif ($url == '/edit') {
  include 'edit.php';
}

?>