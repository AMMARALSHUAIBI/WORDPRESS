
<?php
include("file/dialog.php");
include("include/config.php");
include("include/function.php");
if($c=$_COOKIE['ul']==1){
header('Location:home.php');

}
//get user sing up data

if(isset($_POST['singup'])){
    $ufname=$_POST['ufname'];
$usname=$_POST['usname'];
$upass=$_POST['upass'];
$urpass=$_POST['urpass'];
$uemail=$_POST['uemail'];
$ubday=$_POST['ubday'];
$usex=$_POST['usex'];
$ucat=$_POST['ucat'];
    if($ufname==null){

   
        $mess="الاسم الاول  فارغ";

error($mess);
        $err=1;
    
    }  if($usname==null){
        $mess="الاسم الثاني فارغ";
error($mess);
                $err=1;

    
    }if($upass==null){
        $mess="الرقم السري فارغ";
error($mess);
                $err=1;

    
    }if($urpass==null){
        $mess="الرقم السري التأكيدي فارغ";
error($mess);
                $err=1;

    
    }
    if($upass != $urpass){
     $mess= "الرقم السري غير متطابق";
error($mess);
                $err=1;
    }
    
    if($uemail==null){
        $mess="البريد الالكتروني  فارغ";
error($mess);
                $err=1;

    
    }if($uemail !==null){
    $valdemail=mysql_query("select * from users where uemail='$uemail'");
        $numq=mysql_num_rows($valdemail);
        if($numq > 1){
           $mess="البريد الالكتروني مستخدم ";
error($mess);
        $err=1;
        }
        
    }
    if($ubday==null){
        $mess="ادخل عمرك";
error($mess);
                $err=1;

    
    }
    if($usex=="الجنس"){
        $mess="ادخل جنسك";
error($mess);
                $err=1;

    
    }
    if($ucat==null){
        $mess="ادخل تخصصك";
error($mess);
                $err=1;

    
    }
    if($err==1){

} else{
        $upass=md5($upass);
$addpost=mysql_query("insert into users 
(ufname,usname,upass,uemail,ubday,usex,ucat) 
values
('$ufname','$usname','$upass','$uemail','$ubday','$usex','$ucat') "); 
        if($addpost){
         setcookie("ul",1,time() +36000,null,null,null,ture);
         setcookie("ueamil",$uemail,time() +36000,null,null,null,ture);
     header('Location:home.php');

        }else{
           $mess="البريد مستخدم  ";
error($mess);
        }
}
}


?>

<?php
//singin
if(isset($_POST['singin'])){
    $email=$_POST['email'];
    $pass=md5($_POST['pass']);
    $sql=mysql_query("SELECT * 
FROM  `users` 
WHERE uemail =  '$email'
AND upass =  '$pass'")or die(mysql_error());
    $sql=mysql_num_rows($sql);
    if($sql==1){
    
     setcookie("ul",1,time() +36000,null,null,null,ture);
        $email=base64_encode($email);
         setcookie("ueamil",$email,time() +36000,null,null,null,ture);
        header('Location:home.php');

    }else{
    $mess="تأكد من البريد و الرقم السري";
    error($mess);
    }
    
    

}

?>
<!doctype html>
<html lang="ar">
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

  <title>ملتقى المطورين</title>
  <link rel="shortcut icon" href="">
  <link rel="icon" href="img/logo.png">
  <link rel="stylesheet" type="text/css" media="all" href="stylef.css">
<script src="js/jquery-1.11.0.min.js"></script>
  <!-- jQuery plugin leanModal under MIT License http://leanmodal.finelysliced.com.au/ -->
 <link href="css/bootstrap.min.css" rel="stylesheet">
 <link href="css/bootstrap-rlt.min.css" rel="stylesheet">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
</head>
     <script type="text/javascript">
$(document).ready(function()
{

var start=/@/ig;
var word=/@(\w+)/ig;

$("#contentbox").live("keyup",function() 
{
var content=$(this).text();
var go= content.match(start);
var name= content.match(word);
var dataString = 'searchword='+ name;
if(go.length>0)
{
$("#msgbox").slideDown('show');
$("#display").slideUp('show');
$("#msgbox").html("اسم الشخص الذي ترغب بالبحث عنه...");
           if(content.length<3){
    $("#msgbox").hide();
$("#display").hide();
$("#msgbox").hide();
$(".ilogin").show();}
else if(name.length>0)
{
$.ajax({
type: "POST",
url: "boxsearch.php",
data: dataString,
cache: false,
success: function(html)
{
$("#msgbox").hide();
$(".ilogin").hide();
$("#display").html(html).show();
}
});

}

        


}
return false();
});

$(".addname").live("click",function() 
{
var username=$(this).attr('title');
var old=$("#contentbox").html();
var content=old.replace(word,""); 
$("#contentbox").html(content);
var E="<a class='red' contenteditable='false' href='#' >"+username+"</a>";
$("#contentbox").append(E);
$("#display").hide();
$("#msgbox").hide();
$("#contentbox").focus();
});

});
</script>
<style>
body
{
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
}
#contentbox
{
    width: 20%;
    height: 50px;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 14px;
    text-align: left;
    float: left;
    background: rgba(255, 255, 255, 0.39);
    margin-top: 1px;
    margin-left: 1.1%;
    direction: ltr;
    overflow: hidden;
}
.img
{
float:left; width:150px; margin-right:10px;
text-align:center;
}
#msgbox
{
border:solid 1px #dedede;padding:5px;
display:none;background-color:#f2f2f2
}
.red
{
color:#cc0000;
font-weight:bold;
}
 a
{
text-decoration:none;
}
a:hover
{
text-decoration:none;
}
#display
{
      display: none;
    border-left: solid 1px #dedede;
    border-right: solid 1px #dedede;
    border-bottom: solid 1px #dedede;
    overflow: hidden;
    float: left;
    height: 388px;
    clear: left;
    position: relative;
    width: 27%;
    background: rgba(154, 147, 131, 0.39);
}
.display_box
{
    padding: 4px;
    border-top: solid 1px #dedede;
    font-size: 12px;
    height: 30px;
    width: 100%;
    float: left;
}

.display_box:hover
{

}
.display_box a
{
color:#333;
}
.display_box a:hover
{
color:#fff;
}
#container
{
}
.image
{
    width: 22%;
    float: left;
    margin-right: 6px;
    height: 52px;}

</style>

<body id="bodys">
<div class="ihead">
    <div id="ilogo">
    <img src="img/logo.png" width="40" height="40">
أسأل مطور    </div>
<div id="xxx"></div>
<div id="container">
<div id="contentbox" contenteditable="true"> 
</div>
<div id='display'>
</div>
<div id="msgbox">
</div>
</div>
    
    
    
</div>
    <div class="ilogin">
    <form class="ilogoinf" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

        <h3 style="font-size: 117%; margin-right: 4%; border-right: 8px solid black; padding-right: 1%; height: 24px;">تسجيل الدخول</h3>
        <input type="eamil" name="email" placeholder="اسم المستخدم" class="linp">    
      <input type="password" name="pass" placeholder="الرقم السري" class="linp" style=" background: rgb(255, 255, 255) url('img/ps.png')left no-repeat;">   
        <button style="background:rgba(73, 198, 128, 1); border: 1px none; padding: 5px;  color: rgb(255, 255, 255); margin-right: 3%; margin-top: 7px;"  name="singin">تسجيل الدخول</button>
</form>
        <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <h3 style="font-size: 117%; margin-right: 4%; border-right: 8px solid black; padding-right: 1%; height: 24px; background:#fff;">تسجيل مستخدم جديد</h3>
   <input type="text" placeholder="الاسم الاول" class="linp" name="ufname" style="width:42%;  background:#fff;">   
            
      <input type="text" placeholder="الاسم الثاني" class="linp" name="usname" style="  background:#fff;width:42%;" >    
            <input type="password" placeholder="الرقم السري " name="upass" class="linp" style="width:42%;  background:#fff;">   
            
      <input type="password" placeholder=" تأكيد الرقم السري" name="urpass" class="linp" style="  background:#fff;width:42%;" >  
              
      
              
            
          <input type="email" placeholder="البريد الالكتروني " name="uemail" class="linp" style="  background:#fff;">  
              
            
          <input type="date" placeholder="تاريخ الميلاد" class="linp" name="ubday" style="  background:#fff;">  
            <select class="linp" style="background:#fff;"  name="usex">
            <option>الجنس</option>
            <option value="1">ذكر</option>
            <option value="2">انثى</option>
            </select>
                        <select class="linp" style="background:#fff;"  name="ucat">
            <option>التخصص</option>
            <option>تكنلوجيا انترنت</option>
            <option>هندسة برمجيات</option>
            <option> علم حاسوب</option>
            <option>نظم معلومات حاسوبة </option>
            </select>
               
            
        
         <button style="background:rgba(73, 198, 128, 1); border: 1px none; padding: 5px;  color: rgb(255, 255, 255); margin-right: 3%; margin-top: 7px; float:right;" name="singup">تسجيل </button>
        </form>
    <div style="
    float: left;
    margin-left: 31%;
">
        او باستخدام <img src="img/f.png" width="40" height="40"  style="margin-top: 5px;">
        </div>
    
    
    </div>
    
<div class="indexright">
    <div id="slider">
<ul>
	
<li>
	<div class="slider-container">
    <h4>   تواصل مع اصدقائك</h4>
		<p><img src="img/m.png"  width="90" height="90"><br>
      يمكنك التواصل مع الاصدقاء بكل خصوصية 
        </p>
	</div>
	</li><li>
	<div class="slider-container">
    <h4>   تواصل مع اصدقائك</h4>
		<p><img src="img/m.png"  width="90" height="90"><br>
      يمكنك التواصل مع الاصدقاء بكل خصوصية 
        </p>
	</div>
	</li><li>
	<div class="slider-container">
    <h4>   تواصل مع اصدقائك</h4>
		<p><img src="img/m.png"  width="90" height="90"><br>
      يمكنك التواصل مع الاصدقاء بكل خصوصية 
        </p>
	</div>
	</li><li>
	<div class="slider-container">
    <h4>   تواصل مع اصدقائك</h4>
		<p><img src="img/m.png"  width="90" height="90"><br>
      يمكنك التواصل مع الاصدقاء بكل خصوصية 
        </p>
	</div>
	</li><li>
	<div class="slider-container">
    <h4>   تواصل مع اصدقائك</h4>
		<p><img src="img/m.png"  width="90" height="90"><br>
      يمكنك التواصل مع الاصدقاء بكل خصوصية 
        </p>
	</div>
	</li>
	
</ul>
</div>    
    
</div>
    <script>
$(function(){

$("#error").fadeIn(2000).delay(4000).fadeOut(5000);

});

</script>    <script>
$(function(){

$("#ture").fadeIn(2000).delay(4000).fadeOut(5000);

});

</script>
</body>
</html>
