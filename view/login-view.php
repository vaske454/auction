<?php
//start session
require_once('../includes/DbConnection.php');

// Check if user is already logged in
if ($user->is_logged_in()) {
  // Redirect logged in user to their home page
  $user->redirect('index.php');
}

// Check if log-in form is submitted
if (isset($_POST['log_in'])) {
  // Retrieve form input
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  // Check for empty and invalid inputs
  if (empty($email)) {
    array_push($errors, "Please enter a valid e-mail address");
  } elseif (empty($password)) {
    array_push($errors, "Please enter a valid password.");
  } else {
    // Check if the user may be logged in
    if ($user->login($email, $password)) {
      // Redirect if logged in successfully
      $user->redirect('../index.php');

    } else {
      array_push($errors, "Incorrect log-in credentials.");
    }
  }
}

?>
<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Document</title>
<link rel="stylesheet" href="../assets/css/starter.css">
<body>
<div class="container">
  <main class="pt-5">
  <!-- Log in -->
  <h2>Log in</h2>
  <form action="login-view.php" method="POST">
    <label for="email">E-mail Address:</label>
    <input type="email" name="email" id="email" class="form-control" required>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" class="form-control" required>
    <p>Don't have account? You can do it on <a href="register.php">this</a> link.</p>
    <input type="submit" class="btn btn-primary" name="log_in" value="Sign in" style="background: #ABC100; ">
  </form>
  </main>
</div>
</body>
</html>
