<?php 
  session_start();

  if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  
    header("location: login.php");
    exit();
  }
  
  include("config.php");
?>
<?php  

  // Variables
  $college_code = "";
  $description = "";
  $name_of_dean = "";
  $other_notes = "";

  // Deleting items from database
  if (isset($_POST['college_id']) && !empty($_POST['college_id'])) {

    $sql = "DELETE FROM colleges WHERE college_id = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {

      mysqli_stmt_bind_param($stmt, "i", $param_college_id);

      $param_college_id = trim($_POST['college_id']);

      if (mysqli_stmt_execute($stmt)) {

        header("location: index.php");
        exit();
      
      } else {

        echo "Oops! Something went wrong. Try again later.";
      }
    }
      mysqli_stmt_close($stmt);

      mysqli_close($link);

  } else {

    if (isset($_GET['college_id']) && !empty(trim($_GET['college_id']))) {

      $sql = "SELECT * FROM colleges WHERE college_id = ?";
      if ($stmt = mysqli_prepare($link, $sql)) {
        
        mysqli_stmt_bind_param($stmt, "i", $param_college_id);

        $param_college_id = trim($_GET['college_id']);

        if (mysqli_stmt_execute($stmt)) {
          
          $result = mysqli_stmt_get_result($stmt);
          if (mysqli_num_rows($result) == 1) {
            
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

            $college_code = $row['college_code'];
            $description = $row['description'];
            $name_of_dean = $row['name_of_dean'];
            $other_notes = $row['other_notes'];
          }
        } else {

          echo "Oops! Something went wrong. Please try again later.";
        }
      }

      mysqli_stmt_close($stmt);

      mysqli_close($link);  

    } else {

      header("location: error.php");
      exit();
    }
  }
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
    <title>CRUD Activity</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-10 offset-md-1 card border-3 border-danger p-4 mt-5 shadow">
            <h2>Delete College Record</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
              <div class="alert alert-danger ">
                <input type="hidden" name="college_id" value="<?php echo trim($_GET['college_id']) ?>">
                <p>Are you sure you want to delete the record?</p>
                <p>
                  <input type="submit" value="Yes" class="btn btn-danger">
                  <a href="index.php" class="btn btn-secondary">No</a>
                </p>
              </div>
            </form>
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