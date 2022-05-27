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
if ($stmt = $mysqli->prepare("SELECT title,body,post_time,sum(IFNULL(isNew,0)) FROM ask natural join question left join questionanswer on question.qid=questionanswer.qid left join answer on questionanswer.answerid=answer.answerid where userid=?
GROUP BY question.qid
Order by post_time desc")) {
    $stmt->bind_param("s", $userid);
    $stmt->execute();
    $stmt->bind_result($title, $body,$post_time,$new);
    // Printing results in HTML
    
    $askquestion=0;
    if($stmt->fetch()){
        echo "<table border = '1'>\n";
        echo "<td>Question</td><td>Description</td><td>Post Time</td><td>New Answers</td>";
        echo "<tr>";
        echo "<td><a href=\"article.php?title=$title&post_time=$post_time\">$title</a></td><td>$body</td><td>$post_time</td><td>$new</td>";
        echo "</tr>\n";
        $askquestion=1;
        #echo "<a href='article.php?title=".$row['title']."&post_time=".$row['post_time']."'><div class='article-box'>
    }else{
        echo "Want to ask a question?\n";
    }

    while ($stmt->fetch() && $askquestion==1) {
        echo "<tr>";
        echo "<td><a href=\"article.php?title=$title&post_time=$post_time\">$title</a></td><td>$body</td><td>$post_time</td><td>$new</td>";
        echo "</tr>\n";
        
    }
    echo "</table>\n";
    $stmt->close();
}
?>