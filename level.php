<?php
    include "connectdb.php";
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: logpage.php");
        exit;
    }
    $this_user=$_SESSION["userid"];
    #echo "$this_user";
    $this_user=trim($this_user);
    if ($stmt = $mysqli->prepare("SELECT count(*) as likes
        From thumbsup join giveAnswer on GiveAnswer.answerid=Thumbsup.answerid
        where GiveAnswer.userid=?
        Group by GiveAnswer.userid")) {
        $stmt->bind_param("i", $this_user);
        $stmt->execute();
        $stmt->bind_result($num_likes);
        // Printing results in HTML
        if($stmt->fetch()){
            echo "You have $num_likes likes!";
            echo "  ";
            $total=$num_likes * 5;
            #echo "$total";
            if($total>=10 and $total<50){
                $classid=2;
                #echo "$classid";
            }
            else if($total>=50){
                $classid=3;
                #echo "$classid";
            }
        }
        if($classid==3){
            echo "  ";
            echo "Good Job! You are an expert!";
        }
        else if ($classid==2){
            echo "  ";
            echo "Great! You are an advanced user!";
        }
        else{
            echo "  ";
            echo "You are a beginning user! Answer more questions to level up!";
        }
        $stmt->close();
    }
    if ($stmt2 = $mysqli->prepare("UPDATE user SET classid=? where userid=?")) {
        $stmt2->bind_param("ii", $classid, $this_user);
        $stmt2->execute();
        }

?>