<?php

$output = shell_exec('grep -nr "footer-bottom" ./');

echo "<pre>$output</pre>";
?>
