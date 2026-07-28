<?php

header("Content-Type: application/json");

require_once("../db/connect.php");

$sql = "

SELECT

id,

uuid,

patient_name,

mrn,

assessment,

icd10,

created_at,

status

FROM medical_scribe_record

ORDER BY id DESC

";

$query = $conn->query($sql);

$data = [];

while ($row = $query->fetch_assoc()) {

   $data[] = $row;
}

echo json_encode($data);
