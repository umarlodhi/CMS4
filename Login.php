<?php require_once('includes/DB.php'); ?>
<?php require_once('includes/Functions.php'); ?>
<?php require_once('includes/Sessions.php'); ?>

<?php 
if(isset($_SESSION["UserId"])) {
    Redirect_to("Dashboard.php");
}
if(isset($_POST["Submit"])) {
    $UserName = $_POST["Username"];
    $Password = $_POST["Password"];

    if (empty($UserName) || empty($Password)) {
        $_SESSION["ErrorMessage"] = "All Fields must be Filled";
        Redirect_to("Login.php");
    } else {
        $Found_Account = Login_Attempt($UserName, $Password);
        if($Found_Account) {
            $_SESSION["UserId"] = $Found_Account["id"];
            $_SESSION["UserName"] = $Found_Account["username"];
            $_SESSION["AdminName"] = $Found_Account["aname"];
            
            $_SESSION['SuccessMessage'] = "Welcome ". $_SESSION["AdminName"];
            if(isset($_SESSION["TrackingURL"])){
                Redirect_to($_SESSION["TrackingURL"]);
            } else {
                Redirect_to("Dashboard.php");
            }
        } else {
            $_SESSION['ErrorMessage'] = "Incorrect Username/Password";
            Redirect_to("Login.php");
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
    <title>Login</title>
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

            </div>
        </div>
    </nav>
    <!-- navbar ending -->
    <div style="height: 10px; background-color: #27aae1;"></div>

    <!-- Main area -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="col-sm-6 offset-sm-3" style="height: 500px;">
            <br><br><br>
            <?php 
                echo SuccessMessage();
                echo ErrorMessage();
            ?>
            <div class="card">
                <div class="card-header bg-info text-light">
                    <h4>Welcome Back!</h4>
                </div>
                    <div class="card-body">
                        <form action="Login.php" method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-info"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="Username" id="username">
                                </div>
                                
                            </div>
                            <div class="form-group">
                                <label for="Password">Password</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-info"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" class="form-control" name="Password" id="password">
                                </div>
                                
                            </div>
                            <input type="submit" class="btn btn-info btn-block" name="Submit" value="Login">
                        </form>
                    </div>
                
            </div>
            </div>
        </div>

    </section>
    <!-- Main area ending -->

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