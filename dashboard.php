<!doctype html>

<html>

<head>

   <meta charset="utf-8">

   <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
      rel="stylesheet">

   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   <style>
      /* ==========================================
   AI MEDICAL SCRIBE DASHBOARD
========================================== */

      @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

      * {
         margin: 0;
         padding: 0;
         box-sizing: border-box;
      }

      body {

         font-family: 'Inter', sans-serif;

         background: #F4F7FC;

         color: #1E293B;

      }

      /*==============================*/

      .container {

         max-width: 1500px;

      }

      /*==============================*/

      h2 {

         font-weight: 700;

      }

      /*==============================*/

      .card {

         border: none;

         border-radius: 22px;

         box-shadow: 0 10px 30px rgba(0, 0, 0, .05);

         transition: .3s;

         overflow: hidden;

      }

      .card:hover {

         transform: translateY(-6px);

         box-shadow: 0 20px 45px rgba(0, 0, 0, .08);

      }

      /*==============================*/

      .card-body {

         padding: 25px;

      }

      /*==============================*/

      .card h6 {

         color: #64748B;

         font-size: 15px;

         margin-bottom: 12px;

      }

      /*==============================*/

      .card h2 {

         font-size: 36px;

         font-weight: 700;

      }

      /*==============================*/

      .row>.col:nth-child(1) .card {

         background: linear-gradient(135deg, #3B82F6, #2563EB);

         color: white;

      }

      .row>.col:nth-child(2) .card {

         background: linear-gradient(135deg, #10B981, #059669);

         color: white;

      }

      .row>.col:nth-child(3) .card {

         background: linear-gradient(135deg, #F59E0B, #EA580C);

         color: white;

      }

      .row>.col:nth-child(4) .card {

         background: linear-gradient(135deg, #EF4444, #DC2626);

         color: white;

      }

      .row>.col:nth-child(5) .card {

         background: linear-gradient(135deg, #7C3AED, #6D28D9);

         color: white;

      }

      /*==============================*/

      hr {

         border-top: 2px dashed #CBD5E1;

         margin: 35px 0;

      }

      /*==============================*/

      canvas {

         background: white;

         border-radius: 22px;

         padding: 25px;

         box-shadow: 0 10px 30px rgba(0, 0, 0, .05);

      }

      /*==============================*/

      .dashboard-title {

         display: flex;

         justify-content: space-between;

         align-items: center;

         margin-bottom: 30px;

      }

      .dashboard-title h2 {

         margin: 0;

      }

      .dashboard-title small {

         color: #64748B;

      }

      /*==============================*/

      .badge-live {

         background: #DCFCE7;

         color: #166534;

         padding: 8px 15px;

         border-radius: 12px;

         font-size: 13px;

         font-weight: 600;

      }

      /*==============================*/

      @media(max-width:992px) {

         .row>.col {

            margin-bottom: 20px;

         }

         .card h2 {

            font-size: 28px;

         }

      }
   </style>

</head>

<body>

   <div class="container mt-4">

      <h2>AI Medical Scribe Dashboard</h2>

      <div class="row">

         <div class="col">

            <div class="card">

               <div class="card-body">

                  <h6>Hari Ini</h6>

                  <h2 id="today">0</h2>

               </div>

            </div>

         </div>

         <div class="col">

            <div class="card">

               <div class="card-body">

                  <h6>Medical Scribe</h6>

                  <h2 id="scribe">0</h2>

               </div>

            </div>

         </div>

         <div class="col">

            <div class="card">

               <div class="card-body">

                  <h6>Clinical AI</h6>

                  <h2 id="clinical">0</h2>

               </div>

            </div>

         </div>

         <div class="col">

            <div class="card">

               <div class="card-body">

                  <h6>Draft</h6>

                  <h2 id="draft">0</h2>

               </div>

            </div>

         </div>

         <div class="col">

            <div class="card">

               <div class="card-body">

                  <h6>Final</h6>

                  <h2 id="final">0</h2>

               </div>

            </div>

         </div>

      </div>

      <hr>

      <canvas id="chartAI"></canvas>

   </div>

   <script>
      fetch("api/dashboard.php")

         .then(r => r.json())

         .then(d => {

            today.innerHTML = d.today;

            scribe.innerHTML = d.scribe;

            clinical.innerHTML = d.clinical;

            draft.innerHTML = d.draft;

            final.innerHTML = d.final;

         });

      fetch("api/dashboard_chart.php")

         .then(r => r.json())

         .then(d => {

            let label = [];

            let value = [];

            d.forEach(x => {

               label.push(x.tanggal);

               value.push(x.total);

            });

            new Chart(

               document.getElementById("chartAI"),

               {

                  type: "line",

                  data: {

                     labels: label,

                     datasets: [{

                        label: "AI Medical Scribe",

                        data: value

                     }]

                  }

               }

            );

         });
   </script>

</body>

</html>