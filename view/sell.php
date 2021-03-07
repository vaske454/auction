<?php
// Include necessary file
include_once '../includes/DbConnection.php';
 //$db_conn;
if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $startPrice = trim($_POST['startPrice']);
    $methodOfPayment = trim($_POST['methodOfPayment']);
    $wayOfDelivery = trim($_POST['wayOfDelivery']);
    $id = $_SESSION['session'];
    $target_dir = '../assets/uploads/';
    $target_dir2 = 'assets/uploads/';
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $target_file2 = $target_dir2 . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    var_dump($check);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
      
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
  
    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
  
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
  
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $start_date = date("Y-m-d");
            $end_date = date("Y-m-d", strtotime($start_date . '+ 10 days')); 
            $sql = "INSERT INTO sell (name, description, startPrice, methodOfPayment, wayOfDelivery, image, start_date, end_date, userId) VALUES (:name, :description, :startPrice,:methodOfPayment,:wayOfDelivery,:image, :start_date, :end_date, :userId)";
            var_dump($sql);
            $query = $db_conn->prepare($sql);
           // $query = $this->db->prepare($sql);

            // Bind parameters
            $query->bindParam(":name", $name);
            $query->bindParam(":description", $description);
            $query->bindParam(":startPrice", $startPrice);
            $query->bindParam(":methodOfPayment", $methodOfPayment);
            $query->bindParam(":wayOfDelivery", $wayOfDelivery);
            $query->bindParam(":image", $target_file2);
            $query->bindParam(":start_date", $start_date);
            $query->bindParam(":end_date", $end_date);
            $query->bindParam(":userId", $id);

            // Execute the query
            $query->execute();
            echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
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
    <link rel="stylesheet" href="../assets/css/starter.css">
</head>
<body>
<?php include("../common/pages-navigation.php"); ?>


<main class="pt-5">
<div class="container">
    
    <div class="row">
        
        <div class="col-10 mx-auto">
            <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Enter Product Name</label>
                    <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="Some Name here..">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Enter Product Description</label>
                    <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Product Description.."></textarea>
                </div>
    
                <div class="form-group">
                    <label for="exampleFormControlInput1">Enter Start Price</label>
                    <input type="number" name="startPrice" class="form-control" id="exampleFormControlInput1" min="0" placeholder="Start Price..">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Payment Options</label>
                    <select class="form-control" name="methodOfPayment" id="exampleFormControlSelect1">
                        <option>Credit Card</option>
                        <option>Delivery</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Delivery Options</label>
                    <select class="form-control" name="wayOfDelivery" id="exampleFormControlSelect1">
                        <option>Personal Acquirement</option>
                        <option>Delivery</option>
                    </select>
                </div>
                <div class="form-group mb-5">
                    <label for="exampleFormControlFile1">Image upload (Optional)</label>
                    <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
</main>


<?php include("../common/footer.php"); ?>

<script src="../node_modules/jquery/dist/jquery.min.js"></script>
<script type="module" src="../assets/js/starter.js"></script>