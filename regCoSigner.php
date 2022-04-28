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

  <title>Registrar Co-Signer</title>
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
                    <li class="breadcrumb-item active" aria-current="page">New Co-Signer</li>
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
                <h6 class="mb-0 text-uppercase">New Co-Signer</h6>
                <label class="text-warning">For security, you cannot close the registration process until registration is complete</label>
                <hr/>
                <form class="row g-3" method="post" action="controlador/new_coSigner?id_prestario=<?=$_REQUEST['id_prestario']?>" >
                <h6 class="mb-0 text-uppercase">Co-Signer</h6>
                  <div class="col-4">
                    <label class="form-label">* Name</label>
                    <input name="name" type="text" class="form-control" required>
                  </div>
                  <div class="col-4">
                    <label class="form-label"> Middle Name</label>
                    <input name="midName" type="text" class="form-control" >
                  </div>
                  <div class="col-4">
                    <label class="form-label">* lastName</label>
                    <input name="lastName" type="text" class="form-control" required>
                  </div>
                  
                  <div class="col-4">
										<label class="form-label">Date of Birth</label>
										<input name="DOF" type="date" class="form-control">
									</div>

                  <hr/>
                  
                  <h6 class="mb-0 text-uppercase">Address</h6>
                  <div class="col-12">
                    <label class="form-label">* Address</label>
                    <input name="address" type="text" class="form-control" required>
                  </div>
                  <div class="col-4">
                    <label class="form-label">* City</label>
                    <input name="city" type="text" class="form-control" required>
                  </div>
                  <div class="col-4">
                    <label class="form-label">* State</label>
                    <select name="state" class="form-select mb-3" aria-label=".form-select-sm example" required>
		    							<option value="" selected>Select State</option>
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
                    <input name="zip" type="text" class="form-control" required>
                  </div>
                  <hr/>
                  <h6 class="mb-0 text-uppercase">Contact</h6>
                  <div class="col-6">
                    <label class="form-label">Home Phone</label>
                    <input name="homePh" type="tel" class="form-control" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">* Cell Phone</label>
                    <input name="cellPh" type="tel" class="form-control" required>
                  </div>
                  <div class="col-12">
                    <label class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" >
                  </div>
                  
                  <hr/>
                  <h6 class="mb-0 text-uppercase">Employer</h6>
                  <div class="col-3">
                    <label class="form-label">* NSS</label>
                    <input name="NSS" type="text" class="form-control" required>
                  </div>
                  <div class="col-3">
                    <label class="form-label"> * Employer</label>
                    <input name="empleo" type="text" class="form-control" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">* address</label>
                    <input name="eDireccion" type="text" class="form-control" required>
                  </div>
                  <div class="col-4">
                    <label class="form-label">* city</label>
                    <input name="eCiudad" type="text" class="form-control" required>
                  </div>
                  <div class="col-4">
                    <label class="form-label">* State</label>
                    <select name="eState" class="form-select mb-3" aria-label=".form-select-sm example" required>
		    							<option value="" selected>Select State</option>
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
                    <input name="eZIP" type="text" class="form-control" required>
                  </div>
                  <div class="col-10">
                    <label class="form-label">*Phone</label>
                    <input name="eOffPh" type="text" class="form-control" required>
                  </div>
                  <div class="col-2">
                    <label class="form-label">* Ext.</label>
                    <input name="eExt" type="text" class="form-control" required>
                  </div>
                  <hr/>

                  <label class="form-label">* Required Field</label>
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