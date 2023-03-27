<?php
require "../config/function.php";
$idp=$_GET['idp'];
if (isset($_GET['idp'])) {
    $idp = $_GET['idp'];

    $cek=mysqli_query($conn,"SELECT * FROM pesan WHERE id_pesanan='$idp'");
    $c=mysqli_fetch_array($cek);
    $no=$c['no_pesanan'];
    $meja=$c['no_meja'];
}else{
    header("location:list.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link href="asset/css/style.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>KedaiKu</h1>
  <p>Welcome !</p> 
</div>
  
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <ul class="navbar-nav">
    <li class="nav-item active">
      <a class="nav-link" href="listpl.php">Data Pesanan</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="menupl.php">Menu</a>
    </li>
     <li class="nav-item">
      <a class="nav-link" href="../logout.php">Logout</a>
    </li>
  </ul>
  </nav>


<div class="container">
  <div class="row">    
    <div class="container-fluid"><br><br>
                      <h3>List Data Pesanan</h3>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Data Pesanan</li>
                        </ol>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                        Tambah Pesanan
                      </button><br><br>
                      <h3>Data Pesanan <?=$no; ?></h3>
                        <h4>No. Meja : <?=$meja; ?></h4>
                        <div class="card mb-4 mt-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Tabel Data Pesanan
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Menu</th>
                                                <th>Qty</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $ambildata = mysqli_query($conn,"SELECT * FROM detailpesanan p, menu m WHERE p.idm=m.idm AND id_pesanan='$idp'");
                                            $i=1;
                                            while ($data=mysqli_fetch_array($ambildata)) {
                                                $menu = $data['list'];
                                                $qty = $data['qty'];
                                                $idm = $data['idm'];
                                                $iddp = $data['iddp'];
                                                $stok=$data['stok'];

                                            ?>

                                                <tr>
                                                    <td><?=$i++; ?></td>
                                                    <td><?= $menu; ?></td>
                                                    <td><?= $qty; ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit<?=$idm;?>">
                                                        Edit
                                                        </button>
                                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$idm;?>">
                                                        Delete
                                                        </button>
                                                    </td>
                                                </tr>

                                            
                                            <!--Edit Modal-->
                                            <div class="modal fade" id="edit<?=$idm; ?>">
                                                <div class="modal-dialog">
                                                  <div class="modal-content">
                                                  
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                      <h4 class="modal-title">Ubah Data Detail Pesanan</h4>
                                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    
                                                    <!-- Modal body -->
                                                    <form method="post" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                      <input type="text" name="menu" value="<?=$menu; ?> (<?=$stok; ?> left) " class="form-control" disabled><br>
                                                      <input type="number" name="qty" value="<?=$qty; ?>" class="form-control" min="1" required><br>
                                                      <input type="hidden" name="iddp" value="<?=$iddp; ?>">
                                                      <input type="hidden" name="idm" value="<?=$idm; ?>">
                                                      <input type="hidden" name="idp" value="<?=$idp; ?>">
                                                      <button type="submit" class="btn btn-primary" name="updatepsn">Submit</button>
                                                    </div>
                                                    </form> 
                                                  </div>
                                                </div>
                                              </div>

                                              <!--Delete Modal-->
                                            <div class="modal fade" id="delete<?=$idm;?>">
                                                <div class="modal-dialog">
                                                  <div class="modal-content">
                                                  
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                      <h4 class="modal-title">Hapus Barang?</h4>
                                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    
                                                    <!-- Modal body -->
                                                    <form method="post">
                                                    <div class="modal-body">
                                                      Apakah Anda Yakin Ingin Menghapus <?=$menu; ?> dari nomor pesanan <?=$no; ?>?
                                                      <input type="hidden" name="iddp" value="<?=$iddp; ?>">
                                                      <input type="hidden" name="idm" value="<?=$idm; ?>">
                                                      <input type="hidden" name="idp" value="<?=$idp; ?>">
                                                      <br><br>
                                                      <button type="submit" class="btn btn-danger" name="hapuspsn">Hapus</button>
                                                    </div>
                                                    </form>
                                                  </div>
                                                </div>
                                              </div>




                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
    </div>
  </div>
</div>

</body>

<!-- Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Tambah Pesanan</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form method="post">
        <div class="modal-body">
          <b>List Menu</b><br> 
          <select name="menu" class="form-control"> 
          <?php 
                $ambildata = mysqli_query($conn,"SELECT * FROM menu WHERE stok>0 AND idm not in (select idm from detailpesanan where id_pesanan='$idp') ");
                while ($fetcharray = mysqli_fetch_array($ambildata)) {
                    $menu = $fetcharray['list'];
                    $stok = $fetcharray['stok'];
                    $idm = $fetcharray['idm'];
           ?>
           <option value="<?=$idm; ?>"><?=$menu; ?> (Tersedia <?=$stok; ?> porsi)</option>
        <?php } ?>
           </select><br>
           <input type="number" name="qty" placeholder="Quantity" class="form-control" ><br>
           <input type="hidden" name="idp" value="<?=$idp; ?>">
          <button type="submit" class="btn btn-primary" name="tmbhpesanan">Submit</button>
        </div>
        </form>

        
      </div>
    </div>
  </div>
  
</div>

</html>