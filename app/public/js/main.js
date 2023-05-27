/* ========== MENÚ ========== */

var html = document.querySelector("html");
var menu = document.querySelector("header");

/**
 * Muestra el menú
 */
function showMenu() {
    console.log("A")
    html.style = "overflow: hidden";
    menu.style = "display: flex";
}

/**
 * Oculta el menú
 */
function closeMenu() {
    html.style = "";
    menu.style = "";
}

/* ========== VENTANA MODAL ========== */

// Selectores
var modal = document.querySelector('.modal');
var flogin = document.querySelector('.modal #login');
var fregister = document.querySelector('.modal #register');

/**
 * Muestra la ventana modal con el login
 * @return false
 */
function login() {
    flogin.style = "display: block";
    fregister.style = "display: none";
    modal.style = "top: 50%";
    return false;
}

/**
 * Muestra la ventana modal con el registro
 * @return false
 */
function register() {
    fregister.style = "display: block";
    flogin.style = "display: none";
    modal.style = "top: 50%";
    return false
}

/**
 * Oculta la ventana modal
 */
function closeModal() {
    modal.style = "";
    fregister.style = "";
    flogin.style = "";
}

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