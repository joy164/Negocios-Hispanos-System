<?php
    include 'modelo/conexion.php';
    session_start();
    if(!isset($_REQUEST['numContrato'])){
        header("location: validar");
    }
    
    $conn->set_charset('utf8');

    $contrato = $conn->real_escape_string($_REQUEST['numContrato']);
    
    $consulta = $conn->prepare("SELECT * FROM prestarios WHERE numContrato = ?");
    $consulta->bind_param('s', $contrato);
    $consulta->execute();

    $resultado = $consulta->get_result();
    $datosPrestario = $resultado->fetch_assoc();

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

 <!--start wrapper-->
 <div class="wrapper">
    <!--start content-->
    <main class="page-content">
        <div class="col-xl-10">
          <div class="card">
            <div class="card-body">
              <div class="border p-3 rounded">
                <h6 class="mb-0 text-uppercase">Borrower references Registration</h6><hr>
                <div class="col-20 col-lg-12 text-md-end">
                  <a href="validar" class="btn btn-warning">Cancel</a>
                </div><br>

              <form action="controlador/new_referencias?id_contrato=<?=$datosPrestario['numContrato']?>" method="post">
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
                          <input name="name1" type="text" class="form-control" required>
                      </div>
                      <div class="col-6">
                          <label class="form-label">relationship</label>
                          <input name="rel1" type="text" class="form-control" required>
                      </div>
                      <hr><h6 class="mb-0">Address</h6>
                      <div class="col-12">
                          <label class="form-label">* Address</label>
                          <input name="dir1" type="text" class="form-control" required>
                      </div>
                      <div class="col-4">
                          <label class="form-label">* City</label>
                          <input name="city1" type="text" class="form-control" required>
                      </div>
                      <div class="col-4">
                        <label class="form-label">* State</label>
                        <select name="state1" class="form-select mb-3" aria-label=".form-select-sm example" required>
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
                        <input name="zip1" type="text" class="form-control" required>
                      </div>
                      <hr/>
                      <h6 class="mb-0">Contact</h6>
                      <div class="col-6">
                        <label class="form-label">Home Phone</label>
                        <input name="homePh1" type="tel" class="form-control" >
                      </div>
                      <div class="col-6">
                        <label class="form-label">* Cell Phone</label>
                        <input name="cellPh1" type="tel" class="form-control" required>
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
                          <input name="name2" type="text" class="form-control" required>
                      </div>
                      <div class="col-6">
                          <label class="form-label">relationship</label>
                          <input name="rel2" type="text" class="form-control" required>
                      </div>
                      <hr><h6 class="mb-0">Address</h6>
                      <div class="col-12">
                          <label class="form-label">* Address</label>
                          <input name="dir2" type="text" class="form-control" required>
                      </div>
                      <div class="col-4">
                          <label class="form-label">* City</label>
                          <input name="city2" type="text" class="form-control" required>
                      </div>
                      <div class="col-4">
                        <label class="form-label">* State</label>
                        <select name="state2" class="form-select mb-3" aria-label=".form-select-sm example" required>
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
                        <input name="zip2" type="text" class="form-control" required>
                      </div>
                      <hr/>
                      <h6 class="mb-0">Contact</h6>
                      <div class="col-6">
                        <label class="form-label">Home Phone</label>
                        <input name="homePh2" type="tel" class="form-control" >
                      </div>
                      <div class="col-6">
                        <label class="form-label">* Cell Phone</label>
                        <input name="cellPh2" type="tel" class="form-control" required>
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
                          <input name="name3" type="text" class="form-control" required>
                      </div>
                      <div class="col-6">
                          <label class="form-label">relationship</label>
                          <input name="rel3" type="text" class="form-control" required>
                      </div>
                      <hr><h6 class="mb-0">Address</h6>
                      <div class="col-12">
                          <label class="form-label">* Address</label>
                          <input name="dir3" type="text" class="form-control" required>
                      </div>
                      <div class="col-4">
                          <label class="form-label">* City</label>
                          <input name="city3" type="text" class="form-control" required>
                      </div>
                      <div class="col-4">
                        <label class="form-label">* State</label>
                        <select name="state3" class="form-select mb-3" aria-label=".form-select-sm example" required>
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
                        <input name="zip3" type="text" class="form-control" required>
                      </div>
                      <hr/>
                      <h6 class="mb-0">Contact</h6>
                      <div class="col-6">
                        <label class="form-label">Home Phone</label>
                        <input name="homePh3" type="tel" class="form-control" >
                      </div>
                      <div class="col-6">
                        <label class="form-label">* Cell Phone</label>
                        <input name="cellPh3" type="tel" class="form-control" required>
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
                          <input name="name4" type="text" class="form-control" value=" ">
                      </div>
                      <div class="col-6">
                          <label class="form-label">relationship</label>
                          <input name="rel4" type="text" class="form-control" value=" ">
                      </div>
                      <hr><h6 class="mb-0">Address</h6>
                      <div class="col-12">
                          <label class="form-label">* Address</label>
                          <input name="dir4" type="text" class="form-control" value=" ">
                      </div>
                      <div class="col-4">
                          <label class="form-label">* City</label>
                          <input name="city4" type="text" class="form-control" value=" ">
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
                        <input name="zip4" type="text" class="form-control" value=" ">
                      </div>
                      <hr/>
                      <h6 class="mb-0">Contact</h6>
                      <div class="col-6">
                        <label class="form-label">Home Phone</label>
                        <input name="homePh4" type="tel" class="form-control" value=" ">
                      </div>
                      <div class="col-6">
                        <label class="form-label">* Cell Phone</label>
                        <input name="cellPh4" type="tel" class="form-control" value=" ">
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
                          <input name="name5" type="text" class="form-control" value=" ">
                      </div>
                      <div class="col-6">
                          <label class="form-label">relationship</label>
                          <input name="rel5" type="text" class="form-control" value=" ">
                      </div>
                      <hr><h6 class="mb-0">Address</h6>
                      <div class="col-12">
                          <label class="form-label">* Address</label>
                          <input name="dir5" type="text" class="form-control" value=" ">
                      </div>
                      <div class="col-4">
                          <label class="form-label">* City</label>
                          <input name="city5" type="text" class="form-control" value=" ">
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
                        <input name="zip5" type="text" class="form-control" value=" ">
                      </div>
                      <hr/>
                      <h6 class="mb-0">Contact</h6>
                      <div class="col-6">
                        <label class="form-label">Home Phone</label>
                        <input name="homePh5" type="tel" class="form-control" value=" ">
                      </div>
                      <div class="col-6">
                        <label class="form-label">* Cell Phone</label>
                        <input name="cellPh5" type="tel" class="form-control" value=" ">
                      </div>
                    </div>
                  </div>
                </div>
                <!--Boton de guardar-->
                <div class="col-20 col-lg-12 text-md-end">
                  <button name ="enviar" type="submit" class="btn btn-success " title="Send References"><i class="lni lni-save"> Save changes</i></button>
                </div>
              </form>

            </div><!--endpage-card-body-->
          </div><!--end card-->
        </div><!--end col-xl-10-->
      </div><!--end page-content-->
    </main><!--end page main-->
       
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
  <script src="assets/js/reenvio.js"></script>

</body>

</html>