<?php

echo "<pre>";






//$phpPath = exec("curl https://storystar.com/script.php");
//print_r($phpPath);


//$phpPath = exec("which php");
//print_r($phpPath);

$file = fopen("xyz123.txt","w");
echo fwrite($file,"Hello World. Testing!");
fclose($file);
?>