<?php
// Include necessary file
include_once 'includes/DbConnection.php';
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
$user->redirect('index.php');
}

?>
<!doctype html>
<html lang="en" xmlns="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Auction</title>
    <link rel="stylesheet" href="assets/css/starter.css">
</head>
<body>
<?php include("common/navigation.php"); ?>

<main class="pt-5">
<div class="container">
<?php if($_SESSION['session']): ?>
<p>Welcome, <b><?php echo $_SESSION['firstName']; ?>.</b> </p>
<?php endif; ?>
    <div class="row">

    <div class="col-lg-4 col-sm-6 ml-auto">
            <div class="d-flex justify-content-between">
                <div class="input-group input-group__search">
                    <input type="search" class="form-control flex-grow-1" placeholder="Search" aria-label="Search"
                        aria-describedby="search-addon" />
                    <button type="submit" class="search-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                    </button>

                </div>
            </div>
            <div class="list-group list-group-flush mt-5">
                <a href="#" class="list-group-item list-group-item-action">Clothes</a>
                <a href="#" class="list-group-item list-group-item-action">Shoes</a>
                <a href="#" class="list-group-item list-group-item-action">Computers and equipment</a>
                <a href="#" class="list-group-item list-group-item-action">Mobile Phones</a>
                <a href="#" class="list-group-item list-group-item-action">Books</a>
                <a href="#" class="list-group-item list-group-item-action">Others</a>
            </div>
    </div>
    <div class="col-lg-8 col-md-12 col-sm-12">
        <div class="row">
            <?php 

                try {
                // Define query to select values from the users table
                $sql_sell = "SELECT * FROM sell";


                // Prepare the statement
                $query = $db_conn->prepare($sql_sell);

                
                // Execute the query
                $query->execute();

                // Return row as an array indexed by both column name
                $returned_row = $query->fetchAll(PDO::FETCH_ASSOC);
                    foreach($returned_row as $item):
                    $formatted_date = new DateTime($item['start_date']);
                    ?>
                    <div class="col-md-4 col-sm-12">
                        <div class="card">
                            <img class="card-img-top" src="<?php echo $item['image']?>" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $item['name']; ?></h5>
                                <p class="card-text">
                                    <?php echo $item['description']; ?>
                                </p>
                                
                                <p class="card-text"><small class="text-muted">Posted on: <?php echo $formatted_date->format('d/m/Y'); ?></small></p>
                                <?php if($item['userId'] != $_SESSION['session']): ?>
                                    <a type="submit" class="btn btn-primary" href="<?php if(!isset($_SESSION['session'])): echo 'view/login-view.php'; else: echo '#'; endif;?>">Place Bid</a>
                                <?php else: ?>
                                    <a disabled class="btn btn-alert">You cant bid</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                    </div>

                <?php   
                endforeach;
                } catch (PDOException $e) {
                array_push($errors, $e->getMessage());
                }
            ?>
            
            
            
            
        </div>
    </div>
</main>

<?php include("common/footer.php"); ?>

<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script type="module" src="assets/js/starter.js"></script>

</body>
</html>
