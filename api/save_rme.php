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

$uuid = uniqid("RME");

$mrn = $data["mrn"] ?? "";

$encounter = $data["encounter_id"] ?? "";

$doctor = $data["doctor_id"] ?? "";

$patient = $data["patient_name"] ?? "";

$keluhan = $data["keluhan_utama"] ?? "";

$riwayat = $data["riwayat_penyakit"] ?? "";

$alergi = $data["riwayat_alergi"] ?? "";

$td = $data["vital_sign"]["tekanan_darah"] ?? "";

$nadi = $data["vital_sign"]["nadi"] ?? "";

$rr = $data["vital_sign"]["respirasi"] ?? "";

$suhu = $data["vital_sign"]["suhu"] ?? "";

$spo2 = $data["vital_sign"]["spo2"] ?? "";

$fisik = $data["pemeriksaan_fisik"] ?? "";

$assessment = $data["assessment"] ?? "";

$plan = $data["plan"] ?? "";

$icd10 = $data["icd10"] ?? "";

$transcript = $data["transcript"] ?? "";

$model = "openai/gpt-4.1";

$stmt = $conn->prepare("
INSERT INTO medical_scribe_record(

uuid,
mrn,
encounter_id,
doctor_id,
patient_name,

keluhan_utama,
riwayat_penyakit,
riwayat_alergi,

tekanan_darah,
nadi,
respirasi,
suhu,
spo2,

pemeriksaan_fisik,
assessment,
plan,
icd10,

transcript,
ai_model

)

VALUES(

?,?,?,?,?,
?,?,?,?,?,
?,?,?,?,?,
?,?,?,?

)

");

$stmt->bind_param(

   "sssssssssssssssssss",

   $uuid,
   $mrn,
   $encounter,
   $doctor,
   $patient,

   $keluhan,
   $riwayat,
   $alergi,

   $td,
   $nadi,
   $rr,
   $suhu,
   $spo2,

   $fisik,
   $assessment,
   $plan,
   $icd10,

   $transcript,
   $model

);

$stmt->execute();

$id = $stmt->insert_id;

echo json_encode([

   "success" => true,

   "scribe_id" => $id,

   "uuid" => $uuid

]);
