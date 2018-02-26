<?php

$content = file_get_contents("php://input");

$postFile = fopen("postrequest", "w");

fwrite("postrequest", json_encode($content));
fclose($postFile);