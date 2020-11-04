<?php 
    require_once('db_config/db_connect.php');

    $sql_new = 'Select * from glasses where new = 1';
    $result_new = mysqli_query($conn,$sql_new);

    $sql_sale = 'Select * from glasses where sale_price is not null';
    $result_sale = mysqli_query($conn,$sql_sale);

?>

<!doctype html>
<html lang="en">
  <head>
    <title>Mắt Kính Duy Hoàng</title>
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
    <script src="code.js"></script>
  </head>
  <body>
    <!----------------------- I. CREATE MENU -->
    <?php include('header.php') ?>

    <!----------------------- II. CREATE CAROUSEL -->
    <div class="carousel slide" data-ride="carousel" id="slides">
        <!-- Thanh nhỏ ở dưới để chuyển ảnh slide -->
        <ul class="carousel-indicators">
            <li data-target="#slides" data-slide-to="0" class="active"></li>
            <li data-target="#slides" data-slide-to="1"></li>
            <li data-target="#slides" data-slide-to="2"></li>
        </ul>
        <!-- Ảnh -->
        <div class="carousel-inner">
            <div class="carousel-item  active">
                <img src="./img/slide1.jpg"  id="slide-after">
                <div class="carousel-caption">
                    <h2>CHÀO MỪNG ĐẾN VỚI MẮT KÍNH</h2>
                    <h1 class="display-2">DUY HOÀNG</h1>
                </div>
            </div>
            <div class="carousel-item">
                <img src="./img/slide2.jpg"  id="slide-after">
                <div class="carousel-caption">
                    <h1 class="display-4">MẪU KÍNH MỚI TỪ RAY-BAN</h1>
                    <button type="button" class="btn btn-outline-light btn-md">
                        Xem Thêm
                    </button>
                </div>
            </div>
            <div class="carousel-item">
                <img src="./img/slide3.jpg"  id="slide-after">
                <div class="carousel-caption">
                    <h1 class="display-4">TOP BÁN CHẠY 2020</h1>
                    <button type="button" class="btn btn-outline-light btn-md">
                        Xem Thêm
                    </button>
                </div>
            </div>

            <a class="carousel-control-prev" href="#slides" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#slides" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
        </div>
    </div>

    <div class="container">
    <!----------------------- III. San Pham Moi -->
        <div class="container-fluid padding pt-5">
        <div>
            <h2 class="text-center text-color"><i class="fa fa-tag"></i>  SẢN PHẨM MỚI</h2>
            <hr id="hra">
        </div>
        <div class="row">
            <?php 
                if(mysqli_num_rows($result_new) > 0)
                {
                    while($row = mysqli_fetch_array($result_new))
                    {
                        echo '
                        <div class="col-md-3 product_item">
                            <a href="detail.php?id='.$row['id'].'"><img class="product_image" src="./img/'.$row['image'].'"></a>
                            <h3 class="text-color">'.$row['name'].'</h3>
                            <p class="price">'.number_format($row['normal_price']).' VND</p>
                            <button class="btn bg-color text-white">Thêm vào <i class="fa fa-shopping-cart"></i> </button>
                        </div>
                        ';
                    }
                }
            ?>
        </div>
        </div>

    <!----------------------- III. San Pham Sale -->
    <div class="container-fluid padding pt-5">
        <div>
            <h2 class="text-center text-color">SẢN PHẨM GIẢM GIÁ </h2>
            <hr id="hra">
        </div>
        <div class="row">
            <?php 
                if(mysqli_num_rows($result_sale) > 0)
                {
                    while($row = mysqli_fetch_array($result_sale))
                    {
                        echo '
                        <div class="col-md-3 product_item">
                            <a href="detail.php?id='.$row['id'].'"><img class="product_image" src="./img/'.$row['image'].'"></a>
                            <h3 class="text-color">'.$row['name'].'</h3>
                            <p class="rating">
                                Đánh giá: ';
                                for($i=0; $i<$row['rating']; $i++)
                                    echo ' <i class="fa fa-star"></i>'; 
                            echo'</p>
                            <p class="price">
                                <del>'.number_format($row['normal_price']).' VND</del>
                                <span class="text-danger">'.number_format($row['sale_price']).' VND</span>
                            </p>
                            <button class="btn bg-color text-white">Thêm vào <i class="fa fa-shopping-cart"></i> </button>
                        </div>
                        ';
                    }
                }
            ?>
        </div>
        </div>    
    </div>
  

<!----------------------- VII. Contact -->
<br id="cont">
<div class="container-fluid">
    <div class="row">
        <div class="col-12 text-center ">
            <h2 class="text-center">LIÊN HỆ</h2>
            <hr id="hra">
        </div>
        <div class="col-12 social text-center">
            <i class="fa fa-facebook" aria-hidden="true"></i>
            <i class="fa fa-phone" aria-hidden="true"></i>
            <i class="fa fa-twitter" aria-hidden="true"></i>
            <i class="fa fa-envelope" aria-hidden="true"></i>
            <i class="fa fa-comment" aria-hidden="true"></i>
        </div>
    </div>
</div>
</div>
<!----------------------- VIII. Footer -->
<?php include('footer.php') ?>
</body>
</html>

<?php 
    mysqli_free_result($result_new);
    mysqli_free_result($result_sale);
    mysqli_close($conn);
?>