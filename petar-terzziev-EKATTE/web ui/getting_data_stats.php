 <?php 

$db=new PDO('mysql:host=localhost;dbname=ekatte','ekatteuser','1241323');

$count_obl="Select count(*) from oblasti";
$count_obst="Select count(*) from obstini";
$count_sel="select count(*) from selishta";
$numbers=array();
$numbers['oblasti']=$db->query($count_obl)->fetch();
$numbers['obstini']=$db->query($count_obst)->fetch();
$numbers['selishta']=$db->query($count_sel)->fetch();
header('Content-Type: application/json');
echo json_encode($numbers);
 ?>