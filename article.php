<?php
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: logpage.php");
        exit;
    }
    include "connectdb.php";
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<h1>Question Page</h1>

<?php 
    
    $new_answer="";
    $last_aid="";
    $new_answer_err="";
    
    $last_qid="";
    if(isset($_GET["title"])) {
        $title=$_GET["title"];
        #echo "$title";
    }
    else{
        echo "no";
    }
    
    #$title=mysqli_real_escape_string($link,$_GET['title']);
    #$title=trim($title);
    #echo "Here!";
    #echo "$title";
    #$date=mysqli_real_escape_string($link,$_GET['post_time']);
    #echo "$last_qid";
    #if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["submit_answer"]) == "POST"){

        if(empty($_POST["new_answer"])){
            $new_answer_err="Please enter your answer before submitting.";     
        } 
        else{
            $new_answer = $_POST["new_answer"];
            #echo "$new_answer";
        }
    
    }

    if(empty($new_answer_err)&&!empty($_POST["new_answer"])){
        if ($stmt = mysqli_prepare($link,"INSERT into answer(answertext,answer_time) values (?,CURRENT_TIMESTAMP)")){
            mysqli_stmt_bind_param($stmt, "s", $new_answer);
    
            $stmt->execute();
            $last_aid = mysqli_insert_id($link);
            #echo "Last insert answerid";
            #echo "$last_aid";
            $stmt->close();
        }
    
        if ($stmt2 = mysqli_prepare($link,"INSERT into giveanswer(userid,answerid) values (?,?)")){
            mysqli_stmt_bind_param($stmt2, "ii", $_SESSION["userid"], $last_aid);
            $stmt2->execute();
            $stmt2->close();
        }

        if ($stmt4 = mysqli_prepare($link,"SELECT qid from question where title=?")){
            #echo "Last qid";
            mysqli_stmt_bind_param($stmt4, "s", $_SESSION["title"]);
            #echo "$title";
            #echo "Last qid";
            $stmt4->execute();
            $stmt4->bind_result($last_qid);
            while ($stmt4->fetch()) {
                #echo "Last qid";
                #echo "$last_qid";
            }
            $stmt4->close();
        }

    
        if ($stmt3 = mysqli_prepare($link,"INSERT into questionanswer(qid,answerid) values (?,?)")){
            mysqli_stmt_bind_param($stmt3, "ii", $last_qid, $last_aid);
            $stmt3->execute();
            $stmt3->close();
        }
        #header('location: article.php?title='.$_SESSION["title"].'&post_time='.$_SESSION["post_time"].'');

    }
    
?>



