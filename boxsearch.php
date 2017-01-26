<?php
include('include/config.php');

if($_POST)
{
$q=$_POST['searchword'];
$q=str_replace("@","",$q);
$q=str_replace(" ","%",$q);

$sql_res=mysql_query("SELECT * 
FROM  `users` 
WHERE ufname LIKE  '%$q%'
LIMIT 5");
while($row=mysql_fetch_array($sql_res))
{
$fname=$row['ufname'];
$lname=$row['usname'];
$img=$row['upic'];
$id=$row['uid'];
?>
<div class="display_box" align="left">
<img  src="data:image/jpeg;base64,<?php echo base64_encode($img); ?>" class="image"/>
<a href="vporofile.php?uid=<?php echo $id;?>" class='addname' title='<?php echo $fname; ?>&nbsp;<?php echo $lname; ?>' style="
    font-size: 162%;
    float: left;
    margin-top: 13px;
">
<?php echo $fname; ?>&nbsp;<?php echo $lname; ?> </a><br/>
<?php
}}

?>
