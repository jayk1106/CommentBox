<?php

    $name = $_POST['name'];
    $email = $_POST['email'];
    $comment = $_POST['comment'];
    $pid =  $_POST['pid'];



    $conn = mysqli_connect("localhost","root","","cmbox1") or die("Connection Failed");
    $sql = "INSERT INTO comment (userName,userEmail,commentDes,perentId) VALUES ('{$name}','{$email}','{$comment}',{$pid})";
    $result = mysqli_query($conn,$sql) or die("Query Falied");
    $i="cmtStart";
    if(!$pid==0) $i=$pid;

    header("Location: http://comment.test/#$i");
    mysqli_close($conn);

?>