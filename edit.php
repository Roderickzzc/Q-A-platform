<?php
    include "connectdb.php";
    session_start();
    $changed=$_SESSION['changedAid'];
    #echo "$changed";
    $new_edit = $new_edit_err="";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty($_POST["new_edit"])){
            $new_edit_err = "Please reanswer before submit or click cancel.";     
        } 
        else{
            $new_edit = $_POST["new_edit"];
            echo "$new_edit";
        }
        
        if(empty($new_edit_err)){
            $sql = "UPDATE answer SET answertext = ?, answer_time=CURRENT_TIMESTAMP(), isNew='1' WHERE answerid = ?";
            if($stmt = mysqli_prepare($link, $sql)){
                mysqli_stmt_bind_param($stmt, "si", htmlspecialchars($new_edit), $changed);
                $stmt->execute();
                $stmt->close();
            }
        }
        mysqli_close($link);
        header('location: article.php?title='.$_SESSION["title"].'&post_time='.$_SESSION["post_time"].'');
    }
 


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Answer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Edit Answer</h2>
        <p>Please reanswer the question.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group">
                <textarea type="text" name="new_edit" class="form-control <?php echo (!empty($new_edit_err)) ? 'is-invalid' : ''; ?>" rows="3" value="<?php echo $new_edit; ?>"></textarea>
                <span class="invalid-feedback"><?php echo $new_edit_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link ml-2" href="main.php">Cancel</a>
            </div>
        </form>
    </div>    
</body>