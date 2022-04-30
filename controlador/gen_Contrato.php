<?php
session_start();
include "../fpdf/fpdf.php";
include '../modelo/conexion.php';
include 'correo.php';
$id_contrato = $_REQUEST['id_prestario'];

$consulta = $conn->prepare("SELECT * FROM prestarios WHERE id_prestario = ?");
$consulta->bind_param('s', $id_contrato);
$consulta->execute();

$resultado = $consulta->get_result();
$datosPrestario = $resultado->fetch_assoc();

$consulta = $conn->prepare("SELECT * FROM db_deal.coborrower WHERE id_coBorrower = ?");                                        

$consulta->bind_param('i', $datosPrestario['id_CoBorrower']);
$consulta->execute();

$resultado = $consulta->get_result();
$datosCoBorrower = $resultado->fetch_assoc();

$consulta = $conn->prepare("SELECT * FROM db_deal.cosigner WHERE id_CoSigner = ?");
$consulta->bind_param('i', $datosPrestario['id_CoSigner']);
$consulta->execute();

$resultado = $consulta->get_result();
$datosCoSigner = $resultado->fetch_assoc();

$consulta = $conn->prepare("SELECT * FROM vehicle WHERE id_auto = ?");
$consulta->bind_param('i', $datosPrestario['id_auto']);
$consulta->execute();

$resultado = $consulta->get_result();
$datosAuto = $resultado->fetch_assoc();

$consulta = $conn->prepare("UPDATE prestarios SET contGenerado = 1");
$consulta->execute();

$fechaactual = date('Y-m-d');

$fechainicio = strtotime ('+ 1 days' , strtotime($fechaactual)); 
$fechainicio = date ('Y-m-d',$fechainicio);
$periodo = $datosPrestario['period'];

$totalPagos = 0;

if($periodo == 24){
    $fechafinal = strtotime ('+ 2 year' , strtotime($fechaactual)); 
    $fechafinal = date ('Y-m-d',$fechafinal);
    $totalPagos = (23 * $datosPrestario['pagoPeriodo']) + $datosPrestario['pagoFinal'];
}elseif($periodo == 36){
    $fechafinal = strtotime ('+ 3 year' , strtotime($fechaactual)); 
    $fechafinal = date ('Y-m-d',$fechafinal);
    $totalPagos = (35 * $datosPrestario['pagoPeriodo']) + $datosPrestario['pagoFinal'];
}elseif($periodo == 48){
    $fechafinal = strtotime ('+ 4 year' , strtotime($fechaactual)); 
    $fechafinal = date ('Y-m-d',$fechafinal);
    $totalPagos = (47 * $datosPrestario['pagoPeriodo']) + $datosPrestario['pagoFinal'];
}

$costoCredito = $totalPagos - $datosPrestario['amount'];
$conn->close();

//OBJETOS FPDF////////////////////////////////////////////////////////////////////
$pdf = new FPDF($orientation='P',$unit='mm');
$pdf->AddPage();
$pdf->SetFont('Arial','B',20);    
$textypos = 5;
$fontSize = 9;

//IMPLEMENTACION DE FUNCIONES DE LA CLASE FPDF////////////////////////////////////
class pdf extends FPDF{
    public function header(){
        if($this->pageNo() == 1){
            $this->Image('../assets/images/logo.png', 10, 10, 55);    
        }else{
            $this->setFont('Arial', '', 9);
            $this->Image('../assets/images/logo.png', 10, 10, 55);
            $this->Cell(0, 5, $this->PageNo()." of {nb}" ,0, 0, 'R');
        }
    }
    public function footer(){
        $this->setFont('Arial', '', 9);
        $this->setY(-15);
        $this->write(5, "powered by Dinozing");
        $this->Cell(0, 5, $this->PageNo()." of {nb}" ,0, 0, 'R');
    }
}
$pdf = new pdf();
$pdf->AliasNbPages();
//PAGINA 1////////////////////////////////////////////////////////////////////////
$pdf->AddPage('P', 'Letter');
$pdf->SetTitle('CONTRATO #'. $datosPrestario['numContrato']);
$pdf->SetAuthor('Amigos Prestamos');
$pdf->SetCreator('Dinozing');

$pdf->setY(25);
$pdf->setFont('Arial', 'B', 15);
$tipo = $datosPrestario['contratacion'];
if($tipo == 1){
    $pdf->Cell(0, 5, 'SECONDARY MOTOR VEHICLE FINANCE TRANSACTION' ,0, 0, 'C');
}else{
    $pdf->Cell(0, 5, 'SECONDARY MOTOR VEHICLE FINANCE REGISTRATION' ,0, 0, 'C');
}

$pdf->setFont('Arial', '', 10);
$pdf->Ln();
$pdf->Cell(0, 5, '( hereinafter refered to as "CONTRACT" )' ,0, 0, 'C');
$pdf->Ln();

