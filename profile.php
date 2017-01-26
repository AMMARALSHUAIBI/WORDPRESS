<?php
include("file/head.php");
include("include/config.php");
include("file/dialog.php");


?>
        <div class="profile-cont">
        <div class="cover">
              <img src="data:image/jpeg;base64,<?php echo base64_encode(ucoverpic); ?>" width="100%" height="280px" />
            <a href="?do=ccpic#openModal"><img src="img/changepic.png" width="50px" height="40px;" style="
    float: .;
    margin-top: -37px;
    margin-right: 90%;
    display: block;
"></a>
            
            </div>
        <div class="profile-pic">
            <?php
if(upic == null){

echo'            <img src="img/default.png" id="ppics" width="140" height="140">
';
}else{


?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode(upic); ?>" id="ppics" width="140" height="140" />
            
            
  <?php
    
}
            
            
            ?>
            <div id="changepic">
             <a href="?do=cpic#openModal"   >  <img src="img/changepic.ico" width="40px" id="changes" height="40px" style="
    margin-top: 47%;
    margin-right: 23%;
">
                </a>
            
            </div>
            </div>
            <div class="ac-name">
            <h3><a href="#"style="
    margin-right: 38%;
    color: #337ab7;
    text-decoration: none;
"><?php echo fname." ".sname ?></a></h3>
            </div>

             <div class="h-p">
        <h4>
اكتب ما في بالك
        </h4>
  <form action="profile.php"  method="post" enctype="multipart/form-data">
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
    
            $pic = addslashes(file_get_contents($_FILES['postimg']['tmp_name']));  
    $time=date('H:i:s', time());
    $date=date('Y-m-d');
    $cl=strlen($cont);
    if($cl >40){
    
    $insertpost=mysql_query("insert into post (`postcont`,`userpost`,`postimg`,`posttime`,`postdate`) values ('$cont','$uid','{$pic}','$time','$date')")or die(mysql_error());

    }else{
    echo"المنشور فارغ";
    
    }
}

?>
          </div>
       <?php
$nump=$_GET['nump'];
if($nump <10){
$nump=8;
}else{
$nump=$nump+8;
}
$selectpost=mysql_query("SELECT * 
FROM  `post` where userpost=$uid
ORDER BY postid  desc 
LIMIT 0 , $nump  ");
while($fp=mysql_fetch_object($selectpost)){
    $upid=$fp->userpost;
    
$suser=mysql_query("select * from users where uid=$upid")or die(mysql_error());
    $suserf=mysql_fetch_assoc($suser);
     $fname=$suserf['ufname'];
     $sname=$suserf['usname'];
     $uppic=$suserf['upic'];
 $postcont=htmlspecialchars($fp->postcont);
echo'
<div class="h-p-h">
<div class="m-p-pic">';
               ?>

 <img src="data:image/jpeg;base64,<?php echo base64_encode($uppic); ?>" width="100" height="100" id="m-p-pics" />

<?php
    if($uid == $upid){
    echo '          
    <form action="profile.php" method="POST">
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
header('Location:index.php');
    }
    
    
    
             echo'             </div>
                   <div class="m-p-name">
                       
      <a href="#" style="padding-bottom:10px;">  '.$fname." ".$sname.' </a>
                       <br><h6>'.$fp->postdate.' <br> '.$fp->posttime.'</h6> 
                  </div>
                  <div class="p-h-cont" id="seemore">
                  <h5>
                   
                      
                  '.($postcont).'
                      
                      
                      </h5>
                      '; ?>
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
            url : "file/loveit.php?pid=<?php echo $fp->postid; ?>&uid=<?php echo $uid;?>",
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
                      
                <form action="profile.php" method="post">
                      
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
?>
         <?php
$nump=$_GET['nump'];

if($nump <10){
$nump=20;
}else{
$nump=$nump+10;
}
echo '<a href="profile.php?nump='.$nump.'">
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
            
        </div>
 <div class="cont-home-left">
        sd
          
          
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
$add=mysql_query("INSERT INTO  `askdev`.`comment` (
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
");  
    }?>


