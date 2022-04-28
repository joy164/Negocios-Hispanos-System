<?php
    include 'modelo/conexion.php';
    session_start();
    if(!isset($_REQUEST['id_contrato'])){
        header("location: validar");
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

  <title>Borrow's references</title>
</head>

<body>
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
    </header>
     <!--end top header-->

       <!--start sidebar -->
       <aside class="sidebar-wrapper" data-simplebar="false"></aside>
       <!--end sidebar -->

       <!--start content-->
          <main class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Register</div>
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item active" aria-current="page">References</li>
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
                <div class="col-10">
                    <div class="d-grid">
                      <a href="validar">
                        <button name ="enviar" type="submit" class="btn btn-warning">Cancel</button>
                      </a>
                    </div>
                    <br>
                </div>
                <h6 class="mb-0 text-uppercase">*Borrower references #1</h6>
                <hr/>
                <form class="row g-3" method="post" action="controlador/new_referencias" >
                  
                  <h6 class="mb-0 text-uppercase">Name</h6>
                  <div class="col-6">
                    <label class="form-label">* Name</label>
                    <input name="name" type="text" class="form-control" required>
                  </div>
                  <div class="col-6">
                    <label class="form-label">* relationship</label>
                    <input name="midName" type="text" class="form-control" required>
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
                  <hr/>
                  <h6 class="mb-0 text-uppercase">*Borrower references #2</h6>
                <hr/>
                <form class="row g-3" method="post" action="controlador/new_prestamo" >
                  
                  <h6 class="mb-0 text-uppercase">Name</h6>
                  <div class="col-6">
                    <label class="form-label">* Name</label>
                    <input name="name" type="text" class="form-control" required>
                  </div>
                  <div class="col-6">
                    <label class="form-label">* relationship</label>
                    <input name="midName" type="text" class="form-control" required>
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
                  <hr/>
                  <h6 class="mb-0 text-uppercase">*Borrower references #3</h6>
                <hr/>
                <form class="row g-3" method="post" action="controlador/new_prestamo" >
                  
                  <h6 class="mb-0 text-uppercase">Name</h6>
                  <div class="col-6">
                    <label class="form-label">* Name</label>
                    <input name="name" type="text" class="form-control" required>
                  </div>
                  <div class="col-6">
                    <label class="form-label">* relationship</label>
                    <input name="midName" type="text" class="form-control" required>
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
                  <hr/>
                  <h6 class="mb-0 text-uppercase">*Borrower references #4</h6>
                <hr/>
                <form class="row g-3" method="post" action="controlador/new_prestamo" >
                  
                  <h6 class="mb-0 text-uppercase">Name</h6>
                  <div class="col-6">
                    <label class="form-label">Name</label>
                    <input name="name" type="text" class="form-control" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">relationship</label>
                    <input name="midName" type="text" class="form-control" >
                  </div>
                  <hr/>
                  
                  <h6 class="mb-0 text-uppercase">Address</h6>
                  <div class="col-12">
                    <label class="form-label">Address</label>
                    <input name="address" type="text" class="form-control" >
                  </div>
                  <div class="col-4">
                    <label class="form-label">City</label>
                    <input name="city" type="text" class="form-control" >
                  </div>
                  <div class="col-4">
                    <label class="form-label">State</label>
                    <select name="state" class="form-select mb-3" aria-label=".form-select-sm example" >
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
                    <label class="form-label">ZIP</label>
                    <input name="zip" type="text" class="form-control">
                  </div>
                  <hr/>
                  <h6 class="mb-0 text-uppercase">Contact</h6>
                  <div class="col-6">
                    <label class="form-label">Home Phone</label>
                    <input name="homePh" type="tel" class="form-control" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Cell Phone</label>
                    <input name="cellPh" type="tel" class="form-control" >
                  </div>
                  <hr/>
                  <h6 class="mb-0 text-uppercase">*Borrower references #5</h6>
                <hr/>
                <form class="row g-3" method="post" action="controlador/new_prestamo" >
                  
                  <h6 class="mb-0 text-uppercase">Name</h6>
                  <div class="col-6">
                    <label class="form-label">Name</label>
                    <input name="name" type="text" class="form-control" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">relationship</label>
                    <input name="midName" type="text" class="form-control" >
                  </div>
                  <hr/>
                  
                  <h6 class="mb-0 text-uppercase">Address</h6>
                  <div class="col-12">
                    <label class="form-label">Address</label>
                    <input name="address" type="text" class="form-control">
                  </div>
                  <div class="col-4">
                    <label class="form-label">City</label>
                    <input name="city" type="text" class="form-control" >
                  </div>
                  <div class="col-4">
                    <label class="form-label">State</label>
                    <select name="state" class="form-select mb-3" aria-label=".form-select-sm example" >
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
                    <label class="form-label">ZIP</label>
                    <input name="zip" type="text" class="form-control">
                  </div>
                  <hr/>
                  <h6 class="mb-0 text-uppercase">Contact</h6>
                  <div class="col-6">
                    <label class="form-label">Home Phone</label>
                    <input name="homePh" type="tel" class="form-control" >
                  </div>
                  <div class="col-6">
                    <label class="form-label">Cell Phone</label>
                    <input name="cellPh" type="tel" class="form-control">
                  </div>
                  <hr/>
                  <label class="form-label">Required field</label>
                  <div class="col-12">
                    <div class="d-grid">
                      <button name ="enviar" type="submit" class="btn btn-primary">Continue</button>
                    </div>
                  </div>
                </form>
                <br>
              </div>
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
  <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
  <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
  <script src="assets/js/table-datatable.js"></script>
	
  <!--app-->
  <script src="assets/js/app.js"></script>
  

</body>

</html>