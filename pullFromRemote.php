<?php

$logFile = fopen("github.log", "a");

fwrite($logFile, "New request on webhook endpoint!\n");

$headers = getallheaders();
$body = file_get_contents("php://input");

fwrite($logFile, "Headers: \n");
foreach($headers as $name => $value) {
  fwrite($logFile, $name.": ".$value."\n");
}
fwrite($logFile, "Body: \n");
fwrite($logFile, $body);

$secret = str_replace(array("\r", "\n"), '', file_get_contents("github_webhook_secret")); // file might contain newline
$hmacHash = hash_hmac("sha1", $body, $secret);

fwrite($logFile, "Calculated signature hash: ".$hmacHash."\n");

if("sha1=".$hmacHash === $headers["X-Hub-Signature"]) {
  fwrite($logFile, "Signatures match! Pulling from master...\n");
  fwrite($logFile, shell_exec("git pull"));
  fwrite($logFile, "Successfully pulled from master\n");
  fwrite($logFile, "=======================================\n\n");
} else {
  fwrite($logFile, "ERR: Wrong signature!\n");
  fwrite($logFile, "=======================================\n\n");
}
