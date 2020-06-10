<?php require_once('includes/DB.php'); ?>
<?php require_once('includes/Functions.php'); ?>
<?php require_once('includes/Sessions.php'); ?>

<?php 
    if(isset($_GET["id"])){
        $SearchQueryParameter = $_GET["id"];
        $Admin = $_SESSION["AdminName"];
        $sql = "UPDATE comments SET status='OFF', approvedby='$Admin' WHERE id='$SearchQueryParameter'";
        $Execute = $ConnectingDB->query($sql);
        if($Execute){
            $_SESSION["SuccessMessage"] = "Comment DisApproved Successfully";
            Redirect_to("Comments.php");
        } else {
            $_SESSION["ErrorMessage"] = "Error DisApproving Comment";
            Redirect_to("Comments.php");
        }
    }

?>