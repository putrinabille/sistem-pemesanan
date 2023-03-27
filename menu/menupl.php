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
      <a class="nav-link" href="listpl.php">Data Pesanan</a>
    </li>
    <li class="nav-item active">
      <a class="nav-link" href="menupl.php">Menu</a>
    </li>
     <li class="nav-item">
      <a class="nav-link" href="../logout.php">Logout</a>
    </li>
  </ul>
  </nav>


<div class="container">
  <div class="row">    
    <div class="container-fluid">
                        <h1 class="mt-4">Menu KedaiKu</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Menu</li>
                        </ol>
                        <div class="card mb-4 mt-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Tabel Menu
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Menu</th>
                                                <th>Harga</th>
                                                <th>Stok</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $ambildata=mysqli_query($conn,"SELECT * FROM menu")  ;
                                                $i=1;
                                                while ($data=mysqli_fetch_array($ambildata)) {
                                                $idm=$data['idm'];
                                                $menu=$data['list'];
                                                $harga=$data['harga'];
                                                $stok=$data['stok'];
                                                

                                                        if ($stok>=1) {
                                                        $st="<font color='green'>Ready!</font>";
                                                    }else{
                                                        $st="<font color='red'>Habis</font>";
                                                    }

                                             ?>

                                             <tr>
                                               <td><?= $i++; ?></td>
                                               <td><?= $menu; ?></td>
                                               <td><?= $harga; ?></td>
                                               <td><?= $stok; ?></td>
                                               <td><b><?=$st; ?></b></td>
                                               
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