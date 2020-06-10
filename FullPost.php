<?php require_once('includes/DB.php'); ?>
<?php require_once('includes/Functions.php'); ?>
<?php require_once('includes/Sessions.php'); ?>

<?php $SearchQueryParameter = $_GET["id"]; ?>

<!-- Comments section -->
<?php 
if(isset($_POST["Submit"])) {
    $Name = $_POST["CommenterName"];
    $Email = $_POST["CommenterEmail"];
    $Comment = $_POST["CommenterThoughts"];

    // Date and time
    date_default_timezone_set("Asia/Karachi");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

    // Check if CategoryTitle is empty or not
    if(empty($Name) || empty($Email) || empty($Comment)) {
        $_SESSION["ErrorMessage"] = "All Fields must be Filled";
        Redirect_to("FullPost.php?id=$SearchQueryParameter");

    }  elseif(strlen($Category) > 500 ) {
        
        $_SESSION["ErrorMessage"] = "Comment Should be less than 500 charactors";
        Redirect_to("FullPost.php?id=$SearchQueryParameter");
    } else { 
        
        // Add Query to enter Comment into the database
        $sql = "INSERT INTO comments(datetime, name, email, comment, approvedby, status, post_id)";
        $sql .= "VALUES(:datetime, :name, :email, :comment, 'Pending', 'OFF', :postIdFromURL)";

        $stmt = $ConnectingDB->prepare($sql);

        $stmt->bindValue(':datetime', $DateTime);
        $stmt->bindValue(':name', $Name);
        $stmt->bindValue(':email', $Email);
        $stmt->bindValue(':comment', $Comment);
        $stmt->bindValue(':postIdFromURL', $SearchQueryParameter);

        $Execute = $stmt->execute();

        if($Execute) {
            $_SESSION["SuccessMessage"] = "Comment Submitted Successfully";
            Redirect_to("FullPost.php?id=$SearchQueryParameter");
        } else {
            $_SESSION["ErrorMessage"] = "Error Storing Comment Data. Something went Wrong.";
            Redirect_to("FullPost.php?id=$SearchQueryParameter");
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

    <title>Blog Page</title>
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
                        <a href="Blog.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="about.php" class="nav-link">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="Blog.php" class="nav-link">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a href="Admins.php" class="nav-link">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="Comments.php" class="nav-link">Features</a>
                    </li>
                    
                </ul>
                <ul class="navbar-nav ml-auto">
                    <form class="form-group form-inline d-none d-sm-block" action="Blog.php">
                        <input class="form-control mr-2" type="text" name="Search" placeholder="Search Here...">
                        <button class="btn btn-primary" name="SearchButton">Go</button>
                    
                    </form>
                </ul>
            </div>
        </div>
    </nav>
    <!-- navbar ending -->
    <div style="height: 10px; background-color: #27aae1;"></div>

    <!-- Header -->
    <div class="container">
        <div class="row mt-4">
            <!-- Main Area -->
            <div class="col-sm-8" >
                <h1>The Complete CMS Blog</h1>
                <h2 class="lead">The Complete CMS Blog By Umar</h2>
                <?php 
                    echo ErrorMessage();
                    echo SuccessMessage(); 
                ?>
                <?php 
                    if(isset($_GET["SearchButton"])){
                        $Search = $_GET["Search"];
                        $sql = "SELECT * FROM posts 
                        WHERE datetime LIKE :search
                        OR title LIKE :search
                        OR category LIKE :search
                        OR post LIKE :search";

                        $stmt = $ConnectingDB->prepare($sql);
                        $stmt->bindValue(':search', '%'. $Search .'%');
                        $stmt->execute();
                    }
                    // Default Query
                    else {

                        $PostIdFromURL = $_GET['id'];
                        if(!isset($PostIdFromURL)) {
                            $_SESSION["ErrorMessage"] = "Bad Request!";
                            Redirect_to("Blog.php");
                        }
                
                        $sql = "SELECT * FROM posts WHERE id='$PostIdFromURL'";
                        $stmt = $ConnectingDB->query($sql);
                    }
                    while($DataRows = $stmt->fetch()){
                        $PostId = $DataRows['id'];
                        $DateTime = $DataRows['datetime'];
                        $PostTitle = $DataRows['title'];
                        $Category = $DataRows['category'];
                        $Admin = $DataRows['author'];
                        $Image = $DataRows['image'];
                        $PostText = $DataRows['post'];
                    ?>
                    <div class="card">
                        <img src="uploads/<?php echo htmlentities($Image); ?>" style="max-height:450px;" class="img-fluid card-img-top">
                        <div class="card-body">
                            <h4 class="card-title">
                                <?php echo htmlentities($PostTitle); ?>
                            </h4>
                            <small class="text-muted">Written By <?php echo htmlentities($Admin); ?> On <?php echo htmlentities($DateTime); ?></small>
                            <span style="float:right;" class="badge badge-dark text-light">Comments 20</span>
                            <hr>
                            <p class="card-text">
                                 <?php echo htmlentities($PostText); ?>
                            </p>
                            
                        </div>
                    </div>
                    <?php } ?>
                    <!-- Commenting Area -->

                    <!-- Fetching existing comments -->
                    <br><br>
                    <span class="FieldInfo">Comments</span>
                    
                    <?php
                        $sql = "SELECT * FROM comments WHERE post_id='$SearchQueryParameter' AND status='ON'";

                        $stmt = $ConnectingDB->query($sql);
                        while($DataRows = $stmt->fetch()){
                            $CommentDate = $DataRows["datetime"];
                            $CommenterName = $DataRows["name"];
                            $CommentContent = $DataRows["comment"];
                        
                    ?>
                    
                       <div class="media CommentBlock">
                           <img src="images/comment.png" alt="" class="img-fluid d-block align-self-start">
                           <div class="media-body ml-2">
                               <h6 class="media-heading"><?php echo $CommenterName; ?></h6>
                               <p class="small"><?php echo $CommentDate; ?></p>
                               <p><?php echo $CommentContent; ?></p>
                           </div>
                       </div>
                       <hr>
                    <?php } ?>
                    <!-- Fetching Existing Comments -->

                    <div>
                        <form class="" action="FullPost.php?id=<?php echo $SearchQueryParameter; ?>" method="post">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h5 class="FieldInfo">Share Your Thoughts about this Post</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="CommenterName" placeholder="Name">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="CommenterEmail" placeholder="Email">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <textarea name="CommenterThoughts" class="form-control" rows="6" cols=80></textarea>
                                    </div>

                                    <div class="">
                                        <button class="btn btn-primary" name="Submit" type="submit">Submit</button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Commenting area end -->
            </div>
            <!-- End Main Area -->

            <!-- Side Area -->
            <div class="col-sm-4" style="min-height:40px; background-color:#27aee1;">
                
            </div>
            <!-- End Side Area -->
        </div>
    </div>
    <!-- header ending -->


    <!-- footer -->
    <footer class="bg-light text-black">
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