<?php
// Include necessary file
require_once('../includes/DbConnection.php');

// Check if register form is submitted
if (isset($_POST['register'])) {
// Retrieve form input
  $firstName = trim($_POST['firstName']);
  $lastName = trim($_POST['lastName']);
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

// Check for empty and invalid inputs
  if (empty($firstName)) {
    array_push($errors, "Please enter a valid first name.");
  } elseif (empty($lastName)) {
    array_push($errors, "Please enter a valid last name.");
  }elseif (empty($email)) {
    array_push($errors, "Please enter a valid e-mail address.");
  } elseif (empty($password)) {
    array_push($errors, "Please enter a valid password.");
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    array_push($errors, "Please enter a valid e-mail address.");
  } else {
    try {
// Define query to select matching values
      $sql = "SELECT email FROM users WHERE email=:email";

// Prepare the statement
      $query = $db_conn->prepare($sql);

// Bind parameters
      $query->bindParam(':email', $email);

// Execute the query
      $query->execute();

// Return clashes row as an array indexed by both column name
      $returned_clashes_row = $query->fetch(PDO::FETCH_ASSOC);

// Check for usernames or e-mail addresses that have already been used
      if ($returned_clashes_row['email'] == $email) {
        array_push($errors, "That e-mail address is taken. Please choose something different.");
      } else {
// Check if the user may be registered
        if ($user->register($firstName, $lastName, $email, $password)) {
          echo "Registered";
        }
      }
    } catch (PDOException $e) {
      array_push($errors, $e->getMessage());
    }
    if($query) {
      echo "<script language=\"JavaScript\">\n";
      echo "alert('You are register now. Please log in.');\n";
      echo "window.location='login-view.php'";
      echo "</script>";
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Register</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class="container">

  <!-- Log in -->
  <!--<h2>Log in</h2>-->
  <!--<form action="register.php" method="POST">-->
  <!--    <label for="user_name_email">Username or E-mail Address:</label>-->
  <!--    <input type="text" name="email" id="email" required>-->
  <!---->
  <!--    <label for="user_password_log_in">Password:</label>-->
  <!--    <input type="password" name="password" id="password" required>-->
  <!---->
  <!--    <input type="submit" name="log_in" value="Log in">-->
  <!--</form>-->

  <!-- Register -->
  <h2>Register New User Here</h2>
  <form action="register.php" method="POST">
    <div class="form-group">
      <label for="firstName">First Name:</label>
      <input type="text" name="firstName" id="firstName" class="form-control" placeholder="Enter First Name" required>
    </div>
    <div class="form-group">
      <label for="lastName">Last Name::</label>
      <input type="text" name="lastName" id="lastName" class="form-control" placeholder="Enter Last Name" required>
    </div>
    <div class="form-group">
      <label for="email">E-mail Address:</label>
      <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" required>
    </div>
    <div class="form-group">
      <label for="user_password">Password:</label>
      <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required>
    </div>
    <input type="submit" class="btn btn-primary" name="register" value="Register">
  </form>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
