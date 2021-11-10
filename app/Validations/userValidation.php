<?php
namespace App\Validations;

class userValidation{

    public function chequeoEdad(string $fecha)
    {
        //$hoy = date("Y-m-d");
        
        $fechaActual = date_create(date("Y-m-d"));
        $fechaNac = date_create($fecha);
        $interval = date_diff($fechaActual, $fechaNac);
        $anio=intval($interval->format('%y'));
        if($anio < 18){
            return false;
        }else{
            return true;
        }
        // echo gettype(intval($interval->format('%y')));
    }
}