<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment Box</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
        }
        div.f{
            box-sizing: border-box;
            width: 60%;
            margin: auto;
            padding: 40px;
            border:2px solid rgba(83,83,83,.1);
        }
        .form input, .form textarea{
            width:100%;
            padding: 10px 0;
            font-size: 20px;
            margin-bottom: 30px;
            border: 2px solid rgba(83,83,83,.1);
            background: transparent;
            border-radius: 10px;
        }

        .form::placeholder{
            padding-top: 2%;
            padding-left: 5%;
        }
        input[type="submit"]{
            border: none;
            outline: none;
            background: #d4aa02;
            color:#fff;
            padding: 10px 20px;
        }
        .comment_item{
            font-size: 17px;
            margin-bottom: 50px;
            padding: 20px;
            border-bottom: 2px solid rgba(0,0,0,.3);
        }
        .card img{
            float: left;
            margin-right: 10px;
        }
        .card div{
            height:40px;
            float: left;
            display: flex;
            flex-direction: column;
        }
        .reply{
            padding-left: 5%;
        }
        .f button{
            background: none;
            border: none;
            outline: none;
            color: #d4aa02;
            cursor: pointer;
            margin: 10px 0;
        }

    </style>
</head>
<body>
    <div class="f">
    
                <h1>Add Comment</h1>
                <form action="saveComment.php" method="POST" class="fo">
                    <input type="hidden" value="0" name="pid"/>
                    <div class="form">
                        <input type="text" name="name" placeholder="Name*" required />

                    </div>
                    <div class="form">
                        <input type="email" name="email" placeholder="Email*" required />
                    </div>
                    <div class="form">
                        <textarea name="comment" rows="5" cols="20" placeholder="Comment*" required></textarea>

                    </div>
                    <div class="form"><input type="submit" name="submit" value="Submit Comment"></div>
                </form>


                 <!-- <div class='comment_item' id=".$row['commentId'].">
                                        <div class='card' style='height: 40px;'>
                                            <img src='/u_icon.png' alt='user icon'>
                                            <div><span><b>Jay</b></span><span style="color:#d4aa02">Sep 14th 2020 | 10:56</span></div>
                                        </div>
                                        <pre>I am back</pre>
                                        <button onclick="openForm('1')">Reply</button> <br> <br> 

                                        <div class="reply">
                                        <div class='card' style='height: 40px;'>
                                                  <img src='/u_icon.png' alt='user icon'>
                                                  <div><span><b>Admin</b></span><span>14-09-2020 10:56</span></div>
                                                </div>
                                                <pre>Ohhh Good</pre>
                                        </div>  
                 </div> -->
                <?php

                    $conn = mysqli_connect("localhost","root","","cmbox1") or die("Connection Failed");
                    $sql = "SELECT *FROM comment WHERE perentId=0 ORDER BY commentID DESC";
                    

                    $result = mysqli_query($conn,$sql) or die("Query Falied");
                    
                     echo "<h3 id='cmtStart'>".mysqli_num_rows($result)." Comments</h3><hr>";   
                    if(mysqli_num_rows($result)>0){
                        while($row=mysqli_fetch_assoc($result)){
                            $cmid = $row['commentId'];
                            $name = $row['userName'];
                            $cmt = $row['commentDes'];
                            $date = $row['dateTime'];
                            $pid = $row['perentId'];
                            
                            $arr = explode("\n",$cmt);
                            $para = "";
                            foreach($arr as $p){
                                $para.="<p>$p</p>";
                            }

                            if($pid==0){
                                echo "
                                    <div class='comment_item' id='$cmid'>
                                        <div class='card' style='height: 40px;'>
                                            <img src='/u_icon.png' alt='user icon'>
                                            <div><span><b>$name</b></span><span style='color:#d4aa02'>".date('F d, Y  h:i A', strtotime($date))."</span></div>
                                        </div>
                                        <div>$para</div>
                                        <button onclick='openForm(".$cmid.")'>Reply</button>  <br> <br>
                                ";
            
                                $sql2 = "SELECT *FROM comment WHERE perentId=$cmid";
                                $result2 = mysqli_query($conn,$sql2) or die("Query 2 Failed");

                                if(mysqli_num_rows($result2) > 0){
                                    while($r_row=mysqli_fetch_assoc($result2)){
                                        $r_cmid = $r_row['commentId'];
                                        $r_name = $r_row['userName'];
                                        $r_date = $r_row['dateTime'];
                                        $r_cmt = $r_row['commentDes'];
                                        $r_pid = $r_row['perentId'];
                                        
                                        $r_arr = explode("\n",$r_cmt);
                                        $r_para = "";
                                        foreach($r_arr as $r_p){
                                            $r_para.="<p>$r_p</p>";
                                        }
                                        if(true){
                                            
                                            echo "
                                            <div class='reply'>
                                                    <div class='card' style='height: 40px;'>
                                                      <img src='/u_icon.png' alt='user icon'>
                                                      <div><span><b>".$r_name."</b></span><span style='color:#d4aa02'>".$r_date."</span></div>
                                                    </div>
                                                    <div>$r_para</div>
                                                    
                                            </div>
                                            ";
                                        }

                                    }
                                }
                                echo "</div>";

                            }  
                             
                          
                        }
                    }
                    mysqli_close($conn);
                ?>
    
    
    
    </div>
    <script>
        var c = 1;
        function openForm(index){
        
        if(c>1) return;
        var mainDiv = document.createElement("div");
        mainDiv.id="rBox";

        var f = document.createElement("form");
        f.setAttribute('method',"post");
        f.setAttribute('action',"saveComment.php");


        var btn = document.createElement("button");
        btn.innerHTML= "Cancel Reply";
        btn.setAttribute('id','rb');
        btn.setAttribute('onclick',"closeForm()");

        var d1 = document.createElement("div");
        d1.setAttribute('class','form');    


        var i = document.createElement("input");
        i.required = "required";
        i.placeholder="Name*";
        i.type = "text";
        i.name = "name";
        d1.appendChild(i);    

        var i2 = document.createElement('input');
        i2.type="hidden";
        i2.value = index;
        i2.name="pid";


        var d4 = document.createElement("div");
        d4.setAttribute('class','form'); 

        var i3 = document.createElement("input");
        i3.required = "required";
        i3.placeholder="Email*";
        i3.type = "email";
        i3.name = "email";
        d4.appendChild(i3);
        



        var d2 = document.createElement("div");
        d2.setAttribute('class','form');     

        var t = document.createElement("textarea");
        t.required = "required";
        t.placeholder="Comment*";
        t.rows='5';
        t.cols='20';
        t.name = "comment";
        d2.appendChild(t);


        var d3 = document.createElement("div");
        d3.setAttribute('class','form');

        var su = document.createElement('input');  
        su.type = 'submit';
        su.value = 'Submit';  
        d3.appendChild(su);    



        f.appendChild(i2);
        f.appendChild(d1);
        f.appendChild(d4);
        f.appendChild(d2);
        f.appendChild(d3); 
           

        var d = document.getElementById(index);
        mainDiv.appendChild(btn);
        mainDiv.appendChild(f);

        d.appendChild(mainDiv);
        c++;
        }


        function closeForm(){
            var d = document.getElementById('rBox');
            d.remove();
            c--;
        }
    
    </script>
</body>
</html>
