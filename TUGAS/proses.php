<?php
$koneksi = mysqli_connect("localhost", "root", "", "html");
parse_str($_POST['datakirim'], $hasil);
$action = $_POST['action'];

if ($action == 'insert') {
	$syntaxsql = "INSERT INTO pendaftar(NamaLengkap, NamaPanggilan, username, email, Pulau, kota, paymentMethod, NamaBank, NomorKartu, expiration, cvv, Waktu) VALUES ('$hasil[NamaLengkap]','$hasil[NamaPanggilan]','$hasil[username]','$hasil[email]','$hasil[Pulau]','$hasil[kota]','$hasil[paymentMethod]','$hasil[NamaBank]','$hasil[NomorKartu]','$hasil[expiration]','$hasil[cvv]','now()')";
}
elseif ($action == 'update') {
	$syntaxsql = "UPDATE pendaftar SET NamaLengkap='$hasil[NamaLengkap]',NamaPanggilan='$hasil[NamaPanggilan]',username='$hasil[username]',email='$hasil[email]',Pulau='$hasil[Pulau]',kota='$hasil[kota]',paymentMethod='$hasil[paymentMethod]',NamaBank='$hasil[NamaBank]',NomorKartu='$hasil[NomorKartu]',expiration='$hasil[expiration]',cvv='$hasil[cvv]' WHERE username='$tambahan[ketTambahan]'";
}
elseif ($action == 'delete') {
	$syntaxsql = "DELETE FROM pendaftar WHERE username='$hasil[username]'";
}
elseif ($action == 'read') {
	$syntaxsql = "SELECT NamaLengkap, NamaPanggilan, username, email, Pulau, kota, paymentMethod, NamaBank, NomorKartu, expiration, cvv FROM pendaftar WHERE username='$hasil[username]'";
}else {
	echo "ERROR ACTION";
	exit();
}

if (mysqli_errno($koneksi)) {
	echo "Gagal Terhubung ke Database".$koneksi -> connect_error; 
	exit();
}else{
	//echo "Database Terhubung";	
}

if ($koneksi -> query($syntaxsql) === TRUE) {
	echo "$action Successfully";
}
elseif ($koneksi->query($syntaxsql) === FALSE){
	echo "Error:  $syntaxsql" .$koneksi -> error;
}
else {
	$result = $koneksi->query($syntaxsql); //bukan true false tapi data array asossiasi
	if($result->num_rows > 0){
		echo "<table id='tresult' class='table table-striped table-bordered'>";
		echo "<thead><th>NamaLengkap</th><th>NamaPanggilan</th><th>username</th><th>email</th><th>Pulau</th><th>kota</th><th>paymentMethod</th><th>NamaBank</th><th>NomorKartu</th><th>expiration</th><th>cvv</th></thead>";
		//echo "<tbody>";
		while($row = $result->fetch_assoc()) {
			echo "<tr><td>".$row['NamaLengkap']."</td><td>". $row['NamaPanggilan']."</td><td>".$row['username']."</td><td>". $row['email']."</td><td>".$row['Pulau']."</td><td>". $row['kota']."</td><td>".$row['paymentMethod']."</td><td>". $row['NamaBank']."</td><td>".$row['NomorKartu']."</td><td>". $row['expiration']."</td><td>".$row['cvv']."</td></tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}
	else{
		echo "Data Not Available";
	}
}
$koneksi->close();
?>