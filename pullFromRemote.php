<?php

$postFile = fopen("postrequest", "w");

foreach (getallheaders() as $name => $value) {
  fwrite($postFile, $name.": ".$value."\n");
}

$content = file_get_contents("php://input");
fwrite($postFile, $content);

fclose($postFile);