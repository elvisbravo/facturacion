<?php

use App\Models\AperturaCajaModel;

if (!function_exists('getCajaAbierta')) {
    function getCajaAbierta()
    {
        $session = session();
        $usuario_id = $session->get('id');

        if (!$usuario_id) {
            return null;
        }

        $aperturaCajaModel = new AperturaCajaModel();
        return $aperturaCajaModel->select('apertura_caja.*, caja.hora_cierre, caja.nombre_caja')
            ->join('caja', 'caja.id = apertura_caja.caja_id')
            ->where('apertura_caja.usuario_id', $usuario_id)
            ->where('apertura_caja.estado', 1)
            ->first();
    }
}
