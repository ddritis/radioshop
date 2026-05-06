// #0 public/js/script.js

/**
 * Funzione per il controllo dei campi del form di registrazione
 */
function myFunction() {
    alert("Controllare i campi obbligatori");
}

/**
 * Funzioni di reindirizzamento per l'acquisto prodotti
 */
function goto4() {
    window.location.href = "https://www.raspberrypi.com/products/raspberry-pi-4-model-b/";
}

function goto3() {
    window.location.href = "https://www.raspberrypi.com/products/raspberry-pi-3-model-b/";
}

function goto5() {
    window.location.href = "http://www.orangepi.org/html/hardWare/computerAndMicrocontrollers/details/Orange-Pi-5-plus.html";
}


    document.addEventListener("DOMContentLoaded", function() {
        // #1 Funzione per leggere l'array dei cookie del browser
        function getCookie(name) {
            let match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
            if (match) return match[2];
            return null;
        }

    // #2 Logica di visualizzazione
    if (!getCookie("gdpr_accepted")) {
        document.getElementById("cookieConsent").style.display = "block";
    }

    // #3 Gestione evento click
    document.getElementById("btnAcceptCookies").addEventListener("click", function() {
        let expires = new Date();
    // #4 Imposto la scadenza a 30 giorni
    expires.setTime(expires.getTime() + (30 * 24 * 60 * 60 * 1000));

    // #5 Scrivo il cookie con flag di sicurezza
    document.cookie = "gdpr_accepted=true;expires=" + expires.toUTCString() + ";path=/;SameSite=Strict";

    // #6 Rimuovo il banner dal flusso visivo
    document.getElementById("cookieConsent").style.display = "none";
    });
});
