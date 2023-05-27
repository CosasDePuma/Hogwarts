/* ========== VENTANA MODAL ACTIVA CON AMBOS LOGINS ========== */

// Activamos estilos eventuales para poder desarrollar mejor
document.querySelector('.modal').style = "top: 50%";
document.querySelector('.modal #login').style = "display: block";
document.querySelector('.modal #register').style = "display: block";

/* ========== CORTINA ========== */

// Selectores
var cortina = document.querySelector('.modal .animal .cortina');
var passwds = document.querySelectorAll('.modal input[type="password"]');

// Eventos
for(var i = 0; i < passwds.length; i++) {
    // Sube la persiana
    passwds[i].addEventListener('blur', function() {
        cortina.style = "height: 20px";
    });
    
    // Baja la persina
    passwds[i].addEventListener('focus', function() {
        cortina.style = "height: 150px";
    });
}