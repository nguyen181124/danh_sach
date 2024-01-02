<?php

$url = $_SERVER['REQUEST_URI'];
if ($url == '/list') {
  include 'list.php';
} elseif ($url == '/add') {
  include 'add.php';
} elseif ($url == '/fix') {
  include 'fix.php';
}

?>