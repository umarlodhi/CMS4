<?php require_once('includes/DB.php'); ?>
<?php require_once('includes/Functions.php'); ?>
<?php require_once('includes/Sessions.php'); ?>

<?php Confirm_Login(); ?>

<?php 
$SearchQueryParameter = $_GET['id'];

$sql = "SELECT * FROM posts WHERE id='$SearchQueryParameter'";
$stmtPost = $ConnectingDB->query($sql);

while($DataRows = $stmtPost->fetch()){
    $TitleToBeDeleted = $DataRows["title"];
    $CategoryToBeDeleted = $DataRows["category"];
    $ImageToBeDeleted = $DataRows["image"];
    $PostToBeDeleted = $DataRows["post"];
}
echo $ImageToBeDeleted;

if(isset($_POST["Submit"])) {
    $sql = "DELETE FROM posts WHERE id='$SearchQueryParameter'";

    $Execute = $ConnectingDB->query($sql);

        if($Execute) {
            $Target_Path_To_Deleted_Image = "uploads/$ImageToBeDeleted";
            unlink($Target_Path_To_Deleted_Image);
            $_SESSION["SuccessMessage"] = "Post Deleted Successfully";
            Redirect_to("Posts.php");
        } else {
            
            $_SESSION["ErrorMessage"] = "Error Deleting Post Data. Something went Wrong.";
            Redirect_to("Posts.php");
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
    <title>Delete Post</title>
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
                <h1><i class="fas fa-edit"></i> Delete Post</h1>
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
                <form class="" action="DeletePost.php?id=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light">
                        
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"><span class="FieldInfo"> Post Title </span></label>
                                <input disabled class="form-control" type="text" name="PostTitle" value="<?php echo $TitleToBeDeleted; ?>" id="title" placeholder="Type Here Title"> 
                                
                            </div>
                            <div class="form-group">
                                <span class="FieldInfo">Existing Category</span>
                                <?php echo $CategoryToBeDeleted; ?>
                                
                            </div>
                            <div class="form-group">
                            <span class="FieldInfo">Existing Image</span>
                                <img class="mb-2" src="uploads/<?php echo $ImageToBeDeleted; ?>" width="100px" height="70px"> 
                                
                            </div>
                            <div class="form-group">
                                <label for="Post"> <span class="FieldInfo"> Post </span></label>
                                <textarea disabled class="form-control" name="PostDescription" id="Post" cols="80" rows="8"><?php echo $PostToBeDeleted; ?>
                                </textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                                
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="Submit" name="Submit" class="btn btn-danger btn-block">
                                    <i class="fas fa-trash"></i> Delete
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