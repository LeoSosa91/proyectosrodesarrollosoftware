<?php
namespace App\Validations;

class chequeofecha
{
  public function validarFechaIngresadaInicioMayor(string $fechaInicio,string $fechaFin){
    
    $fecha_fin = date($fechaFin.' 00:00:00');
    $fecha_ini = date($fechaInicio.' 00:00:00');
    $fecha_actual = date("d-m-Y 00:00:00");
    if($fecha_ini > $fecha_fin){
        return false;
    };
    if($fecha_ini<$fecha_actual){
        return false;
    };
    return true;
  }
  public function validarFechaIngresadaFinMenor(string $fechaInicio,string $fechaFin){
    
    // $fecha_ini = strtotime($fechaInicio.' 00:00:00');
    //$fecha_ini = date_create($fechaInicio);
    //$fecha_fin = date_create($fechaFin);
    // $fecha_fin = strtotime($fechaFin.' 00:00:00');
    // $fecha_actual = strtotime(date("d-m-Y H:i:00",time()));
    $fecha_fin = date($fechaFin.' 00:00:00');
    $fecha_ini = date($fechaInicio.' 00:00:00');

    if($fecha_fin < $fecha_ini){
        return true;//antes false
    }else{
        return false;//antes true
    }
  }
  public function validateDate(string $fecha){

    $fecha_actual = strtotime(date("d-m-Y H:i:00",time()));
    $fecha_entrada = strtotime($fecha.' 00:00:00');

    if($fecha_entrada > $fecha_actual)
        {
        return false;
        }else
            {
            return true;
            }
  }

  public function fechamayor(string $fecha){
    $fecha_actual = strtotime(date("d-m-Y 00:00:00"));
    $fecha_entrada = strtotime($fecha.' 00:00:00');

    if($fecha_entrada < $fecha_actual)
        {
        return false;
        }else
            {
            return true;
            }
  }

  public function validarfechasfut(string $fecha){
    $fecha_actual = strtotime(date("d-m-Y 00:00:00",time()));
    $fecha_entrada = strtotime($fecha.' 00:00:00');

    if($fecha_entrada < $fecha_actual)
        {

        return false;
        }else
            {
            return true;
            }

  }

}
