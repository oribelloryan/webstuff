<?php
try {
$host = 'localhost';
$db   = 'schuler';
$user = 'root';
$pass = '';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
	PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES   => false,
];

$conn = new PDO($dsn, $user, $pass, $opt);
} catch (PDOException $e) {
	  print "Error!: " . $e->getMessage() . "<br/>";
	  die();
}
// $xmlDoc=new DOMDocument();
// $xmlDoc->load("links.xml");
//
// $x=$xmlDoc->getElementsByTagName('link');

//get the q parameter from URL
$q=$_GET["q"];

//lookup all links from the xml file if length of q>0
// if (strlen($q)>0) {
//   $hint="";
//   for($i=0; $i<($x->length); $i++) {
//     $y=$x->item($i)->getElementsByTagName('title');
//     $z=$x->item($i)->getElementsByTagName('url');
//     if ($y->item(0)->nodeType==1) {
//       //find a link matching the search text
//       if (stristr($y->item(0)->childNodes->item(0)->nodeValue,$q)) {
//         if ($hint=="") {
//           $hint="<a href='" .
//           $z->item(0)->childNodes->item(0)->nodeValue .
//           "' target='_blank'>" .
//           $y->item(0)->childNodes->item(0)->nodeValue . "</a>";
//         } else {
//           $hint=$hint . "<br /><a href='" .
//           $z->item(0)->childNodes->item(0)->nodeValue .
//           "' target='_blank'>" .
//           $y->item(0)->childNodes->item(0)->nodeValue . "</a>";
//         }
//       }
//     }
//   }
// }
$data = array();
$sql = "SELECT * FROM teacher_profile WHERE firstname LIKE :f";
$result  = $conn->prepare($sql);
$keyword = "%".$q."%";
$result->bindValue(':f', $keyword, PDO::PARAM_STR);
$result->execute();
if(!empty($result)){
  while($row = $result->fetch(PDO::FETCH_ASSOC)){
  array_push($data,$row['firstname']);
  }
	$response=$data;
}else if(empty($result)){
	$response=array_push($data, "No available record");
}
echo count($result);
echo json_encode($response);
?>
