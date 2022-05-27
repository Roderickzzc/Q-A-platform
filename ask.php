<?php

session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: logpage.php");
    exit;
}
 
include "connectdb.php";
 

$new_question = $new_question_err = "";
$new_question_des = $new_question_des_err = "";
$new_topic = $new_topic_err = "";
$last_qid="";
$param_id = $_SESSION["userid"];
$result = $mysqli->query("SELECT topic_name from topic");




if($_SERVER["REQUEST_METHOD"] == "POST"){
 

    if(empty($_POST["new_question"])){
        $new_question_err = "Please enter the question title.";     
    } 
    else{
        $new_question = $_POST["new_question"];
    }

    if(empty($_POST["new_question_des"])){
        $new_question_des_err = "Please enter the question description.";     
    } 
    else{
        $new_question_des = $_POST["new_question_des"];
    }
    
    if(empty($_POST["new_topic"])){
        $new_topic_err="Please select a topic";
        #echo "Please select a topic!";
        #echo "Here!";
    }
    else{
        $new_topic = $_POST['new_topic'];
    }
 

    if(empty($new_question_err)&empty($new_question_des_err)&empty($new_topic_err)){

        $sql = "INSERT into question(title,body,post_time,isResolved,bestanswerid) values (?,?,CURRENT_TIMESTAMP,0,null)";
        
        if($stmt = mysqli_prepare($link, $sql)){

            $param_id = $_SESSION["userid"];
            mysqli_stmt_bind_param($stmt, "ss", htmlspecialchars($new_question), htmlspecialchars($new_question_des));

            if(!mysqli_stmt_execute($stmt)){
                echo "Oops! Something went wrong. Please try again later.";
            }
            $last_qid = mysqli_insert_id($link);
            // Close statement
            mysqli_stmt_close($stmt);
        }

        $sql2 = "INSERT into ask(qid,userid) values (?,?)";
        if($stmt = mysqli_prepare($link, $sql2)){

            mysqli_stmt_bind_param($stmt, "ii", $last_qid,$param_id);

            if(mysqli_stmt_execute($stmt)){
                #session_destroy();
                #header("location: main.php");

            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }

        if ($stmt = mysqli_prepare($link,"SELECT tid from topic where topic_name=?")){
            #iconv(mb_detect_encoding($new_topic, mb_detect_order(), true), "ASCII", $new_topic);
            $new_topic= trim($new_topic);
            mysqli_stmt_bind_param($stmt, "s", $new_topic);

            $stmt->execute();
            $stmt->bind_result($topicid);
            $stmt->fetch();
            
        }

        if($stmt = $mysqli->prepare("INSERT INTO QuestionTopic(qid,tid) values (?,?)")){
            mysqli_stmt_bind_param($stmt, "ii", $last_qid,$topicid);
            $stmt->execute();
        }

        $sql3 = "WITH recursive cte (tid,fatherid) as (SELECT tid,fatherid from topic natural join topichierarchy where topic.tid=? union all select p.tid, p.fatherid from topichierarchy p inner join cte on p.tid=cte.fatherid)select * from cte";
        if($stmt = mysqli_prepare($link,$sql3)){
            mysqli_stmt_bind_param($stmt, "i", $topicid);
            $stmt->execute();
            $stmt->bind_result($tid,$fid);
            while ($stmt->fetch()) {
                if($stmt2 = $mysqli->prepare("INSERT INTO QuestionTopic(qid,tid) values (?,?)")){
                    mysqli_stmt_bind_param($stmt2, "ii", $last_qid,$fid);
                    $stmt2->execute();
                }
            }
            echo "</table>\n";
            $stmt->close();
            header("location: main.php");
        }



    }
    
    // Close connection
    mysqli_close($link);
    #header("location: main.php");
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
        <h2>Question</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <p>Question title</p>
            <div class="form-group">
                <textarea type="text" name="new_question" class="form-control <?php echo (!empty($new_question_err)) ? 'is-invalid' : ''; ?>" rows="1" value="<?php echo $new_question; ?>"></textarea>
                <span class="invalid-feedback"><?php echo $new_question_err; ?></span>
            </div>
            <p>Question Description</p>
            <div class="form-group">
                <textarea type="text" name="new_question_des" class="form-control <?php echo (!empty($new_question_des_err)) ? 'is-invalid' : ''; ?>" rows="5" value="<?php echo $new_question_des; ?>"></textarea>
                <span class="invalid-feedback"><?php echo $new_question_des_err; ?></span>
            </div>
            <p>Topic</p>
            <div class="form-group">
                <select name="new_topic" class="form-control <?php echo (!empty($new_topic_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_topic; ?>">
                    <option value="">Select Topic</option>
                    <?php $result = $mysqli->query("SELECT topic_name from topic"); ?>
                    <?php
                        while ($row = mysqli_fetch_array($result)) {
                    ?>
                    <option value=" <?php echo $row['topic_name']; ?> ">
                    <?php echo $row['topic_name']; ?>
                    </option>
                    <?php
                        }
                    ?>        
                </select>
                <span class="invalid-feedback"><?php echo $new_topic_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link ml-2" href="main.php">Cancel</a>
            </div>
        </form>
    </div>    







</body>
</html>