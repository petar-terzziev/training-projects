<?php
 
$db=new PDO('pgsql:host=localhost;dbname=ekatte','postgres','1241323');
$db->exec("set names utf8");
$sql="select s.name as sel_name,obst.name as obst_name,obl.name as obl_name from selishta s inner join obstini obst on s.obstina=obst.id inner join oblasti obl on obst.oblast=obl.id  where s.name=?";

$numbers=array();
$nq=$db->prepare($sql);
$nq->execute(array($_POST['selishte']));
$numbers=$nq->fetchall(PDO::FETCH_ASSOC);
header('Content-Type: application/json charset=utf-8');
echo json_encode($numbers, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

?>