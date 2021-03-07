<?php
include "../../includes/DbConnection.php"; 
if (isset($_POST['submit'])) {
  $lastName = trim($_POST['lastName']);
  $newLastName = trim($_POST['newLastName']);
  $_SESSION['session'];

if (empty($lastName)) {
    array_push($errors, "Please enter a valid first name.");
  }else {
    try {
   
      // Define query to select matching values
      $sql = "UPDATE users SET lastName='$newLastName' WHERE lastName = '$lastName' AND id =" . $_SESSION['session'];
      //var_dump($sql);
   
     // Prepare the statement
      $query = $db_conn->prepare($sql);
         
     // Bind parameters
      $query->bindParam(':newLastName', $newLastName);

        //Sql query to check if all emails match new email
      $sql_lastName = "SELECT lastName FROM users WHERE id=" . $_SESSION['session'];

      $lastName_check = $db_conn->prepare($sql_lastName);
      $lastName_check->execute();
  // Return clashes row as an array indexed by both column name
     $returned_clashes_row = $lastName_check->fetch(PDO::FETCH_ASSOC);
    // print_r($lastName_check);

  // Check for usernames or e-mail addresses that have already been used
     if ($returned_clashes_row['lastName'] != $lastName) {
      echo '<script language="javascript">';
      echo 'alert("Wrong last name!")';
      echo '</script>';
      
     } else {
      $query->execute(['lastName'=>$newLastName]);
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
          <label for="exampleInputEmail1">Enter old Last name</label>
          <input type="text" name="lastName" class="form-control" id="exampleTextInput1" placeholder="Old Last Name">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Enter new name</label>
          <input type="text" name="newLastName" class="form-control" id="exampleTextInput2" placeholder="New Last Name">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </main>


<?php include("../../common/footer.php"); ?>

<script src="../../node_modules/jquery/dist/jquery.min.js"></script>
<script type="module" src="../../assets/js/starter.js"></script>