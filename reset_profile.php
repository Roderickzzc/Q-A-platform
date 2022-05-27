<?php

session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: logpage.php");
    exit;
}
 
include "connectdb.php";
 

$new_profile = $new_profile_err="";
$new_email = $new_email_err="";
$new_city = $new_city_err="";
$new_country = $new_country_err="";


if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($_POST["new_profile"])){
        $new_profile_err = "Please enter the new profile.";     
    }
    if(empty($_POST["new_email"])){
        $new_email_err = "Please enter the new email.";     
    }  
    if(empty($_POST["new_city"])){
        $new_city_err = "Please enter the new city.";     
    }  
    if(empty($_POST["new_country"])){
        $new_country_err = "Please enter the new country";  
    } 

    if(empty($new_profile_err)&empty($new_email_err)&empty($new_city_err)&empty($new_country_err)){
        $new_profile = htmlspecialchars($_POST["new_profile"]);
        $new_email = htmlspecialchars($_POST["new_email"]);
        $new_city = htmlspecialchars($_POST["new_city"]);
        $new_country = htmlspecialchars($_POST["new_country"]);

    
        $sql = "UPDATE user SET uprofile = ?,email=?,ucity=?,ucountry=? WHERE userid = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ssssi", $new_profile,$new_email,$new_city,$new_country, $param_id);
            $param_id = $_SESSION["userid"];
            if(mysqli_stmt_execute($stmt)){
                #session_destroy();
                header("location: main.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }


    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Edit Profile</h2>
        <p>Please fill out this form to change your profile.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <h3>Email</h3>
            <div class="form-group">
                <textarea type="text" name="new_email" class="form-control <?php echo (!empty($new_email_err)) ? 'is-invalid' : ''; ?>" rows="1" value="<?php echo $new_email; ?>"></textarea>
                <span class="invalid-feedback"><?php echo $new_email_err; ?></span>
            </div>
            <h3>City</h3>
            <div class="form-group">
                <textarea type="text" name="new_city" class="form-control <?php echo (!empty($new_city_err)) ? 'is-invalid' : ''; ?>" rows="1" value="<?php echo $new_city; ?>"></textarea>
                <span class="invalid-feedback"><?php echo $new_city_err; ?></span>
            </div>
            <h3>Country</h3>
            <div class="form-group">
                <textarea type="text" name="new_country" class="form-control <?php echo (!empty($new_country_err)) ? 'is-invalid' : ''; ?>" rows="1" value="<?php echo $new_country; ?>"></textarea>
                <span class="invalid-feedback"><?php echo $new_country_err; ?></span>
            </div> 
            <h3>Profile</h3>
            <div class="form-group">
                <textarea type="text" name="new_profile" class="form-control <?php echo (!empty($new_profile_err)) ? 'is-invalid' : ''; ?>" rows="3" value="<?php echo $new_profile; ?>"></textarea>
                <span class="invalid-feedback"><?php echo $new_profile_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link ml-2" href="main.php">Cancel</a>
            </div>
        </form>
    </div>    
</body>
</html>