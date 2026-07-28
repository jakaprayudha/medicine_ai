<?php

header("Content-Type: application/json");

require_once("../db/connect.php");

$id = $_GET["id"];

$sql = "

SELECT

r.*,

c.*

FROM medical_scribe_record r

LEFT JOIN medical_clinical_pathway c

ON c.scribe_id=r.id

WHERE r.id='$id'

";

$query = $conn->query($sql);

echo json_encode(

   $query->fetch_assoc()

);
