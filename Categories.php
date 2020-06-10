<?php require_once('includes/DB.php'); ?>
<?php require_once('includes/Functions.php'); ?>
<?php require_once('includes/Sessions.php'); ?>

<?php 
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
Confirm_Login(); ?>

<?php 
if(isset($_POST["Submit"])) {
    $Category = $_POST['CategoryTitle'];
    $Admin = $_SESSION["AdminName"];

    // Date and time
    date_default_timezone_set("Asia/Karachi");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

    // Check if CategoryTitle is empty or not
    if(empty($Category)) {
        $_SESSION["ErrorMessage"] = "All Fields must be Filled";
        Redirect_to("Categories.php");
    } elseif(strlen($Category) < 3 ) {
        $_SESSION["ErrorMessage"] = "Category Title Should be greater than 2 charactors";
        Redirect_to("Categories.php");
    } elseif(strlen($Category) > 49 ) {
        $_SESSION["ErrorMessage"] = "Category Title Should be less than 50 charactors";
        Redirect_to("Categories.php");
    } else { 
        
        // Add Query to enter Category into the database
        $sql = "INSERT INTO category(title, author, datetime)";
        $sql .= "VALUES(:categoryName, :adminName, :dateTime)";

        $stmt = $ConnectingDB->prepare($sql);

        $stmt->bindValue(':categoryName', $Category);
        $stmt->bindValue(':adminName', $Admin);
        $stmt->bindValue(':dateTime', $DateTime);

        $Execute = $stmt->execute();

        if($Execute) {
            $_SESSION["SuccessMessage"] = "Category Added Successfully";
            Redirect_to("Categories.php");
        } else {
            $_SESSION["ErrorMessage"] = "Error Storing Data. Something went Wrong.";
            Redirect_to("Categories.php");
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
    <title>Categories</title>
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
                <h1><i class="fas fa-edit"></i> Manage Categories</h1>
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
                <form class="" action="Categories.php" method="post">
                    <div class="card bg-secondary text-light">
                        <div class="card-header">
                            <h1>Add New Category</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"><span class="FieldInfo"> Category Title </span></label>
                                <input class="form-control" type="text" name="CategoryTitle" id="title" placeholder="Type Here Title"> 
                                
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
                <!--  -->
                <h2>Existing Categories</h2>
                <table class="table table-stripped table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>No. </th>
                            <th>Date &amp; Time</th>
                            <th>Category Name</th>
                            <th>Creator Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                <?php 
                    $sql = "SELECT * FROM category order by id desc";
                    $Execute = $ConnectingDB->query($sql);
                    $SrNo = 0;
                    while ($DataRows = $Execute->fetch()){
                        $CategoryId = $DataRows['id'];
                        $CategoryDate = $DataRows['datetime'];
                        $CategoryName = $DataRows['title'];
                        $CreatorName = $DataRows['author'];
                        $SrNo++;
                ?>
                <tbody>
                    <tr>
                        <td><?php echo htmlentities($SrNo); ?></td>
                        <td><?php echo htmlentities($CategoryDate); ?></td>
                        <td><?php echo htmlentities($CategoryName); ?></td>
                        <td><?php echo htmlentities($CreatorName); ?></td>
                        <td><a class="btn btn-danger" href="DeleteCategory.php?id=<?php echo $CategoryId; ?>">Delete</a></td>
                    </tr>
                </tbody>
                <?php } ?>
                </table>
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