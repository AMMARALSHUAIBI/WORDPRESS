<?php 
include_once("include/config.php");
$ui=$_GET['uid'];
$ufid=$_GET['ufid'];
    $date=date('Y-m-d');


$fun=$_GET['fun'];
if($fun=="unf"){
$unfollow=mysql_query("Delete from follow where `u-f-id`=$ui AND `u-f-id-w`=$ufid")or die(mysql_error());
echo "تم بنجاح";
}else{
if($ui!=='0' AND $ufid!=='0'){
$sql = "INSERT INTO `askdev`.`follow` (`f_id`, `u-f-id`, `u-f-id-w`, `f-date`) VALUES (NULL, '$ui', '$ufid', '$date');";
    $sql=mysql_query($sql)or die("انت متابع");

}

}
?>