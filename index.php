<?php
require 'functions.php';
$mahasiswa = query("select * from mahasiswa ORDER BY id DESC");
if(isset($_POST["cari"])){
	$mahasiswa = cari($_POST["keyword"]);
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Halaman Administrator</title>
</head>
<body>

<h1>Halaman Administratori</h1>

<a href="tambah.php">Tambah data Mahasiswa</a>
<br>
<form action="" method="post">
	<input type="text" name="keyword" size="40" autofocus placeholder="cari!!" autocomplete="off">
	<button type="submit" name="cari">Cari!!</button>
</form>
<br>

<table border="1" cellspacing="0" cellpadding="5">
	<tr>
		<th>#</th>
		<th>Aksi</th>
		<th>Gambar</th>
		<th>NRP</th>
		<th>Nama</th>
		<th>Email</th>
		<th>Jurusan</th>
	</tr>
	<?php $i = 1; ?>
	<?php foreach( $mahasiswa as $row ) { ?>
	<tr>
		<td><?= $i; ?></td>
		<td><a href="ubah.php?id=<?php echo $row["id"]; ?>">ubah</a> | <a href="hapus.php?id=<?php echo $row["id"]; ?>" onclick="return confirm('yakin?')">hapus</a></td>
		<td>
			<img src="img/<?= $row["gambar"]; ?>" width="50">
		</td>
		<td><?= $row["nrp"]; ?></td>
		<td><?= $row["nama"]; ?></td>
		<td><?= $row["email"]; ?></td>
		<td><?= $row["jurusan"]; ?></td>
	</tr>
	<?php $i++; ?>
	<?php } ?>
</table>


</body>
</html>