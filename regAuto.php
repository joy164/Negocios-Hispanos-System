<?php
    include 'modelo/conexion.php';
    session_start();
    if(!isset($_SESSION['id_user'])){
        header("location: index");
    }


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
  <!--plugins-->
  <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
  <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
  <link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
  <link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/bootstrap-extended.css" rel="stylesheet" />
  <link href="assets/css/style.css" rel="stylesheet" />
  <link href="assets/css/icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet" />
  <!--Theme Styles-->
  <link href="assets/css/dark-theme.css" rel="stylesheet" />
  <link href="assets/css/semi-dark.css" rel="stylesheet" />
  <link href="assets/css/header-colors.css" rel="stylesheet" />
  <!--Sweet Alert 2-->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="assets\js\alerts.js"></script>

  <title>Registrar Auto</title>
</head>

<body onload="nobackbutton();">
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
    <!--start top header-->
    <header class="top-header">        
        <nav class="navbar navbar-expand gap-3">
          <div class="mobile-toggle-icon fs-3">
              <i class="bi bi-list"></i>
            </div>
            <div class="top-navbar-right ms-auto">
              <ul class="navbar-nav align-items-center">
              <li class="nav-item dropdown dropdown-user-setting">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                  <div class="user-setting d-flex align-items-center">
                    <i class="bi bi-grid-3x3-gap-fill"></i>
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li>
                     <a class="dropdown-item" href="#">
                       <div class="d-flex align-items-center">
                          <div class="ms-3">
                            <h6 class="mb-0 dropdown-user-name"><?= $_SESSION["correo"]?></h6>
                            <small class="mb-0 dropdown-user-designation text-secondary"><?=$_SESSION["id_rol"] == 1?'Administrador':'Dealer'?></small>
                          </div>
                       </div>
                     </a>
                   </li>
                   <li><hr class="dropdown-divider"></li>
                   <!--User Menu-->
                   <?php if($_SESSION['id_rol'] == 1):?>
                    <li>
                      <a class="dropdown-item" href="#">
                         <div class="d-flex align-items-center">
                           <div class=""><i class="bi bi-person-fill"></i></div>
                           <div class="ms-3"><span>Profile</span></div>
                         </div>
                       </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                         <div class="d-flex align-items-center">
                           <div class=""><i class="lni lni-files"></i></div>
                           <div class="ms-3"><span>Contracts</span></div>
                         </div>
                       </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                         <div class="d-flex align-items-center">
                           <div class=""><i class="lni lni-network"></i></div>
                           <div class="ms-3"><span>Users</span></div>
                         </div>
                       </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                      <a class="dropdown-item" href="#">
                         <div class="d-flex align-items-center">
                           <div class=""><i class="bi bi-lock-fill"></i></div>
                           <div class="ms-3"><span>Logout</span></div>
                         </div>
                       </a>
                    </li>
                   <?php else:?>
                    <li>
                      <a class="dropdown-item" href="#">
                         <div class="d-flex align-items-center">
                           <div class=""><i class="bi bi-person-fill"></i></div>
                           <div class="ms-3"><span>Profile</span></div>
                         </div>
                       </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                      <a class="dropdown-item" href="#">
                         <div class="d-flex align-items-center">
                           <div class=""><i class="bi bi-lock-fill"></i></div>
                           <div class="ms-3"><span>Logout</span></div>
                         </div>
                       </a>
                    </li>                    
                   <?php endif;?>
                   <!--End User Menu-->                   
                </ul>
                </li>
              </ul>
              </div>
        </nav>
      </header>
     <!--end top header-->

       <!--start sidebar -->
       <aside class="sidebar-wrapper" data-simplebar="true">
          <div class="sidebar-header">
            <div>
                <a href="#"><img src="assets/images/Logo4.png" class="logo-icon" alt="logo icon"></a>
            </div>
            <div>
              <h4 class="logo-text">Negocios Hispanos</h4>
            </div>
            <div class="toggle-icon ms-auto"> <i class="bi bi-list"></i>
            </div>
        </div>
       </aside>
       <!--end sidebar -->
       
       <!--start content-->
          <main class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Functions</div>
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">New Contract</li>
                    <li class="breadcrumb-item active" aria-current="page">Vehicule Description</li>
                  </ol>
                </nav>
              </div>
            </div>
            <!--end breadcrumb-->
        <div class="row">
					<div class="col-xl-10 mx-auto">
            <div class="card">
              <div class="card-body">
                <div class="border p-3 rounded">
                <h6 class="mb-0 text-uppercase">Create Vehicle</h6>
                <label class="text-warning">For security, you cannot close the registration process until registration is complete</label>
                <hr/>
                <form class="row g-3" method="post" action="controlador/new_carro?id_contrato=<?=$_REQUEST['id_prestario']?>">
                  
                  <h6 class="mb-0 text-uppercase">Description</h6>
                  <div class="col-6">
                    <label class="form-label">* Year</label>
                    <input name="year" type="text" class="form-control" required>
                  </div>
                  <div class="col-6">
                    <label class="form-label">* Make</label>
                    <input name="make" type="text" class="form-control" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">* Model</label>
                    <input name="model" type="text" class="form-control" required>
                  </div>
                  <div class="col-6">
                    <label class="form-label">* Odometer</label>
                    <input name="odometer" type="text" class="form-control" required>
                  </div>
                  <div class="col-6">
                    <label class="form-label">* Color</label>
                    <input name="color" type="text" class="form-control" required>
                  </div>
                  <div class="col-6">
                    <label class="form-label">* Transmision</label>
                    <input name="transmision" type="text" class="form-control" required>
                  </div>
                  <hr/>
                  <h6 class="mb-0 text-uppercase">Documents</h6>
                  <div class="col-6">
                    <label class="form-label">* VIN</label>
                    <input name="vin" type="text" class="form-control" required>
                  </div>
                  <div class="col-6">
                    <label class="form-label">* No. de Licencia</label>
                    <input name="licencia" type="text" class="form-control" required>
                  </div>
                  <hr/>
                  <h6 class="mb-0 text-uppercase">Register Joint Persons</h6>
                  <div class="form-check">
									  <input name="coBorrower" class="form-check-input" type="checkbox" value="True" id="flexCheckDefault">
									  <label class="form-check-label" for="flexCheckDefault">Register Co-Borrower</label>
								  </div>
                  <div class="form-check">
									  <input name="coSigner" class="form-check-input" type="checkbox" value="True" id="flexCheckDefault">
									  <label class="form-check-label" for="flexCheckDefault">Register Co-Signer</label>
								  </div>
                  <hr/>
                  <label class="form-label">* datos obligatorios</label>
                  <div class="col-12">
                    <div class="d-grid">
                      <button name ="enviar" type="submit" class="btn btn-primary">Continue</button>
                    </div>
                  </div>
                </form>
              </div>
              </div>
            </div>
					</div>
				</div>
				<!--end row-->
      </main>
       <!--end page main-->
       <footer class="pie-pagina-index">
            <a href="#" class="logo-dino-cont">
                <img src="https://dinozign.com/firmas/webByDinozign_blanco.png" class="logo-dino" alt="Logo de Dinozign" />
            </a>
        </footer>
       <!--start overlay-->
        <div class="overlay nav-toggle-icon"></div>
       <!--end overlay-->

        <!--Start Back To Top Button-->
        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->

  </div>
  <!--end wrapper-->

  <!-- Bootstrap bundle JS -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <!--plugins-->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
  <script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
  <script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
  <script src="assets/js/pace.min.js"></script>
  <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
  <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
  <script src="assets/js/table-datatable.js"></script>
	
  <!--app-->
  <script src="assets/js/app.js"></script>
  

</body>

</html>