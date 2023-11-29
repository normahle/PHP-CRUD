<?php include 'connection.php'; ?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Portfolio Website - Overzichtspagina</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <style>
    .container {
      background-color: #CBC3E3;
    }
  </style>
</head>

<body>
  <main>
    <div class="container">

      <?php
       session_start();
      if (isset($_SESSION["username"])) 
      {?>
        <form action="logout.php" method="get">
          <input type="submit" value="logout">
        </form>
      <?php } else { ?>

        <form action="login.php" method="get">
          <input type="submit" value="login">
        </form>
      <?php } ?>



      <?php
      $stmt = $conn->prepare("SELECT id, title, desc_short, desc_long, type, date FROM projects");
      $conn = new PDO("mysql:host=$servername;dbname=crud", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt->execute();

      // set the resulting array to associative
      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      foreach ($stmt->fetchAll() as $k => $v) {
        //echo $v["id"];
      }


      ?>


      <div class="d-flex justify-content-center align-items-center m-4">
        <nav aria-label="search and filter">
          <form action="" method="get">
            <input name="search" type="search" class="form-control ds-input" id="search-input" placeholder="Search..." aria-label="Search for..." autocomplete="off" spellcheck="false" role="combobox" aria-autocomplete="list" aria-expanded="false" aria-owns="algolia-autocomplete-listbox-0" dir="auto" style="position: relative; vertical-align: top;">
            <input type="submit" value="search">
          </form>
        </nav>
      </div>



      <?php
      $searchbtn = '%%';
      if (isset($_GET["search"])) {

        echo ($_GET["search"]);
        $searchbtn = "%" . $_GET["search"] . "%";
      }




      if (isset($_GET["search"])) {
        $searchbtn = "%" . $_GET["search"] . "%";
        $stmt = $conn->prepare("SELECT * FROM projects WHERE title like :search ORDER BY id desc");
        $stmt->bindParam(':search', $searchbtn);
      } else {
        $stmt = $conn->prepare("SELECT * FROM projects");
      }

      //$stmt = $conn->prepare("SELECT  *  FROM projects");
      $stmt->execute();
      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      ?>
      
      <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 g-1 projects">
   
      <?php foreach ($stmt->fetchAll() as $k => $v) {?>

          <div id="project_" class="project card shadow-sm card-body m-2">
            <div class="card-text">
              <h2><?php echo $v["title"]; ?> </h2>
              <?php echo $v["desc_short"]; ?><br><br>

              <a href="detail.php?id=<?php echo $v["id"]; ?>"> <button type="button" class="btn btn-sm btn-outline-secondary">
                  View
                </button></a>

                <?php 
              if (isset($_SESSION["username"])) { ?>

            <a href="add.php?id=<?php echo $v["id"]; ?>">
             <button type="button" class="btn btn-sm btn-outline-secondary">
                  add
             </button></a>
            <?php }; ?>

            <?php 
              if (isset($_SESSION["username"])) { ?>

            <a href="edit.php?id=<?php echo $v["id"]; ?>">
             <button type="button" class="btn btn-sm btn-outline-secondary">
                  edit
             </button></a>
            <?php }; ?>

              <?php 
              if (isset($_SESSION["username"])) { ?>

            <a href="delete.php?id=<?php echo $v["id"]; ?>">
             <button type="button" class="btn btn-sm btn-outline-secondary">
                  delete
             </button></a>
            <?php }; ?>
          

             
            </div>

          </div>
          <?php }; ?>

     

        <div class="d-flex justify-content-center align-items-center m-4">
          <nav aria-label="Page navigation example">
            <ul class="pagination">
              <li class="page-item">
                <a class="page-link" href="#">Previous</a>
              </li>
              <li class="page-item"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
          </nav>
        </div>

      </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>