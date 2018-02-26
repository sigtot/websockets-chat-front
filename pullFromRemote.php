<?php

$headers = getallheaders();
$body = file_get_contents("php://input");

$secret = str_replace(array("\r", "\n"), '', file_get_contents("github_webhook_secret")); // file might contain newline
$hmacHash = hash_hmac("sha1", $body, $secret);

if("sha1=".$hmacHash === $headers["X-Hub-Signature"]) {
  exec("git pull");
}
