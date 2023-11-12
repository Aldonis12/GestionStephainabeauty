setTimeout(function () {
    $.ajax({
        url: "/clearSession",
        method: "GET",
        success: function (response) {
            console.log("Session Effacer");
        },
        error: function (error) {
            console.error("Erreur AJAX");
        },
    });
}, 2000);

var textCode = document.getElementById("texte-qrcode");
var scanqrDiv = document.querySelector(".scanqr");
var nomclient = document.getElementById("nom");

var scanner = null;

function startScanner() {
    if (scanner === null) {
        scanner = new Instascan.Scanner({
            video: document.getElementById("preview"),
        });
        Instascan.Camera.getCameras()
            .then(function (cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                } else {
                    alert("Pas de caméra disponible");
                }
            })
            .catch(function (e) {
                console.error(e);
            });

        scanner.addListener("scan", function (content) {
            if (content.startsWith("CLI-")) {
                checkClientInDatabaseForStartScanner(content);
            } else {
                alert("Ce QR Code n'est pas valide");
                startScanner();
            }
        });
    }
}

function stopScanner() {
    if (scanner) {
        scanner.stop();
        scanner = null;
    }
}

function checkClientInDatabaseForStartScanner(content) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "/CheckClientCode?code=" + content, true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);

            if (response.exists) {
                document.getElementById("selectedId").value = content;
                scanqrDiv.style.display = "none";
                textCode.innerHTML =
                    '<strong>Qr Code <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16"> <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg></strong>';
                stopScanner();
            } else {
                alert("Ce code client n'existe pas");
                startScanner();
            }
        }
    };

    xhr.send();
}

function startScannerUpdate() {
    if (scanner === null) {
        scanner = new Instascan.Scanner({
            video: document.getElementById("preview"),
        });
        Instascan.Camera.getCameras()
            .then(function (cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                } else {
                    alert("Pas de caméra disponible");
                }
            })
            .catch(function (e) {
                console.error(e);
            });

        scanner.addListener("scan", function (content) {
            if (content.startsWith("CLI-")) {
                checkClientCodeInDatabase(content);
            } else {
                alert("Ce QR Code n'est pas valide");
                startScanner();
            }
        });
    }
}

function checkClientCodeInDatabase(content) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "/CheckClientCode?code=" + content, true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.exists) {
                alert("Ce code appartient déjà à un client");
                startScanner();
            } else {
                document.getElementById("newCode").value = content;
                stopScanner();
                scanqrDiv.style.display = "none";
            }
        }
    };

    xhr.send();
}

function startScannerClient() {
    if (scanner === null) {
        scanner = new Instascan.Scanner({
            video: document.getElementById("preview"),
        });
        Instascan.Camera.getCameras()
            .then(function (cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                } else {
                    alert("Pas de caméra disponible");
                }
            })
            .catch(function (e) {
                console.error(e);
            });

        scanner.addListener("scan", function (content) {
            if (content.startsWith("CLI-")) {
                checkClientInDatabase(content);
                stopScanner();
            } else {
                alert("Ce QR Code n'est pas valide");
                startScannerClient();
            }
        });
    }
}

function checkClientInDatabase(content) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "/CheckClientCode?code=" + content, true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);

            if (response.exists) {
                displayClientDetails(
                    response.clientDetails,
                    response.serviceDetails
                );
            } else {
                alert("Ce code client n'existe pas");
                startScannerClient();
            }
        }
    };

    xhr.send();
}

function displayClientDetails(clientDetails, serviceDetails) {
    var h3_scanner = document.getElementById("h3_scanner");
    var clientHTML =
        '<br><div class="container"><h4>Nom : ' +
        clientDetails.nom +
        "</h4><h4>Prénom : " +
        clientDetails.prenom +
        "</h4></div>";

    var serviceHTML =
        '<br><div class="container"><table class="table table-bordered"><thead><tr><th>Service</th><th>Nombre</th></tr></thead><tbody>';

    serviceDetails.forEach(function (service) {
        serviceHTML +=
            "<tr><td>" +
            service.nom +
            "</td><td>" +
            service.nombre +
            "</td></tr>";
    });

    serviceHTML += "</tbody></table></div>";

    h3_scanner.style.display = "none";
    var detailsDiv = document.getElementById("clientDetails");
    detailsDiv.innerHTML = clientHTML + serviceHTML;
}
