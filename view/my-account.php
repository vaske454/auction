<?php
// Include necessary file
include_once '../includes/DbConnection.php';
//include_once 'includes/User.php';

try {
// Define query to select values from the users table
$sql = "SELECT * FROM users WHERE id=:id";


// Prepare the statement
$query = $db_conn->prepare($sql);

// Bind the parameters
$query->bindParam(':id', $_SESSION['session']);
// Execute the query
$query->execute();

// Return row as an array indexed by both column name
$returned_row = $query->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
array_push($errors, $e->getMessage());
}

if (isset($_GET['logout']) && ($_GET['logout'] == 'true')) {
$user->log_out();
$user->redirect('my-account.php');
}

?>
<!doctype html>
<html lang="en" xmlns="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/starter.css">
</head>
<body>
<?php include("../common/pages-navigation.php"); ?>


<main class="pt-5">
<div class="container">
    
    <div class="row">
        <div class="col-4">
            <ul class="list-group list-group-flush list-unstyled" id="myTab" role="tablist">
                <li class="list-group-item list-group-item-action">
                    <a class="active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Edit Profile</a>
                </li>
                <li class="list-group-item list-group-item-action">
                    <a class="" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">My history</a>
                </li>
            </ul>
        </div>
        <div class="col-8">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <?php include("./edit-profile.php"); ?>
            </div>
            <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                <?php include("./history.php"); ?>
            </div>
        </div>
        </div>
    </div>
</div>
</main>


<?php include("../common/footer.php"); ?>

<script src="../node_modules/jquery/dist/jquery.min.js"></script>
<script type="module" src="../assets/js/starter.js"></script>



