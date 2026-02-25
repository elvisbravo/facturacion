<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Venta #<?= $id ?></title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            width: 80mm;
            margin: 0;
            padding: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 16px;
            margin: 5px 0;
        }

        .separator {
            border-bottom: 1px dashed #000;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .total {
            font-weight: bold;
            font-size: 14px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
        }

        @media print {
            body {
                width: 80mm;
            }
        }
    </style>
</head>

<body>
    <!-- Container to be converted to PDF -->
    <div id="ticket-container">
        <div class="header">
            <h1>BRAVO FACT</h1>
            <p>RUC: 20601234567<br> Av. Pardo 123, Miraflores<br> Lima - Perú</p>
        </div>

        <div class="separator"></div>

        <p>
            <strong>BOLETA DE VENTA ELECTRÓNICA</strong><br>
            Serie: B001 - Correlativo: <?= str_pad($id, 8, '0', STR_PAD_LEFT) ?><br>
            Fecha: <?= date('d/m/Y H:i:s') ?><br>
            Cliente: CLIENTE GENÉRICO
        </p>

        <div class="separator"></div>

        <table>
            <thead>
                <tr>
                    <th style="width: 50%;">DESCRIPCIÓN</th>
                    <th class="text-right">CANT</th>
                    <th class="text-right">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Producto de Ejemplo 1</td>
                    <td class="text-right">2</td>
                    <td class="text-right">20.00</td>
                </tr>
                <tr>
                    <td>Producto de Ejemplo 2</td>
                    <td class="text-right">1</td>
                    <td class="text-right">15.50</td>
                </tr>
            </tbody>
        </table>

        <div class="separator"></div>

        <table>
            <tr>
                <td>Op. Gravadas</td>
                <td class="text-right">30.08</td>
            </tr>
            <tr>
                <td>IGV (18%)</td>
                <td class="text-right">5.42</td>
            </tr>
            <tr class="total">
                <td>TOTAL</td>
                <td class="text-right">S/ 35.50</td>
            </tr>
        </table>

        <div class="separator"></div>

        <div class="footer">
            <p>Representación impresa de la Boleta de Venta Electrónica.</p>
            <p><strong>¡GRACIAS POR SU COMPRA!</strong></p>
        </div>
    </div>

    <!-- html2pdf Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        window.onload = function() {
            const element = document.getElementById('ticket-container');
            const opt = {
                margin: [0, 0],
                filename: 'ticket-<?= $id ?>.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2,
                    logging: false,
                    dpi: 192,
                    letterRendering: true
                },
                jsPDF: {
                    unit: 'mm',
                    format: [80, 150],
                    orientation: 'portrait'
                }
            };

            // Generate and open print dialog
            html2pdf().set(opt).from(element).toPdf().get('pdf').then(function(pdf) {
                window.parent.document.title = "Ticket #<?= $id ?>";
                // Optionally auto-open the print dialog of the generated PDF
                setTimeout(() => {
                    window.print();
                }, 500);
            });
        };
    </script>
</body>

</html>