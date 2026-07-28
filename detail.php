<!doctype html>

<html>

<head>

   <meta charset="utf-8">

   <title>Detail RME</title>

   <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
      rel="stylesheet">

</head>

<body>

   <div class="container mt-4">

      <h2>Detail AI Medical Scribe</h2>

      <pre id="hasil"></pre>

   </div>

   <script>
      const id = new URLSearchParams(

         window.location.search

      ).get("id");

      fetch(

            "api/get_detail.php?id=" + id

         )

         .then(r => r.json())

         .then(data => {

            document.getElementById("hasil")

               .innerHTML =

               JSON.stringify(data, null, 4);

         });
   </script>

</body>

</html>