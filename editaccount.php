<?php 
  session_start();
  require_once('db_config/db_connect.php');

  $name = $_SESSION['name'];
  $address = $_SESSION['addr'];
  $phone = $_SESSION['phone'];
  $username = $_SESSION['usn'];
  $password = $_SESSION['pwd'];
  $img = $_SESSION['img'];

  $errName = $errAddress = $errPhone = $errUsername = $errPassword = $errPasswordRT = "";
  if(isset($_POST['submit']))
  {
    //Kiem Tra name
    if(isset($_POST['name']))
    {
      $name = $_POST['name'];
      if($name =="")
        $errName = "Chưa nhập tên";
      elseif(!preg_match('/[a-zA-Z ]/', $name))
        $errName = "Dữ liệu không hợp lệ";
    }
    //Kiem Tra address
    if(isset($_POST['address']))
    {
        $address = $_POST['address'];
        if($address =="")
        $errAddress = "Chưa nhập địa chỉ";
        elseif(!preg_match('/[a-zA-Z0-9\/]/', $address))
        $errAddress = "Dữ liệu không hợp lệ";
    }
    //Kiem Tra phone
    if(isset($_POST['phone']))
    {
        $phone = $_POST['phone'];
        if($phone =="")
        $errPhone = "Chưa nhập SĐT";
        elseif(!is_numeric($phone))
        $errPhone = "Dữ liệu không hợp lệ";
    }
    //Kiem Tra username
    if(isset($_POST['username']))
    {
        $username = $_POST['username'];
        if($username =="")
        $errUsername = "Chưa nhập tên đăng nhập";
        elseif(!is_string($username))
        $errUsername = "Dữ liệu không hợp lệ";
        else{
            $sql_check = 'SELECT * FROM account WHERE username = "'.$username.'"';
            $result_check = mysqli_query($conn,$sql_check);
            if(mysqli_num_rows($result_check))
                $errUsername = "Tên đăng nhập đã tồn tại";
        }
    }
    //Kiem Tra password
    if(isset($_POST['password']))
    {
        $password = $_POST['password'];
        if($password =="")
        $errPassword = "Chưa nhập mật khẩu";
        elseif(!is_string($password))
        $errPassword = "Dữ liệu không hợp lệ";
    }
    //Kiem Tra passwordRetype
    if(isset($_POST['passwordRT']))
    {
        $passwordRT = $_POST['passwordRT'];
        if($passwordRT =="")
        $errPasswordRT = "Chưa nhập lại mật khẩu";
        elseif(isset($password) && strcmp($password,$passwordRT)!=0)
        $errPasswordRT = "Mật khẩu không trùng khớp";
        elseif(!is_string($passwordRT))
        $errPasswordRT = "Dữ liệu không hợp lệ";
    }
    //Kiem Tra img
    if(isset($_FILES['img']))
    {
      if($_FILES['img']['name'] == "")
        $errImg = "Chưa chọn ảnh đại diện! Ảnh đại diện sẽ thiêt lập theo mặc định";
      else{
        $img = $_FILES['img']['name'];
        $target_dir = "img/";
        $target_file = $target_dir . basename($img);
        move_uploaded_file($_FILES['img']['tmp_name'],$target_file);
      }
    }
    
    else $errImg = "Chưa chọn ảnh !";

    if(empty($img)) $img = 'avatar.png';
    //update
    if(empty($errName) && empty($errAddress) && empty($errPhone) && empty($errUsername) && empty($errPassword) && empty($errPasswordRT))
    {
      $sql = 'UPDATE account
              SET name = "'.$name.'",
                  username = "'.$username.'",
                  password = "'.$password.'",
                  phone = "'.$phone.'",
                  address = "'.$address.'",
                  image = "'.$img.'"
              WHERE id ='.$_SESSION['id'];
      mysqli_query($conn, $sql);
      $check = 1;
      session_destroy();
      header('location: index.php?log=1');
    }
  }
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Tài khoản</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="style.css">
        <link rel="icon" href="img/logo.png">
        
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="code.js"></script>
      </head>
  <body>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!----------------------- I. Header -->
    <?php 
        include('header.php');
        if(isset($check) && isset($name))
          echo '<script type="text/javascript">swal("Cập nhật khoản thành công!", "Tên tài khoản: '.$name.'", "success");</script>';
    ?>   

