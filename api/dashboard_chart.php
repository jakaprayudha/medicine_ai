<?php

header("Content-Type:application/json");

require_once("../db/connect.php");

$sql = "

SELECT

DATE(created_at) tanggal,

COUNT(*) total

FROM medical_scribe_record

GROUP BY DATE(created_at)

ORDER BY tanggal

";

$query = $conn->query($sql);

$data = [];

while ($r = $query->fetch_assoc()) {

   $data[] = $r;
}

echo json_encode($data);
