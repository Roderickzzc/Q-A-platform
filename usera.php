<?php

session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: logpage.php");
    exit;
}
 
include "connectdb.php";
 

$new_profile = $new_profile_err="";
 


$userid=$_SESSION["userid"];
if ($stmt = $mysqli->prepare("SELECT title,answertext,post_time,answer_time FROM giveanswer natural join answer join questionanswer on answer.answerid = questionanswer.answerid natural join question WHERE userid=? Order by answer_time desc")) {
    $stmt->bind_param("s", $userid);
    $stmt->execute();
    $stmt->bind_result($title,$body,$post_time,$answer_time);
    // Printing results in HTML
    
    $ansquestion=0;
    if($stmt->fetch()){
        echo "<table border = '1'>\n";
        echo "<td>Question</td><td>Answer</td><td>Answer Time</td>";
        echo "<tr>";
        echo "<td>$title</a></td><td><a href=\"article.php?title=$title&post_time=$post_time\">$body</td><td>$answer_time</td>";
        echo "</tr>\n";
        $ansquestion=1;
        #echo "<a href='article.php?title=".$row['title']."&post_time=".$row['post_time']."'><div class='article-box'>
    }else{
        echo "Want to share your knowledge? Answer a question!\n";
    }

    while ($stmt->fetch() && $ansquestion==1) {
        echo "<tr>";
        echo "<td>$title</a></td><td><a href=\"article.php?title=$title&post_time=$post_time\">$body</td><td>$answer_time</td>";
        echo "</tr>\n";
        
    }
    echo "</table>\n";
    $stmt->close();
$mysqli->close();
}
?>