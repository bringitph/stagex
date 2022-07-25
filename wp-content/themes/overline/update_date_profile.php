<?php 
$conn = new mysqli('localhost','thecheek_wp12','S!8Z9p8AO)','thecheek_wp12');
// dbuser, db password, db name

if(isset($_POST['user_id'])){
$id = $_POST['user_id'];
$msg = $_POST['payment_box'];
 $sql1  = "SELECT * FROM  wplj_usermeta WHERE user_id='".$_POST['user_id']."'";
 // table series name
 $r = $conn->query($sql1);
 while($row = mysqli_fetch_assoc($r)){
     $meta_key = $row['meta_key'];
     $meta_value = $row['meta_value'];
     if($meta_key=="mp_seller_payment_details" && $meta_value!==$msg){
  
      $sql = "UPDATE wplj_users set updated_at=NOW() WHERE id='$id'";
      // table series name
if($conn->query($sql)){
  echo "done";
}else{
  echo $conn->error;
}
      
     
     }
 };

}
if(isset($_GET['id'])){
 $sql1  = "SELECT * FROM wplj_users WHERE id='".$_GET['id']."'";
 $r = $conn->query($sql1);
 $row = mysqli_fetch_assoc($r);
  $date = $row['updated_at'];
  echo "Last updated: " . date('j F Y h:i a',strtotime($date)) ." by ". $row['display_name'];
}
?>