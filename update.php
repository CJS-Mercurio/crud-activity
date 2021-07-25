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
  $name = "";
  $address = "";

  // Variables for errors
  $name_err = "";
  $address_err = "";

  if (isset($_POST['id']) && !empty($_POST['id'])) {

    $id = $_POST['id'];

    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {

      $name_err = "Please input a name.";

    } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))) {

      $name_err = "Please enter a valid name.";

    } else {

      $name = $input_name;
    }

    $input_address = trim($_POST["address"]);
    if (empty($input_address)) {

      $address_err = "Please input a address.";

    } else {

      $address = $input_address;
    }

    if (empty($name_err) && empty($address_err)) {
      
      $sql = "UPDATE students SET name = ?, address = ? WHERE id = ?";

      if ($stmt = mysqli_prepare($link, $sql)) {

        mysqli_stmt_bind_param($stmt, "ssi", $param_name, $param_address, $param_id);

        $param_id = $id;
        $param_name = $name;
        $param_address = $address;

        if (mysqli_stmt_execute($stmt)) {

          header("location: index.php");
          exit();
        
        } else {

          echo "Oops! Something went wrong. Try again later.";
        }
      }
      mysqli_stmt_close($stmt);
    }
      mysqli_close($link);

  } else {

    if (isset($_GET['id']) && !empty(trim($_GET['id']))) {

      $id = trim($_GET['id']);

      $sql = "SELECT * FROM students WHERE id = ?";
      if ($stmt = mysqli_prepare($link, $sql)) {
        
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        $param_id = $id;

        if (mysqli_stmt_execute($stmt)) {
          
          $result = mysqli_stmt_get_result($stmt);
          if (mysqli_num_rows($result) == 1) {
            
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

            $id = $row['id'];
            $name = $row['name'];
            $address = $row['address'];

          } else {

            header("location: error.php");
            exit();
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
    <link rel="stylesheet" href="fontawesome/css/all.css"/>
    <title>Sample CRUD</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2>Modify Student Information</h2>
            <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control <?php echo(!empty($name_err)) ? 'is-invalid':'' ?>" value="<?= $name ?>">
                    <span class="invalid-feedback"><?= $name_err ?></span>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" class="form-control <?php echo(!empty($address_err)) ? 'is-invalid':'' ?>"><?= $address ?></textarea>
                    <span class="invalid-feedback"><?= $address_err ?></span>
                </div>
                <hr>
                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
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