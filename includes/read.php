<?php
//include('simple_image.php');
$dir = new DirectoryIterator('../images/');
foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
        var_dump($fileinfo->getFilename());
    }
}
?>