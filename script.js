const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  showClass: {
    popup: "animate__animated animate__fadeInRight",
  },
  hideClass: {
    popup: "animate__animated animate__fadeOutRight",
  },
});
//=====================================================
// AI MEDICAL SCRIBE
// PART 1
//=====================================================

//==============================
// OPENROUTER
//==============================

const OPENROUTER_API = "https://openrouter.ai/api/v1/chat/completions";

const API_KEY = "Bearer " + window.APP_CONFIG.OPENROUTER_KEY;

//==============================
// GLOBAL DATA
//==============================

let rmeData = null;
let clinicalData = null;
let finalTranscript = "";
let interimTranscript = "";
let isRecording = false;
let recognitionRunning = false;

//==============================
// ELEMENT
//==============================

const txtTranscript = document.getElementById("transcript");

const status = document.getElementById("status");

const btnStart = document.getElementById("start");

const btnStop = document.getElementById("stop");

const btnProcess = document.getElementById("process");

const btnClinical = document.getElementById("clinicalBtn");

btnClinical.disabled = true;

//==============================
// SPEECH API
//==============================

const SpeechRecognition =
  window.SpeechRecognition || window.webkitSpeechRecognition;

if (!SpeechRecognition) {
  alert("Browser tidak mendukung Speech Recognition");

  throw new Error("Speech Recognition tidak tersedia");
}

const recognition = new SpeechRecognition();

recognition.lang = "id-ID";

recognition.continuous = true;

recognition.interimResults = true;

//==============================
// START RECORD
//==============================

btnStart.onclick = () => {
  if (recognitionRunning) return;
  startVoiceUI();
  finalTranscript = "";
  interimTranscript = "";

  txtTranscript.value = "";

  isRecording = true;

  recognition.start();
};

//==============================
// STOP RECORD
//==============================

btnStop.onclick = () => {
  isRecording = false;

  try {
    recognition.stop();
  } catch (e) {
    console.log(e);

    stopVoiceUI();
  }
};

//==============================
// RECORD START
//==============================

recognition.onstart = () => {
  recognitionRunning = true;

  status.innerHTML = "🎤 Sedang Merekam...";

  dot.style.background = "#2ecc71";
};

//==============================
// RECORD END
//==============================

recognition.onend = () => {
  recognitionRunning = false;

  stopVoiceUI();

  if (isRecording) {
    status.innerHTML = "🔄 Menyambungkan ulang...";

    setTimeout(() => {
      if (!recognitionRunning) {
        try {
          recognition.start();
        } catch (e) {}
      }
    }, 600);
  } else {
    status.innerHTML = "⏹ Rekaman Berhenti";

    dot.style.background = "#e74c3c";
  }
};

//==============================
// RECORD ERROR
//==============================

recognition.onerror = (event) => {
  console.log("Speech Error :", event.error);

  recognitionRunning = false;

  if (
    isRecording &&
    (event.error === "aborted" ||
      event.error === "no-speech" ||
      event.error === "audio-capture")
  ) {
    setTimeout(() => {
      try {
        recognition.start();
      } catch (e) {}
    }, 600);
  }
};

//==============================
// HASIL SPEECH
//==============================

recognition.onresult = (event) => {
  interimTranscript = "";

  for (let i = event.resultIndex; i < event.results.length; i++) {
    const text = event.results[i][0].transcript;

    if (event.results[i].isFinal) {
      finalTranscript += text + " ";
    } else {
      interimTranscript += text;
    }
  }

  txtTranscript.value = finalTranscript + interimTranscript;
};

//==============================
// PROMPT MEDICAL SCRIBE
//==============================

const SYSTEM_PROMPT = `
Anda adalah AI Medical Scribe Rumah Sakit.

Ubah percakapan dokter dan pasien menjadi JSON.

Balas HANYA JSON VALID.

Jika data tidak ada isi dengan "".

{
"keluhan_utama":"",
"riwayat_penyakit":"",
"riwayat_alergi":"",
"vital_sign":{
"tekanan_darah":"",
"nadi":"",
"respirasi":"",
"suhu":"",
"spo2":""
},
"pemeriksaan_fisik":"",
"assessment":"",
"plan":"",
"icd10":""
}
`;

//==============================
// PROMPT CLINICAL PATHWAY
//==============================

