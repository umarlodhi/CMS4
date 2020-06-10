<?php require_once('includes/DB.php'); ?>
<?php require_once('includes/Functions.php'); ?>
<?php require_once('includes/Sessions.php'); ?>

<?php 
    $_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
    // echo $_SESSION["TrackingURL"];
    Confirm_Login();
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
    <title>Dashboard</title>
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
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><i class="fas fa-cog"></i> Dashboard</h1>
                </div>

                <div class="col-lg-3 mb-2">
                    <a href="AddNewPost.php" class="btn btn-primary btn-block">
                        <i class="fas fa-edit"></i> Add New Post
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Categories.php" class="btn btn-info btn-block">
                       <i class="fas fa-folder-plus"></i> Add New Category
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Admins.php" class="btn btn-warning btn-block">
                       <i class="fas fa-user-plus"></i> Add New Admin
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Comments.php" class="btn btn-success btn-block">
                       <i class="fas fa-check"></i> Approve Comments
                    </a>
                </div>
            </div>
        </div>
    </header>
    <!-- header ending -->
    <section class="container py-2 mb-4">
        <div class="row">
        <?php 
            echo ErrorMessage();
            echo SuccessMessage();  ?>

        <!-- Left Side Area -->
        <div class="col-lg-2">
            <div class="card text-center bg-dark text-light mb-3">
                <div class="card-body">
                    <h1 class="lead">Posts</h1>
                    <h4 class="display-5">
                        <i class="fab fa-readme"></i> 
                        <?php 
                            TotalPosts();
                        ?>
                    </h4>
                </div>

            </div>
            <div class="card text-center bg-dark text-light mb-3">
                <div class="card-body">
                    <h1 class="lead">Categories</h1>
                    <h4 class="display-5">
                        <i class="fas fa-folder"></i> 
                        <?php 
                            TotalCategories();
                        ?>
                    </h4>
                </div>

            </div>
            <div class="card text-center bg-dark text-light mb-3">
                <div class="card-body">
                    <h1 class="lead">Admins</h1>
                    <h4 class="display-5">
                        <i class="fas fa-users"></i> 
                        <?php 
                            TotalAdmins();
                        ?>
                    </h4>
                </div>

            </div>
            <div class="card text-center bg-dark text-light mb-3">
                <div class="card-body">
                    <h1 class="lead">Comments</h1>
                    <h4 class="display-5">
                        <i class="fas fa-comments"></i> 
                        <?php 
                            TotalComments();
                        ?>
                    </h4>
                </div>

            </div>
        </div>
        <!-- Left Side Area End -->

        <!-- Right Side Area -->
        <div class="col-lg-10">
            <h1>Top Posts</h1>
            <table class="table table-stripped table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>No.</th>
                        <th>Title</th>
                        <th>Date &amp; Time</th>
                        <th>Author</th>
                        <th>Comments</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <?php
                    $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5"; 
                    $stmt = $ConnectingDB->query($sql);
                    $SrNo = 0;
                    while($DataRows = $stmt->fetch()) {
                        $PostId = $DataRows["id"];
                        $DateTime = $DataRows["datetime"];
                        $Title = $DataRows["title"];
                        $Author = $DataRows["author"];
                        $SrNo++;
                    
                 ?>
                 <tbody>
                     <tr>
                         <td><?php echo $SrNo; ?></td>
                         <td><?php echo $Title; ?></td>
                         <td><?php echo $DateTime; ?></td>
                         <td><?php echo $Author; ?></td>
                         <td> 
                                <?php 
                                    $Total = ApproveCommentsToPost($PostId);
                                    
                                    if($Total > 0){ ?>
                                        <span class="badge badge-success">
                                            <?php echo $Total; ?>
                                        </span>
                                    <?php } ?>
                                    
                                    <?php 
                                        $Total = DisApproveCommentsToPost($PostId);
                                    
                                    if($Total > 0){ ?>
                                        <span class="badge badge-danger">
                                            <?php echo $Total; ?>
                                        </span>
                                    <?php } ?>
                             
                         </td>
                         <td><a target="_blank" href="FullPost.php?id=<?php echo $PostId; ?>">
                                 <span class="btn btn-info">Preview</span>
                             </a>
                        </td>
                     </tr>
                 </tbody>
                    <?php } ?>
            </table>

        </div>
        <!-- Right Side Area End -->

        </div>
    </section>

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