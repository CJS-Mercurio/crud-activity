<?php
  session_start();

  if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  
    header("location: login.php");
    exit();
  }

  include("config.php");
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="fontawesome/css/all.css" rel="stylesheet">
    <title>CRUD</title>
  </head>
  <body>
    <div class="container card border-3 border-info mt-3 mb-3 shadow">
      <div class="row">
        <div class="col-md-3 offset-md-9 pull-right">
          <p class="mt-5">
            Hi! <b><?= htmlspecialchars($_SESSION['username']) ?></b>. Wellcome to our site. <br>
            <a href="reset-password.php" class="btn btn-warning">Password Reset</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
          </p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-10 offset-md-1">

          <!-- Sample CRUD table -->
            <h1>Sample CRUD</h1>
            <a href="add.php" class="btn btn-primary float-end">
              <i class="fas fa-plus"></i> Add Record
            </a>           
            <?php $qry = "SELECT * FROM students"; ?>
            <?php if ($result = mysqli_query($link, $qry)): ?>
              <?php if(mysqli_num_rows($result) > 0): ?>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($rows = mysqli_fetch_array($result)): ?>
                  <tr>
                    <td scope="row"><?= $rows["id"] ?></th>
                    <td><?= $rows["name"] ?></td>
                    <td><?= $rows["address"] ?></td>
                    <td>
                      <a class="btn btn-secondary btn-sm" href="show.php? id=<?= $rows["id"] ?>"><i class="far fa-eye"></i></a>
                      <a class="btn btn-warning btn-sm" href="update.php? id=<?= $rows["id"] ?>"><i class="fas fa-pencil-alt"></i></a>
                      <a class="btn btn-danger btn-sm" href="delete.php? id=<?= $rows["id"] ?>"><i class="fas fa-trash-alt"></i></a>
                    </td>
                  </tr>
                <?php endwhile; ?>
                </tbody>
              </table>
              <?php else: ?>
                <br><br>
                <div class="alert alert-danger"><em>No Records Found.</em></div>
              <?php endif; ?>
            <?php else:  ?>
              <br><br>
              <div class="alert alert-danger"><em>Something went wrong. Query Related error</em></div>
          <?php endif; ?>

          <!-- College Table -->
          <br><hr>
          <h2>College Table</h2>
          <a href="college-add.php" class="btn btn-primary float-end ms-1">
            <i class="far fa-edit"></i> Add College Record 
          </a>
          <?php $qry = "SELECT * FROM colleges"; ?>
            <?php if ($result = mysqli_query($link, $qry)): ?>
              <?php if(mysqli_num_rows($result) > 0): ?>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Code</th>
                    <th scope="col">Description</th>
                    <th scope="col">Dean</th>
                    <th scope="col">Notes</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($rows = mysqli_fetch_array($result)): ?>
                  <tr>
                    <td scope="row"><?= $rows["college_id"] ?></th>
                    <td><?= $rows["college_code"] ?></td>
                    <td><?= $rows["description"] ?></td>
                    <td><?= $rows["name_of_dean"] ?></td>
                    <td><?= $rows["other_notes"] ?></td>
                    <td>
                      <a class="btn btn-secondary btn-sm" href="college-show.php? college_id=<?= $rows["college_id"] ?>"><i class="far fa-eye"></i></a>
                      <a class="btn btn-warning btn-sm" href="college-update.php? college_id=<?= $rows["college_id"] ?>"><i class="fas fa-pencil-alt"></i></a>
                      <a class="btn btn-danger btn-sm" href="college-delete.php? college_id=<?= $rows["college_id"] ?>"><i class="fas fa-trash-alt"></i></a>
                    </td>
                  </tr>
                <?php endwhile; ?>
                </tbody>
              </table>
              <?php else: ?>
                <br><br>
                <div class="alert alert-danger"><em>No Records Found.</em></div>
              <?php endif; ?>
            <?php else:  ?>
              <br><br>
              <div class="alert alert-danger"><em>Something went wrong. Query Related error!</em></div>
          <?php endif; ?>
          <br><hr>
        </div>
      </div>
    </div>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="js/bootstrap.bundle.min.js"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>