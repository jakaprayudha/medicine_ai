const container = document.getElementById("historyContainer");

loadHistory();

async function loadHistory() {
  try {
    const response = await fetch("api/get_history.php");

    const data = await response.json();

    renderHistory(data);
  } catch (e) {
    console.log(e);
  }
}

function renderHistory(data) {
  let html = "";

  data.forEach((item) => {
    html += `

<div class="patient-card">

    <div class="patient-top">

        <div class="patient-avatar">

            👤

        </div>

        <div class="patient-info">

            <h4>${item.patient_name}</h4>

            <small>

                MRN : ${item.mrn}

            </small>

        </div>

        <span class="status final">

            ${item.status}

        </span>

    </div>

    <div class="patient-body">

        <div class="item">

            <label>

                Assessment

            </label>

            <p>

                ${item.assessment}

            </p>

        </div>

        <div class="item">

            <label>

                ICD-10

            </label>

            <span class="badge-icd">

                ${item.icd10}

            </span>

        </div>

        <div class="item">

            <label>

                AI Generated

            </label>

            <span class="badge-ai">

                🤖 AI Medical Scribe

            </span>

        </div>

    </div>

    <div class="patient-footer">

        <small>

            <i class="bi bi-clock"></i>

            ${item.created_at}

        </small>

        <div>

            <button class="btn-action view"

                onclick="showDetail(${item.id})">

                <i class="bi bi-eye"></i>

            </button>

            <button class="btn-action pdf">

                <i class="bi bi-file-earmark-pdf"></i>

            </button>

            <button class="btn-action print">

                <i class="bi bi-printer"></i>

            </button>

        </div>

    </div>

</div>

`;
  });

  container.innerHTML = html;
}

window.showDetail = async function (id) {
  const modal = new bootstrap.Modal(document.getElementById("detailModal"));

  document.getElementById("detailBody").innerHTML = `
        <div class="text-center p-5">

            <div class="spinner-border text-primary"></div>

            <p class="mt-3">

                Loading...

            </p>

        </div>
    `;

  modal.show();

  try {
    const response = await fetch("api/get_detail.php?id=" + id);

    const data = await response.json();

    document.getElementById("detailBody").innerHTML = `

            <div class="row">

                <div class="col-md-6">

                    <div class="card">

                        <div class="card-body">

                            <h5>${data.patient_name}</h5>

                            <hr>

                            <p><b>MRN :</b> ${data.mrn}</p>

                            <p><b>Assessment :</b> ${data.assessment}</p>

                            <p><b>ICD-10 :</b> ${data.icd10}</p>

                        </div>

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="card">

                        <div class="card-body">

                            <h5>Vital Sign</h5>

                            <hr>

                            <p>TD : ${data.tekanan_darah}</p>

                            <p>Nadi : ${data.nadi}</p>

                            <p>RR : ${data.respirasi}</p>

                            <p>Suhu : ${data.suhu}</p>

                            <p>SpO₂ : ${data.spo2}</p>

                        </div>

                    </div>

                </div>

            </div>

        `;
  } catch (e) {
    console.log(e);
  }
};
