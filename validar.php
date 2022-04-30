<?php
    include 'modelo/conexion.php';
?>
<!doctype html>
<html lang="en" class="semi-dark">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="https://amigosprestamos.com/wp-content/uploads/2021/08/cropped-favicon-32x32.png" sizes="32x32" />
  <link rel="icon" href="https://amigosprestamos.com/wp-content/uploads/2021/08/cropped-favicon-192x192.png" sizes="192x192" />
  <link rel="apple-touch-icon" href="https://amigosprestamos.com/wp-content/uploads/2021/08/cropped-favicon-180x180.png" />
  <!-- Bootstrap CSS -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/bootstrap-extended.css" rel="stylesheet" />
  <link href="assets/css/style.css" rel="stylesheet" />
  <link href="assets/css/icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet" />
  <!--Sweet Alert 2-->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="assets\js\alerts.js"></script>

  <title>Iniciar Sesion</title>
</head>

<body>
  <?php if(isset($_REQUEST['error'])):?>
    <?php if($_REQUEST['error'] == True):?>
      <script>ErrorInicioContrato();</script> 
    <?php endif;?>
  <?php endif;?>

  <?php if(isset($_REQUEST['vis'])):?>
    <?php if($_REQUEST['vis'] == True):?>
      <script>ErrorInicioContrato2();</script> 
    <?php endif;?>
  <?php endif;?>

  <?php
      if(isset($_REQUEST['Reg'])){
        $res = $_REQUEST['Reg'];
        if(strcmp($res, "True") == 0){
          echo"<script>CorrCreateItem();</script>";
        }else{
          echo"<script>IncoCreateItem();</script>";
        }
      }
  ?>
  <!--start wrapper-->
  <div class="wrapper">
    
       <!--start content-->
       <main class="authentication-content">
        <div class="container-fluid">
          <div class="authentication-card">
            <div class="card shadow rounded-0 overflow-hidden">
              <div class="row g-0">
                <div class="col-lg-6 bg-login d-flex align-items-center justify-content-center">
                  <img src="assets/images/error/image-start.jpg" class="img-fluid" alt="">
                </div>
                <div class="col-lg-6">
                  <div class="card-body p-4 p-sm-5">
                    <h5 class="card-title">References</h5>
                    <form class="form-body" method="post" action="controlador/validarReferencias">
                      <div class="login-separater text-center mb-4"> <span>Log In with number contract</span>
                        <hr>
                      </div>
                        <div class="row g-3">
                          <div class="col-12">
                            <label for="inputEmailAddress" class="form-label">Enter number of contract to continue</label>
                            <div class="ms-auto position-relative">
                              <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="lni lni-magnifier"></i></div>
                              <input name="correoF" type="text" class="form-control radius-30 ps-5" id="inputEmailAddress" placeholder="contract" Required>
                            </div>
                          </div>
                          <div class="col-12">
                            <div class="d-grid">
                              <button type="submit" class="btn btn-primary radius-30">Login</button>
                            </div>
                          </div>
                        </div>
                    </form>
                 </div>
                </div>
              </div>
            </div>
          </div>
        </div>
       </main>
 
       <!--end page main-->
  </div>
  <!--end wrapper-->


  <!--plugins-->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/pace.min.js"></script>

  <footer class="pie-pagina-index">
            <a href="https://dinozign.com/" class="logo-dino-cont">
                <img src="https://dinozign.com/firmas/webByDinozign_blanco.png" class="logo-dino" alt="Logo de Dinozign" />
            </a>
  </footer>   

</body>

</html>