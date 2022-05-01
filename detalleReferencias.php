<?php
    include 'modelo/conexion.php';
    session_start();
    if(!isset($_SESSION['id_user'])){
        header("location: index");
    }
    
    $id_contrato = $_REQUEST['id_prestario'];

    $consulta = $conn->prepare("SELECT * FROM prestarios WHERE id_prestario = ?");
    $consulta->bind_param('s', $id_contrato);
    $consulta->execute();

    $resultado = $consulta->get_result();
    $datosPrestario = $resultado->fetch_assoc();
    
    $consulta = $conn->prepare("SELECT * FROM db_deal.referencias WHERE idReferencia = ?");                                        
    $consulta->bind_param('i', $datosPrestario['id_referencia']);
    $consulta->execute();

    $resultado = $consulta->get_result();
    $datosReferencias = $resultado->fetch_assoc();
    
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

  <title>Borrower Details</title>
</head>

<body>
<?php  
    if(isset($_REQUEST['Actualizado'])){
      $resultado = $_REQUEST['Actualizado'];
      if(strcmp($resultado, "True") == 0){
        echo"<script>CorrUpdateItem();</script>";
      }else{
        echo"<script>IncoUpdateItem();</script>";
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
                    <div class="d-flex align-items-center">
                      <div class="ms-3">
                        <h6 class="mb-0 dropdown-user-name"><?= $_SESSION["correo"]?></h6>
                        <?php  if($_SESSION['id_rol'] == 1):?>
                          <small class="mb-0 dropdown-user-designation text-secondary">Admin</small>
                        <?php  elseif($_SESSION['id_rol'] == 2):?>
                          <small class="mb-0 dropdown-user-designation text-secondary">Amigos Prestamos Personal</small>
                        <?php else:?>
                          <small class="mb-0 dropdown-user-designation text-secondary">Dealer</small>
                        <?php endif;?>
                      </div>
                    </div>
                   </li>
                   <li><hr class="dropdown-divider"></li>
                   <!--User Menu-->
                   <!--User Menu Admin-->
                  <?php if($_SESSION['id_rol'] == 1):?>
                    <li>
                      <a class="dropdown-item" href="perfil">
                         <div class="d-flex align-items-center">
                           <div class=""><i class="bi bi-person-fill"></i></div>
                           <div class="ms-3"><span>Profile</span></div>
                         </div>
                       </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="regPrestamos">
                         <div class="d-flex align-items-center">
                           <div class=""><i class="lni lni-files"></i></div>
                           <div class="ms-3"><span>Contracts</span></div>
                         </div>
                       </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="regDeal">
                         <div class="d-flex align-items-center">
                           <div class=""><i class="lni lni-network"></i></div>
                           <div class="ms-3"><span>Users</span></div>
                         </div>
                       </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                      <a class="dropdown-item" href="controlador/dest_sesion">
                         <div class="d-flex align-items-center">
                           <div class=""><i class="bi bi-lock-fill"></i></div>
                           <div class="ms-3"><span>Logout</span></div>
                         </div>
                       </a>
                    </li>
                    <!--User Menu Amigos Prestamos Personal-->
                   <?php elseif($_SESSION['id_rol'] == 2):?>
                    <li>
                      <a class="dropdown-item" href="perfil">
                         <div class="d-flex align-items-center">
                           <div class=""><i class="bi bi-person-fill"></i></div>
                           <div class="ms-3"><span>Profile</span></div>
                         </div>
                       </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="regPrestamos">
                         <div class="d-flex align-items-center">
                           <div class=""><i class="lni lni-files"></i></div>
                           <div class="ms-3"><span>Contracts</span></div>
                         </div>
                       </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                      <a class="dropdown-item" href="controlador/dest_sesion">
                         <div class="d-flex align-items-center">
                           <div class=""><i class="bi bi-lock-fill"></i></div>
                           <div class="ms-3"><span>Logout</span></div>
                         </div>
                       </a>
                    </li>        
                  <!--User Menu Dealer-->            
                  <?php else:?>
                      <li>
                        <a class="dropdown-item" href="perfil">
                          <div class="d-flex align-items-center">
                            <div class=""><i class="bi bi-person-fill"></i></div>
                            <div class="ms-3"><span>Profile</span></div>
                          </div>
                        </a>
                      </li>
                      <li><hr class="dropdown-divider"></li>
                      <li>
                        <a class="dropdown-item" href="controlador/dest_sesion">
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
                <a href="init"><img src="assets/images/Logo4.png" class="logo-icon" alt="logo icon"></a>
            </div>
            <div>
              <h4 class="logo-text">Negocios Hispanos</h4>
            </div>
            <div class="toggle-icon ms-auto"> <i class="bi bi-list"></i>
            </div>
          </div>
          <!--navigation-->
          <!--sidebar Admin-->
          <?php if($_SESSION['id_rol'] == 1):?>
            <ul class="metismenu" id="menu">
            <li class="menu-label">Functions</li> 
            <li>
                <a href="newBorrower">
                  <div class="parent-icon"><i class="lni lni-empty-file"></i></div>
                  <div class="menu-title">New Borrower</div>
                </a>
              </li>
              <a href="newAdmin">
                  <div class="parent-icon"><i class="lni lni-plus"></i></div>
                  <div class="menu-title">New Admin</div>
              </a>
              <a href="newPersonal">
                  <div class="parent-icon"><i class="lni lni-plus"></i></div>
                  <div class="menu-title">New A.P. Personal</div>
              </a>
              <a href="newDealer">
                  <div class="parent-icon"><i class="lni lni-plus"></i></div>
                  <div class="menu-title">New Dealer</div>
              </a>
              <li class="menu-label">Registration</li> 
              <li>
                <a href="regDeal">
                  <div class="parent-icon"><i class="lni lni-network"></i></div>
                  <div class="menu-title">Users</div>
                </a>
              </li>
              <li>
                <a href="regPrestamos">
                  <div class="parent-icon"><i class="lni lni-files"></i></div>
                  <div class="menu-title">Contracts</div>
                </a>
              </li>  
              <li class="menu-label">Others</li>
              <li>
                <a href="perfil">
                  <div class="parent-icon"><i class="bi bi-person-fill"></i></div>
                  <div class="menu-title">User Profile</div>
                </a>
              </li>
          <!--sidebar Amigos Prestamos Personal-->
          <?php elseif($_SESSION['id_rol'] == 2):?>            
            <ul class="metismenu" id="menu">
            <li class="menu-label">Functions</li> 
            <li>
                <a href="newBorrower">
                  <div class="parent-icon"><i class="lni lni-empty-file"></i></div>
                  <div class="menu-title">New Borrower</div>
                </a>
              </li>
              <li class="menu-label">Registration</li> 
              <li>
                <a href="regPrestamos">
                  <div class="parent-icon"><i class="lni lni-files"></i></div>
                  <div class="menu-title">Contracts</div>
                </a>
              </li>  
              <li class="menu-label">Others</li>
              <li>
                <a href="perfil">
                  <div class="parent-icon"><i class="bi bi-person-fill"></i></div>
                  <div class="menu-title">User Profile</div>
                </a>
              </li>
          <!--sidebar Dealer-->
          <?php else: ?>
            <ul class="metismenu" id="menu">
            <li class="menu-label">Functions</li> 
            <li>
                <a href="newBorrower">
                  <div class="parent-icon"><i class="lni lni-empty-file"></i></div>
                  <div class="menu-title">New Borrower</div>
                </a>
              </li>
              <li class="menu-label">Others</li>
              <li>
                <a href="perfil">
                  <div class="parent-icon"><i class="bi bi-person-fill"></i></div>
                  <div class="menu-title">User Profile</div>
                </a>
              </li>              
          <?php endif;?>            
          <!--end navigation-->
       </aside>
       <!--end sidebar -->

       <!--start content-->
          <main class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title2 pe-3">Contract</div>
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="init.php"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Borrower Details</li>
                  </ol>
                </nav>
              </div>
            </div>

            <!--end breadcrumb-->
            <div class="row">
              <div class="col-xl-10 mx-auto">
                <div class="card shadow-sm border-0">
                  <div class="card-body">
                      <?php if($datosPrestario["numContrato"] == 0):?>
                        <h5 class="mb-0">Pre-Borrower #<?=$datosPrestario["id_prestario"]?> References</h5>
                      <?php else:?>
                        <h5 class="mb-0">Borrower #<?=$datosPrestario["numContrato"]?> References</h5>
                      <?php endif;?>                        
                      <hr>
                      <div class="col-20 col-lg-12 text-md-end">
                        <a href="detalleBorrower?id_prestario=<?=$datosPrestario["id_prestario"]?>" class="btn btn-sm btn-primary"> <i class="lni lni-angle-double-left"></i> Return</a>                            
                      </div>
                      <br>
                      <form action="controlador/editReferencias?id_prestario=<?=$datosPrestario['id_prestario']?>" method="post">
                        <!--Primera referencia-->
                        <div class="card shadow-none border">
                        <div class="card-header">
                            <h6 class="mb-0 text-uppercase">* Borrower references #1</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                            <h6 class="mb-0">Reference</h6>
                            <div class="col-6">
                                <label class="form-label">Name</label>
                                <input name="name1" type="text" class="form-control" value="<?=$datosReferencias['Nombre1']?>">
                            </div>
                            <div class="col-6">
                                <label class="form-label">relationship</label>
                                <input name="rel1" type="text" class="form-control" value="<?=$datosReferencias['relacion1']?>">
                            </div>
                            <hr><h6 class="mb-0">Address</h6>
                            <div class="col-12">
                                <label class="form-label">* Address</label>
                                <input name="dir1" type="text" class="form-control" value="<?=$datosReferencias['direccion1']?>">
                            </div>
                            <div class="col-4">
                                <label class="form-label">* City</label>
                                <input name="city1" type="text" class="form-control" value="<?=$datosReferencias['ciudad1']?>">
                            </div>
                            <div class="col-4">
                                <label class="form-label">* State</label>
                                <select name="state1" class="form-select mb-3" aria-label=".form-select-sm example" >
                                <option value="" selected>Select state</option>
                                <option value="AZ">Arizona</option>
                                <option value="AL">Alabama</option>
                                <option value="AK">Alaska</option>
                                <option value="AR">Arkansas</option>
                                <option value="CA">California</option>
                                <option value="CO">Colorado</option>
                                <option value="CT">Connecticut</option>
                                <option value="DE">Delaware</option>
                                <option value="DC">Distrito de Columbia</option>
                                <option value="FL">Florida</option>
                                <option value="GA">Georgia</option>
                                <option value="HI">Hawaii</option>
                                <option value="ID">Idaho</option>
                                <option value="IL">Illinois</option>
                                <option value="IN">Indiana</option>
                                <option value="IA">Iowa</option>
                                <option value="KS">Kansas</option>
                                <option value="KY">Kentucky</option>
                                <option value="LA">Louisiana</option>
                                <option value="ME">Maine</option>
                                <option value="MD">Maryland</option>
                                <option value="MA">Massachusetts</option>
                                <option value="MI">Michigan</option>
                                <option value="MN">Minnesota</option>
                                <option value="MS">Mississippi</option>
                                <option value="MO">Missouri</option>  
                                <option value="MT">Montana</option>
                                <option value="NE">Nebraska</option>
                                <option value="NV">Nevada</option>
                                <option value="NH">New Hampshire</option>
                                <option value="NJ">New Jersey</option>
                                <option value="NM">New Mexico</option>
                                <option value="NY">New York</option>
                                <option value="NC">North Carolina</option>
                                <option value="ND">North Dakota</option>
                                <option value="OH">Ohio</option>
                                <option value="PK">Oklahoma</option>
                                <option value="OR">Oregon</option>
                                <option value="PA">Pennsylvania</option>
                                <option value="RI">Rhode Island</option>
                                <option value="SC">South Carolina</option>
                                <option value="SD">South Dakota</option>
                                <option value="TN">Tennessee</option>
                                <option value="TX">Texas</option>
                                <option value="UT">Utah</option>
                                <option value="VT">Vermont</option>
                                <option value="VA">Virginia</option>
                                <option value="WA">Washington</option>
                                <option value="WV">West Virginia</option>
                                <option value="WI">Wisconsin</option>
                                <option value="WY">Wyoming</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label class="form-label">* ZIP</label>
                                <input name="zip1" type="text" class="form-control" value="<?=$datosReferencias['ZIP1']?>">
                            </div>
                            <hr/>
                            <h6 class="mb-0">Contact</h6>
                            <div class="col-6">
                                <label class="form-label">Home Phone</label>
                                <input name="homePh1" type="tel" class="form-control"value="<?=$datosReferencias['homePh1']?>" >
                            </div>
                            <div class="col-6">
                                <label class="form-label">* Cell Phone</label>
                                <input name="cellPh1" type="tel" class="form-control" value="<?=$datosReferencias['cellPh1']?>">
                            </div>
                            </div>
                        </div>
                        </div><hr>
                        <!--Segunda referencia-->
                        <div class="card shadow-none border">
                        <div class="card-header">
                            <h6 class="mb-0 text-uppercase">* Borrower references #2</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                            <h6 class="mb-0">Reference</h6>
                            <div class="col-6">
                                <label class="form-label">Name</label>
                                <input name="name2" type="text" class="form-control" value="<?=$datosReferencias['Nombre2']?>">
                            </div>
                            <div class="col-6">
                                <label class="form-label">relationship</label>
                                <input name="rel2" type="text" class="form-control" value="<?=$datosReferencias['relacion2']?>">
                            </div>
                            <hr><h6 class="mb-0">Address</h6>
                            <div class="col-12">
                                <label class="form-label">* Address</label>
                                <input name="dir2" type="text" class="form-control" value="<?=$datosReferencias['direccion2']?>">
                            </div>
                            <div class="col-4">
                                <label class="form-label">* City</label>
                                <input name="city2" type="text" class="form-control" value="<?=$datosReferencias['ciudad2']?>">
                            </div>
                            <div class="col-4">
                                <label class="form-label">* State</label>
                                <select name="state2" class="form-select mb-3" aria-label=".form-select-sm example" >
                                <option value="" selected>Select state</option>
                                <option value="AZ">Arizona</option>
                                <option value="AL">Alabama</option>
                                <option value="AK">Alaska</option>
                                <option value="AR">Arkansas</option>
                                <option value="CA">California</option>
                                <option value="CO">Colorado</option>
                                <option value="CT">Connecticut</option>
                                <option value="DE">Delaware</option>
                                <option value="DC">Distrito de Columbia</option>
                                <option value="FL">Florida</option>
                                <option value="GA">Georgia</option>
                                <option value="HI">Hawaii</option>
                                <option value="ID">Idaho</option>
                                <option value="IL">Illinois</option>
                                <option value="IN">Indiana</option>
                                <option value="IA">Iowa</option>
                                <option value="KS">Kansas</option>
                                <option value="KY">Kentucky</option>
                                <option value="LA">Louisiana</option>
                                <option value="ME">Maine</option>
                                <option value="MD">Maryland</option>
                                <option value="MA">Massachusetts</option>
                                <option value="MI">Michigan</option>
                                <option value="MN">Minnesota</option>
                                <option value="MS">Mississippi</option>
                                <option value="MO">Missouri</option>  
                                <option value="MT">Montana</option>
                                <option value="NE">Nebraska</option>
                                <option value="NV">Nevada</option>
                                <option value="NH">New Hampshire</option>
                                <option value="NJ">New Jersey</option>
                                <option value="NM">New Mexico</option>
                                <option value="NY">New York</option>
                                <option value="NC">North Carolina</option>
                                <option value="ND">North Dakota</option>
                                <option value="OH">Ohio</option>
                                <option value="PK">Oklahoma</option>
                                <option value="OR">Oregon</option>
                                <option value="PA">Pennsylvania</option>
                                <option value="RI">Rhode Island</option>
                                <option value="SC">South Carolina</option>
                                <option value="SD">South Dakota</option>
                                <option value="TN">Tennessee</option>
                                <option value="TX">Texas</option>
                                <option value="UT">Utah</option>
                                <option value="VT">Vermont</option>
                                <option value="VA">Virginia</option>
                                <option value="WA">Washington</option>
                                <option value="WV">West Virginia</option>
                                <option value="WI">Wisconsin</option>
                                <option value="WY">Wyoming</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label class="form-label">* ZIP</label>
                                <input name="zip2" type="text" class="form-control" value="<?=$datosReferencias['ZIP2']?>">
                            </div>
                            <hr/>
                            <h6 class="mb-0">Contact</h6>
                            <div class="col-6">
                                <label class="form-label">Home Phone</label>
                                <input name="homePh2" type="tel" class="form-control" value="<?=$datosReferencias['homePh2']?>">
                            </div>
                            <div class="col-6">
                                <label class="form-label">* Cell Phone</label>
                                <input name="cellPh2" type="tel" class="form-control" value="<?=$datosReferencias['cellPh2']?>">
                            </div>
                            </div>
                        </div>
                        </div><hr>
                        <!--Tercera referencia-->
                        <div class="card shadow-none border">
                        <div class="card-header">
                            <h6 class="mb-0 text-uppercase">* Borrower references #3</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                            <h6 class="mb-0">Reference</h6>
                            <div class="col-6">
                                <label class="form-label">Name</label>
                                <input name="name3" type="text" class="form-control" value="<?=$datosReferencias['Nombre3']?>">
                            </div>
                            <div class="col-6">
                                <label class="form-label">relationship</label>
                                <input name="rel3" type="text" class="form-control" value="<?=$datosReferencias['relacion3']?>">
                            </div>
                            <hr><h6 class="mb-0">Address</h6>
                            <div class="col-12">
                                <label class="form-label">* Address</label>
                                <input name="dir3" type="text" class="form-control" value="<?=$datosReferencias['direccion3']?>">
                            </div>
                            <div class="col-4">
                                <label class="form-label">* City</label>
                                <input name="city3" type="text" class="form-control" value="<?=$datosReferencias['ciudad3']?>">
                            </div>
                            <div class="col-4">
                                <label class="form-label">* State</label>
                                <select name="state3" class="form-select mb-3" aria-label=".form-select-sm example" >
                                <option value="" selected>Select state</option>
                                <option value="AZ">Arizona</option>
                                <option value="AL">Alabama</option>
                                <option value="AK">Alaska</option>
                                <option value="AR">Arkansas</option>
                                <option value="CA">California</option>
                                <option value="CO">Colorado</option>
                                <option value="CT">Connecticut</option>
                                <option value="DE">Delaware</option>
                                <option value="DC">Distrito de Columbia</option>
                                <option value="FL">Florida</option>
                                <option value="GA">Georgia</option>
                                <option value="HI">Hawaii</option>
                                <option value="ID">Idaho</option>
                                <option value="IL">Illinois</option>
                                <option value="IN">Indiana</option>
                                <option value="IA">Iowa</option>
                                <option value="KS">Kansas</option>
                                <option value="KY">Kentucky</option>
                                <option value="LA">Louisiana</option>
                                <option value="ME">Maine</option>
                                <option value="MD">Maryland</option>
                                <option value="MA">Massachusetts</option>
                                <option value="MI">Michigan</option>
                                <option value="MN">Minnesota</option>
                                <option value="MS">Mississippi</option>
                                <option value="MO">Missouri</option>  
                                <option value="MT">Montana</option>
                                <option value="NE">Nebraska</option>
                                <option value="NV">Nevada</option>
                                <option value="NH">New Hampshire</option>
                                <option value="NJ">New Jersey</option>
                                <option value="NM">New Mexico</option>
                                <option value="NY">New York</option>
                                <option value="NC">North Carolina</option>
                                <option value="ND">North Dakota</option>
                                <option value="OH">Ohio</option>
                                <option value="PK">Oklahoma</option>
                                <option value="OR">Oregon</option>
                                <option value="PA">Pennsylvania</option>
                                <option value="RI">Rhode Island</option>
                                <option value="SC">South Carolina</option>
                                <option value="SD">South Dakota</option>
                                <option value="TN">Tennessee</option>
                                <option value="TX">Texas</option>
                                <option value="UT">Utah</option>
                                <option value="VT">Vermont</option>
                                <option value="VA">Virginia</option>
                                <option value="WA">Washington</option>
                                <option value="WV">West Virginia</option>
                                <option value="WI">Wisconsin</option>
                                <option value="WY">Wyoming</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label class="form-label">* ZIP</label>
                                <input name="zip3" type="text" class="form-control" value="<?=$datosReferencias['ZIP3']?>">
                            </div>
                            <hr/>
                            <h6 class="mb-0">Contact</h6>
                            <div class="col-6">
                                <label class="form-label">Home Phone</label>
                                <input name="homePh3" type="tel" class="form-control" value="<?=$datosReferencias['homePh3']?>">
                            </div>
                            <div class="col-6">
                                <label class="form-label">* Cell Phone</label>
                                <input name="cellPh3" type="tel" class="form-control" value="<?=$datosReferencias['cellPh3']?>">
                            </div>
                            </div>
                        </div>
                        </div><hr>
                        <!--Cuarta referencia-->
                        <div class="card shadow-none border">
                        <div class="card-header">
                            <h6 class="mb-0 text-uppercase">* Borrower references #4</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                            <h6 class="mb-0">Reference</h6>
                            <div class="col-6">
                                <label class="form-label">Name</label>
                                <input name="name4" type="text" class="form-control" value="<?=$datosReferencias['Nombre4']?>">
                            </div>
                            <div class="col-6">
                                <label class="form-label">relationship</label>
                                <input name="rel4" type="text" class="form-control" value="<?=$datosReferencias['relacion4']?>">
                            </div>
                            <hr><h6 class="mb-0">Address</h6>
                            <div class="col-12">
                                <label class="form-label">* Address</label>
                                <input name="dir4" type="text" class="form-control" value="<?=$datosReferencias['direccion4']?>">
                            </div>
                            <div class="col-4">
                                <label class="form-label">* City</label>
                                <input name="city4" type="text" class="form-control" value="<?=$datosReferencias['ciudad4']?>">
                            </div>
                            <div class="col-4">
                                <label class="form-label">* State</label>
                                <select name="state4" class="form-select mb-3" aria-label=".form-select-sm example" >
                                <option value=" " selected>Select state</option>
                                <option value="AZ">Arizona</option>
                                <option value="AL">Alabama</option>
                                <option value="AK">Alaska</option>
                                <option value="AR">Arkansas</option>
                                <option value="CA">California</option>
                                <option value="CO">Colorado</option>
                                <option value="CT">Connecticut</option>
                                <option value="DE">Delaware</option>
                                <option value="DC">Distrito de Columbia</option>
                                <option value="FL">Florida</option>
                                <option value="GA">Georgia</option>
                                <option value="HI">Hawaii</option>
                                <option value="ID">Idaho</option>
                                <option value="IL">Illinois</option>
                                <option value="IN">Indiana</option>
                                <option value="IA">Iowa</option>
                                <option value="KS">Kansas</option>
                                <option value="KY">Kentucky</option>
                                <option value="LA">Louisiana</option>
                                <option value="ME">Maine</option>
                                <option value="MD">Maryland</option>
                                <option value="MA">Massachusetts</option>
                                <option value="MI">Michigan</option>
                                <option value="MN">Minnesota</option>
                                <option value="MS">Mississippi</option>
                                <option value="MO">Missouri</option>  
                                <option value="MT">Montana</option>
                                <option value="NE">Nebraska</option>
                                <option value="NV">Nevada</option>
                                <option value="NH">New Hampshire</option>
                                <option value="NJ">New Jersey</option>
                                <option value="NM">New Mexico</option>
                                <option value="NY">New York</option>
                                <option value="NC">North Carolina</option>
                                <option value="ND">North Dakota</option>
                                <option value="OH">Ohio</option>
                                <option value="PK">Oklahoma</option>
                                <option value="OR">Oregon</option>
                                <option value="PA">Pennsylvania</option>
                                <option value="RI">Rhode Island</option>
                                <option value="SC">South Carolina</option>
                                <option value="SD">South Dakota</option>
                                <option value="TN">Tennessee</option>
                                <option value="TX">Texas</option>
                                <option value="UT">Utah</option>
                                <option value="VT">Vermont</option>
                                <option value="VA">Virginia</option>
                                <option value="WA">Washington</option>
                                <option value="WV">West Virginia</option>
                                <option value="WI">Wisconsin</option>
                                <option value="WY">Wyoming</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label class="form-label">* ZIP</label>
                                <input name="zip4" type="text" class="form-control" value="<?=$datosReferencias['ZIP4']?>">
                            </div>
                            <hr/>
                            <h6 class="mb-0">Contact</h6>
                            <div class="col-6">
                                <label class="form-label">Home Phone</label>
                                <input name="homePh4" type="tel" class="form-control" value="<?=$datosReferencias['homePh4']?>">
                            </div>
                            <div class="col-6">
                                <label class="form-label">* Cell Phone</label>
                                <input name="cellPh4" type="tel" class="form-control" value="<?=$datosReferencias['cellPh4']?>">
                            </div>
                            </div>
                        </div>
                        </div><hr>
                        <!--Quinta referencia-->
                        <div class="card shadow-none border">
                        <div class="card-header">
                            <h6 class="mb-0 text-uppercase">* Borrower references #5</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                            <h6 class="mb-0">Reference</h6>
                            <div class="col-6">
                                <label class="form-label">Name</label>
                                <input name="name5" type="text" class="form-control" value="<?=$datosReferencias['Nombre5']?>">
                            </div>
                            <div class="col-6">
                                <label class="form-label">relationship</label>
                                <input name="rel5" type="text" class="form-control" value="<?=$datosReferencias['relacion5']?>">
                            </div>
                            <hr><h6 class="mb-0">Address</h6>
                            <div class="col-12">
                                <label class="form-label">* Address</label>
                                <input name="dir5" type="text" class="form-control" value="<?=$datosReferencias['direccion5']?>">
                            </div>
                            <div class="col-4">
                                <label class="form-label">* City</label>
                                <input name="city5" type="text" class="form-control" value="<?=$datosReferencias['ciudad5']?>">
                            </div>
                            <div class="col-4">
                                <label class="form-label">* State</label>
                                <select name="state5" class="form-select mb-3" aria-label=".form-select-sm example" >
                                <option value=" " selected>Select state</option>
                                <option value="AZ">Arizona</option>
                                <option value="AL">Alabama</option>
                                <option value="AK">Alaska</option>
                                <option value="AR">Arkansas</option>
                                <option value="CA">California</option>
                                <option value="CO">Colorado</option>
                                <option value="CT">Connecticut</option>
                                <option value="DE">Delaware</option>
                                <option value="DC">Distrito de Columbia</option>
                                <option value="FL">Florida</option>
                                <option value="GA">Georgia</option>
                                <option value="HI">Hawaii</option>
                                <option value="ID">Idaho</option>
                                <option value="IL">Illinois</option>
                                <option value="IN">Indiana</option>
                                <option value="IA">Iowa</option>
                                <option value="KS">Kansas</option>
                                <option value="KY">Kentucky</option>
                                <option value="LA">Louisiana</option>
                                <option value="ME">Maine</option>
                                <option value="MD">Maryland</option>
                                <option value="MA">Massachusetts</option>
                                <option value="MI">Michigan</option>
                                <option value="MN">Minnesota</option>
                                <option value="MS">Mississippi</option>
                                <option value="MO">Missouri</option>  
                                <option value="MT">Montana</option>
                                <option value="NE">Nebraska</option>
                                <option value="NV">Nevada</option>
                                <option value="NH">New Hampshire</option>
                                <option value="NJ">New Jersey</option>
                                <option value="NM">New Mexico</option>
                                <option value="NY">New York</option>
                                <option value="NC">North Carolina</option>
                                <option value="ND">North Dakota</option>
                                <option value="OH">Ohio</option>
                                <option value="PK">Oklahoma</option>
                                <option value="OR">Oregon</option>
                                <option value="PA">Pennsylvania</option>
                                <option value="RI">Rhode Island</option>
                                <option value="SC">South Carolina</option>
                                <option value="SD">South Dakota</option>
                                <option value="TN">Tennessee</option>
                                <option value="TX">Texas</option>
                                <option value="UT">Utah</option>
                                <option value="VT">Vermont</option>
                                <option value="VA">Virginia</option>
                                <option value="WA">Washington</option>
                                <option value="WV">West Virginia</option>
                                <option value="WI">Wisconsin</option>
                                <option value="WY">Wyoming</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label class="form-label">* ZIP</label>
                                <input name="zip5" type="text" class="form-control" value="<?=$datosReferencias['ZIP5']?>">
                            </div>
                            <hr/>
                            <h6 class="mb-0">Contact</h6>
                            <div class="col-6">
                                <label class="form-label">Home Phone</label>
                                <input name="homePh5" type="tel" class="form-control" value="<?=$datosReferencias['homePh5']?>">
                            </div>
                            <div class="col-6">
                                <label class="form-label">* Cell Phone</label>
                                <input name="cellPh5" type="tel" class="form-control" value="<?=$datosReferencias['cellPh5']?>">
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-20 col-lg-12 text-md-end">
                          <button name ="enviar" type="submit" class="btn btn-danger" title="Save changes"><i class="lni lni-save"> Save changes</i></button>
                        </div>
                      </form>                                      
                  </div>
                </div>
              </div>
            </div>
            <!--end row-->
          </main>
       <!--end page main-->
       <footer class="pie-pagina-index">
            <a href="https://dinozign.com/" class="logo-dino-cont">
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
  <!--app-->
  <script src="assets/js/app.js"></script>
  

</body>

</html>