<?php require_once('includes/DB.php'); ?>
<?php require_once('includes/Functions.php'); ?>
<?php require_once('includes/Sessions.php'); ?>

<?php 
    if(isset($_GET["id"])){
        $SearchQueryParameter = $_GET["id"];
        // $Admin = $_SESSION["AdminName"];
        $sql = "DELETE FROM admins WHERE id='$SearchQueryParameter'";
        $Execute = $ConnectingDB->query($sql);
        if($Execute){
            $_SESSION["SuccessMessage"] = "Admin Deleted Successfully";
            Redirect_to("Admins.php");
        } else {
            $_SESSION["ErrorMessage"] = "Error deleting Admin";
            Redirect_to("Admins.php");
        }
    }

?>