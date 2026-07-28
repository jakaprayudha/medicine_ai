<?php

header("Content-Type:application/json");

require_once("../db/connect.php");

$data = [];

$data["today"] = $conn->query("
SELECT COUNT(*)
AS total
FROM medical_scribe_record
WHERE DATE(created_at)=CURDATE()
")->fetch_assoc()["total"];

$data["scribe"] = $conn->query("
SELECT COUNT(*)
AS total
FROM medical_scribe_record
")->fetch_assoc()["total"];

$data["clinical"] = $conn->query("
SELECT COUNT(*)
AS total
FROM medical_clinical_pathway
")->fetch_assoc()["total"];

$data["draft"] = $conn->query("
SELECT COUNT(*)
AS total
FROM medical_scribe_record
WHERE status='Draft'
")->fetch_assoc()["total"];

$data["final"] = $conn->query("
SELECT COUNT(*)
AS total
FROM medical_scribe_record
WHERE status='Final'
")->fetch_assoc()["total"];

echo json_encode($data);
