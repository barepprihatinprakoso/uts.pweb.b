<?php
//including the database connection file
include_once("config.php");

//fetching data in descending order (lastest entry first)
//$result = mysql_query("SELECT * FROM users ORDER BY id DESC"); // mysql_query is deprecated
$halaman = 10;
$page = isset($_GET["halaman"]) ? (int)$_GET["halaman"] : 1;
$mulai = ($page > 1) ? ($page * $halaman) - $halaman : 0;
$result = mysqli_query($mysqli, "SELECT * FROM users");
$total = mysqli_num_rows($result);
$pages = ceil($total / $halaman);
$query = mysqli_query($mysqli, "select * from users LIMIT $mulai, $halaman") or die(mysql_error);
$no = $mulai + 1;

// $result = mysqli_query($mysqli, "SELECT * FROM users ORDER BY id DESC"); // using mysqli_query instead
?>

<html>

<head>
	<title>Homepage</title>
</head>

<body>
	<a href="add.html">Add New Data</a><br /><br />

	<table width='80%' border=0>

		<tr bgcolor='#CCCCCC'>
			<td>Name</td>
			<td>Age</td>
			<td>Email</td>
			<td>Action</td>
		</tr>
		<?php
		//while($res = mysql_fetch_array($result)) { // mysql_fetch_array is deprecated, we need to use mysqli_fetch_array 
		while ($res = mysqli_fetch_array($query)) {
			echo "<tr>";
			echo "<td>" . $res['name'] . "</td>";
			echo "<td>" . $res['age'] . "</td>";
			echo "<td>" . $res['email'] . "</td>";
			echo "<td><a href=\"edit.php?id=$res[id]\">Edit</a> | <a href=\"delete.php?id=$res[id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";
		}
		?>
	</table>
	<div class="">
		<?php for ($i = 1; $i <= $pages; $i++) { ?>
			<a href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a>

		<?php } ?>

	</div>
</body>

</html>