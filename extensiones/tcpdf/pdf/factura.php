<?php

require_once "../../../controladores/ventas.controlador.php";
require_once "../../../modelos/ventas.modelo.php";
require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";
require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";
require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";

class imprimirFactura {

    public $codigo;

    public function traerImpresionFactura() {
        // TRAEMOS LA INFORMACIÓN DE LA VENTA
        $itemVenta = "codigo";
        $valorVenta = $this->codigo;
        $respuestaVenta = ControladorVentas::ctrMostrarVentas($itemVenta, $valorVenta);

        $fecha = substr($respuestaVenta["fecha"], 0, -8);
        $productos = json_decode($respuestaVenta["productos"], true);
        $neto = number_format($respuestaVenta["neto"], 2);
        $impuesto = number_format($respuestaVenta["impuesto"], 2);
        $total = number_format($respuestaVenta["total"], 2);

        // TRAEMOS LA INFORMACIÓN DEL CLIENTE
        $itemCliente = "id";
        $valorCliente = $respuestaVenta["id_cliente"];
        $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

        // TRAEMOS LA INFORMACIÓN DEL VENDEDOR
        $itemVendedor = "id";
        $valorVendedor = $respuestaVenta["id_vendedor"];
        $respuestaVendedor = ControladorUsuarios::ctrMostrarUsuarios($itemVendedor, $valorVendedor);

        // REQUERIMOS LA CLASE TCPDF
        require_once('tcpdf_include.php');

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->startPageGroup();
        $pdf->AddPage();

        // BLOQUE 1: ENCABEZADO
        $bloque1 = <<<EOF
        <table>
            <tr>
                <td style="width:150px"><img src="images/logo-negro-bloque.png"></td>
                <td style="background-color:white; width:140px">
                    <div style="font-size:8.5px; text-align:right; line-height:15px;">
                        <br>
                        <strong>NIT:</strong> 123456789
                        <br>
                        <strong>Dirección:</strong> Calle Falsa 123
                    </div>
                </td>
                <td style="background-color:white; width:140px">
                    <div style="font-size:8.5px; text-align:right; line-height:15px;">
                        <br>
                        <strong>Teléfono:</strong> (123) 456-7890
                        <br>
                        <strong>Correo:</strong> info@empresa.com
                    </div>
                </td>
                <td style="background-color:white; width:110px; text-align:center; color:red"><br><br><strong>FACTURA N.</strong><br>$valorVenta</td>
            </tr>
        </table>
EOF;
        $pdf->writeHTML($bloque1, false, false, false, false, '');

        // BLOQUE 2: INFORMACIÓN DEL CLIENTE Y VENDEDOR
        $bloque2 = <<<EOF
        <table>
            <tr>
                <td style="width:540px"><img src="images/back.jpg"></td>
            </tr>
        </table>
        <table style="font-size:10px; padding:5px 10px;">
            <tr>
                <td style="border: 1px solid #666; background-color:white; width:390px">
                    <strong>Cliente:</strong> $respuestaCliente[nombre]
                </td>
                <td style="border: 1px solid #666; background-color:white; width:150px; text-align:right">
                    <strong>Fecha:</strong> $fecha
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; background-color:white; width:540px"><strong>Vendedor:</strong> $respuestaVendedor[nombre]</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #666; background-color:white; width:540px"></td>
            </tr>
        </table>
EOF;
        $pdf->writeHTML($bloque2, false, false, false, false, '');

        // BLOQUE 3: ENCABEZADO DE PRODUCTOS
        $bloque3 = <<<EOF
        <table style="font-size:10px; padding:5px 10px;">
            <tr>
                <td style="border: 1px solid #666; background-color:#f2f2f2; width:260px; text-align:center"><strong>Producto</strong></td>
                <td style="border: 1px solid #666; background-color:#f2f2f2; width:80px; text-align:center"><strong>Cantidad</strong></td>
                <td style="border: 1px solid #666; background-color:#f2f2f2; width:100px; text-align:center"><strong>Valor Unit.</strong></td>
                <td style="border: 1px solid #666; background-color:#f2f2f2; width:100px; text-align:center"><strong>Valor Total</strong></td>
            </tr>
        </table>
EOF;
        $pdf->writeHTML($bloque3, false, false, false, false, '');

        // BLOQUE 4: DETALLES DE PRODUCTOS
        foreach ($productos as $key => $item) {
            $precioTotal = number_format($item["total"], 2);
            $cantidad = $item["cantidad"];
            $valorUnitario = $cantidad > 0 ? number_format($item["total"] / $cantidad, 2) : '0.00';

            $bloque4 = <<<EOF
            <table style="font-size:10px; padding:5px 10px;">
                <tr>
                    <td style="border: 1px solid #666; color:#333; background-color:white; width:260px; text-align:center">
                        $item[descripcion]
                    </td>
                    <td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:center">
                        $item[cantidad]
                    </td>
                    <td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
                        $ $valorUnitario
                    </td>
                    <td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
                        $ $precioTotal
                    </td>
                </tr>
            </table>
EOF;
            $pdf->writeHTML($bloque4, false, false, false, false, '');
        }

        // BLOQUE 5: TOTALES
        $bloque5 = <<<EOF
        <table style="font-size:10px; padding:5px 10px;">
            <tr>
                <td style="color:#333; background-color:white; width:340px; text-align:center"></td>
                <td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:center"></td>
                <td style="border-bottom: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center"></td>
            </tr>
            <tr>
                <td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>
                <td style="border: 1px solid #666; background-color:#f2f2f2; width:100px; text-align:center">
                    <strong>Neto:</strong>
                </td>
                <td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
                    $ $neto
                </td>
            </tr>
            <tr>
                <td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>
                <td style="border: 1px solid #666; background-color:#f2f2f2; width:100px; text-align:center">
                    <strong>Total:</strong>
                </td>
                <td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
                    $ $total
                </td>
            </tr>
        </table>
EOF;
        $pdf->writeHTML($bloque5, false, false, false, false, '');

        // SALIDA DEL ARCHIVO
        $pdf->Output('factura.pdf');
    }
}

$factura = new imprimirFactura();
$factura->codigo = $_GET["codigo"];
$factura->traerImpresionFactura();

?>