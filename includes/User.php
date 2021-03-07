<?php
//include_once('DbConnection.php');
class User
{
  // Refer to database connection
  private $db;

  // Instantiate object with database connection
  public function __construct($db_conn)
  {
    $this->db = $db_conn;
  }

  // Register new users
  public function register($firstName, $lastName, $email, $password)
  {
    try {
      $user_hashed_password = password_hash($password, PASSWORD_DEFAULT);
      // Define query to insert values into the users table
      $sql = "INSERT INTO users(id, firstName, lastName, email, password) VALUES(NULL ,:firstName, :lastName, :email, :password)";

      // Prepare the statement
      $query = $this->db->prepare($sql);

      // Bind parameters
      $query->bindParam(":firstName", $firstName);
      $query->bindParam(":lastName", $lastName);
      $query->bindParam(":email", $email);
      $query->bindParam(":password", $user_hashed_password);

      // Execute the query
      $query->execute();
    } catch (PDOException $e) {
      array_push($errors, $e->getMessage());
    }
  }

  //Log in registered users with either their username or email and their password
  public function login($email, $password)
  {
    try {
      // Define query to insert values into the users table
      $sql = "SELECT * FROM users WHERE email='$email'";

      // Prepare the statement
      $query = $this->db->prepare($sql);

      // Bind parameters
      $query->bindParam(":email", $email);
      //$query->bindParam(":password", $password);

      // Execute the query
      $query->execute();


      // Return row as an array indexed by both column name
      $returned_row = $query->fetch(PDO::FETCH_ASSOC);
      // var_dump($returned_row);
      // die;
      // Check if row is actually returned
      if ($query->rowCount() > 0) {
        // Verify hashed password against entered password
        if (password_verify($password, $returned_row['password'])) {
          // Define session on successful login
          $_SESSION['session'] = $returned_row['id'];
          $_SESSION['firstName'] = $returned_row['firstName'];
          return true;

        } else {
          // Define failure
          return false;
        }
      } 
      else {
        $errors = "Nije uspelo";
        return $errors;
      }
    } catch (PDOException $e) {
      array_push($errors, $e->getMessage());
    }
  }

  // Check if the user is already logged in
  public function is_logged_in()
  {
    // Check if user session has been set
    if (isset($_SESSION['session'])) {
      return true;
    }
  }

  // Redirect user
  public function redirect($url)
  {
    header("Location: $url");
  }

  // Log out user
  public function log_out()
  {
    // Destroy and unset active session
    session_destroy();
    unset($_SESSION['session']);
    return true;
  }
}
