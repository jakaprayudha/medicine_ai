<?php

date_default_timezone_set("Asia/Jakarta");

$host = "localhost";
$user = "root";
$pass = "";
$db = "ai_medical_scribe";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_errno) {

   http_response_code(500);

   die(json_encode([
      "success" => false,
      "message" => $conn->connect_error
   ]));
}

$conn->set_charset("utf8mb4");
