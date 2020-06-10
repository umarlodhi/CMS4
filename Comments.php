<?php require_once('includes/DB.php'); ?>
<?php require_once('includes/Functions.php'); ?>
<?php require_once('includes/Sessions.php'); ?>

<?php 
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
Confirm_Login(); ?>

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
    <title>Comments</title>
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
                <h1><i class="fas fa-comments"></i> Manage Comments</h1>
            </div>
        </div>
    </header>
    <!-- header ending -->

    <section class="container py-2 mb-4">
        <div class="row" style="min-height:30px">
            <div class="col-lg-12" style="min-height:400px">
            <?php 
                echo SuccessMessage();
                echo ErrorMessage();
            ?>
            <h2>UnApproved Comments</h2>
                <table class="table table-stripped table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>No. </th>
                            <th>Name</th>
                            <th>Date &amp; Time</th>
                            <th>Comment</th>
                            <th>Approve</th>
                            <th>Action</th>
                            <th>Details</th>
                        </tr>
                    </thead>

                <?php 
                    $sql = "SELECT * FROM comments WHERE status='OFF' ORDER BY id desc";
                    $Execute = $ConnectingDB->query($sql);
                    $SrNo = 0;
                    while ($DataRows = $Execute->fetch()){
                        $CommentId = $DataRows['id'];
                        $DateTimeOfComment = $DataRows['datetime'];
                        $CommenterName = $DataRows['name'];
                        $CommenterContent = $DataRows['comment'];
                        $CommenterPostId = $DataRows['post_id'];
                        $SrNo++;
                        if(strlen($CommenterName) > 10) { $CommenterName= substr($CommenterName,0,10).'...'; }
                        if(strlen($DateTimeOfComment) > 11) { $DateTimeOfComment= substr($DateTimeOfComment,0,11).'...'; }
                        if(strlen($CommenterContent) > 20) { $CommenterContent= substr($CommenterContent,0,20).'...'; }
                ?>
                <tbody>
                    <tr>
                        <td><?php echo htmlentities($SrNo); ?></td>
                        <td><?php echo htmlentities($CommenterName); ?></td>
                        <td><?php echo htmlentities($DateTimeOfComment); ?></td>
                        <td><?php echo htmlentities($CommenterContent); ?></td>
                        <td><a class="btn btn-success" href="ApproveComment.php?id=<?php echo $CommentId; ?>">Approve</a></td>
                        <td><a class="btn btn-danger" href="DeleteComment.php?id=<?php echo $CommentId; ?>">Delete</a></td>
                        <td><a class="btn btn-primary" href="FullPost.php?id=<?php echo $CommenterPostId; ?>">Live Preview</a></td>
                    </tr>
                </tbody>
                <?php } ?>
                </table>

                <h2>Approved Comments</h2>
                <table class="table table-stripped table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>No. </th>
                            <th>Name</th>
                            <th>Date &amp; Time</th>
                            <th>Comment</th>
                            <th>Revert</th>
                            <th>Action</th>
                            <th>Details</th>
                        </tr>
                    </thead>

                <?php 
                    $sql = "SELECT * FROM comments WHERE status='ON' ORDER BY id desc";
                    $Execute = $ConnectingDB->query($sql);
                    $SrNo = 0;
                    while ($DataRows = $Execute->fetch()){
                        $CommentId = $DataRows['id'];
                        $DateTimeOfComment = $DataRows['datetime'];
                        $CommenterName = $DataRows['name'];
                        $CommenterContent = $DataRows['comment'];
                        $CommenterPostId = $DataRows['post_id'];
                        $SrNo++;
                        if(strlen($CommenterName) > 10) { $CommenterName= substr($CommenterName,0,10).'...'; }
                        if(strlen($DateTimeOfComment) > 11) { $DateTimeOfComment= substr($DateTimeOfComment,0,11).'...'; }
                        if(strlen($CommenterContent) > 20) { $CommenterContent= substr($CommenterContent,0,20).'...'; }
                ?>
                <tbody>
                    <tr>
                        <td><?php echo htmlentities($SrNo); ?></td>
                        <td><?php echo htmlentities($CommenterName); ?></td>
                        <td><?php echo htmlentities($DateTimeOfComment); ?></td>
                        <td><?php echo htmlentities($CommenterContent); ?></td>
                        <td><a class="btn btn-warning" href="DisApproveComment.php?id=<?php echo $CommentId; ?>">DisApprove</a></td>
                        <td><a class="btn btn-danger" href="DeleteComment.php?id=<?php echo $CommentId; ?>">Delete</a></td>
                        <td><a class="btn btn-primary" href="FullPost.php?id=<?php echo $CommenterPostId; ?>">Live Preview</a></td>
                    </tr>
                </tbody>
                <?php } ?>
                </table>
            </div>
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