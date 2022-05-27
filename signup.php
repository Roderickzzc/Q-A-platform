<?php

include "connectdb.php";
 

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
$email=$email_err="";
$city=$city_err="";
$state=$state_err="";
$country=$country_err="";
$profile="";
$uprofile_err="";

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // check if a username is valid
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{

        $sql = "SELECT username FROM user WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){

            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            $param_username = trim($_POST["username"]);
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have at least 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password does not match.Please check again.";
        }
    }
    //validate emial
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";     
    } elseif(!preg_match('/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/', trim($_POST["email"]))){
        $email_err = "Email format is not correct.";
    } else{
        $email = trim($_POST["email"]);
    }

    if(empty(trim($_POST["city"]))){
        $city_err = "Please enter the city you live.";     
    } 
    else{
        $city = trim($_POST["city"]);
    }

    if(empty(trim($_POST["state"]))){
        $state_err = "Please enter the state you live. If your country does not have a state, enter your country name";     
    } 
    else{
        $state = trim($_POST["state"]);
    }

    if(empty(trim($_POST["country"]))){
        $country_err = "Please enter the country you live.";     
    } 
    else{
        $country = trim($_POST["state"]);
    }

    if(empty(trim($_POST["profile"]))){
        $uprofile_err = "Please use several sentences to introduce yourself.";     
    } 
    else{
        $profile = $_POST["profile"];
    }
    
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && 
    empty($email_err) && empty($city_err) && empty($state_err) && empty($country_err) && empty($uprofile_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO user (username, email,uprofile,passw,ucity,ustate,ucountry) VALUES (?, ?,?,?,?,?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $username, $email, $profile, $password, $city, $state, $country);
            
            
            #$param_username = $username;
            #$param_password = $password; 
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: logpage.php");
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <label>E-mail</label>
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <label>City</label>
                <input type="text" name="city" class="form-control <?php echo (!empty($city_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $city; ?>">
                <span class="invalid-feedback"><?php echo $city_err; ?></span>
            </div>
            <div class="form-group">
                
                <p style="font-style:italic">(If your country does not have a state, just enter country name.)</p>
                <label>State</label>
                <input type="text" name="state" class="form-control <?php echo (!empty($state_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $state; ?>">
                <span class="invalid-feedback"><?php echo $state_err; ?></span>
            </div>
            <div class="form-group">
                <label>Country</label>
                <input type="text" name="country" class="form-control <?php echo (!empty($country_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $country; ?>">
                <span class="invalid-feedback"><?php echo $country_err; ?></span>
            </div>
            <div class="form-group">
                <label>Profile</label>
                <textarea type="text" name="profile" class="form-control <?php echo (!empty($uprofile_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $profile; ?>"></textarea>
                <span class="invalid-feedback"><?php echo $uprofile_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="logpage.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>
