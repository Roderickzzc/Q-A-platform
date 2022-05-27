<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: logpage.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
   
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to HiQuest.</h1>
    <!-- navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a href="#" class="navbar-brand">HiQuest</a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
            <div class="navbar-nav">
                <a href="main.php" class="nav-item nav-link active">Home</a>
                <a href="level.php" class="nav-item nav-link">Level</a>
            </div>
            <form class="d-flex" action='searchq.php' method="POST">
                <div class="input-group">              
                        <input type="text" name='searchwhat' class="required" placeholder="Search..">
                        <fieldset>
                        <div>
                        <input type="radio" name="searchtype" value="gs"
                        checked><label>General Search</label>
                        </div>
                        <div>
                        <input type="radio" name="searchtype" value="qs">
                        <label>Question Search</label>
                        </div>
                        <div>
                        <input type="radio" name="searchtype" value="as">
                        <label>Answer Search</label>
                        </div>
                        </fieldset>

                        <!--<button type="button" class="btn btn-secondary" name='submit-search'><i class="bi bi-search"></i></button>-->
                        <button type="submit" class="btn btn-secondary" name='submit-search'><i class="bi bi-search"></i></button>
                </div>
            </form>
            <div class="navbar-nav">
                <a href="ask.php" class="btn btn-success">Ask</a>
                <a href="reset_profile.php" class="btn btn-warning ml-3">Change profile</a>
                <a href="logout.php" class="btn btn-danger ml-3">Sign Out</a>
            </div>
        </div>
    </div>
</nav>
</body>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
            <div class="navbar-nav">
                    <?php include "connectdb.php"; $result = $mysqli->query("SELECT topic_name from topic left outer join topichierarchy on topic.tid=topichierarchy.tid
where fatherid is null"); ?>
                    <?php
                        while ($row = mysqli_fetch_array($result)) {
                    ?>
                    <a href="searchq.php?topic=<?php echo $row['topic_name']; ?>" class="nav-item nav-link active">
                    <?php echo $row['topic_name']; ?></a>
                    <?php
                        }
                    ?>     
            </div>
        </div>
    </div>
    </nav>
</body>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
            <div class="navbar-nav">
                <a href="userq.php" class="nav-item nav-link active">Questions</a>
                <a href="usera.php" class="nav-item nav-link active">Answers</a>   
            </div>
        </div>
    </div>
    </nav>
</body>

<?php
include "connectdb.php";
$userid=$_SESSION["userid"];
if ($stmt = $mysqli->prepare("SELECT title,body,post_time,sum(IFNULL(isNew,0)) FROM ask natural join question left join questionanswer on question.qid=questionanswer.qid left join answer on questionanswer.answerid=answer.answerid where userid=?
GROUP BY question.qid
Order by post_time desc LIMIT 5")) {
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
<body>
    <br>
</body>
<?php
if ($stmt = $mysqli->prepare("SELECT title,answertext,post_time,answer_time FROM giveanswer natural join answer join questionanswer on answer.answerid = questionanswer.answerid natural join question WHERE userid=? Order by answer_time desc LIMIT 5")) {
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
</html>