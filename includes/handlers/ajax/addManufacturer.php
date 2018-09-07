<?php
// CONNECT TO DATABASE
$host = 'localhost';
$dbname = 'healthcare';
$user = 'root';
$password = '';
$charset = 'utf8';
$pdo = new PDO(
	"mysql:host=$host;dbname=$dbname;charset=$charset", $user, $password, [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => false,
	]
);

// FETCH & DATA
$stmt = $pdo->prepare("SELECT * FROM `manufacturer` WHERE `manName` LIKE ?");
$stmt->execute(["%" . $_GET['term'] . "%"]);
$data = [];
while ($row = $stmt->fetch(PDO::FETCH_NAMED)) {
	$data[] = $row['manName'];
}
$pdo = null;
echo json_encode($data);
?>