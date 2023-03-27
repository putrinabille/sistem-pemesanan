<?php 

$conn=mysqli_connect("localhost","root","","pesanan");

//login
if (isset($_POST['login'])) {
	$nama=$_POST['nama'];
	$pass=$_POST['pass'];
	$jbt=$_POST['jbt'];

	$cek=mysqli_query($conn,"SELECT * FROM login WHERE username='$nama' AND password='$pass' AND role='$jbt'");
	$hitung=mysqli_num_rows($cek);

	if ($hitung>0) {
		$ambildatarole=mysqli_fetch_array($cek);
		$role=$ambildatarole['role'];

		if ($role=='pelayan') {
			$_SESSION['log']= 'Logged';
			$_SESSION['role']= 'Pelayan';
			header('location:menu/listpl.php');
		}else{
			$_SESSION['log']= 'Logged';
			$_SESSION['role']= 'Kasir';
			header('location:menu/list.php');
		}
	}else{
		echo"<div class='alert alert-danger fade show text-center mb-3'>
            <strong>Terjadi Kesalahan!</strong> Periksa Kembali Username, Password, Serta Role Anda!
        </div>";
	}
}

//tambah menu
if (isset($_POST['addmenu'])) {
	$kategori=$_POST['menunya'];
	$list=$_POST['list'];
	$harga=$_POST['harga'];
	$stok=$_POST['stok'];
	
	$cek = mysqli_query($conn,"SELECT * FROM menu WHERE list='$list'");
	$hitung = mysqli_num_rows($cek);

	if ($hitung<1) {	
		$cekkategori = mysqli_query($conn,"SELECT * FROM kategori WHERE idk='$kategori'");
		$ambildatanya = mysqli_fetch_array($cekkategori);

		$addtotable = mysqli_query($conn,"INSERT INTO menu(idk, list, harga, stok) VALUES('$kategori','$list','$harga', '$stok')");

		if ($addtotable) {
			header('location:menu.php');
		}else {
					echo "<script>
						alert('Gagal Menambahkan Menu');
						window.location.href='menu.php';
					</script>";				
			  }			
	}else{
		echo "
		<script>
			alert('Nama menu sudah ada');
			window.location.href='menu.php';
		</script>
		";
	}

	
}

//update menu
if (isset($_POST['updatemenu'])) {
	$idm = $_POST['idm'];
	$list = $_POST['list'];
	$harga = $_POST['harga'];
	$stok = $_POST['stok'];

		$update = mysqli_query($conn, "UPDATE menu SET list='$list', harga='$harga', stok='$stok' WHERE idm='$idm' ");
		if ($update) {
			header('location:menu.php');
		}else {
			echo "<script>
			alert('Gagal Mengubah Menu');
			window.location.href='menu.php'
			</script>";
		}
}

//menghapus menu
if (isset($_POST['hapusmenu'])) {
	$idm = $_POST['idm'];

	$hapus = mysqli_query($conn,"DELETE FROM menu WHERE idm='$idm'");
	
	if ($hapus) {
		header('location:menu.php');
	}else {
		echo "gagal";
		header('location:menu.php');
	}
}

//input data pesanan
if (isset($_POST['tmbhlist'])) {
	$no=$_POST['no_ps'];
	$meja= $_POST['meja'];

	$cek=mysqli_query($conn,"SELECT * FROM menu WHERE idm='$idm'");
	$c=mysqli_fetch_array($cek);
	$stok=$c['stok'];

	$selisih = $stok-$qty;

	$update = mysqli_query($conn, "UPDATE menu SET stok='$selisih' WHERE idm='$idm'");

	$tambah=mysqli_query($conn,"INSERT INTO pesan(no_pesanan, no_meja)VALUES('$no', '$meja')");

	if ($tambah&&$update) {

			$cek=mysqli_query($conn,"SELECT * FROM meja WHERE no_meja='$meja'");
			$c=mysqli_fetch_array($cek);
			$status=$c['status'];

			$update=mysqli_query($conn,"UPDATE meja SET status='Booked' WHERE no_meja='$meja'");

			header('location:pesanan.php');
		}else {
			echo "<script>
			alert('Gagal Menambah Pesanan');
			window.location.href='pesanan.php'
			</script>";
		}
}

