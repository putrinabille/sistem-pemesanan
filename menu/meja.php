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
    <li class="nav-item">
      <a class="nav-link" href="pesanan.php">Data Pesanan</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="menu.php">Menu</a>
    </li>
    <li class="nav-item active">
      <a class="nav-link" href="meja.php">Status Meja</a>
    </li>
     <li class="nav-item">
      <a class="nav-link" href="../logout.php">Logout</a>
    </li>
  </ul>
  </nav>


<div class="container">
  <div class="row">    
    <div class="container-fluid">
                        <h1 class="mt-4">Status Meja KedaiKu</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Status Meja</li>
                        </ol>
                        <div class="card mb-4 mt-4">
                           
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No. Meja</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php 

                                                $ambildata = mysqli_query($conn,"SELECT * FROM meja");
                                            
                                            $i=1;
                                            while ($data=mysqli_fetch_array($ambildata)) {
                                                $status = $data['status'];
                                                $meja=$data['no_meja'];

                                                
                                                if ($status=='Booked') {
                                                  $ket="<font color='green'>Aktif</font>";
                                                }else{
                                                  $ket="<font color='black'>Non Aktif</font>";
                                                }

                                                ?>

                                                <tr>
                                                    <td><?= $meja; ?></td>
                                                    <td><b><?=$ket; ?></b></td>
                                                    <td>
                                                      <?php 
                                                            if ($status=='Booked') {
                                                              ?>
                                                              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$meja;?>">
                                                        Non Aktifkan
                                                        </button> 
                                                      <?php  }   ?>
                                                      </td>
                                                </tr>
                                                  <div class="modal fade" id="delete<?=$meja;?>">
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
                                                      Apakah Anda Yakin Ingin Mengosongkan Meja <?=$meja; ?>?
                                                      <input type="hidden" name="meja" value="<?=$meja; ?>">
                                                      <input type="hidden" name="status" value="<?=$status; ?>">
                                                      <br><br>
                                                      <button type="submit" class="btn btn-info" name="ksgmeja">Ya, Kosongkan</button>
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

</html>