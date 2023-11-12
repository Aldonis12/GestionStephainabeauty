var toggleButton = document.getElementById("toggleButton");
var scanqrDiv = document.querySelector(".scanqr");

var scanner = null;

toggleButton.addEventListener("click", function () {
    if (scanqrDiv.style.display === "none") {
        scanqrDiv.style.display = "block";
        startScanner();
    } else {
        scanqrDiv.style.display = "none";
        stopScanner();
    }
});

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
                scanqrDiv.style.display = "none";
                document.getElementById("selectedId").value = content;
                stopScanner();
            } else {
                alert("Le QR Code n'est pas valide");
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
