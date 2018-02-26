<?php

$postFile = fopen("postrequest", "w");

foreach (getallheaders() as $name => $value) {
  fwrite($postFile, $name.": ".$value."\n");
}

$content = file_get_contents("php://input");
$hash = hash_hmac("sha1", $content, "blahblah"); // This key is not legit
fwrite($postFile, $hash);

fclose($postFile);