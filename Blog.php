<?php require_once('includes/DB.php'); ?>
<?php require_once('includes/Functions.php'); ?>
<?php require_once('includes/Sessions.php'); ?>

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
                    else {
                
                        $sql = "SELECT * FROM posts";
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
                                <?php if(strlen($PostText)>150){ 
                                    $PostText = substr($PostText, 0, 150).'...';
                                 } 
                                 echo htmlentities($PostText); ?>
                            </p>
                            <a href="FullPost.php?id=<?php echo $PostId; ?>" style="floar:right;">
                                <span class="btn btn-info">Read More...</span>
                            </a>
                        </div>
                    </div>
                    <?php } ?>
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