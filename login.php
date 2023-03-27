<?php 
require "config/function.php";


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link href="css/style.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  
</head>
<body>

<div class="jumbotron text-center">
  <h1>KedaiKu</h1>
  <p>Book your table here!</p> 
</div>
  
<div class="container">
  <div class="row">
    <div class="col-sm-6">
      <h3>Login Here!</h3>
      <form method="post">

        <div class="container">
          <label for="nama"><b>Username</b></label>
          <input type="text" placeholder="Enter Username" name="nama" required>

          <label for="pass"><b>Password</b></label>
          <input type="password" placeholder="Enter Password" name="pass" required>
          
          <div class="mb-1">
            <label class="form-label"><b>Role As</b></label>
          </div>

          <select class="form-select mb-3" name="jbt" style="width:200px;">
            <option value="pelayan">Pelayan</option>
            <option value="kasir">Kasir</option>
          </select>

          <button type="submit" name="login">Login</button>
          <label>
            <input type="checkbox" checked="checked" name="remember"> Remember me
          </label>
        </div>

      </form>
    </div>
    <div class="col-sm-6">
        <h3>Table List</h3>
          <div class="table-responsive">
              <table class="table table-bordered" id="meja" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>No.Meja</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                    $ambildata = mysqli_query($conn,"SELECT * FROM meja");

                    while($fetch=mysqli_fetch_array($ambildata)){
                          $no = $fetch['no_meja'];
                          $status = $fetch['status'];
                           
                           if ($status=='Empty') {
                                  $ket="<font color='green'>Empty</font>";
                            }else{
                                  $ket="<font color='red'>Booked</font>";
                            }                 
                  ?>
                      <tr>
                        <td><?=$no; ?></td>
                        <td><b><?=$ket; ?></b></td>
                      </tr>      
                  <?php };  ?>    
                </tbody>
               </table>
          </div>
    </div>

  </div>
</div>

</body>
</html>
