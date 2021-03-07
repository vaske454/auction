<?php 
include_once '../../includes/DbConnection.php';

if (isset($_POST['submit'])) {
  $password = trim($_POST['oldPassword']);
  $newPassword = trim($_POST['newPassword']);
  $confirmNewPassword = trim($_POST['confirmNewPassword']);
  $_SESSION['session'];
  

  $sql_pass = "SELECT password FROM users WHERE id = ". $_SESSION['session'];
  
  $sql_checkpass = $db_conn->prepare($sql_pass);
  $sql_checkpass->execute();
  // Return clashes row as an array indexed by both column name
  $returned_clashes_row = $sql_checkpass->fetch(PDO::FETCH_ASSOC);
  
  if(password_verify($password, $returned_clashes_row['password'])) {
    try {
   
      if($newPassword == $confirmNewPassword) {
        $user_hashed_password = password_hash($confirmNewPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password='$user_hashed_password' WHERE id =" . $_SESSION['session'];

        $query = $db_conn->prepare($sql);
        
        // Bind parameters
        $query->bindParam(':password', $user_hashed_password);
        $query->execute();
        echo 'You have successfully changed your password';
      }
      else {
        echo 'New and old password do not match';
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
        <label for="exampleInputPassword1">Enter old password</label>
        <input type="password" class="form-control" id="exampleInputPassword1" name="oldPassword" placeholder="Old Password">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Enter new password</label>
        <input type="password" class="form-control" id="exampleInputPassword1" name="newPassword" placeholder="New Password">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Confirm new password</label>
        <input type="password" class="form-control" id="exampleInputPassword1" name="confirmNewPassword" placeholder="New Password">
      </div>
      <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</main>


<?php include("../../common/footer.php"); ?>

<script src="../../node_modules/jquery/dist/jquery.min.js"></script>
<script type="module" src="../../assets/js/starter.js"></script>

