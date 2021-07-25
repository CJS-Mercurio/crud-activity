<?php 
  session_start();

  if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  
    header("location: login.php");
    exit();
  }

  include_once("config.php");
?>
<?php 
  $name = "";
  $address = "";

  $name_err = "";
  $address_err = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
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
      
      $sql = "INSERT INTO students (name, address) VALUE (?, ?)";

      if ($stmt = mysqli_prepare($link, $sql)) {
        
        mysqli_stmt_bind_param($stmt, "ss", $param_name, $param_address);

        $param_name = $name;
        $param_address = $address;

        if (mysqli_stmt_execute($stmt)) {
          
          header("location: index.php");
          exit();

        } else {

          echo "Something went wrong. Please try again.";
        }
      }

      mysqli_stmt_close($stmt);
    }

    mysqli_close($link);
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
            <h1>Creating New Student Information</h1>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
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
