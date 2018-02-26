<?php

$postFile = fopen("postrequest", "w");
$secret = file_get_contents("github_webhook_secret");

$headers = getallheaders();

foreach ($headers as $name => $value) {
  fwrite($postFile, $name.": ".$value."\n");
}

$content = file_get_contents("php://input");
$hmacHash = hash_hmac("sha1", $content, $secret);

if($hmacHash === $headers["X-Hub-Signature"]) {
  fwrite($postFile, "Signature verified");
} else {
  fwrite($postFile, "WARNING: Wrong signature!");
}
fwrite($postFile, $hmacHash);

fclose($postFile);