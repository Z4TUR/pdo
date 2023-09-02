<?php
require_once "pdo.php";
if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}

// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return;
}
if (isset($_POST['make']) && isset ($_POST['year']) && isset ($_POST['mileage'])){
	if(strlen($_POST['make'])< 1 && strlen($_POST['year'])< 1 && strlen($_POST['mileage']) < 1){
	$failure = "Make, year and mileage are required";
	}else{
		if(is_numeric($_POST['mileage']) && is_numeric($_POST['year'])){
			$stmt = $pdo->prepare('INSERT INTO autos
			(make, year, mileage) VALUES ( :mk, :yr, :mi)');
			$stmt->execute(array(
				':mk' => $_POST['make'],
				':yr' => $_POST['year'],
				':mi' => $_POST['mileage']));
			echo '<p style="color: green;">Record inserted</p>';
		}
		else{
			$failure = "Mileage and year must be numeric";
		}		
}
}else{
	$failure = "Make is required";
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Israel's pdo</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<h1>Tracking Autos for <?php echo($_GET['name'])?><h1>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( $failure !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
}
?>
<form method="post">
<p>Make:
<input type="text" name="make" size="40"></p>
<p>Year:
<input type="text" name="year"></p>
<p>Mileage:
<input type="text" name="mileage"></p>
<input type="submit" value="Add">
<input type="submit" name="logout" value="Logout">
</form>
<?php
$prueba = $pdo -> prepare("SELECT * FROM autos");
$prueba -> execute();
$sies = $prueba->fetchAll(); 
if ($sies[0][0]){
	echo ('<h1 style="color: blue;">Carritos</h1>');
	foreach ($sies as list($k, $v1, $v2, $v3 )){
			echo "<li>$v1 $v2 $v3</li>";

}
}
?>

</body>
</html>
