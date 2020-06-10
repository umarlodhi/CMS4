<?php require_once('includes/DB.php'); ?>

<?php 
function Redirect_to($NewLocation) {
    header("Location:". $NewLocation);
    exit;
}

function CheckUserNameExistsOrNot($userName){
    global $ConnectingDB;
    $sql = "SELECT username FROM admins WHERE username=:userName";
    $stmt = $ConnectingDB->prepare($sql);

    $stmt->bindValue(':userName', $userName);

    $stmt->execute();
    $Result = $stmt->rowcount();
    if($Result == 1) {
        return true;
    } else {
        return false;
    }
}

function Login_Attempt($UserName, $Password) {
    global $ConnectingDB;
    $sql = "SELECT * From Admins WHERE username=:userName AND password=:passWord LIMIT 1";
    $stmt = $ConnectingDB->prepare($sql);

    $stmt->bindValue(':userName', $UserName);        
    $stmt->bindValue(':passWord', $Password);
    $stmt->execute();

    $Result = $stmt->rowcount();
    if($Result == 1) {
        return $Found_Account = $stmt->fetch();
    } else {
        return null;
    }
}

function Confirm_Login() {
    if(isset($_SESSION["UserId"])) {
        return true;
    } else {
        $_SESSION["ErrorMessage"] = "Login Requried";
        Redirect_to("Login.php");
    }
}

function TotalPosts() {
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM posts";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalPosts = array_shift($TotalRows);
    echo $TotalPosts;
}

function TotalCategories() {
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM category";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalCategory = array_shift($TotalRows);
    echo $TotalCategory;
}

function TotalAdmins() {
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM admins";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalAdmins = array_shift($TotalRows);
    echo $TotalAdmins;
}
function TotalComments() {
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM comments";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalComments = array_shift($TotalRows);
    echo $TotalComments;
}

function ApproveCommentsToPost($PostId){
    global $ConnectingDB;
    $sqlApprove = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='ON'";
    $stmtApprove = $ConnectingDB->query($sqlApprove);
    $RowsTotal = $stmtApprove->fetch();
    $Total = array_shift($RowsTotal);
    return $Total;
}

function DisApproveCommentsToPost($PostId) {
    global $ConnectingDB;
    $sqlDisApprove = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='OFF'";
    $stmtDisApprove = $ConnectingDB->query($sqlDisApprove);
    $RowsTotal = $stmtDisApprove->fetch();
    $Total = array_shift($RowsTotal);
    return $Total;
}

?>