//DATOS DE PRESTAMISTA
$pdf->SetFont('Arial','B',$fontSize);    
$pdf->setY(35);$pdf->setX(10);
$pdf->Cell(65,$textypos,"Lender");
$pdf->SetFont('Arial','', $fontSize);    
$pdf->setY(40);$pdf->setX(10);
$pdf->MultiCell(80, 4, "CA & SA Financial Inc. dba Amigos Prestamos
2929 N 75th AVE., Suite 03
Phoenix AZ 85033
623-473-74444
");

//DATOS DE PRESTARIO 
$pdf->SetFont('Arial','', $fontSize);    
$pdf->setY(40);$pdf->setX(150);
$pdf->MultiCell(55, 4,"Loan Number:".$datosPrestario['numContrato']."
Date of Loan:".$fechaactual."
maturity Date:".$fechafinal."
Salesperson:". $_SESSION['name']."
", 0, 'R');

//TABLA DE DATOS DE PRESTARIOS////////////////////////////////////////////////////
//DATOS DETALLADOS DE PRESTARIOS Borrower 
$pdf->SetFont('Arial','B', $fontSize);
$pdf->SetFillColor(13, 49, 124);
$pdf->SetTextColor(240, 255, 240);    
$pdf->setY(62);$pdf->setX(10);
$pdf->Cell(65,$textypos,"Borrower", 1, 0, 'R', true);
$pdf->setY(67);$pdf->setX(10);
$pdf->SetFont('Arial','', $fontSize);   
$pdf->SetFillColor(224,235,255);
$pdf->SetTextColor(0); 
$pdf->MultiCell(65, 4, $datosPrestario['name']." ".$datosPrestario['midName']." ".$datosPrestario['lastName']."
".$datosPrestario['address']."
".$datosPrestario['city']." ".$datosPrestario['state']." ".$datosPrestario['ZIP']."
".$datosPrestario['homePh']."
".$datosPrestario['cellPh']."
".$datosPrestario['email']."
", 1);


//DATOS DETALLADOS DE PRESTARIOS Co-Borrower
$pdf->SetFont('Arial','B', $fontSize); 
$pdf->SetFillColor(13, 49, 124);
$pdf->SetTextColor(240, 255, 240);       
$pdf->setY(62);$pdf->setX(75);
$pdf->Cell(65,$textypos,"Co-Borrower", 1, 0, 'R', true);
$pdf->setY(67);$pdf->setX(75);
$pdf->SetFont('Arial','', $fontSize);    
$pdf->SetFillColor(224,235,255);
$pdf->SetTextColor(0); 
$pdf->MultiCell(65, 4,$datosCoBorrower['name']." ".$datosCoBorrower['midName']." ".$datosCoBorrower['lastName']."
".$datosCoBorrower['address']."
".$datosCoBorrower['city']." ".$datosCoBorrower['state']." ".$datosCoBorrower['ZIP']."
".$datosCoBorrower['homePh']."
".$datosCoBorrower['cellPh']."
".$datosCoBorrower['email']."
", 1);

//DATOS DETALLADOS DE PRESTARIOS Co-Signer
$pdf->SetFont('Arial','B', $fontSize);    
$pdf->SetFillColor(13, 49, 124);
$pdf->SetTextColor(240, 255, 240);  
$pdf->setY(62);$pdf->setX(140);
$pdf->Cell(65,$textypos,"Co-Signer", 1, 0, 'R', true);
$pdf->setY(67);$pdf->setX(140);
$pdf->SetFont('Arial','', $fontSize);    
$pdf->SetFillColor(224,235,255);
$pdf->SetTextColor(0); 
$pdf->MultiCell(65, 4,$datosCoSigner['name']." ".$datosCoSigner['midName']." ".$datosCoSigner['lastName']."
".$datosCoSigner['address']."
".$datosCoSigner['city']." ".$datosCoSigner['state']." ".$datosCoSigner['ZIP']."
".$datosCoSigner['homePh']."
".$datosCoSigner['cellPh']."
".$datosCoSigner['email']."
", 1);
//TERMINOS
$pdf->SetFont('Arial','', $fontSize);    
$pdf->setY(92);$pdf->setX(10);
$pdf->MultiCell(0,4,"In this Secondary Motor Vehicle Finance (\"contract\") Borrower, Co-Borrower and Co-Signer are refered to as \"you\" and \"your\".\"Lender\", \"we\", \"us\" and \"our\" refered to Amigos Auto Title Loans. \"Loan\" refer to the loan made by Lender to Borrower hereunder pursuant to Arizona Revised Statues 44-281 et seq. \"Vehicle\" refer to the motor vehicle described below. Lender is a Sales Finance Company licensed and regulated by the Arizona Departament of Financial Institutions. 100 N 15th Avenue, Suite 261 Phoenix, AZ 85007 Phone 602-771-2800, Toll Free 800-544-0708, Fax 602-381-125 www.azdfi.gov. The federal Truth in lending Act Disclosures are part of this contract. On the date shown opposite signature(s) below, we have loaned you money and you have granted to us segurity interest in your motor vehicle described below (\"vehicle\"). This loan is made primarily for household purposes.");
$pdf->SetFont('Arial','',10);    

//DESCRIPCION DE VEHICULO
$pdf->SetFont('Arial','B', $fontSize);    
$pdf->setY(122);$pdf->setX(10);
$pdf->Cell(0, $textypos,"Motor Vehicle Description",0,1,'C');
$pdf->setY(127);$pdf->setX(40);
$pdf->SetFont('Arial','', $fontSize);  
$pdf->SetFillColor(192, 211, 232);
$pdf->SetTextColor(0);       
$pdf->Cell(65, $textypos,"Year: ".$datosAuto['year'], 1, 0, 'L', true);
$pdf->Cell(65, $textypos,"Make: ".$datosAuto['make'], 1, 0, 'L', true);
$pdf->Ln();
$pdf->setX(40);
$pdf->Cell(65, $textypos,"Model: ".$datosAuto['model'], 1, 0, 'L', true);
$pdf->Cell(65, $textypos,"Color: ".$datosAuto['color'], 1, 0, 'L', true);
$pdf->Ln();
$pdf->setX(40);
$pdf->Cell(65, $textypos,"Odometer: ".$datosAuto['odometer'], 1, 0, 'L', true);
$pdf->Cell(65, $textypos,"VIN #: ".$datosAuto['VIN'], 1, 0, 'L', true);
$pdf->Ln();
$pdf->setX(40);
$pdf->Cell(65, $textypos,"Transmission: ".$datosAuto['transmission'], 1, 0, 'L', true);
$pdf->Cell(65, $textypos,"License No: ".$datosAuto['LicenseNo'], 1, 0, 'L', true);
$pdf->SetFillColor(224,235,255);
$pdf->SetTextColor(0); 

//TABLA DE INDEMIZACION DE MONTO FINANCIADO
$pdf->SetFont('Arial','B', $fontSize);    
$pdf->setY(150);$pdf->setX(55);
$pdf->SetFillColor(13, 49, 124);
$pdf->SetTextColor(255, 255, 255);  
$pdf->Cell(100, $textypos,"Itemization of Amount Financed",1,1,'C', true);
$pdf->setY(155);$pdf->setX(55);
$pdf->SetFillColor(224,235,255);
$pdf->SetTextColor(0); 
$pdf->SetFont('Arial','', $fontSize);  
$pdf->multiCell(100, $textypos,"A. Amount Given to Yoy Directly: ".$datosPrestario['amount']."
B. Amount Paid to:
C. Amount Paid to:
D. Amount Paid to:
E. Total Loan Amount: ".$datosPrestario['amount']."
F. Amount Financed: ".$datosPrestario['amount']."
", 1);

//CALCULO DE DEUDA


$pdf->SetFont('Arial','B', $fontSize);    
$pdf->setY(187);$pdf->setX(10);
$pdf->Cell(0, $textypos,"FEDERAL TRUTH-IN LENDING ACT DISCLOSURES",0,1,'C');
$pdf->setY(192);$pdf->setX(10);
$pdf->SetFont('Arial','', $fontSize);  
$pdf->SetFillColor(192, 211, 232);
$pdf->SetTextColor(0);
$pdf->multiCell(40, 4,"ANUAL PERCENTAGE RATE
the cost of your credit as a yearly rate

".$datosPrestario['rate']."%
", 1,'C', true);
$pdf->setY(192);$pdf->setX(50);
$pdf->multiCell(50, 4,"FINANCE CHARGE

The dollar amount the credit will cost you

$".$costoCredito."
", 1,'C', true);
$pdf->setY(192);$pdf->setX(100);
$pdf->multiCell(50, 4,"AMOUNT FINANCED 

The amount of credit provided to you or on your behalf

$".$datosPrestario['amount']."
", 1,'C', true);
$pdf->setY(192);$pdf->setX(150);
$pdf->multiCell(56, 4,"TOTAL OF PAYMENTS

the amount you will have paid after you have made all payments as scheduled 
$".$totalPagos."
", 1,'C', true);

$pdf->SetFillColor(224,235,255);
$pdf->SetTextColor(0); 

//TABLA DE PAGOS
$pdf->SetFont('Arial','B', $fontSize);
$pdf->setY(217);$pdf->setX(10);
$pdf->Cell(65,$textypos,"Your payment schedule will be", 0, 0);

$pdf->SetFillColor(13, 49, 124);
$pdf->SetTextColor(240, 255, 240);    
$pdf->setY(222);$pdf->setX(10);

if($datosPrestario['period'] == 24){
    $pdf->Cell(65,$textypos,"23 Payments of", 1, 0, 'L', true);
    $pdf->SetFont('Arial','', $fontSize);   
    $pdf->SetFillColor(224,235,255);
    $pdf->SetTextColor(0); 
}elseif($datosPrestario['period'] == 36){
    $pdf->Cell(65,$textypos,"35 Payments of", 1, 0, 'L', true);
    $pdf->SetFont('Arial','', $fontSize);   
    $pdf->SetFillColor(224,235,255);
    $pdf->SetTextColor(0); 
}elseif($datosPrestario['period'] == 48){
    $pdf->Cell(65,$textypos,"47 Payments of", 1, 0, 'L', true);
    $pdf->SetFont('Arial','', $fontSize);   
    $pdf->SetFillColor(224,235,255);
    $pdf->SetTextColor(0); 
}

$pdf->SetFont('Arial','B', $fontSize); 
$pdf->SetFillColor(13, 49, 124);
$pdf->SetTextColor(240, 255, 240);       
$pdf->setY(222);$pdf->setX(75);
$pdf->Cell(65,$textypos,"One Final Payment of", 1, 0, 'L', true);
$pdf->SetFont('Arial','', $fontSize);    
$pdf->SetFillColor(224,235,255);
$pdf->SetTextColor(0); 

$pdf->SetFont('Arial','B', $fontSize);    
$pdf->SetFillColor(13, 49, 124);
$pdf->SetTextColor(240, 255, 240);  
$pdf->setY(222);$pdf->setX(140);
$pdf->Cell(66,$textypos,"When payments are Due", 1, 0, 'L', true);
$pdf->SetFont('Arial','', $fontSize);    
$pdf->SetFillColor(224,235,255);
$pdf->SetTextColor(0); 
$pdf->Ln();

$pdf->setY(227);
$pdf->Cell(65,$textypos,"$".$datosPrestario['pagoPeriodo'], 1, 0, 'C');
$pdf->Cell(65,$textypos,"$".$datosPrestario['pagoFinal'], 1, 0, 'C');
$pdf->Cell(66,$textypos,"Monthly, beginning ".$fechainicio, 1, 0, 'C');
$pdf->Ln();

$pdf->setY(235);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->cell(30, $textypos, "Security:",0,0,'R');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->multiCell(0, $textypos, $aux."you are giving a security interest in the Vehicle described above.");
$pdf->setY(240);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->cell(30, $textypos, "Late Charge:",0,0,'R');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->multiCell(0, $textypos, $aux."On any payment not paid in full on the 10th day after it is due you will charged 5% of unpaid intallmet.");
$pdf->setY(245);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->cell(30, $textypos, "Prepayment:",0,0,'R');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->multiCell(0, $textypos, $aux."if you pay off early, you will not have to pay a penalty. See your contract documents for any additional information about nonpayment, default, and any required repayment in full before the scheduled date, and prepayment refunds.");




//PAGINA 2////////////////////////////////////////////////////////////////////////
$pdf->AddPage('P', 'Letter');

$pdf->setY(25);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(30, $textypos, "Promiese to pay:",0, 'R');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(25);$pdf->setX(40);
$pdf->multiCell(0, $textypos, $aux.'For value received you promise to pay us the total loan amount ("Principal") shown above (the amount financed) plus interest at rate of 168.00 % per year (based on a monthly rate of 14.000 %). Interest accrues based on the number of days elapsed over a 365-day on the loan princpipal from the loan date until the loan is paid in full. Lender calculates interest, including interest on past due principal from the loan date "secondary motor vehicle finance rate" for purposes of Arizona Revised Statues 44-281 et seq. If any interest charge or other fee is held invalid, the remainder shall remain in effect. If more than oneof you signs this Contract, each of you will be individually and jointly liable to us for repayment.');

$pdf->setY(65);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(30, $textypos, "Application of payments:", 0, 'R');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(65);$pdf->setX(40);
$pdf->multiCell(0, $textypos, $aux.'Paymets we receive will be applied first to unpaid interest, then to fess, such as late charges, then to unpaid Principal, If you make more than one payment that is due, you will still owe the payments due as scheduled(advance payments are applied to Principal balance). The finance charge, total of payments and  payment schedule disclosed in the federal truth in lending disclosures may differ from the actual amount you pay if your payments are not received by us on the exact due dates. Your final payment may be different than the amount disclosed under the Payment Schedule if you make your payments after or before the date are due.');

$pdf->setY(100);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(30, $textypos, "Statement of payments:", 0, 'R');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(100);$pdf->setX(40);
$pdf->multiCell(0, $textypos, $aux.'Upon your written request, Lneder shall give you a written statement with the amount and date of payments and the total amount unpaid under this contract.');

$pdf->setY(115);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(30, $textypos, "Usury Savings Clause:", 0, 'R');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(115);$pdf->setX(40);
$pdf->multiCell(0, $textypos, $aux.'Lender does not intent to charge or receive any interest rate or charge higher than Arizona law allows. The interest rete and charges under this Contract will never exceed the hisghest lawful interest rete or charge. Lender will prompthy refund or credit to your Loan any unlawful excess amount. Lender will reduce any excessive interest rate or charge tothe maximum lawful interest rete or charge.');

$pdf->setY(140);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(30, $textypos, "Prepayment:", 0, 'R');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(140);$pdf->setX(40);
$pdf->multiCell(0, $textypos, $aux.'You may pay us all that you owe under this contract at any time without penalty. If there is more than one of you, you agree that we may release our lien interest in the certificate of ownership ( certificate of title) to any one of you ');

$pdf->setY(155);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(30, $textypos, "Loan Funding:", 0, 'R');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(155);$pdf->setX(40);
$pdf->multiCell(0, $textypos, $aux.'Lender will fund the proceeds of the Loan by check. You may make paymentes to Lender during Lender\'s normal business hours at the location at which you obtained thisloan. Lender accepts paymentes by cash, cashier\'s check, money order, debit card or credit cards, Lender may at its discretion agree to refinance this Loan. As a condition to any refinance you must satisfy Lender\'s other underwriting criteria for refinances and enter into a new Secondary Motor Vehicle Finance with Lender.');

$pdf->setY(185);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(30, $textypos, "Late Fee:", 0, 'R');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(185);$pdf->setX(40);
$pdf->multiCell(0, $textypos, $aux.'you agree to pay a late charge fee not to exceed 5% of the unpaid scheduled monthly amount if any part of scheduled payment remains unpaid after the 10th day after the payment due date.');

$pdf->setY(200);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(30, $textypos, "Right to Cancel:", 0, 'R');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(200);$pdf->setX(40);
$pdf->multiCell(0, $textypos, $aux.'You may cancel this Contract, without cost, no later than the close of business on the fisrt business day after the Loan Date, by returning the Loan proceeds, Lender will credit you account for any accrued interest and cancel the Loan. If you don\'t  cancel this Contract in compliance with this section, the Loan and this Contract remain in full force and effect');

$pdf->setY(225);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(30, $textypos, "Security Interest:", 0, 'R');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(225);$pdf->setX(40);
$pdf->multiCell(0, $textypos, $aux.'You grant us a security interest in: (1) the Vehicle and all vehicle improvements, and all part and accessories attached to the Vehicle; (2) all money or goods received for the Vehicle ("Proceeds"); (3) all Proceeds or refunded insurance premiums or charges for optional products or services financed in the Loan, which secure all sums due or to become due under this loan as well as any modifications, extensions, renewals, amendments or refinancing of this loan; and (4) any substitution, in whole or in part, for the vehicle. The Vehicle is not stollen. The vehicle has no liens. If Lender asks, you will sign other documents and take other actions to support Lender\'s security interest.');

//PAGINA 3////////////////////////////////////////////////////////////////////////
$pdf->AddPage('P', 'Letter');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(25);$pdf->setX(40);
$pdf->multiCell(0, $textypos, $aux.'As a condition to Lender making this Loan, any co-owner of the vehicle who is not a borrower under this Contract must execute a separate Co-Owner Consent, Grant of Security Interest, and Waiver of Jury Trial and Arbitration security interest in the Vehicle. Any co-owner who is not a Borrower under this Contract shall not be personally obligated to Lender for satisfying Borrower\'s obligations under this Contract.');

$pdf->setY(50);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(30, $textypos, "Use of Vehicle:", 0, 'R');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(50);$pdf->setX(40);
$pdf->multiCell(0, $textypos, $aux.'You agree to keep the Vehicle free of al liens and encumbrances, including tax liens, except the lien in our favor, and to not use the Vehicle or permit the Vehicle to be used illegally, improperly or for hire, or to expose the Vehicle to misuse, seizure, confiscation, forfeiture or other involuntary transfer, even if the vehicle is not the subject of judicial or administrative proceedings. you agree noc to make or allow any material change to be made to the Vehicle. You agree to allow us to inspect the Vehicle at any reasonable time. You agree not to remove the Vehicle, or allow the Vehicle to be removed from Arizona for a period in excess of 30 days without our permission. You agree not to remove the Vehicle from the U.S. without our written consent. You agree not to sell, rent, lease or transfer any interest in the vehicle. you agree to keep the vehicle in good working condition and make all necessary repairs. Although we are not obligated to do so, if we pay any liens, fees, maintenance or taxes in connection with the Vehicle, or advance any other amount to protect our interest in the Vehicle, you wil reimburse us, at our option within five (S) dayg of our demand upon you to do so, or we may add the amount of any such liens, fees, maintenace or taxes or other charges we pay to the Principal balance. Such amounts will accrue finance charges at the rate set forth above. Unless you have paid us such amounts prior to maturity, they will be due at the maturity of this Contract.');

$pdf->setY(120);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(30, $textypos, "Risk of Lost:", 0, 'R');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(120);$pdf->setX(40);
$pdf->multiCell(0, $textypos, $aux.'You will be liable for the Vehicle damage and loss. You hold the Lender harmless for all claims and costs arising from you using the vehicle. This includes all judgments, attorney\'s fees, court costs and expenses.');

$pdf->setY(135);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(30, $textypos, "Insurance:", 0, 'R');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(135);$pdf->setX(40);
$pdf->multiCell(0, $textypos, $aux.'You agree to keep the Vehicle insured in our favor with a policy and insurance provider satisfactory to us, with comprehensive fire, theft and collision coverage, insuring the Vehicle in an amount sufficient to cover the value of the Vehicle. You may obtain the insurance from any insurer or broker you choose that is acceptable to us. You agree to obtain and deliver to us a loss payable endorsement on such insurance. You agree that we may (1) contact your insurance agent to verify coverage or to have us added as a loss payee, (2) make any claim under your insurance policy for physical damage or loss to the Vehicle. (3) cancel the insurance if you default in your obligations under this Contract and we take possegion of the Vehicle and/or (4) receive any payment for loss or damage, or return premium, and apply amounts we receive, at our option, to replacement of the Vehicle or to what you owe under this Contract, including indebtedness not yet due. THIS CONTRACT DOES NOT INCLUDE INSURANCE FOR BODILY INJURY AND PROPERTY DAMAGE CAUSED TO OTHERS');

$pdf->setY(190);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(30, $textypos, "Default:", 0, 'R');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(190);$pdf->setX(40);
$pdf->multiCell(0, $textypos, $aux.'If you fail to pay us what you owe when it is due or when we demand you pay, you will be in default of this Contract. You will also be in default of this contract if: (1) you gave us false information or commited forgery in connection with this loan; (2) you fail to keep your promises or fulfill your obligations under this Contract . (3) the Vehicle is taken outside of the United States, stolen, damaged, destroyed, impounded, seized, confiscated or forfeited; or (4) you remove or alter or attempt to remove our lien interest as it appears on the certificate of ownership to the Vehicle .');

$pdf->setY(220);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(30, $textypos, "Remedies", 0, 'R');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(220);$pdf->setX(40);
$pdf->multiCell(0, $textypos, $aux.'Remedies; If you are in default, Lender \' s rights are cumulative and not exclusive, we may (1) declare all that you owe us to be immediately due and payable and (2) file suit against you for all unpaid sums you owe under this Contract; (3) take immediate possession of the Vehicle where we may find it, provided that we do go peacefully; and (4) exercise any other legal or equitable remedy. If we take possession Of the Vehicle, any accesories, equipment or replacement parts will stay with the Vehicle. If any of your personal items are in the Vehicle when we take possession, they will be stored for you at your expense. If you do not ask for these items back within the time permitted by law, we may dispose of them as permitted by law. Our remedies under (1) and (2) are subject to any');

//PAGINA 4////////////////////////////////////////////////////////////////////////
$pdf->AddPage('P', 'Letter');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(25);$pdf->setX(40);
$pdf->multiCell(0, $textypos, $aux.'right you may have to reinstate the Contract or redeem the Vehicle by paying what you owe us in full. Upon taking possession of the Vehicle, subject to any right you may have to reinstate or redeem, we will sell the Vehicle at a public or private gale. we will give you notice at least 10 days before selling the Vehicle. we will add the costs of retaking, holding, preparing for sale, and disposing of the Vehicle to what you owe, as permitted by law. The proceeds of sale will be applied first to unpaid interest, then to fees and then to the costs of preparing the Vehicle for gel I. If we must pursue collection, or hire an attorney to collect what you owe, you will reimburse us our reasonable collection costs and attorney fees when we demand, to the extent permitted by law. If there is any money left over (surplus) , we pay it to you unless we must pay it to someone else who has a subordinate lien or encumbrance on the Vehicle, as permitted by law. If a balance remains due, you promise to pay it when we make demand. After we accelerate the unpaid principal balance, you will pay interest on what you still owe us at the rate of Finance Charge shown in this Contract, until you pay us all that you owe, or until judgement is entered in our favor. Our remedies are cumulative, and our taking any action will not be deemed as waiver of or prohibited against us taking any other action.');

$pdf->setY(95);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(30, $textypos, "Extension of Defers:", 0, 'R');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(95);$pdf->setX(40);
$pdf->multiCell(0, $textypos, $aux.'We may agree from time to time to extend or defer payments or amounts you owe us. If we do so, such extension or deferral does not mean we must or will extend or defer any other payment, and does not affect our liability for what you owe.');

$pdf->setY(115);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(30, $textypos, "Limited Recourse:", 0, 'R');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(115);$pdf->setX(40);
$pdf->multiCell(0, $textypos, $aux.'If Lender takes and sells the Vehicle, Lender will not sue you for the Loan balance unless you have engaged in fraud or have wrongully transferred any interest in the vehicle while the Loan is outstanding.');

$pdf->setY(130);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(30, $textypos, "Power of Attorney:", 0, 'R');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(130);$pdf->setX(40);
$pdf->multiCell(0, $textypos, $aux.'Until you have paid us all that you owe us, you hereby appoint us, and any one of our designated officers or employees, as your attorney-in-fact, with full power of substitution, to sign in your name any and all applications for certificate of ownership to secure our lien in the Vehicle and any affidavits or certificate of ownership to transfer and convey the title or our interest in the Vehicle.');

$pdf->setY(155);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(30, $textypos, "Other terms:", 0, 'R');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(155);$pdf->setX(40);
$pdf->multiCell(0, $textypos, $aux.'If we agree to an extension of the due date for payment, agree to extend or defer payment (s) us, accept money in amounts less than is due, or waive a right we have, our doing so will not be waiver other right or later right to enforce the terms of this Contract. If any provision of this Contract is held the remaining provisions will continue to be valid and enforceable. You waive the right to presenttnent, notice of dishonor and notice or protest. You must notify ug of any change of your name, residential telephone number, or employment within 30 days.');

$pdf->setY(185);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(30, $textypos, "Waivers:", 0, 'R');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(185);$pdf->setX(40);
$pdf->multiCell(0, $textypos, $aux.'If Lender delays or does not enforce its rights every time, Lender can still do go later. you waive presentment, demand for payment, notice of intent to accelerate, notice of acceleration, protest, and notice of dishonor. Lender need not sue, arbitrate or show dilligence in collecting against me or others. Lender need not go against the Vehicle. Lender may require that any Borrower pay the whole Loan without asking anyone else to pay. Lender may sue any Borrower without giving up any of its rights against any other Borrower. Lender may sue or arbitrate with a person without joining or suing others. Lender may release or modify a person\'s liability without changing other persons\'s liability.');

$pdf->setY(225);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(30, $textypos, "Confidentiality and Credit Reporting:", 0, 'R');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(225);$pdf->setX(40);
$pdf->multiCell(0, $textypos, $aux.'we will abide by our Privacy policy. we may report your payment experience with us to credit reporting agencies and others who may lawfully receive that information. Late payments, missed payments or other defaultg on your account may be reflected In your credit report.');

//PAGINA 5////////////////////////////////////////////////////////////////////////
$pdf->AddPage('P', 'Letter');
$pdf->SetFont('Arial','', $fontSize);   

$pdf->setY(25);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(30, $textypos, "Borrower's Acknowledge-
ment and warranties:", 0, 'R');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(25);$pdf->setX(40);
$pdf->multiCell(0, $textypos, $aux.'You warrant that you have the right to enter into this Contract and you are at least eighteen (18) year of age.');

$pdf->setY(50);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(30, $textypos, "Contact Authorization:", 0, 'R');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(50);$pdf->setX(40);
$pdf->multiCell(0, $textypos, $aux.'You authorize us to contact you from time to time regarding your Loan Account;and to contact you in any manner we choose unless the law says that we cannot, including but not limited to the following: (1) by mail, telephone, email, fax, recorded message or personal visit; (2) on mobil (cellular/wireless) telephone or similar wireless device; (3) using an automated dialing device, a prerecorded message or similar automated contact device ("Auto-dialer"); (4) at your home and at your place of employment; (5) at any telephone number, mobile (cellular/wireless) telephone number, email, social media or other address you provided or is in our records or we reasonable believe we may contact you; (6) at any time, as allowed by law, including weekends and holidays; (7) with any frequency; (8) leave prerecorded and other messages on your answering machine/gervice and with others; and (9) identify ourselves, your relationship with us, and our purpose for contacting you even if other might hear or read it. In addition, you acknowledge and agree to the following: (I) Our contacts with you about your Loan Account are not unsolicited and might result from information we obtain from you or others; (2) we may monitor or record any conversation or other communication with you; (3) unless the law says we cannot, we may modify or suppress caller ID and similar services and identify ourselves on these services in any manner we choose; (4) when you give us or we obtain your (cellular) telephone number or similar device number, you authorize us to contact you at that number using an Auto-dialer and we may also leave prerecorded and other messages; (5) you authorize us to do all of these things whether we contact you or you contact us; and (6) attemptinq to contact you every day you are in default at any number associated with you is okay and you do not consider that to be harrasing. annoying or abusive.');

$pdf->setY(140);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(30, $textypos, "Severability:", 0, 'R');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(140);$pdf->setX(40);
$pdf->multiCell(0, $textypos, $aux.'Each provision of this Contract shall be considered severable. If for any reason any provision or provisions herein are determined to be invalid and contrary to any existing or future law, such an invalidity shall not impair the operation of or affect those portions of this Contract which are valid and those provisions shall remain in full force and effect .');

$pdf->setY(165);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(30, $textypos, "Governing Law:", 0, 'R');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(165);$pdf->setX(40);
$pdf->multiCell(0, $textypos, $aux.'This Contract and Loan involve interstate cottmerce. Arizona Law governs this Contract, Federal Arbitration Act governs the Waiver of Jury Trail and Arbitration.');

$pdf->setY(205);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(0, $textypos, "WAIVER OF RIGHT TO TRIAL BY JURY: TRIAL CONDITIONS THE LAW ALLOWS PARTIES TO WAIVE WAIVE ALL RIGHTS TO A JURY TRIAL FOR ANY CONTRACT AND (B) THE LOAN. THIS JURY TRIAL WHICH LENDER AND YOU AGREE. SUCH AGREEMENT BY JURY IS A CONSTITUTIONAL RIGHT. UNDER CERTAIN THIS RIGHT. LENDER AND YOU KNOWLINGLY AND FREELY SUIT RELATED DIRECTLY OR INDIRECTLY TO (A) THIS WAIVER WILL NOT CHANCE ANY ARBITRATION AGREEMENT TO HAS ITS OWN SEPARATE JURY TRIAL WAIVER.");

//PAGINA 6////////////////////////////////////////////////////////////////////////
$pdf->AddPage('P', 'Letter');
$pdf->SetFont('Arial','', $fontSize);   

$pdf->setY(25);$pdf->setX(10);
$pdf->SetFont('Arial','B', 11);    
$aux= $pdf->multicell(0, $textypos, "ARBITRATION AGREEMENT", 0, 'C');

$pdf->setY(33);$pdf->setX(10);
$pdf->SetFont('Arial','B', 13);    
$aux= $pdf->multicell(0, $textypos, "AND WAIVER OF CLASS ACTION PARTICIPATION", 0, 'C');

$pdf->setY(42);$pdf->setX(10);
$pdf->SetFont('Arial','B', 10);    
$aux= $pdf->multicell(0, $textypos, "THIS ARBITRATION AGREEMENT MAY SUBSTANTIALLY LIMIT OR AFFECT YOUR RIGHTS. PLEASE READ IT CAREFULLY! KEEP A COPY OF THIS ARBITRATION AGREEMENT FOR YOUR RECORDS.");

$pdf->setY(55);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(10, $textypos, "1.", 0, 'L');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(55);$pdf->setX(20);
$pdf->multiCell(0, $textypos, $aux.'Broad Definition of "Dispute": For purposes of this Agreement, the words "dispute" and "disputes" are given the broadest possible meaning and include, without limitation, (a) all Federal or State law claims, disputes or controversies, arising from or relating directly or indirectly to the loan application, this Agreement (including this Arbitration Agreement and its validity) and the fees charged, or any prior agreement or agreements between you and Lender; (b) all counterclaims, cross-claims, and third party claims; (c) all common law claims based upon contract, tort, fraud and other intentional torts; (d) all claims based upon a violation of any State or Federal Constitution, statute or regulation; (e) all claims asserted by Lender against you, including claims for money damages to collect any sum Lender claims you owe Lender; (f) all claims asserted by you individually, as a private attorney general, as a representative and/or member of a class of persons, or in other representative capacity, against Lender and/or any of Lender \' s employees, agents, officer, shareholders, trembers, directors, assignees, managers, governors, brokers, or affiliate entities (hereinafter collectively referred to as "Related Third Parties") , including claims for money damages and/or equitable or injuntive relief. The words "dispute" and "disputes" do not mean an action subject to the jurisdiction of a small claims tribunal, a further described in Paragraph 8 below.');

$pdf->setY(120);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(10, $textypos, "2.", 0, 'L');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(120);$pdf->setX(20);
$pdf->multiCell(0, $textypos, $aux.'Any Party Can Demand Arbitration: Any party to a dispute, including Related Third Parties, may send the other party written notice by certified mail, return receipt requested, of their intent to arbitrate and setting forth the subject of the dispute along with the relief requested, even if a lawsuit has been filed. All doubts about whether to arbitrate a dispute shall be resolved in favor of arbitration.');

$pdf->setY(140);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(10, $textypos, "3.", 0, 'L');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(140);$pdf->setX(20);
$pdf->multiCell(0, $textypos, $aux.'How to Choose and Contact an Arbitrator: Regardless of who demands arbitration, you shall have the right to select any of the following arbitration organizations to administer the arbitration: the American Arbitrarion Association (Tel. 800-778-7879 or www.adr.org) or JAMS (Tel. 800-352-5267 or www.jamsadr.com) or ARC (Tel. 800-347-4512 or www.arc4adr.com) . However, the parties may agree to select a local arbitrator who is an attorney, retired judge, or abitrator registered and in good standing with an arbitration association, and arbitrate pursuant to such arbitrator\'s rules. If you demand arbitration, you must inform Lender in your demand of the arbitration organization you have selected or whether you desire to select a local arbitrator. If Related Third Parties or Lender demand (s) arbitration, you must notify Lender within twenty (20) days in writting by certified mail, return receipt requested, of your decision to select an arbitration organization or you desire to select a local arbitrator. If you fail to notify Lender or Related Third parties, whichever demanded arbitration, then the party demanding arbitration has the right to select an arbitration organization. The parties to such dispute will be governed by the rules and procedures of such arbitration organization applicable to consumer disputes; to the extent those rules and procedures do not contradict the express terms of this Agreement, including the limitations on the arbitrator below. You may obtain a copy of the rules and procedures by contacting the arbitration organization at the telephone numbers or websites listed above.');

$pdf->setY(210);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(10, $textypos, "4.", 0, 'L');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(210);$pdf->setX(20);
$pdf->multiCell(0, $textypos, $aux.'Payment of Fees and Expenses: If you demand arbitration, then, at your request, Lender or Related Third parties, as applicable, will advance your portion of the expenses associated with the arbitration, including the filing, administrative, hearing and arbitrator\' s fee ("Arbitration Fees") . If Related Third Parties or Lender demand (s) arbitration, then at your request, Lender or Related thirds Parties, ag applicable, will advance your portion of the Arbitration Fees. The arbitration hearing will be conducted in the county of your residency or in the county which the transaction under thig Agreement occurred, or in such place ag shall be ordered by the arbitrator in accordance with applicable law . Except as may be awarded by the arbitrator pursuant to Paragraph 7 below, each party shall bear his or his own attorney\' s fees and expenses through the arbitration, such as witness fees.');

//PAGINA 7////////////////////////////////////////////////////////////////////////
$pdf->AddPage('P', 'Letter');

$pdf->setY(25);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(10, $textypos, "5.", 0, 'L');
$pdf->setY(25);$pdf->setX(20);
$aux= $pdf->multicell(0, $textypos, "WAIVER OF ABILITY TO PURSUE OR PARTICIPATE IN CLASS ACTIONS: THE PARTIES AGREE THAT ALL DISPUTES SHALL BE RESOLVED ONLY ON AN INDIVIDUAL BASIS. IF ARBITRATION IS DEMANDED BY ANY PARTY WITH RESPECT TO A DISPUTE, THE ARBITRATOR SHALL NOT CONDUCT CLASS ARBITRATION\' THAT IS, THE ARBITRATOR SHALL NOT ALLOW YOU TO SERVE AS A CLASS REPRESENTATIVE, AS A PRIVATE ATTORNEY GENERAL, OR IN ANY OTHER REPRESENTATIVE CAPACITY FOR OTHERS IN THE ARBITRATION. IF ARBITRATION 13 NOT DEMANDED BY ANY PARTY TO A DISPUTE AND THE DISPUTE IS SUBJECT TO RESOLUTION IN A COURT OF LAW, THE COURT SHALL NOT CONDUCT A CLASS ACTION\' THAT IS, THE JUDGE SHALL NOT ALLOW YOU TO SERVE AS A CLASS REPRESENTATIVE, AS A PRIVATE ATTORNEY GENERAL, OR IN ANY OTHER REPRESENTATIVE CAPACITY FOR OTHERS IN THE LAWSUIT. IN OTHER WORDS, THE PARTIES MAY NOT BRING A CLASS ACTION LAWSUIT OR CLASS ARBITRATION AND MAY NOT PARTICIPATE IN A CLASS ACTION LAWSUIT OR CLASS-WIDE ARBITRATION AS A CLAIMANT. CLAIMS BROUGHT BY ANY BORROWER MAY NOT BE JOINED TO CLAIMS BROUGHT BY ANOTHER BORROWER IN A COURT or LAW OR IN ARBITRATION.");

$pdf->setY(90);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(10, $textypos, "6.", 0, 'L');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(90);$pdf->setX(20);
$pdf->multiCell(0, $textypos, $aux.'Rules Applicable to the Arbitration: The arbitrator shall apply applicable substantive law consistent with the Federal Arbitration Act, 9 U. S.C. Sections 1 -16 ( "FAA"), shall apply statutes of limitation and shall honor claims of privilege recognized at law. The arbitrator may decide, with or without a hearing, any motion that is substantially similar to a motion to dismiss for failure to state a claim or a motion for summary judgment, in conducting the arbitration proceeding, the arbitrator shall not apply any Federal or State rules of civil procedure or evidence. Except as limited in this Agreement, the arbitrator shall have the authority to award any legal or equitable remedy or relief that a court in the State of Arizona could order or grant . If allowed by statute or applicable law, the arbitrator may award the prevailing party expert witness fees, statutory damages and/or reasonable attorney\' s fees and expenses. Regardless of whether the arbitrator renders a decision or an award in your favor resolving the dispute, you will not be responsible for reimbursing Lender for any portion of the Arbitration Fees advanced by Lender. At the timely request of any party, the arbitrator shall provide a written explanation of the award. The arbitrator\'s award may be filed with any court having jurisdiction.');

$pdf->setY(145);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(10, $textypos, "7.", 0, 'L');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(145);$pdf->setX(20);
$pdf->multiCell(0, $textypos, $aux.'Punitive Damages: The parties agree that they are waiving any right they may have to seed or recover punitive damages in any dispute. The arbitrator will therefore not have any power of authority to award punitive damages.');

$pdf->setY(160);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(10, $textypos, "8.", 0, 'L');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(160);$pdf->setX(20);
$pdf->multiCell(0, $textypos, $aux.'Small Claims Exception and Limitations: You and Lender retain any rights to self-help remedies, such as repossession. Neither you nor Lender waive the right to arbitrate by using self-help remedies or filing suit. All parties, including Related Third Parties, shall retain the right to seek adjudication in a small claims tribunal for claims within the scope of such tribunal\'s juridisction. Any claim which cannot be adjudicated within the juridigction of a small claims tribunal is subject to resolution by binding arbitration upon election by any party to this Agreement as set forth herein. Any appeal of a judgment from a small claims tribunal shall be resolved by binding arbitration.');

$pdf->setY(195);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(10, $textypos, "9.", 0, 'L');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(195);$pdf->setX(20);
$pdf->multiCell(0, $textypos, $aux.'Acknowledgment: You acknowledge and agree by entering into this Agreement, that Lender or any Related Third Party can compel you to arbitrate any dispute. If Lender or any Related Third Party chooses arbitration, you acknowledge and agree that: (a) YOUR ARE WAIVING YOUR RIGHT TO HAVE A COURT, OTHER THAN A SMALL CLAIMS TRIBUNAL RESOLVE ANY DISPUTE ALLEGED AGAINST LENDER OR RELATED THIRD PARTIES; AND (b) YOUR ARE WAIVING YOUR RIGHT TO SERVE AS REPRESENTATIVE, AS A PRIVATE ATTORNEY GENERAL OR IN ANY OTHER REPRESENTATIVE CAPACITY, OR PARTICIPATE AS A MEMBER or A CLASS or CLAIMANTS, IN ANY LAWSUIT PILED AGAINST LENDER AND/OR RELATED THIRD PARTIES.');

$pdf->setY(235);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(10, $textypos, "10.", 0, 'L');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(235);$pdf->setX(20);
$pdf->multiCell(0, $textypos, $aux.'Application of Federal Arbitration Act: The parties agree that the loan involves interstate commerce and that this Arbitration Agreement is subject to the FAA. If a final non-appealable judgment of a court having jurisdiction over this transaction finds for any reason that the FAA does not apply to this transaction, this Arbitration Agreement shall be governed by the arbitration law of your state of residence.');

//PAGINA 8////////////////////////////////////////////////////////////////////////
$pdf->AddPage('P', 'Letter');

$pdf->setY(25);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(10, $textypos, "11.", 0, 'L');
$pdf->SetFont('Arial','', $fontSize); 
$pdf->setY(25);$pdf->setX(20);
$aux= $pdf->multicell(0, $textypos, "OPT-OUT PROCESS: You may choose to opt-out of this Arbitration Agreement but only by following the process set forth below. If you do not wish to be subject to this Arbitration Agreement, then you must notify us in writing within sixty (60) calendar days of the date of the Agreement at the following address: Amigos Auto Title Loans, 2929 N 75th Ave. , Suite #03, Phoenix, AZ, 85033, Attention: Legal Department. Your written notice must include your name, address, social security number, the date and loan number of this Agreement, and a statement that you wish to opt-out of the Arbitration Agreement. Your opt-out notice MUST be sent by certified mail, return receipt requested. If this Agreement is not your first transaction with us and you provide us the appropriate op-out notice, then your decision to opt-out will algo apply to all your previous transactions with us.");

$pdf->setY(65);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(10, $textypos, "12.", 0, 'L');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(65);$pdf->setX(20);
$pdf->multiCell(0, $textypos, $aux.'Binding Agreement: This ARBITRATION AGREEMENT, INCLUDING WAIVER OF CLASS ACTION PROVISION, is binding upon and benefits your, your respective heirs, successors, assignes and related third parties. This Arbitration Agreement continues in full force and effect, even if your obligations have been paid or discharged through bankrupcy. This Arbitration Agreement survives any termination, amendment, expiration, or performace of a transaction between you, Lender and/or Related Third parties and continues in full force and effect unless you, Lender and/or Related Third parties otherwise agree in writing.');

$pdf->setY(95);$pdf->setX(10);
$pdf->SetFont('Arial','B', $fontSize);    
$aux= $pdf->multicell(10, $textypos, "13.", 0, 'L');
$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(95);$pdf->setX(20);
$pdf->multiCell(0, $textypos, $aux.'Severability: If it is determined that any paragraph or provision in this arbitration agreement is invalid, illegal or unenforceable, such illegality, invalidity or unenforceability will not affect the other paragraphs and provisions of this arbitration agreement. The remainder of this arbitration agreement will continue in full force and effect as if the severed paragraph or provision had not been included.');

$pdf->SetFont('Arial','B', $fontSize);   
$pdf->setY(120);$pdf->setX(10);
$pdf->multiCell(0, $textypos, $aux.'THIS CONTRACT CONTAINS A BINDING ARBITRATION PROVISION WHICH MAY BE ENFORCED BY THE PARTIES. BY SIGNING BELOW, YOU AGREE THAT YOU REVIEWED AND AGREED TO THIS ARBITRATION AGREEMENT PROVISION, INCLUDING WAIVER or CLASS ACTIONS PARTICIPATION.');

$pdf->setY(140);$pdf->setX(10);
$pdf->multiCell(0, $textypos, $aux.'You acknowledge that you have read and received a completely filled-in copy of this contract.', 0, 'L');

$pdf->SetFont('Arial','', $fontSize);   
$pdf->setY(150);$pdf->setX(10);
$pdf->cell(200, $textypos, $aux.'Borrower\'s Signature:________________________', 0, 0,'L');
$pdf->setY(150);$pdf->setX(90);
$pdf->cell(200, $textypos, $aux.'Date:________________________', 0, 0,'L');

$pdf->setY(155);$pdf->setX(10);
$pdf->cell(200, $textypos, $aux.'Co-Borrower\'s Signature:_____________________', 0, 'L');
$pdf->setY(155);$pdf->setX(90);
$pdf->cell(200, $textypos, $aux.'Date:________________________', 0, 0,'L');

$pdf->setY(160);$pdf->setX(10);
$pdf->cell(200, $textypos, $aux.'Co-signer\'s Signature:_______________________', 0, 'L');
$pdf->setY(160);$pdf->setX(90);
$pdf->cell(200, $textypos, $aux.'Date:________________________', 0, 0,'L');

$pdf->setY(170);$pdf->setX(10);
$pdf->cell(0, $textypos, $aux.'FOR INFORMATION CONTACT THE DEPARTAMENT OF FINANCIAL INSTITUTIONS, STATE OF ARIZONA', 0, 0, 'C');

//FIN DE DOCUMENTO PDF//////////////////////////////////////////////////////////////
$dominio = ".pdf";
$nombre = "contrato".$datosPrestario['numContrato'];
$final = $nombre . $dominio;
$pdf->output("F", "../contratos/".$final);
enviarContrato('Contract #'.$datosPrestario['numContrato'], 'A new contract has been generated with the number: '.$datosPrestario['numContrato'], "../contratos/", $final);

//$pdf->output();
header('location: ../verContrato.php?id_prestario='.$id_contrato);  

?>