const CLINICAL_PROMPT = `
Anda adalah AI Clinical Decision Support System (CDSS) Rumah Sakit.

Input berupa JSON Rekam Medis Elektronik.

Tugas Anda:

- Tentukan diagnosis paling mungkin.
- Lengkapi ICD-10.
- Tentukan triase.
- Tentukan tingkat kegawatan.
- Berikan diagnosis banding.
- Rekomendasikan pemeriksaan laboratorium.
- Rekomendasikan pemeriksaan radiologi.
- Rekomendasikan obat sesuai diagnosis.
- Berikan tindakan medis.
- Berikan edukasi pasien.
- Berikan follow up.

Semua rekomendasi hanyalah SARAN untuk dokter.

Balas HANYA JSON VALID.

Format:

{
"diagnosis":"",
"icd10":"",
"triase":"",
"tingkat_kegawatan":"",
"diagnosis_banding":[],
"laboratorium":[],
"radiologi":[],
"obat":[
{
"nama":"",
"dosis":"",
"aturan_pakai":"",
"catatan":""
}
],
"tindakan":[],
"edukasi":"",
"follow_up":""
}
`;
//=====================================================
// AI MEDICAL SCRIBE
//=====================================================

btnProcess.onclick = async () => {
  if (!txtTranscript.value.trim()) {
    Toast.fire({
      icon: "warning",
      title: "Belum ada percakapan yang direkam.",
    });

    return;
  }

  Swal.fire({
    title: "AI Medical Scribe",
    text: "Sedang menganalisa percakapan...",
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    },
  });

  try {
    const response = await fetch(OPENROUTER_API, {
      method: "POST",

      headers: {
        Authorization: API_KEY,

        "Content-Type": "application/json",

        "HTTP-Referer": window.location.origin,

        "X-Title": "AI Medical Scribe",
      },

      body: JSON.stringify({
        model: "openai/gpt-4.1",

        temperature: 0,

        max_tokens: 600,

        messages: [
          {
            role: "system",

            content: SYSTEM_PROMPT,
          },

          {
            role: "user",

            content: txtTranscript.value,
          },
        ],
      }),
    });

    const result = await response.json();
    swal.close();

    console.log(result);

    if (!response.ok) {
      console.log(result);

      alert(result.error?.message || "Request gagal");

      return;
    }

    const content = result?.choices?.[0]?.message?.content;

    if (!content) {
      alert("AI tidak mengembalikan data.");

      return;
    }

    let json = content
      .replace(/```json/g, "")
      .replace(/```/g, "")
      .trim();

    console.log(json);

    rmeData = JSON.parse(json);

    console.log("RME");

    console.log(rmeData);

    isiRME(rmeData);

    btnClinical.disabled = false;

    status.innerHTML = "✅ Analisa selesai";
  } catch (err) {
    console.error(err);

    Toast.fire({
      icon: "error",
      title: err.message,
    });
  }
};

//=====================================
// ISI FORM RME
//=====================================

function isiRME(data) {
  const vital = data.vital_sign || {};

  document.getElementById("keluhan").value = data.keluhan_utama || "";

  document.getElementById("riwayat").value = data.riwayat_penyakit || "";

  document.getElementById("alergi").value = data.riwayat_alergi || "";

  document.getElementById("fisik").value = data.pemeriksaan_fisik || "";

  document.getElementById("assessment").value = data.assessment || "";

  document.getElementById("plan").value = data.plan || "";

  document.getElementById("icd10").value = data.icd10 || "";

  document.getElementById("td").value = vital.tekanan_darah || "";

  document.getElementById("nadi").value = vital.nadi || "";

  document.getElementById("rr").value = vital.respirasi || "";

  document.getElementById("suhu").value = vital.suhu || "";

  document.getElementById("spo2").value = vital.spo2 || "";
}

document.getElementById("clinicalBtn").onclick = async () => {
  if (!rmeData) {
    alert("Silakan Analisa AI terlebih dahulu.");
    return;
  }

  status.innerHTML = "🤖 Membuat Clinical Pathway...";

  try {
    const response = await fetch(
      "https://openrouter.ai/api/v1/chat/completions",
      {
        method: "POST",

        headers: {
          Authorization: API_KEY,
          "Content-Type": "application/json",
          "HTTP-Referer": window.location.origin,
          "X-Title": "AI Medical Scribe",
        },

        body: JSON.stringify({
          model: "openai/gpt-4.1",

          temperature: 0,

          max_tokens: 800,

          messages: [
            {
              role: "system",
              content: CLINICAL_PROMPT,
            },

            {
              role: "user",
              content: JSON.stringify(rmeData),
            },
          ],
        }),
      },
      itu,
    );

    const result = await response.json();

    console.log(result);

    if (result.error) {
      alert(result.error.message);
      return;
    }

    let content = result.choices[0].message.content;

    content = content
      .replace(/```json/g, "")
      .replace(/```/g, "")
      .trim();

    clinicalData = JSON.parse(content);

    console.log(clinicalData);

    tampilClinical(clinicalData);

    status.innerHTML = "✅ Clinical Pathway selesai";

    const modal = new bootstrap.Modal(document.getElementById("clinicalModal"));

    modal.show();
  } catch (e) {
    console.log(e);

    alert(e.message);
  }
};