<div class="article-container">
    <?php
        #session_start();
        include "connectdb.php";
        $firsttime=1;
        if($firsttime==1){
            $_SESSION["title"]=$_GET["title"];
            $title=$_SESSION["title"];
            #echo "first";
            #echo "$title";
            $_SESSION["post_time"]=$_GET["post_time"];
            $date=$_SESSION["post_time"];
            #echo "first";
            #echo "$date";
            $firsttime=0;
        }
       
        if(isset($_GET['title'])){
            $title=mysqli_real_escape_string($link,$_GET['title']);
            $date=mysqli_real_escape_string($link,$_GET['post_time']);
        }
        else{
            $_SESSION["title"]=$_GET["title"];
            $_SESSION["post_time"]=$_GET["post_time"];
            $title=trim($_SESSION["title"]);
            #echo "second";
            #echo "$title";
            #$date=trim($_SESSION["post_time"]);
        }
        if ($stmt14 = mysqli_prepare($link,"SELECT qid from question where title=? and post_time=?")){
            mysqli_stmt_bind_param($stmt14, "ss", $_SESSION["title"],$_SESSION["post_time"]);
            $stmt14->execute();
            $stmt14->bind_result($this_qid);
            while ($stmt14->fetch()) {
            }
            $stmt14->close();
            #echo "check qid";
            #echo "$this_qid";
            $_SESSION['qidd']=$this_qid;
        }

        if(isset($_GET["delete"])){
            $this_answer=$_GET["delete"];
            #echo "$this_answer";
            #echo "fetch";
            if ($stmt11 = mysqli_prepare($link,"DELETE FROM answer where answerid=?")){
                mysqli_stmt_bind_param($stmt11, "i",  $this_answer);
                $stmt11->execute();
                $stmt11->close();
            }
            if ($stmt12 = mysqli_prepare($link,"DELETE FROM giveanswer where userid=? and answerid=?")){
                mysqli_stmt_bind_param($stmt12, "ii",  $_SESSION['userid'], $this_answer);
                $stmt12->execute();
                $stmt12->close();
            }
            if ($stmt13 = mysqli_prepare($link,"DELETE FROM questionanswer where questionid=? and answerid=?")){
                mysqli_stmt_bind_param($stmt13, "ii",  $_SESSION['qidd'], $this_answer);
                $stmt13->execute();
                $stmt13->close();
            }
        }

        
        ?>
        
        <div class="p-3 mb-2 bg-info text-white">
                <?php 
                    if ($stmt5 = mysqli_prepare($link,"SELECT qid,userid from question natural join ask where title=?")){
                        mysqli_stmt_bind_param($stmt5, "s", $_SESSION["title"]);
                        $stmt5->execute();
                        $stmt5->bind_result($this_qid,$this_uid_ask);
                        while ($stmt5->fetch()) {
                        }
                        $stmt5->close();
                    }
                    ?>
    
                    <?php
                    if ($this_uid_ask==$_SESSION["userid"]){
                        ?>
                        <form action="" method="post">
                            <input type="submit" name="resolved_b" value="Set question as Resolved" a href="<?php $_SERVER['PHP_SELF']; ?>">
                        </form>
                        <?php
                            if(isset($_POST['resolved_b'])){
                                
                                if ($stmt6 = mysqli_prepare($link,"UPDATE question SET isResolved = '1' WHERE qid = ?")){
                                    
                                    mysqli_stmt_bind_param($stmt6, "i", $this_qid);

                                    $stmt6->execute();
                                    $stmt6->close();
                                    #$_SERVER['PHP_SELF'];
                            }
                        }
                        
                        #header('location: article.php?title='.$_SESSION["title"].'&post_time='.$_SESSION["post_time"].'');
                    }
                   

                    $sql="SELECT * 
                    From question
                    WHERE title='$title' AND post_time='$date'";
                    $result=mysqli_query($link,$sql);
                    $queryResults=mysqli_num_rows($result);
  
                    if($queryResults>0){
                        echo "<br>";
                        #echo"<b>is Resolved?</b>";
                        while($row=mysqli_fetch_assoc($result)){
                            if($row['isResolved']==1){
                                echo "<b>This question has been resolved.</b>";
                            }else{
                                echo "<b>This question has not been resolved.</b>";
                            }
                            echo"<div class='article-box'>
                            <h3>".$row['title']."</h3>
                            <p>".$row['post_time']."</p>
                            <p>".$row['body']."</p>
                            <br>
                    </div>";
                    }
                    }

                    if(isset($_GET["bestaid"])){
                        echo "<b>Following is the best answer:</b>";
                        if ($stmt10 = mysqli_prepare($link,"SELECT answertext,username,answer_time from answer natural join giveanswer natural join user where answerid=?")){
                            mysqli_stmt_bind_param($stmt10, "i", $_GET["bestaid"]);
                            $stmt10->bind_result($banswertext,$busername,$banswer_time);
                            $stmt10->execute();
                            while ($stmt10->fetch()) {
                                echo "<br>";
                                echo"$banswertext";
                                echo "<br>";
                                echo"$busername";
                                echo "<br>";
                                echo "$banswer_time";
                                echo "<br>";
                            }
                            $stmt10->close();
                         }


                    }
                        ?>
                    
                
                <!--<input type="submit" class="btn btn-primary" value="Set question as unresolved">-->        
        </div>

        <?php
        $sql="SELECT * 
        From question natural join questionanswer natural join answer natural join giveanswer natural join user
        WHERE title='$title' AND post_time='$date'
        order by answer_time desc";
        $result2=mysqli_query($link,$sql);
        $queryResults=mysqli_num_rows($result2);

        if($queryResults>0){
            while($row=mysqli_fetch_assoc($result2)){
                echo"<div class='posts-wrapper'>
                <p>".$row['answertext']."</p>
                <p>".$row['username']."</p>
                <p>".$row['answer_time']."</p>
                <i class='fa fa-thumbs-up' style='color: blue'></i>
            </div>";
            $this_answerid=$row['answerid'];
            $this_auser=$row['userid'];
            #echo "$this_auser";
            if($this_auser==$_SESSION['userid']){
                    $_SESSION['changedAid']=$this_answerid;
                    echo '<a class="btn btn-outline-success" name="edit_button" href="edit.php">Edit</a>';
                    echo '   ';
                    echo '<a class="btn btn-danger" name="delete_button" href="article.php?title='.$_SESSION["title"].'&post_time='.$_SESSION["post_time"].'&delete='.$row["answerid"].'">Delete</a>'; 
                    echo '   ';
                }
            
            if(isset($_GET["answerid"])){
                $this_answer=$_GET["answerid"];
                #echo "$this_answer";
                if ($stmt8 = mysqli_prepare($link,"INSERT INTO thumbsup (answerid, userid) VALUES (?, ?)")){
                    mysqli_stmt_bind_param($stmt8, "ii",  $this_answer, $_SESSION['userid']);
                     $stmt8->execute();
                    $stmt8->close();
                 }
                 #echo '<br>';
                 #echo '<br>';
                 #echo '<br>';
            }
            if(isset($_GET["bestaid"])){
                $best_aid=$_GET["bestaid"];
                #echo "$best_aid";
                #echo "following is qid";
                #echo "$this_qid";
                #echo "$this_answer";
                if ($stmt9 = mysqli_prepare($link,"UPDATE question SET bestanswerid=? where qid=?")){
                    mysqli_stmt_bind_param($stmt9, "ii",  $best_aid, $this_qid);
                    $stmt9->execute();
                    $stmt9->close();
                 }
                 #echo '<br>';
                 #echo '<br>';
                 #echo '<br>';
            }

            #echo"$this_answerid";
            echo '<a class="btn btn-success" name="like_button" href="article.php?title='.$_SESSION["title"].'&post_time='.$_SESSION["post_time"].'&answerid='.$row["answerid"].'">Like</a>';
            if($this_uid_ask==$_SESSION["userid"]){
                echo '   ';
                echo '<a class="btn btn-info" name="best_button" href="article.php?title='.$_SESSION["title"].'&post_time='.$_SESSION["post_time"].'&answerid='.$row["answerid"].'&bestaid='.$row["answerid"].'">isBest</a>';
            }
           
            #echo '.$row['answerid'].';
            if ($stmt7 = mysqli_prepare($link,"SELECT count(*) as total_like from thumbsup where answerid=?")){
                mysqli_stmt_bind_param($stmt7, "i", $row['answerid']);
                $stmt7->execute();
                $stmt7->bind_result($num_likes);
                while ($stmt7->fetch()) {
                    echo " $num_likes likes";
                    

                }
                $stmt7->close();
            }
            
            echo '<br>';
            echo '<br>';
            echo '<br>';
            echo '<br>';



           #if ($stmt8 = mysqli_prepare($link,"INSERT INTO thumbsup (answerid, userid) VALUES (?, ?)")){
               #mysqli_stmt_bind_param($stmt8, "ii",  $this_answerid, $_SESSION['userid']);
               #$stmt8->execute();
               #$stmt8->close();
            #}
            }
            if(isset($_GET["answerid"])){
                $this_answer=$_GET["answerid"];
                #echo "$this_answer";
                if ($stmt8 = mysqli_prepare($link,"INSERT INTO thumbsup (answerid, userid) VALUES (?, ?)")){
                    mysqli_stmt_bind_param($stmt8, "ii",  $this_answer, $_SESSION['userid']);
                    $stmt8->execute();
                    $stmt8->close();
                 }

            }

        }    
        
    ?>
   

    <?php
    $userid=$_SESSION["userid"];

    $sql="SELECT qid,userid
        From question natural join ask
        WHERE title='$title' AND post_time='$date'";

    if($stmt=$mysqli->prepare($sql)){
        $stmt->execute();
        $stmt->bind_result($qid,$WhoAsk);
        if($stmt->fetch()){
            if($WhoAsk==$userid){
                #echo "You asked this!";
                $sql2="UPDATE question natural join questionanswer natural join answer set isNew = 0 where question.qid=?";
                if($stmt2=mysqli_prepare($link,$sql2)){
                    mysqli_stmt_bind_param($stmt2, "i", $qid);
                    mysqli_stmt_execute($stmt2);
                    #echo "You viewed this!";
                }

            }

        }


    }

    ?>
</div>
<div class="wrapper">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <h3>Add an answer</h3>
            <div class="form-group">
                <!--<textarea type="text" name="new_answer" class="form-control" rows="5"></textarea>-->
                <textarea type="text" name="new_answer" class="form-control <?php echo (!empty($new_answer_err)) ? 'is-invalid' : ''; ?>" rows="5" value="<?php echo $new_answer; ?>"></textarea>
                <span class="invalid-feedback"><?php echo $new_answer_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="submit_answer" value="Submit">
                <a class="btn btn-link ml-2" href="main.php">Cancel</a>
            </div>
        </form>
</div>   
</body>
</html>