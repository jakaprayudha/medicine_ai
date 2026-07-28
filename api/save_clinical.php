<?php

header("Content-Type: application/json");

require_once("../db/connect.php");

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {

   echo json_encode([
      "success" => false,
      "message" => "Data kosong"
   ]);

   exit;
}

$scribe_id = $data["scribe_id"];

$cp = $data["clinical"];

$diagnosis = $cp["diagnosis"] ?? "";

$icd10 = $cp["icd10"] ?? "";

$triase = $cp["triase"] ?? "";

$tingkat = $cp["tingkat_kegawatan"] ?? "";

$banding = json_encode($cp["diagnosis_banding"] ?? []);

$lab = json_encode($cp["laboratorium"] ?? []);

$radiologi = json_encode($cp["radiologi"] ?? []);

$obat = json_encode($cp["obat"] ?? []);

$tindakan = json_encode($cp["tindakan"] ?? []);

$edukasi = $cp["edukasi"] ?? "";

$follow = $cp["follow_up"] ?? "";

$stmt = $conn->prepare("

INSERT INTO medical_clinical_pathway(

scribe_id,

diagnosis,

icd10,

triase,

tingkat_kegawatan,

diagnosis_banding,

laboratorium,

radiologi,

obat,

tindakan,

edukasi,

follow_up

)

VALUES(

?,?,?,?,?,?,?,?,?,?,?,?

)

");

$stmt->bind_param(

   "isssssssssss",

   $scribe_id,

   $diagnosis,

   $icd10,

   $triase,

   $tingkat,

   $banding,

   $lab,

   $radiologi,

   $obat,

   $tindakan,

   $edukasi,

   $follow

);

if ($stmt->execute()) {

   echo json_encode([

      "success" => true,

      "clinical_id" => $stmt->insert_id

   ]);
} else {

   echo json_encode([

      "success" => false,

      "message" => $stmt->error

   ]);
}
