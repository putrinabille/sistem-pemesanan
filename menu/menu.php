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
      <a class="nav-link" href="list.php">Data Pesanan</a>
    </li>
    <li class="nav-item active">
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
    <div class="container-fluid">
                        <h1 class="mt-4">Menu KedaiKu</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Menu</li>
                        </ol>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                        Tambah Menu
                      </button>
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
                                                <th>Aksi</th>
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
                                               <td><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idm;?>">
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
                                                      <h4 class="modal-title">Edit Menu</h4>
                                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    
                                                    <!-- Edit body -->
                                                    <form method="post" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                       <input type="text" name="list" value="<?=$menu; ?>" class="form-control" placeholder="Nama Menu" required><br>
                                                       <input type="text" name="harga" value="<?=$harga; ?>" class="form-control" placeholder="Harga" required><br>
                                                       <input type="text" name="stok" value="<?=$stok; ?>" class="form-control" placeholder="Stok" required><br>
                                                      <input type="hidden" name="idm" value="<?=$idm; ?>">
                                                      <button type="submit" class="btn btn-primary" name="updatemenu">Submit</button>
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
                                                      Apakah Anda Yakin Ingin Menghapus <?=$menu; ?>?
                                                      <input type="hidden" name="idm" value="<?=$idm; ?>">
                                                      <br><br>
                                                      <button type="submit" class="btn btn-danger" name="hapusmenu">Hapus</button>
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

 <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Tambah List Menu</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form method="post" enctype="multipart/form-data">
        <div class="modal-body">
            <select name="menunya" class="form-control">
            <?php 
                $ambildata = mysqli_query($conn,"SELECT * FROM kategori");
                while ($fetcharray = mysqli_fetch_array($ambildata)) {
                    $kategori = $fetcharray['jenis'];
                    $idk = $fetcharray['idk'];
             ?>

             <option value="<?=$idk; ?>"><?=$kategori; ?></option>

        <?php } ?>
          </select><br>
          <input type="text" name="list" placeholder="Nama Menu" class="form-control" ><br>
          <input type="number" name="harga" placeholder="Harga" class="form-control" ><br>
          <input type="number" name="stok" placeholder="Stock" class="form-control" ><br>
          <button type="submit" class="btn btn-primary" name="addmenu">Submit</button>
        </div>
        </form>

        
      </div>
    </div>
  </div>
</div>

</html>