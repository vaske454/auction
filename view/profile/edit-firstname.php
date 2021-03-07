<?php
include "../../includes/DbConnection.php"; 
if (isset($_POST['submit'])) {
  $firstName = trim($_POST['firstName']);
  $newFirstName = trim($_POST['newFirstName']);
  $_SESSION['session'];

if (empty($firstName)) {
    array_push($errors, "Please enter a valid first name.");
  }else {
    try {
   
      // Define query to select matching values
      $sql = "UPDATE users SET firstName='$newFirstName' WHERE firstName = '$firstName' AND id =" . $_SESSION['session'];
      //var_dump($sql);
   
     // Prepare the statement
      $query = $db_conn->prepare($sql);
         
     // Bind parameters
      $query->bindParam(':newFirstName', $newFirstName);

        //Sql query to check if all emails match new email
      $sql_firstName = "SELECT firstName FROM users WHERE id=" . $_SESSION['session'];

      $firstName_check = $db_conn->prepare($sql_firstName);
      $firstName_check->execute();
  // Return clashes row as an array indexed by both column name
     $returned_clashes_row = $firstName_check->fetch(PDO::FETCH_ASSOC);
    // print_r($firstName_check);

  // Check for usernames or e-mail addresses that have already been used
     if ( $returned_clashes_row['firstName'] != $firstName ) {
      echo '<script language="javascript">';
      echo 'alert("Wrong first name!")';
      echo '</script>';
    }
      
      else {
      $query->execute(['firstName'=>$newFirstName]);
      echo '<script>alert("You have successfully changed your first name!");</script>';
      }
    } catch (PDOException $e) {
      array_push($errors, $e->getMessage());
    }
  }
}
?>

<!doctype html>
<html lang="en" xmlns="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="../../assets/css/starter.css">
</head>
<body>
<?php include("../../common/profile-navigation.php"); ?>
<main class="pt-5">
  <div class="container">
    <div class="back-button mb-5">
      <a href="../my-account.php">Back to Edit Profile</a>
    </div>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="form-group">
          <label for="exampleInputEmail1">Enter Old First Name</label>
          <input type="text" class="form-control" name="firstName" id="exampleTextInput1" placeholder="Old First Name">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Enter New First Name</label>
          <input type="text" class="form-control" name="newFirstName" id="exampleTextInput2" placeholder="New First Name">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </main>


<?php include("../../common/footer.php"); ?>

<script src="../../node_modules/jquery/dist/jquery.min.js"></script>
<script type="module" src="../../assets/js/starter.js"></script>