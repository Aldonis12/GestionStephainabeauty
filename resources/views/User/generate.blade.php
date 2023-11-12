<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .qr-code-container {
            border: 2px solid black;
            margin: 20px;
            padding: 80px;
            text-align: center;
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        .qr-code-image {
            max-width: 200px;
            max-height: 200px;
            margin-left: 10px; /* Espacement entre les images */
        }

        .custom-image {
            max-width: 400px;
            max-height: 400px;
        }
    </style>
    <title>QR Codes</title>
</head>
<body>

    @for($i=1;$i<101;$i++)
        <div class="qr-code-container">
            <img class="custom-image" src="{{ asset('assets/images/logoSB.svg') }}" alt="Custom Image">
            <div class="qr-code-image">
                {!! DNS2D::getBarcodeHTML("CLI-$i",'QRCODE',3,3)!!}
            </div>
        </div>
    @endfor

</body>
</html>
