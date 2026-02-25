<?php

namespace App\Controllers;

class Ventas extends BaseController
{
    public function index()
    {
        return view('ventas/index');
    }

    public function posVenta()
    {
        return view('ventas/pos');
    }

    public function ticket($id = 0)
    {
        // ── Cargar FPDF (clase global sin namespace) ──────────────────────
        require_once ROOTPATH . 'vendor/setasign/fpdf/fpdf.php';

        // ── Datos ─────────────────────────────────────────────────────────
        $empresa    = 'BRAVO FACT';
        $slogan     = 'Tu facturacion, facil y rapida';
        $ruc        = 'RUC: 20601234567';
        $direccion  = 'Av. Pardo 123, Miraflores - Lima';
        $telefono   = 'Tel: (01) 234-5678';
        $web        = 'www.bravofact.pe';

        $serie      = 'B001';
        $corr       = str_pad($id, 8, '0', STR_PAD_LEFT);
        $fecha      = date('d/m/Y H:i:s');
        $cliente    = 'CLIENTE GENERICO';
        $cajero     = session()->get('nombres') ?? 'Administrador';

        $items = [
            ['desc' => 'Producto de Ejemplo 1', 'qty' => 2,  'price' => 20.00],
            ['desc' => 'Producto de Ejemplo 2', 'qty' => 1,  'price' => 15.50],
            ['desc' => 'Producto Adicional 3',  'qty' => 3,  'price' => 8.90],
        ];

        $subtotal = 0;
        foreach ($items as $i) {
            $subtotal += $i['qty'] * $i['price'];
        }
        $igv        = round($subtotal * 0.18 / 1.18, 2);
        $opGravadas = $subtotal - $igv;

        // ── Dimensiones ───────────────────────────────────────────────────
        $pageW  = 80;
        $margin = 4;
        $w      = $pageW - ($margin * 2); // 72 mm útil

        // ── Crear PDF ─────────────────────────────────────────────────────
        $pdf = new \FPDF('P', 'mm', [$pageW, 230]);
        $pdf->AddPage();
        $pdf->SetMargins($margin, $margin, $margin);
        $pdf->SetAutoPageBreak(true, $margin);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetTextColor(0, 0, 0);

        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        // BLOQUE 1: CABECERA
        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        $pdf->SetY($margin);

        // Nombre empresa en grande y negrita
        $pdf->SetFont('Helvetica', 'B', 18);
        $pdf->Cell($w, 9, $empresa, 0, 1, 'C');

        // Slogan en itálica
        $pdf->SetFont('Helvetica', 'I', 7);
        $pdf->Cell($w, 4, $slogan, 0, 1, 'C');

        $pdf->Ln(1);
        $pdf->SetFont('Helvetica', '', 7);
        $pdf->Cell($w, 4, $ruc, 0, 1, 'C');
        $pdf->Cell($w, 4, $direccion, 0, 1, 'C');
        $pdf->Cell($w, 4, $telefono . '  |  ' . $web, 0, 1, 'C');

        // Separador doble
        $pdf->Ln(2);
        $this->lineaDoble($pdf, $margin, $pdf->GetY(), $pageW - $margin);
        $pdf->Ln(2);

        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        // BLOQUE 2: TIPO DE COMPROBANTE
        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        $pdf->SetFont('Helvetica', 'B', 9);
        $pdf->Cell($w, 6, 'BOLETA DE VENTA ELECTRONICA', 0, 1, 'C');

        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->Cell($w, 5, "Serie: {$serie}   N.: {$corr}", 0, 1, 'C');

        $pdf->Ln(1);
        $this->lineaSimple($pdf, $margin, $pdf->GetY(), $pageW - $margin);
        $pdf->Ln(2);

        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        // BLOQUE 3: DATOS DEL COMPROBANTE
        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        $pdf->SetX($margin);
        $pdf->SetFont('Helvetica', 'B', 7.5);
        $pdf->Cell($w * 0.42, 5, 'Fecha emision:', 0, 0, 'L');
        $pdf->SetFont('Helvetica', '', 7.5);
        $pdf->Cell($w * 0.58, 5, $fecha, 0, 1, 'R');

        $pdf->SetX($margin);
        $pdf->SetFont('Helvetica', 'B', 7.5);
        $pdf->Cell($w * 0.42, 5, 'Cliente:', 0, 0, 'L');
        $pdf->SetFont('Helvetica', '', 7.5);
        $pdf->Cell($w * 0.58, 5, $cliente, 0, 1, 'R');

        $pdf->SetX($margin);
        $pdf->SetFont('Helvetica', 'B', 7.5);
        $pdf->Cell($w * 0.42, 5, 'Cajero:', 0, 0, 'L');
        $pdf->SetFont('Helvetica', '', 7.5);
        $pdf->Cell($w * 0.58, 5, $cajero, 0, 1, 'R');

        $pdf->Ln(1);
        $this->lineaSimple($pdf, $margin, $pdf->GetY(), $pageW - $margin);
        $pdf->Ln(2);

        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        // BLOQUE 4: DETALLE DE ITEMS
        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        $cDesc = $w * 0.46;
        $cQty  = $w * 0.12;
        $cPU   = $w * 0.20;
        $cTot  = $w * 0.22;

        // Encabezado tabla en negrita + subrayado
        $pdf->SetFont('Helvetica', 'B', 7.5);
        $pdf->SetX($margin);
        $pdf->Cell($cDesc, 5, 'DESCRIPCION',          'B', 0, 'L');
        $pdf->Cell($cQty,  5, 'CANT',                 'B', 0, 'C');
        $pdf->Cell($cPU,   5, 'P.U.',                 'B', 0, 'R');
        $pdf->Cell($cTot,  5, 'TOTAL',                'B', 1, 'R');

        // Filas de items
        $pdf->SetFont('Helvetica', '', 7.5);
        foreach ($items as $item) {
            $total = $item['qty'] * $item['price'];
            $pdf->SetX($margin);
            $pdf->Cell($cDesc, 5.5, $item['desc'],                           0, 0, 'L');
            $pdf->Cell($cQty,  5.5, (string)$item['qty'],                    0, 0, 'C');
            $pdf->Cell($cPU,   5.5, 'S/' . number_format($item['price'], 2), 0, 0, 'R');
            $pdf->Cell($cTot,  5.5, 'S/' . number_format($total, 2),        0, 1, 'R');
        }

        $pdf->Ln(1);
        $this->lineaSimple($pdf, $margin, $pdf->GetY(), $pageW - $margin);
        $pdf->Ln(2);

        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        // BLOQUE 5: TOTALES
        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        $pdf->SetFont('Helvetica', '', 7.5);
        $pdf->SetX($margin);
        $pdf->Cell($w * 0.6, 5, 'Op. Gravadas:', 0, 0, 'L');
        $pdf->Cell($w * 0.4, 5, 'S/ ' . number_format($opGravadas, 2), 0, 1, 'R');

        $pdf->SetX($margin);
        $pdf->Cell($w * 0.6, 5, 'IGV (18%):', 0, 0, 'L');
        $pdf->Cell($w * 0.4, 5, 'S/ ' . number_format($igv, 2), 0, 1, 'R');

        $pdf->Ln(1);
        $this->lineaDoble($pdf, $margin, $pdf->GetY(), $pageW - $margin);
        $pdf->Ln(2);

        // Total en grande y negrita
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->SetX($margin);
        $pdf->Cell($w * 0.52, 8, 'TOTAL:', 0, 0, 'L');
        $pdf->Cell($w * 0.48, 8, 'S/ ' . number_format($subtotal, 2), 0, 1, 'R');

        $this->lineaDoble($pdf, $margin, $pdf->GetY(), $pageW - $margin);
        $pdf->Ln(4);

        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        // BLOQUE 6: PIE DE PÁGINA
        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        // Línea de corte punteada
        $this->lineaPunteada($pdf, $margin, $pdf->GetY(), $pageW - $margin, $pdf->GetY());
        $pdf->Ln(3);

        $pdf->SetFont('Helvetica', '', 6.5);
        $pdf->SetX($margin);
        $pdf->MultiCell($w, 3.5, 'Representacion impresa de la Boleta de Venta Electronica. Consulte en: ' . $web, 0, 'C');

        $pdf->Ln(2);
        $pdf->SetFont('Helvetica', 'B', 9);
        $pdf->SetX($margin);
        $pdf->Cell($w, 6, '*** GRACIAS POR SU COMPRA ***', 0, 1, 'C');

        // ── Enviar al navegador (inline) ──────────────────────────────────
        $pdf->Output('I', "ticket-{$id}.pdf");
        exit;
    }

    // ── Línea simple ──────────────────────────────────────────────────────
    private function lineaSimple($pdf, float $x1, float $y, float $x2): void
    {
        $pdf->SetLineWidth(0.3);
        $pdf->Line($x1, $y, $x2, $y);
    }

    // ── Línea doble (efecto de separación fuerte) ─────────────────────────
    private function lineaDoble($pdf, float $x1, float $y, float $x2): void
    {
        $pdf->SetLineWidth(0.5);
        $pdf->Line($x1, $y, $x2, $y);
        $pdf->SetLineWidth(0.2);
        $pdf->Line($x1, $y + 0.8, $x2, $y + 0.8);
        $pdf->SetLineWidth(0.3); // reset
    }

    // ── Línea punteada de corte ───────────────────────────────────────────
    private function lineaPunteada($pdf, float $x1, float $y, float $x2, float $y2, float $segLen = 2): void
    {
        $pdf->SetLineWidth(0.2);
        $x = $x1;
        while ($x < $x2) {
            $end = min($x + $segLen, $x2);
            $pdf->Line($x, $y, $end, $y);
            $x += $segLen * 2;
        }
    }
}