<div class="mt-4">
    <h3 class=" text-center mb-4">- Cập nhật thông tin tài khoản -</h3>
    <form action="" method="post" enctype="multipart/form-data" style="width:50%;margin-left:20%">
      <!--Name-->
        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Tên đầy đủ: </label>
          <input type="text" name="name" class="form-control col-sm-8" value="<?php if(isset($name)) echo $name ?>">
        </div>
        <?php 
          if(!empty($errName))
            echo '
            <div class="form-group row">
              <p class="text-danger col-sm-4"></p>
              <p class="text-danger col-sm-8">'.$errName.'</p>
            </div>
            ';
        ?>
      <!--Address-->
        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Địa chỉ: </label>
          <input type="text" name="address" class="form-control col-sm-8" value="<?php if(isset($address)) echo $address ?>">
        </div>
        <?php 
          if(!empty($errAddress))
            echo '
            <div class="form-group row">
              <p class="text-danger col-sm-4"></p>
              <p class="text-danger col-sm-8">'.$errAddress.'</p>
            </div>
            ';
        ?>
      <!--Phone-->
        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Số điện thoại: </label>
          <input type="text" name="phone" class="form-control col-sm-8" value="<?php if(isset($phone)) echo $phone ?>">
        </div>
        <?php 
          if(!empty($errPhone))
            echo '
            <div class="form-group row">
              <p class="text-danger col-sm-4"></p>
              <p class="text-danger col-sm-8">'.$errPhone.'</p>
            </div>
            ';
        ?>
      <!--Username--> 
       <div class="form-group row">
          <label class="col-sm-4 col-form-label">Tên đăng nhập: </label>
          <input type="text" name="username" disabled class="form-control col-sm-8" value="<?php if(isset($username)) echo $username ?>">
        </div>
        <?php 
          if(!empty($errUsername))
            echo '
            <div class="form-group row">
              <p class="text-danger col-sm-4"></p>
              <p class="text-danger col-sm-8">'.$errUsername.'</p>
            </div>
            ';
        ?>
      <!--Password--> 
        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Mật khẩu: </label>
          <input type="password" name="password" class="form-control col-sm-8" value="<?php if(isset($password)) echo $password ?>">
        </div>
        <?php 
          if(!empty($errPassword))
            echo '
            <div class="form-group row">
              <p class="text-danger col-sm-4"></p>
              <p class="text-danger col-sm-8">'.$errPassword.'</p>
            </div>
            ';
        ?>
 
      <!--Nhap lai Password-->
        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Nhập lại mật khẩu: </label>
          <input type="password" name="passwordRT" class="form-control col-sm-8" value="<?php if(isset($passwordRT)) echo $passwordRT ?>">
        </div>
        <?php 
          if(!empty($errPasswordRT))
            echo '
            <div class="form-group row">
              <p class="text-danger col-sm-4"></p>
              <p class="text-danger col-sm-8">'.$errPasswordRT.'</p>
            </div>
            ';
        ?>

      <!--Anh dai dien-->
      <div class="form-group row">
            <label class="col-sm-4 col-form-label">Ảnh đại diện: </label>
            <div class="custom-file col-sm-8">
              <input type="file" class="custom-file-input" value="" name="img" id="img" accept="image/*" onchange="showPreview(event);">
              <label class="custom-file-label" for="inputGroupFile01"><?php if(isset($img)) echo $img; else echo "Chọn ảnh đại diện"; ?></label>
            </div>
            <!--script de hien thi ten anh-->
            <script>
            $(".custom-file-input").on("change", function() {
              var fileName = $(this).val().split("\\").pop();
              $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
            </script>
        </div>
        <?php 
          if(!empty($errImg))
            echo '
            <div class="form-group row">
              <p class="text-secondary col-sm-4"></p>
              <p class="text-secondary col-sm-8">'.$errImg.'</p>
            </div>
            ';
        ?>
        <!--Phan xem truoc anh-->
        <div class="row">
          <div class="col-sm-4"></div>
          <div class="col-sm-8"><img id="img_prv" <?php if(isset($img)) echo 'src="img/'.$img.'"'?>></div>
        </div>
      <!--Button-->
        <div class="form-group row">
        <p class="col-sm-4"></p>
          <div class="col-sm-8 pl-0 pt-3">
            <input class="btn btn-color" type="submit" name="submit" value="Cập nhật">
            <a class="btn btn-secondary" href="account.php">Trở về</a>
          </div>
        </div>

    
    
      </form> 

    </div>

    <!----------------------- VIII. Footer -->
    <?php include('footer.php') ?>

  </body>
</html>

<?php 
    // mysqli_free_result($result);
    // mysqli_free_result($resultlq);
    // mysqli_close($conn);
?>