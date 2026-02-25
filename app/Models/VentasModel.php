<?php

namespace App\Models;

use CodeIgniter\Model;

class VentasModel extends Model
{
    protected $table      = 'ventas';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['id', 'fecha_venta', 'tipo_comprobante_id', 'tipo_pago', 'serie_comprobante', 'numero_comprobante', 'tipo_envio_sunat', 'id_tipo_operacion', 'total_gravadas', 'total_inafecta', 'total_exoneradas', 'total_gratuitas', 'total_exportacion', 'total_icbper', 'total_descuento', 'porcentaje_descuento_total', 'sub_total', 'porcentaje_igv', 'impuesto_icbper', 'total_igv', 'total_isc', 'total_otro_importe', 'total', 'total_letras', 'fecha_vencimiento', 'codigo_moneda', 'tipo_cambio_sunat', 'cliente_id', 'usuario_id', 'fecha_envio_sunat', 'estado_envio_sunat', 'hash_cpe', 'hash_cdr', 'cod_sunat', 'msj_sunat', 'ruta_xml', 'name_cdr', 'ruta_pdf', 'estado', 'sucursal_id'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
