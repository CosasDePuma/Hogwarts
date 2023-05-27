/* Funcion que cambia el color de fondo de un elemento.  */
function surligne(champ, erreur){
   if(erreur)
      champ.style.backgroundColor = "#fba";
   else
      champ.style.backgroundColor = "";
}

/* Funcion encargada de comprobar el nombre del usuario en el registro. */
function verifPseudo(champ){
   if(champ.value.length < 1 || champ.value.length > 25){
      surligne(champ, true);
      return false;
      champ.focus();
   }
   else {
      surligne(champ, false);
      return true;
   }
}

/* Funcion encargada de comprobar el email del usuario en el login y el registro. */
function verifMail(champ){
   var regex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
   if(!regex.test(champ.value)){
      surligne(champ, true);
      return false;
      champ.focus();
   }
   else{
      surligne(champ, false);
      return true;
   }
}

/* Funcion encargada de comprobar la contraseña del usuario en el login y el registro. */
function verifPass(champ){
   var regex = /^[a-zA-Z0-9._-]{6,30}$/;
   if(!regex.test(champ.value)){
      surligne(champ, true);
      return false;
      champ.focus();
   }
   else{
      surligne(champ, false);
      return true;
   }
}

/* Funcion encargada de comprobar el dni en el registro */
function verifDNI(champ){
  var numero = champ.value.substr(0, 8);
	var letr = champ.value.substr(8, 1);
	var letra = 'TRWAGMYFPDXBNJZSQVHLCKET';
	var expresion_regular_dni = /^\d{8}[a-zA-Z]$/;
	if (expresion_regular_dni.test(champ.value)) {
		numero = numero % 23;
		letra = letra.substring(numero, numero + 1);
		if (letra != letr.toUpperCase()) {
      surligne(champ, true);
      return false;
      champ.focus();
		} else {
      surligne(champ, false);
      return true;
		}
	} else {
    surligne(champ, true);
    return false;
    champ.focus();
	}
}

/* Funcion encargada de comprobar los datos que se envian en el login. */
function verifFormLog(f){
   var mailOk = verifMail(f.email);
   var passOk = verifPass(f.password);
   if(passOk && mailOk)
      return true;
   else{
      return false;
   }
}

/* Funcion encargada de comprobar los datos que se envian en el registro. */
function verifFormReg(f){
   var nomOk = verifPseudo(f.apellido);
   var prenomOk = verifPseudo(f.nombre);
   /*var dniOK = verifDNI(f.dni);*/
   var mailOk = verifMail(f.email);
   var passOk = verifPass(f.password);
   if(nomOk && prenomOk /*&& dniOK*/ && mailOk && passOk)
      return true;
   else{
      return false;
   }
}

/* Funcion que devuelve true si una fecha y hora es posterior a la fecha y hora actual */
function dateCheck(f) {
   var current_date = new Date();
   var selected_date = (f.fecha.value + f.hora.value);
   alert(current_date);
   if (selected_date < current_date) {
      return true;
   } else {
      return false;
   }
}

/* Funcion encargada de limpiar el imput de Modal_NewFolder.php una vez que ya se a creado la carpeta. */
function estadoInicialModal_NewFolder(){
   var nameModal = document.getElementById('nameModal');
   nameModal.innerHTML = "";
}
