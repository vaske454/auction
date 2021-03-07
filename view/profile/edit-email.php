<?php 
include_once '../../includes/DbConnection.php';

if (isset($_POST['edit'])) {
  $email = trim($_POST['email']);
  $newEmail = trim($_POST['newEmail']);
  $_SESSION['session'];

if (empty($email)) {
    array_push($errors, "Please enter a valid e-mail address.");
  }else {
    try {
   
      // Define query to select matching values
      $sql = "UPDATE users SET email='$newEmail' WHERE email = '$email' AND id =" . $_SESSION['session'];
   
     // Prepare the statement
      $query = $db_conn->prepare($sql);
         
     // Bind parameters
      $query->bindParam(':newEmail', $newEmail);

        //Sql query to check if all emails match new email
      $sql_email = "SELECT email FROM users";

      $email_check = $db_conn->prepare($sql_email);
      $email_check->execute();
  // Return clashes row as an array indexed by both column name
     $returned_clashes_row = $email_check->fetch(PDO::FETCH_ASSOC);

  // Check for usernames or e-mail addresses that have already been used
     if ($returned_clashes_row['email'] == $newEmail) {
      echo '<script language="javascript">';
      echo 'alert("Wrong email!")';
      echo '</script>';
      
     } else {
 
      $query->execute(['email'=>$newEmail]);
      echo '<script>alert("You have successfully changed your email address!");</script>';

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
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" >
      <div class="form-group">
        <label for="exampleInputEmail1">Enter old mail</label>
          <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Old mail">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Enter new mail</label>
        <input type="email" name="newEmail" class="form-control" id="exampleInputEmail1" placeholder="New mail">
      </div>
      <button type="submit" name="edit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</main>


<?php include("../../common/footer.php"); ?>

<script src="../../node_modules/jquery/dist/jquery.min.js"></script>
<script type="module" src="../../assets/js/starter.js"></script>