function tampilClinical(cp) {
  document.getElementById("cpDiagnosis").innerHTML = cp.diagnosis || "";

  document.getElementById("cpICD").innerHTML = cp.icd10 || "";

  document.getElementById("cpTriase").innerHTML = cp.triase || "";

  document.getElementById("cpKegawatan").innerHTML = cp.tingkat_kegawatan || "";

  document.getElementById("cpBanding").innerHTML = (
    cp.diagnosis_banding || []
  ).join("<br>");

  isiList("cpLab", cp.laboratorium);

  isiList("cpRadiologi", cp.radiologi);

  isiList("cpTindakan", cp.tindakan);

  document.getElementById("cpEdukasi").innerHTML = cp.edukasi || "";

  document.getElementById("cpFollowup").innerHTML = cp.follow_up || "";

  // Obat
  const ul = document.getElementById("cpObat");
  ul.innerHTML = "";

  (cp.obat || []).forEach((o) => {
    ul.innerHTML += `
            <li>
                <b>${o.nama}</b><br>
                ${o.dosis}<br>
                ${o.aturan_pakai}<br>
                <small>${o.catatan}</small>
            </li>
        `;
  });
}

//====================================
// ISI LIST
//====================================

function isiList(id, data) {
  const el = document.getElementById(id);

  if (!el) return;

  el.innerHTML = "";

  if (!Array.isArray(data)) return;

  data.forEach((item) => {
    // Jika object (contoh obat)
    if (typeof item === "object") {
      el.innerHTML += `
                <li>
                    <b>${item.nama || ""}</b><br>
                    ${item.dosis || ""}<br>
                    ${item.aturan_pakai || ""}<br>
                    <small>${item.catatan || ""}</small>
                </li>
            `;
    } else {
      el.innerHTML += `<li>${item}</li>`;
    }
  });
}

const btnSave = document.getElementById("saveBtn");

btnSave.onclick = saveRME;
async function saveRME() {
  btnSave.disabled = true;
  btnSave.innerHTML = "💾 Menyimpan...";

  try {
    // tambahkan transcript ke object
    rmeData.transcript = txtTranscript.value;

    const response = await fetch("api/save_rme.php", {
      method: "POST",

      headers: {
        "Content-Type": "application/json",
      },

      body: JSON.stringify(rmeData),
    });

    const result = await response.json();

    console.log(result);

    if (!result.success) {
      alert(result.message);

      btnSave.disabled = false;
      btnSave.innerHTML = "💾 Simpan ke RME";

      return;
    }

    //---------------------------------
    // simpan id hasil insert
    //---------------------------------

    const scribeID = result.scribe_id;

    //---------------------------------
    // simpan clinical
    //---------------------------------

    await saveClinical(scribeID);

    Toast.fire({
      icon: "success",
      title: "Rekam medis berhasil disimpan.",
    });
  } catch (e) {
    console.log(e);

    alert(e.message);
  }

  btnSave.disabled = false;

  btnSave.innerHTML = "💾 Simpan ke RME";
}
async function saveClinical(scribeID) {
  const body = {
    scribe_id: scribeID,

    clinical: clinicalData,
  };

  const response = await fetch(
    "api/save_clinical.php",

    {
      method: "POST",

      headers: {
        "Content-Type": "application/json",
      },

      body: JSON.stringify(body),
    },
  );

  const result = await response.json();

  console.log(result);
}

let second = 0;

let timer = null;

const wave = document.getElementById("wave");

const timerText = document.getElementById("recordTime");

const dot = document.querySelector(".dot");

function startVoiceUI() {
  second = 0;

  timerText.innerHTML = "00:00";

  wave.classList.add("active");

  dot.classList.add("recording");

  clearInterval(timer);

  timer = setInterval(() => {
    second++;

    const m = String(Math.floor(second / 60)).padStart(2, "0");

    const s = String(second % 60).padStart(2, "0");

    timerText.innerHTML = `${m}:${s}`;
  }, 1000);
}

function stopVoiceUI() {
  clearInterval(timer);

  wave.classList.remove("active");

  dot.classList.remove("recording");
}
