<!DOCTYPE html>
<html lang="id">

<head>

   <meta charset="UTF-8">

   <meta name="viewport"
      content="width=device-width, initial-scale=1.0">

   <title>

      AI Medical Scribe

   </title>

   <!-- Bootstrap -->

   <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
      rel="stylesheet">

   <!-- Bootstrap Icons -->

   <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

   <!-- Google Font -->

   <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
      rel="stylesheet">

   <!-- CSS -->

   <style>
      /* ==========================================
   GOOGLE FONT
========================================== */

      * {
         margin: 0;
         padding: 0;
         box-sizing: border-box;
      }

      body {

         font-family: 'Inter', sans-serif;

         background: #F5F7FB;

         color: #1F2937;

      }

      /* ==========================================
   WRAPPER
========================================== */

      .wrapper {

         max-width: 1600px;

         margin: auto;

         padding: 30px;

      }

      /* ==========================================
   HEADER
========================================== */

      .header {

         display: flex;

         justify-content: space-between;

         align-items: center;

         background: white;

         padding: 25px 35px;

         border-radius: 22px;

         box-shadow: 0 10px 35px rgba(0, 0, 0, .06);

         margin-bottom: 30px;

      }

      .header-left {

         display: flex;

         align-items: center;

         gap: 20px;

      }

      .logo {

         width: 70px;

         height: 70px;

         border-radius: 18px;

         display: flex;

         align-items: center;

         justify-content: center;

         font-size: 34px;

         background: linear-gradient(135deg, #3B82F6, #2563EB);

         color: white;

      }

      .header-left h2 {

         margin: 0;

         font-weight: 700;

      }

      .header-left small {

         color: #6B7280;

      }

      .header-right {

         display: flex;

         align-items: center;

         gap: 15px;

      }

      .avatar {

         width: 55px;

         height: 55px;

         border-radius: 50%;

         object-fit: cover;

         border: 3px solid #EEF2FF;

      }

      .btn-icon {

         width: 45px;

         height: 45px;

         border: none;

         background: #F8FAFC;

         border-radius: 14px;

         transition: .3s;

         cursor: pointer;

         font-size: 20px;

      }

      .btn-icon:hover {

         background: #2563EB;

         color: white;

         transform: translateY(-3px);

      }

      /* ==========================================
   DASHBOARD
========================================== */

      .dashboard {

         display: grid;

         grid-template-columns: repeat(4, 1fr);

         gap: 20px;

         margin-bottom: 30px;

      }

      .dashboard-card {

         background: white;

         border-radius: 22px;

         padding: 25px;

         display: flex;

         align-items: center;

         gap: 20px;

         box-shadow: 0 10px 35px rgba(0, 0, 0, .05);

         transition: .35s;

      }

      .dashboard-card:hover {

         transform: translateY(-8px);

         box-shadow: 0 25px 45px rgba(0, 0, 0, .10);

      }

      .dashboard-card h2 {

         margin: 0;

         font-size: 34px;

         font-weight: 700;

      }

      .dashboard-card p {

         margin-top: 5px;

         color: #64748B;

      }

      /* ==========================================
   ICON
========================================== */

      .icon {

         width: 70px;

         height: 70px;

         border-radius: 20px;

         display: flex;

         align-items: center;

         justify-content: center;

         font-size: 30px;

         color: white;

      }

      .blue {

         background: linear-gradient(135deg, #3B82F6, #2563EB);

      }

      .green {

         background: linear-gradient(135deg, #22C55E, #16A34A);

      }

      .orange {

         background: linear-gradient(135deg, #F59E0B, #EA580C);

      }

      .red {

         background: linear-gradient(135deg, #EF4444, #DC2626);

      }

      /* ==========================================
   SEARCH
========================================== */

      .search-box {

         background: white;

         border-radius: 22px;

         padding: 25px;

         display: flex;

         justify-content: space-between;

         align-items: center;

         box-shadow: 0 10px 35px rgba(0, 0, 0, .05);

         margin-bottom: 30px;

      }

      .search-box h3 {

         margin-bottom: 5px;

         font-weight: 700;

      }

      .search-box small {

         color: #6B7280;

      }

      .search-group {

         display: flex;

         gap: 15px;

      }

      .search-group input {

         width: 380px;

         border: none;

         background: #F8FAFC;

         border-radius: 15px;

         padding: 15px 18px;

         outline: none;

         transition: .3s;

      }

      .search-group input:focus {

         box-shadow: 0 0 0 4px rgba(37, 99, 235, .15);

      }

      .search-group button {

         border: none;

         padding: 15px 30px;

         border-radius: 15px;

         background: #2563EB;

         color: white;

         font-weight: 600;

         transition: .3s;

      }

      .search-group button:hover {

         background: #1D4ED8;

         transform: translateY(-2px);

      }

      /* ==========================================
   HISTORY CONTAINER
========================================== */

      #historyContainer {

         display: grid;

         grid-template-columns: repeat(2, 1fr);

         gap: 25px;

      }

      /* ==========================================
   RESPONSIVE
========================================== */

      @media(max-width:1200px) {

         .dashboard {

            grid-template-columns: repeat(2, 1fr);

         }

         #historyContainer {

            grid-template-columns: 1fr;

         }

      }

      @media(max-width:768px) {

         .wrapper {

            padding: 15px;

         }

         .header {

            flex-direction: column;

            align-items: flex-start;

            gap: 20px;

         }

         .search-box {

            flex-direction: column;

            gap: 20px;

            align-items: flex-start;

         }

         .search-group {

            width: 100%;

            flex-direction: column;

         }

         .search-group input {

            width: 100%;

         }

         .dashboard {

            grid-template-columns: 1fr;

         }

      }

      .patient-card {

         background: white;

         border-radius: 22px;

         padding: 25px;

         box-shadow: 0 10px 35px rgba(0, 0, 0, .05);

         transition: .35s;

         display: flex;

         flex-direction: column;

         gap: 20px;

      }

      .patient-card:hover {

         transform: translateY(-6px);

         box-shadow: 0 20px 45px rgba(0, 0, 0, .10);

      }

      .patient-top {

         display: flex;

         align-items: center;

         justify-content: space-between;

      }

      .patient-avatar {

         width: 65px;

         height: 65px;

         border-radius: 18px;

         background: #EEF4FF;

         display: flex;

         justify-content: center;

         align-items: center;

         font-size: 32px;

      }

      .patient-info {

         flex: 1;

         margin-left: 15px;

      }

      .patient-info h4 {

         margin: 0;

         font-size: 20px;

         font-weight: 700;

      }

      .patient-info small {

         color: #64748B;

      }

      .status {

         padding: 8px 14px;

         border-radius: 12px;

         font-size: 13px;

         font-weight: 600;

      }

      .final {

         background: #DCFCE7;

         color: #15803D;

      }

      .draft {

         background: #FEF3C7;

         color: #B45309;

      }

      .patient-body {

         display: grid;

         grid-template-columns: repeat(3, 1fr);

         gap: 20px;

      }

      .item label {

         display: block;

         font-size: 13px;

         color: #94A3B8;

         margin-bottom: 8px;

      }

      .item p {

         margin: 0;

         font-weight: 600;

      }

      .badge-icd {

         background: #DBEAFE;

         color: #1D4ED8;

         padding: 8px 12px;

         border-radius: 10px;

         font-weight: 600;

         display: inline-block;

      }

      .badge-ai {

         background: #EEF2FF;

         color: #4338CA;

         padding: 8px 12px;

         border-radius: 10px;

         display: inline-block;

      }

      .patient-footer {

         display: flex;

         justify-content: space-between;

         align-items: center;

         padding-top: 15px;

         border-top: 1px solid #E5E7EB;

      }

      .btn-action {

         width: 42px;

         height: 42px;

         border: none;

         border-radius: 12px;

         margin-left: 8px;

         transition: .3s;

      }

      .view {

         background: #2563EB;

         color: white;

      }

      .pdf {

         background: #DC2626;

         color: white;

      }

      .print {

         background: #16A34A;

         color: white;

      }

      .btn-action:hover {

         transform: scale(1.1);

      }
   </style>

</head>

<body>

   <div class="wrapper">

      <!-- HEADER -->

      <header class="header">

         <div class="header-left">

            <div class="logo">

               🩺

            </div>

            <div>

               <h2>

                  AI Medical Scribe

               </h2>

               <small>

                  Artificial Intelligence Electronic Medical Record

               </small>

            </div>

         </div>

         <div class="header-right">

            <button class="btn-icon">

               <i class="bi bi-bell"></i>

            </button>

            <button class="btn-icon">

               <i class="bi bi-moon"></i>

            </button>

            <img
               src="https://i.pravatar.cc/150?img=12"
               class="avatar">

            <div>

               <strong>

                  dr. Jaka Prayudha

               </strong>

               <br>

               <small>

                  Internal Medicine

               </small>

            </div>

         </div>

      </header>

      <!-- DASHBOARD -->

      <section class="dashboard">

         <div class="dashboard-card">

            <div class="icon blue">

               <i class="bi bi-people"></i>

            </div>

            <div>

               <h2>

                  1,245

               </h2>

               <p>

                  Total Patient

               </p>

            </div>

         </div>

         <div class="dashboard-card">

            <div class="icon green">

               <i class="bi bi-robot"></i>

            </div>

            <div>

               <h2>

                  1,223

               </h2>

               <p>

                  AI Generated

               </p>

            </div>

         </div>

         <div class="dashboard-card">

            <div class="icon orange">

               <i class="bi bi-heart-pulse"></i>

            </div>

            <div>

               <h2>

                  1,102

               </h2>

               <p>

                  Clinical Pathway

               </p>

            </div>

         </div>

         <div class="dashboard-card">

            <div class="icon red">

               <i class="bi bi-activity"></i>

            </div>

            <div>

               <h2>

                  98%

               </h2>

               <p>

                  AI Accuracy

               </p>

            </div>

         </div>

      </section>

      <!-- SEARCH -->

      <section class="search-box">

         <div>

            <h3>

               Patient History

            </h3>

            <small>

               Artificial Intelligence Medical Documentation

            </small>

         </div>

         <div class="search-group">

            <input
               type="text"
               placeholder="Search Patient, MRN, ICD-10...">

            <button>

               <i class="bi bi-search"></i>

               Search

            </button>

         </div>

      </section>

      <!-- CONTENT -->

      <section id="historyContainer">

      </section>

   </div>

   <script src="history.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
   <div class="modal fade" id="detailModal">

      <div class="modal-dialog modal-fullscreen">

         <div class="modal-content border-0">

            <div class="modal-header modal-header-custom">

               <div class="d-flex align-items-center">

                  <div class="patient-photo">

                     👨

                  </div>

                  <div class="ms-3">

                     <h3 class="mb-0">

                        AI Medical Scribe

                     </h3>

                     <small>

                        Electronic Medical Record

                     </small>

                  </div>

               </div>

               <div>

                  <button class="btn btn-light">

                     📄 Export

                  </button>

                  <button class="btn btn-light">

                     🖨 Print

                  </button>

                  <button
                     class="btn-close btn-close-white ms-3"
                     data-bs-dismiss="modal">

                  </button>

               </div>

            </div>

            <div class="modal-body p-0">

               <div class="row g-0">

                  <!-- Sidebar -->

                  <div class="col-lg-3 sidebar">

                     <div id="patientInfo">

                     </div>

                  </div>

                  <!-- Content -->

                  <div class="col-lg-9">

                     <ul class="nav nav-tabs px-4 pt-3">

                        <li class="nav-item">

                           <button class="nav-link active">

                              👤 Pasien

                           </button>

                        </li>

                        <li class="nav-item">

                           <button class="nav-link">

                              📝 SOAP

                           </button>

                        </li>

                        <li class="nav-item">

                           <button class="nav-link">

                              ❤️ Vital

                           </button>

                        </li>

                        <li class="nav-item">

                           <button class="nav-link">

                              🤖 Clinical

                           </button>

                        </li>

                        <li class="nav-item">

                           <button class="nav-link">

                              💊 Obat

                           </button>

                        </li>

                        <li class="nav-item">

                           <button class="nav-link">

                              🧪 Lab

                           </button>

                        </li>

                        <li class="nav-item">

                           <button class="nav-link">

                              🎤 Voice

                           </button>

                        </li>

                     </ul>

                     <div class="p-4">

                        <div id="detailBody">

                        </div>

                     </div>

                  </div>

               </div>

            </div>

         </div>

      </div>

   </div>
</body>

</html>