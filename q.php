<?php
if($c=$_COOKIE['ul']==0){
/* This will give an error. Note the output
 * above, which is before the header() call */
  
header('Location:index.php');

}
include("file/head.php");

?>
      <div class="cont-home">
    <div class="h-p">
        <h4>
اكتب ما في بالك
        </h4>
  <form action="home.php"  method="post" enctype="multipart/form-data">
              <textarea id="p-t" name="cont">
        
        
        </textarea>
      <button style="
    background: #fff url(img/camera.png) center no-repeat;
    border: 0px;
    margin-top: 1%;
    float: right;
">
            <input type="file" name="postimg" title=" " style="
    top: 0;
    left: 0;
    width: 75px;
    height: 35px;
    opacity: 0;
">

      </button>
        <input type="submit" name="insert" class="flatbtn" value="أنشر" style="font-size:12px; float:left; margin-left:30px;" >
      
        </form>
        
     
        
<?php

//add post 
if(isset($_POST['insert'])){
$cont=$_POST['cont'];
    $cont=mysql_real_escape_string($cont);
    if(is_uploaded_file($_FILES['postimg']['tmp_name']) || $_FILES['postimg']['error'] !== UPLOAD_ERR_OK)
{

    
    // Create image from file
switch(strtolower($_FILES['postimg']['type']))
{
    case 'image/jpeg':
            $pic = addslashes(file_get_contents($_FILES['postimg']['tmp_name']));
        break;
    case 'image/png':
            $pic = addslashes(file_get_contents($_FILES['postimg']['tmp_name']));
        break;
    case 'image/gif':
            $pic = addslashes(file_get_contents($_FILES['postimg']['tmp_name']));
        break;
    default:
          $pic="";
}}
    $time=date('H:i:s', time());
    $date=date('Y-m-d');
    $cl=strlen($cont);

    if($cl >40){
    
    $insertpost=mysql_query("insert into post (`postcont`,`userpost`,`postimg`,`posttime`,`postdate`) values ('$cont','$uid','{$pic}','$time','$date')")or die(mysql_error());
    echo'<script>swal("تم النشر !", "اضغط ok ", "success");</script>';
    }else{
echo'<script>swal({   title: "خطأ!",   text: "المنشور فارغ!",   type: "error",   confirmButtonText: "Cool" });
undefined</script>';    
    }
}

?>
        
          </div>
       <?php