//tambah pesanan
if (isset($_POST['tmbhpesanan'])) {
	$idp=$_POST['idp'];
	$idm=$_POST['menu'];
	$qty=$_POST['qty'];

	$cek=mysqli_query($conn,"SELECT * FROM menu WHERE idm='$idm'");
	$c=mysqli_fetch_array($cek);
	$stok=$c['stok'];

	$selisih = $stok-$qty;

	$update = mysqli_query($conn, "UPDATE menu SET stok='$selisih' WHERE idm='$idm'");

	$tambah=mysqli_query($conn,"INSERT INTO detailpesanan(id_pesanan, idm, qty)VALUES('$idp', '$idm', '$qty')");
	if ($tambah&&$update) {
			header('location:pesanan.php?idp='.$idp);
		}else {
			echo "<script>
			alert('Gagal Menambah Pesanan');
			window.location.href='pesanan.php?idp=".$idp."'
			</script>";
		}
}

//update pesanan
if (isset($_POST['updatepsn'])) {
	$idm=$_POST['idm'];
	$iddp=$_POST['iddp'];
	$qty=$_POST['qty'];
	$idp = $_POST['idp'];

	$lihatstock = mysqli_query($conn,"SELECT * FROM menu WHERE idm='$idm'");
	$stoknya=mysqli_fetch_array($lihatstock);
	$stockskrg = $stoknya['stok'];

	$qtyskrg = mysqli_query($conn,"SELECT * FROM detailpesanan WHERE iddp='$iddp'");
	$qtynya = mysqli_fetch_array($qtyskrg);
	$qtyskrg = $qtynya['qty'];

	if ($qty>$qtyskrg) {
		$selisih = $qty-$qtyskrg;
		$kurangi = $stockskrg - $selisih;

		if ($selisih<=$stockskrg) {
			$kurangistocknya = mysqli_query($conn,"UPDATE menu SET stok='$kurangi' WHERE idm='$idm'");
			$updatenya = mysqli_query($conn,"UPDATE detailpesanan SET qty ='$qty' WHERE iddp='$iddp'");
			if ($kurangistocknya&&$updatenya) {
				header('location:pesanan.php?idp='.$idp);
			}else {
				echo "gagal";
				header('location:pesanan.php?idp='.$idp);
			} 
		}else{
			echo "
		<script>
		alert('Stock saat ini tidak mencukupi');
		window.location.href='pesanan.php?idp=".$idp."';
		</script>
		";
		}
		
	}else {
		$selisih = $qtyskrg-$qty;
		$kurangi = $stockskrg + $selisih;
		$kurangistocknya = mysqli_query($conn,"UPDATE menu SET stok='$kurangi' WHERE idm='$idm'");
		$updatenya = mysqli_query($conn,"UPDATE detailpesanan SET qty ='$qty' WHERE iddp='$iddp'");
		if ($kurangistocknya&&$updatenya) {
			header('location:pesanan.php?idp='.$idp);
		}else {
			echo "gagal";
			header('location:pesanan.php?idp='.$idp);
		}
	}

}

//menghapus pesanan
if (isset($_POST['hapuspsn'])) {
	$iddp = $_POST['iddp'];
	$idm = $_POST['idm'];
	$idp = $_POST['idp'];

	$cek = mysqli_query($conn, "SELECT * FROM detailpesanan WHERE iddp='$iddp'");
	$fa = mysqli_fetch_array($cek);
	$qtyskrg = $fa['qty'];

	$cek2 = mysqli_query($conn, "SELECT * FROM menu WHERE idm='$idm'");
	$fa2 =mysqli_fetch_array($cek2);
	$stockskrg = $fa2['stok'];

	$hitung = $stockskrg + $qtyskrg;

	$update = mysqli_query($conn,"UPDATE menu SET stok='$hitung' WHERE idm='$idm'");
	$hapus = mysqli_query($conn,"DELETE FROM detailpesanan WHERE idm='$idm' AND iddp= '$iddp'");

	if ($update&&$hapus) {
		header('location:pesanan.php?idp='.$idp);
	}else{
		echo "<script>
			alert('Gagal Menghapus Barang');
			window.location.href='pesanan.php?idp=".$idp."'
			</script>";
	}	
}

//mengosngkan meja
if (isset($_POST['ksgmeja'])) {
	$meja = $_POST['meja'];
	$status=$_POST['status'];

	$update = mysqli_query($conn,"UPDATE meja SET status='Empty' WHERE no_meja='$meja'");

	if ($update) {

		header('location:meja.php');
	}else{
		echo "<script>
			alert('Gagal Mengosongkan Meja');
			window.location.href='meja.php'
			</script>";
	}	
}
