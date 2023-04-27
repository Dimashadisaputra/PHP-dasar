<?php
// Koneksi ke Database
$conn = mysqli_connect("localhost", "root", "", "php-dasar");

	
function query($sql) {
	global $conn;
	$result = mysqli_query($conn, $sql);

	$rows = [];
	while( $row = mysqli_fetch_assoc($result) ) {
		$rows[] = $row;
	}

	return $rows;
}

function hapus($id) {
	global $conn;
	mysqli_query($conn, "delete from mahasiswa where id = $id");

	return mysqli_affected_rows($conn);
}


function tambah($data) {
	global $conn;

	$nrp = htmlspecialchars($data["nrp"]);
	$nama = htmlspecialchars($data["nama"]);
	$email = htmlspecialchars($data["email"]);
	$jurusan = htmlspecialchars($data["jurusan"]);

	$gambar = upload();
	if(!$gambar){
		return false;
	}

	$sql = "INSERT INTO mahasiswa
				VALUES
			('', '$nrp', '$nama', '$email', '$jurusan', '$gambar')";

	mysqli_query($conn, $sql);

	return mysqli_affected_rows($conn);
}

function upload(){
	$namafile = $_FILES['gambar']['name'];
	$ukuranfile = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmpname = $_FILES['gambar']['tmp_name'];

	//cek gambar diupload kosong
	if($error === 4){
		echo "<script>alert('pilih poto dulu');</script>";
	}
	return false;

	//cek apa yang di upload gambar atau bukan
	$ektengambarvalid = ['jpg', 'png', 'jpeg'];
	$ektengambar = explode('.', $namafile);
	$ektengambar = strtolower(end($ektengambar));
	if ( !in_array($ektengambar, $ektengambarvalid)){
		echo "<script>alert('bukan photo');</script>";
	}
	return false;

	//cek gambar terlalu besar 
	if ($ukuranfile > 1000000){
		echo "<script>alert('tidak boleh lebih dari 1MB');</script>";
	} return false;

	//setelah lolos semua
	//generate name gambar baru
	$namafilebaru = uniqid();
	$namafilebaru .= '.';
	$namafilebaru .= $ektengambar;

	move_uploaded_file($tmpname, 'img/'.$namafilebaru);

	return $namafilebaru;
}


function ubah($data) {
	global $conn;

	$id = $data["id"];
	$nrp = htmlspecialchars($data["nrp"]);
	$nama = htmlspecialchars($data["nama"]);
	$email = htmlspecialchars($data["email"]);

	$sql = "UPDATE mahasiswa SET
				nrp = '$nrp',
				nama = '$nama',
				email = '$email',
			WHERE
				id = $id
			";

	mysqli_query($conn, $sql);

	return mysqli_affected_rows($conn);
}

function cari($key){
	$query = "SELECT * FROM mahasiswa where nama LIKE '%$key%' OR nrp LIKE '%$key%' OR email LIKE '%$key%' OR jurusan LIKE '%$key%'";

	return query($query);
}


?>