$nump=$_GET['nump'];
if($nump <10){
$nump=20;
}else{
$nump=$nump+10;
}
$selectpost=mysql_query("SELECT * 
FROM  `question` 
ORDER BY qid desc 
LIMIT 0 , $nump ");
while($fp=mysql_fetch_object($selectpost)){
    $upid=$fp->uqid;
    $selectfollow=mysql_query("SELECT * 
FROM  `follow` 
WHERE  `u-f-id` =$uid
AND  `u-f-id-w` =$upid")or die(mysql_error());
    $selectfollown=mysql_num_rows($selectfollow);
    if($selectfollown >=1 || $upid == $uid){
$suser=mysql_query("select * from users where uid=$upid")or die(mysql_error());
    $suserf=mysql_fetch_assoc($suser);
     $fname=$suserf['ufname'];
     $proid=$suserf['uid'];
     $sname=$suserf['usname'];
     $uppic=$suserf['upic'];
 $postcont=htmlspecialchars($fp->qcont);
        $codep=strpos($postcont,"$");
        $contlength=strlen($postcont);
        $code=$postcont;
        $postcont=substr($postcont,0,$codep);
        $code=substr($code,$codep,$contlength);
$postcont = preg_replace('/(\#)([^\s]+)/', ' <a href="tag/$2">#$2</a> ', $postcont);
$postcont = preg_replace('/حمار/', '*****', $postcont);
$postcont = preg_replace('/بسم الله الرحمن الرحيم /', 'بِسْمِ اللَّـهِ الرَّحْمَـٰنِ الرَّحِيمِ', $postcont);
$postcont = preg_replace('/:O/', '<img src="img/omg.png" width="20px" hegiht="20px" />', $postcont);
$postcont = preg_replace('/:P/', '<img src="img/p.png" width="20px" hegiht="20px" />', $postcont);
$postcont = preg_replace('/:L/', '<img src="img/love.png" width="20px" hegiht="20px" />', $postcont);
    $postcont = preg_replace('/:{/', '<img src="img/ti.png" width="20px" hegiht="20px" />', $postcont);
    $postcont = preg_replace('/:D/', '<img src="img/d.png" width="20px" hegiht="20px" />', $postcont);
    $postcont = preg_replace('/:c/', '<img src="img/c.png" width="20px" hegiht="20px" />', $postcont);
    $postcont = preg_replace('/:li/', '<img src="img/like.png" width="30px" hegiht="30px" />', $postcont);

echo'
<div class="h-p-h">
<div class="m-p-pic">';
               ?>

 <img src="data:image/jpeg;base64,<?php echo base64_encode($uppic); ?>" width="100" height="100" id="m-p-pics" />

<?php
    if($uid == $upid){
    echo '          
    <form action="home.php" method="POST">
    <input type="submit" name="removepost" value="'.$fp->postid.'"   style="float: left;
    margin-top: 17%;
    background: #fff url(img/x.png ) center no-repeat;
    border: 0px;
    content: open-quote;
    width: 25px;
    height: 25px;
        color: rgba(255, 255, 255, 0);
    "  >
    </form>
';
    }
    if(isset($_POST['removepost'])){
     $p=$_POST['removepost'];
        $sql=mysql_query("delete from post where postid=$p");
            echo'<script>swal("تم","تم الحذف", "success");</script>';

header('Location:index.php');
    }
    
    
    
             echo'             </div>
                   <div class="m-p-name">
                       
      <a href="vporofile.php?uid='.$proid.'" style="padding-bottom:10px;">  '.$fname." ".$sname.' </a>
                       <br><h6>'.$fp->postdate.' <br> '.$fp->posttime.'</h6> 
                  </div>
                  <div class="p-h-cont" id="seemore">
                  <h5>
                   
                      
                  '.($postcont).'
                      
                      
                      </h5>
                      '; 
          
          
          ?>
            <pre class="brush: c-sharp;" >
<?php 
echo $code;

?>


</pre>
          <?php if($fp->postimg ==null){
                      
                      }else{ ?>
          <img src="data:image/jpeg;base64,<?php echo base64_encode($fp->postimg); ?>" width="100%" height="300px" />
          <?php } ?>
      </div>
<?php
        $pidl=intval($fp->postid);
    $selectlike=mysql_query("SELECT * 
FROM  `like` 
WHERE uli=$uid AND pid=$pidl")or die(mysql_error());
     $selectlike=mysql_num_rows($selectlike);
    if($selectlike==0){
    
    
    ?>
<button style="
    background: none;
    border: none;
    width: 25px;
    height: 25px;
" title="اعجبني" onclick="loveit<?php echo $fp->postid; ?>()" id="love<?php echo $fp->postid; ?>" class="loveit" name="loveit" value="<?php  echo $fp->postid;  ?> "><img src="img/love.png">
</button>
   <script>
        function loveit<?php echo $fp->postid; ?>(){
         $(function(){
      $( "#love<?php echo $fp->postid; ?>" ).click(function() {
            jQuery(function($) {    
        $.ajax( {           
            url : "file/loveit.php?pid=<?php echo $fp->postid; ?>&uid=<?php echo $uid;?> &upid=<?php echo $fp->userpost; ?>",
            type : "GET",
            success : function(data) {
                }
            });
        });
          
          
      });
    
    });
        
        
        }
 
    </script>
<?php }
    else{
    echo"<img src='img/lovey.png'/>";
                echo " أنت و";

    }

?>
<span id="like">

<?php
    $pidl=intval($fp->postid);
    $selectlike=mysql_query("SELECT * 
FROM  `like` 
WHERE pid =$pidl")or die(mysql_error());
     $selectlike=mysql_num_rows($selectlike);
    echo $selectlike."  احبو هذا ";
    
    ?>
</span>

<div class="comments"  >
                      
                <form action="home.php" method="post">
                      
                        <input type="text" name="addcomment" placeholder=" اضف تعليقا هنا ........" style="
    width: 90%;
    height: 34px;
    margin: 10px;
" />
                    <input type="text" name="poid" value="<?php echo $fp->postid; ?>" style="display:none;">
                    <input type="submit" name="poid" value="<?php echo $fp->postid; ?>" style="display:none;">
                  
                      </form>
                  
                  </div>
    <?php 
    
    $pcid=$fp->postid;
    
    $selectcomment=mysql_query("select * from comment where pid=$pcid order by cid desc");
    while($scf=mysql_fetch_object($selectcomment)){
        $uc=$scf->cuid;
    $suinfo=mysql_query("select * from users where uid=$uc");
        $suserff=mysql_fetch_assoc($suinfo);
        echo'
             
                     
                
                    <div class="comments">';
        ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($suserff['upic']); ?>" width="40px" height="40px" />
<span id="comm">
<?php 
echo'
                        <a href="#" >'.$suserff['ufname'].' '.$suserff['usname'].'</a>
'.htmlspecialchars($scf->comment).'              
                  
                  </div>   
                  

';
    
    }
    echo'                  </div>
';
}

}
?>
</span>
         <?php
$nump=$_GET['nump'];

if($nump <10){
$nump=20;
}else{
$nump=$nump+10;
}
echo '<a href="home.php?nump='.$nump.'">
 <button onclick="" style="
    margin: 14px;
    height: 42px;
    width: 94%;
    background: #1F976E;
    border: 2px;
    color: #fff;
    float: right;
">عرض المزيد</button> 
</a>';


?>

        
      
        </div>

         <div class="cont-home-left">
        <?php

echo fname;

?>
             
 <a href="q.php">    <button type="submit" class="btn btn-success" style="
    background: #27A58D;
    border-color: #329683;
    float: left;
" name="ask">عرض الاسئلة</button>  </a>   
          
        </div>
         <div class="cont-home-left">
<form action="home.php" method="post">
    اطرح سؤال (مشكلة)
     <textarea class="form-control" rows="3" placeholder="ضع وصف المشكلة ثم اشارة $ ثم الكود" name="q"></textarea>
     <button type="submit" class="btn btn-success" style="
    background: #27A58D;
    border-color: #329683;
    float: left;
" name="ask">اسأل</button>

             
</form>          
          
        </div>
         <div class="cont-home-left" id="about">
          about , connect use , etc...
          
        </div>

        
    </body>
</html>

  <?php
    if(isset($_POST['addcomment'])){
        $comment=$_POST['addcomment'];
            $poid=$_POST['poid'];
$add=mysql_query("INSERT INTO  `comment` (
`cid` ,
`cuid` ,
`comment` ,
`view` ,
`pid` ,
`shownote`
)
VALUES (
NULL ,  '$uid',  '$comment',  '0',  '$poid',  '0'
);
")or die(mysql_error());  
  
      
    }//ask insert
  if(isset($_POST['ask'])){
        $q=mysql_real_escape_string($_POST['q']);
               $date=date('Y-m-d');
      $sql=mysql_query("insert into question (qcont,qcat,qdate) values (
      '$q',
      '1',
      '$date'
      
      )")or die(mysql_error());

        }

?>


<!--

  <pre class="brush: c-sharp;" >
 {
	margin: 0;
	padding: 0;
	border: 0;
	outline: 0;
	background: none;
	text-align: left;
    direction: ltr;
	float: none;
	vertical-align: baseline;
	position: static;
	left: auto;
	top: auto;
	right: auto;
	bottom: auto;
	height: auto;
	width: auto;
	line-height: normal;
	font-family: "Consolas", "Monaco", "Bitstream Vera Sans Mono", "Courier New", Courier, monospace;
	font-weight: normal;
	font-style: normal;
	font-size: 100%;
}



</pre>
!-->
  

