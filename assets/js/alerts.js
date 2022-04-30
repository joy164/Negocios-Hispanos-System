//alertas de inicio de sesion 
function ErrorInicioSesion(){
    Swal.fire({
        title: 'Upps!',
        text: 'Login Failed',
        icon: 'error',
        showConfirmButton: false,
        timer: 2000

      })
}
//alertas de inicio de sesion 
function ErrorInicioContrato(){
  Swal.fire({
      title: 'Contract number not found!',
      text: 'Please contact to Amigos Prestamos or verify your number contract',
      icon: 'warning',
      showConfirmButton: false,
      timer: 5000

    })
}

function ErrorInicioContrato2(){
  Swal.fire({
      title: 'Registered References!',
      text: 'You can\'t register your references if you already registered them',
      icon: 'info',
      footer: 'please contact to Amigos Prestamos to update or modify',
      showConfirmButton: false,
      timer: 6000

    })
}
//alertas de registro de Dealer
function AlertaEliminarItem(idItem, page){
  var pagina = page + "?id=";
  var url = 'controlador/' + pagina;
  var id = idItem;
  var urlFinal = url + id;
  Swal.fire({
    title: 'Are you Sure?',
    text: "You can't revert this action",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = urlFinal;
    }
  })
}

//alertas de Eliminacion
function CorrEliminarItem(){
  Swal.fire({
    icon:  'success',
    title: 'Delete it!',
    text:  'The record was deleted.'    
  })
}

function IncoEliminarItem(){
  Swal.fire({
    icon:  'error',
    title: 'Oops...',
    text:  'Something was wrong!'
  })
}
//alertas de Actualizacion
function CorrUpdateItem(){
  Swal.fire({
    icon:  'success',
    title: 'Updated!',
    text:  'The record was updated.'    
  })
}

function IncoUpdateItem(){
  Swal.fire({
    icon:  'error',
    title: 'Oops...',
    text:  'Algo malo ocurrio!'
  })
}
//alertas de Creacion
function CorrCreateItem(){
  Swal.fire({
    icon:  'success',
    title: 'Succes!',
    text:  'The record was created.'    
  })
}

function IncoCreateItem(){
  Swal.fire({
    icon:  'error',
    title: 'Oops...',
    text:  'We can\'t create the record!'
  })
}

//funciones extra

function setLista(valorSelect, id){
  document.getElementById(id).value = valorSelect; 
}

function nobackbutton(){
   window.location.hash="no-back-button";
   window.location.hash="Again-No-back-button"
   window.onhashchange=function(){window.location.hash="no-back-button";}   
}
