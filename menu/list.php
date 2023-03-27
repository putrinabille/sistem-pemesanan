<?php
	require "../config/function.php";
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
      <a class="nav-link" href="list.php">Data Pesanan</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="menu.php">Menu</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="meja.php">Status Meja</a>
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
                                                <th>Tanggal</th>
                                                <th>Nomor Pesanan</th>
                                                <th>Nomor Meja</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $ambildata=mysqli_query($conn,"SELECT * FROM pesan ");
                                                $n=1;

                                                while ($data=mysqli_fetch_array($ambildata)) {
                                                $idp=$data['id_pesanan'];
                                                $no=$data['no_pesanan'];
                                                $meja=$data['no_meja'];
                                                $tgl=$data['tgl'];

                                                $ambilid=mysqli_query($conn,"SELECT * FROM menu m, detailpesanan d WHERE d.idm=m.idm");
                                                $id=mysqli_fetch_array($ambilid);
                                                $idm=$id['idm'];
                                                $iddp=$id['iddp'];
                                             ?>

                                             <tr>
                                               <td><?=$n++; ?></td>
                                               <td><?=$tgl; ?></td>
                                               <td><?=$no; ?></td>
                                               <td><?=$meja; ?></td>
                                               <td>
                                                <a href="pesanan.php?idp=<?=$idp; ?>" class="btn btn-info" target="blank">Lihat Detail Pesanan</a>
                                                </td>
                                             </tr>

                                              <div class="modal fade" id="end<?=$idp;?>">
                                                <div class="modal-dialog">
                                                  <div class="modal-content">
                                                  
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                      <h4 class="modal-title">Lakukan Transaksi?</h4>
                                                      <button type="button" class="close" data-dismiss="modal" target="blank">&times;</button>
                                                    </div>
                                                    
                                                    <!-- Modal body -->
                                                    <form method="post">
                                                    <div class="modal-body">
                                                      Lakukan Transaksi pada Nomor Pesanan <?=$no; ?> ?
                                                      <input type="hidden" name="idp" value="<?=$idp; ?>">
                                                      <input type="hidden" name="iddp" value="<?=$iddp; ?>">
                                                      <input type="hidden" name="idm" value="<?=$idm; ?>">
                                                      <input type="hidden" name="tgl" value="<?=$tgl; ?>">
                                                      <br><br>
                                                      <button type="submit" class="btn btn-info" name="tf">Ya</button>
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
          <b>No. Pesanan</b>
          <?php 
          //kode
                $cek=mysqli_query($conn,"select max(id_pesanan) as maxID from pesan");
                $data=mysqli_fetch_array($cek);

                $kode=$data['maxID'];

                $kode++;
                $ket= "PSN" . date("Ymd") . '-';
                $kodeauto= $ket . sprintf("%03s", $kode); ?>
           <input type="text" name="no_ps" value="<?=$kodeauto;?>" class="form-control" readonly>
          <br>
          <b>No. Meja</b>
          <select name="meja" class="form-control">
           <?php 
                $ambildata = mysqli_query($conn,"SELECT * FROM meja WHERE status='Empty'");
                while ($fetcharray = mysqli_fetch_array($ambildata)) {
                    $no=$fetcharray['no_meja'];
                    $status=$fetcharray['status'];

           ?>
           <option value="<?=$no; ?>"><?=$no;?></option>
        <?php } ?>
          </select><br>
          <button type="submit" class="btn btn-primary" name="tmbhlist">Submit</button>
        </div>
        </form>

        
      </div>
    </div>
  </div>
  
</div>

</html>