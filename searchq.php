<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<?php
	session_start();
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
		header("location: logpage.php");
		exit;
	}
	include "connectdb.php";
?>

<h1>Questions</h1>

<?php
    #session_start();
    #echo "Here";


	if(isset($_POST['submit-search'])){#&isset($_POST['searchtype']


		$search=mysqli_real_escape_string($link,htmlspecialchars($_POST['searchwhat']));
		$searchtype=mysqli_real_escape_string($link,$_POST['searchtype']);
        #mysqli_query($link,"ALTER table question add fulltext (title)") or die("Alter Error: ".mysql_error());
        #mysqli_query($link,"ALTER table question add fulltext (body)") or die("Alter Error: ".mysql_error());
        #mysqli_query($link,"ALTER table answer add fulltext (answertext)") or die("Alter Error: ".mysql_error());
		if($searchtype=='gs'){
			$sql="SELECT distinct title, body, post_time, (MATCH (title) Against ('+$search' IN BOOLEAN MODE)*2+ Match 
        (body) Against ('+$search' IN BOOLEAN MODE)*1+ Match 
        (answertext) Against ('+$search' IN BOOLEAN MODE)*1) as relevance
        FROM question left outer join QuestionAnswer on question.qid = questionanswer.qid left outer join answer on questionanswer.answerid = answer.answerid
        where
        Match (title) Against ('+$search' IN BOOLEAN MODE)
        OR Match (body) Against ('+$search' IN BOOLEAN MODE)
		OR Match (answertext) Against ('+$search' IN BOOLEAN MODE)
		Group by title, body, post_time
        order by relevance desc;";
		}else if($searchtype=='qs'){
			$sql="SELECT title, body, post_time, (MATCH (title) Against ('+$search' IN BOOLEAN MODE)*2+ Match 
			(body) Against ('+$search' IN BOOLEAN MODE)*1) as relevance
		FROM question left outer join QuestionAnswer on question.qid = questionanswer.qid left outer join answer on questionanswer.answerid = answer.answerid
        where
        Match (title) Against ('+$search' IN BOOLEAN MODE)
        OR Match (body) Against ('+$search' IN BOOLEAN MODE)
		Group by title, body, post_time
        order by relevance desc;";
		}else if($searchtype=='as'){
			$sql="SELECT distinct title, body, post_time, (Match 
			(answertext) Against ('+$search' IN BOOLEAN MODE)*1) as relevance
			FROM question left outer join QuestionAnswer on question.qid = questionanswer.qid left outer join answer on questionanswer.answerid = answer.answerid
        where
		Match (answertext) Against ('+$search' IN BOOLEAN MODE)
		Group by title, body, post_time
        order by relevance desc;";
		}
        
		#$sql="SELECT title,body FROM Question Where (title LIKE '%$search%')";
		$result=mysqli_query($link,$sql);
		$queryResult=mysqli_num_rows($result);

        echo "There are ".$queryResult." results!";
        #echo "$search";
		if($queryResult>0){
			while($row=mysqli_fetch_assoc($result)){
				echo "<a href='article.php?title=".$row['title']."&post_time=".$row['post_time']."'><div class='article-box'>
				<h3>".$row['title']."</h3></a>
                <p>".$row['post_time']."</p>
				<p>".$row['body']."</p>
                <p>".$row['relevance']."</p>
			</div>";
			}
		}
		else{
			echo "No results";
		}
	}
	elseif($_GET['topic']){
		$input = $_GET["topic"];
		$sql_subtopics = "SELECT distinct t2.topic_name from topic as t1 join topichierarchy on topichierarchy.fatherid = t1.tid join topic as t2 on topichierarchy.tid = t2.tid where t1.topic_name = ?";
		if($stmt=mysqli_prepare($link,$sql_subtopics)){
			mysqli_stmt_bind_param($stmt, "s", $input);
			$result = mysqli_stmt_execute($stmt);
			$stmt->bind_result($subtopic);
			while($stmt->fetch()){
				echo '<a class="btn btn-success" href="searchq.php?topic='.$subtopic.'">'.$subtopic.'</a>';
				echo "&nbsp;";
			}
		}

		$sql="SELECT distinct title, body, post_time
        FROM question natural join questiontopic natural join topic
        where
        topic_name = ?
        order by post_time desc;";
		if($stmt=mysqli_prepare($link,$sql)){
			mysqli_stmt_bind_param($stmt, "s", $input);
			$result = mysqli_stmt_execute($stmt);
			#$queryResult=mysqli_num_rows($result);
			$stmt->bind_result($title,$body,$post_time);
			$flag=0;
			if($stmt->fetch()){
				echo "<a href='article.php?title=".$title."&post_time=".$post_time."'><div class='article-box'>
				<h3>".$title."</h3></a>
                <p>".$body."</p>
				<p>".$post_time."</p>
			</div>";
				$flag=1;
			}else{
				echo "No result!";
			}

			while($stmt->fetch()&$flag==1){
				echo "<a href='article.php?title=".$title."&post_time=".$post_time."'><div class='article-box'>
				<h3>".$title."</h3></a>
                <p>".$body."</p>
				<p>".$post_time."</p>
			</div>";
			}
            $stmt->close();


		} 
	}
	else{
		echo "You have not submitted anything!";
	}
?>

</html>
