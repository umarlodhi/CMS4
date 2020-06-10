<?php require_once('includes/DB.php'); ?>
<?php require_once('includes/Functions.php'); ?>
<?php require_once('includes/Sessions.php'); ?>

<?php 
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
Confirm_Login(); ?>

<?php 
if(isset($_POST["Submit"])) {
    $PostTitle = $_POST['PostTitle'];
    $Category = $_POST['Category'];
    $Image = $_FILES['Image']['name'];
    $PostText = $_POST['PostDescription'];

    $Target = "uploads/".basename($_FILES['Image']['name']);
    
    $Admin = $_SESSION["UserName"];

    // Date and time
    date_default_timezone_set("Asia/Karachi");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

    // Check if CategoryTitle is empty or not
    if(empty($PostTitle)) {
        $_SESSION["ErrorMessage"] = "Title Cannot be Empty";
        Redirect_to("AddNewPost.php");
    } elseif(strlen($PostTitle) < 5 ) {
        $_SESSION["ErrorMessage"] = "Post Title Should be greater than 5 charactors";
        Redirect_to("AddNewPost.php");
    } elseif(strlen($PostText) > 9999 ) {
        $_SESSION["ErrorMessage"] = "Post Description Should be less than 1000 charactors";
        Redirect_to("AddNewPost.php");
    } else { 
        
        // Add Query to enter Post into the database
        $sql = "INSERT INTO posts(datetime, title, category, author, image, post)";
        $sql .= "VALUES(:dateTime, :postTitle, :categoryName, :adminName, :imageName, :post)";

        $stmt = $ConnectingDB->prepare($sql);

        $stmt->bindValue(':dateTime', $DateTime);
        $stmt->bindValue(':postTitle', $PostTitle);
        $stmt->bindValue(':categoryName', $Category);
        $stmt->bindValue(':adminName', $Admin);
        $stmt->bindValue(':imageName', $Image);
        $stmt->bindValue(':post', $PostText);

        $Execute = $stmt->execute();

        move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);

        if($Execute) {
            $_SESSION["SuccessMessage"] = "Post Added Successfully";
            Redirect_to("AddNewPost.php");
        } else {
            
            $_SESSION["ErrorMessage"] = "Error Storing Post Data. Something went Wrong.";
            Redirect_to("AddNewPost.php");
        }

    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- font awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.6.3/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>Add Post</title>
  </head>
  <body>
      <div style="height: 10px; background-color: #27aae1;"></div>
    <!-- Nav bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a href="#" class="navbar-brand">ProgrammingWithUmar</a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapseCMS">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapseCMS">

                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a href="MyProfile.php" class="nav-link"> <i class="fas fa-user text-success"></i> My Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="Dashboard.php" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="Posts.php" class="nav-link">Posts</a>
                    </li>
                    <li class="nav-item">
                        <a href="Categories.php" class="nav-link">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a href="Admins.php" class="nav-link">Manage Admin</a>
                    </li>
                    <li class="nav-item">
                        <a href="Comments.php" class="nav-link">Comments</a>
                    </li>
                    <li class="nav-item">
                        <a href="Blog.php?page=1" class="nav-link">Live Blog</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="Logout.php" class="nav-link text-danger"> <i class="fas fa-user-times"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- navbar ending -->
    <div style="height: 10px; background-color: #27aae1;"></div>

    <!-- Header -->
    <header class="bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12"></div>
                <h1><i class="fas fa-edit"></i> Add New Post</h1>
            </div>
        </div>
    </header>
    <!-- header ending -->

    <!-- Main Area -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="col-md-10 offset-lg-1">
                <?php 
                    echo ErrorMessage();
                    echo SuccessMessage(); 
                ?>
                <form class="" action="AddNewPost.php" method="post" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light">
                        
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"><span class="FieldInfo"> Post Title </span></label>
                                <input class="form-control" type="text" name="PostTitle" id="title" placeholder="Type Here Title"> 
                                
                            </div>
                            <div class="form-group">
                                <label for="title"><span class="FieldInfo"> Choose Category </span></label>
                                <select class="form-control" name="Category" id="CategoryTitle">
                                    <?php 
                                       // Fetch all the Categories from category table
                                       $sql = "Select * from category";
                                       $stmt = $ConnectingDB->query($sql);
                                       while($DataRows = $stmt->fetch()) {
                                           $Id = $DataRows["id"];
                                           $CategoryName = $DataRows["title"];
                                    ?> 
                                        <option> <?php echo $CategoryName; ?></option>
                                       <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="custom-file">
                                    <input class="custom-file-input" type="file" name="Image" id="imageSelect">
                                    <label class="custom-file-label" for="imageSelect"> Select Image</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Post"> <span class="FieldInfo"> Post </span></label>
                                <textarea class="form-control" name="PostDescription" id="Post" cols="80" rows="8"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                                
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="Submit" name="Submit" class="btn btn-success btn-block">
                                    <i class="fas fa-check"></i> Publish
                                    </button>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <div style="height: 10px; background-color: #27aae1;"></div>
    <!-- footer -->
    <footer class="bg-light text-black mt-2">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="lead text-center">Theme By | Umar | <span id="year"></span> All Rights Reserved</p>
                </div>
            </div>
        </div>

    </footer>
    <div style="height: 10px; background-color: #27aae1;"></div>
    <!-- footer ending -->
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script>
        $('#year').text(new Date().getFullYear());
    </script>



  </body>
</html>