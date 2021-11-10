<?php
namespace App\Controllers\Reporte;
use App\Controllers\BaseController;

class Reporte extends BaseController{

public function validarReporte(){
    $validation =  \Config\Services::validation();
    $request= \Config\Services::request();
    $fechaInicio=$request->getPostGet('inputFechaInicioReportePlatos');
    $fechaFinal=$request->getPostGet('inputFechaHastaReportePlatos');

    $validation->setRules([
            // 'inputFechaInicioReportePlatos' => 'required|fechamayor['.$fechaInicio.']|validarFechaIngresadaInicioMayor['.$fechaInicio.','.$fechaFinal.']|valid_date',
            // 'inputFechaHastaReportePlatos'=>'required|validarfechasfut['.$fechaFinal.']|validarFechaIngresadaFinMenor['.$fechaInicio.','.$fechaFinal.']|valid_date',
            'inputFechaInicioReportePlatos' => 'required|validarFechaIngresadaInicioMayor['.$fechaInicio.','.$fechaFinal.']|valid_date',
            'inputFechaHastaReportePlatos' => 'required|validarFechaIngresadaFinMenor['.$fechaInicio.','.$fechaFinal.']|valid_date',
            'inputTipoReporte'=>'required|in_list[1,2,3,4,5]',
        ],
//Descomentado los input con el tema de las fechas mayores
        [   // Errores-Mensajes
        'inputFechaInicioReportePlatos' =>[
            'required'=>'Debe ingresar una fecha.',
            // 'fechamayor'=>'Debe ingresar una fecha mayor o igual a la fecha actual. ',
             'validarFechaIngresadaInicioMayor'=>'Error. Se ingreso una fecha mayor a la fecha fin. Vuelvalo a intentar. ',
            'valid_date'=>'Debe ingresar una fecha valida.'
        ],
        'inputFechaHastaReportePlatos' => [
            'required' => 'Debe ingresar una fecha.',
            // 'validarfechasfut'=>'Debe ingresar una fecha mayor a la seleccionada 2. ',
             'validarFechaIngresadaFinMenor'=>'Error. Se ingreso una fecha menor a la fecha inicio. Vuelvalo a intentar. ',
            'valid_date'=>'Debe ingresar una fecha valida.'
        ],
        'inputTipoReporte' => [
            'required' => 'Debe ingresar un tipo de reporte',
            'in_list' =>'Debe seleccionar una opcion valida'
        ]
        ]
    );

    if (!$validation->withRequest($this->request)->run()) {
        echo json_encode(["status"=>true,"data"=>$validation->getErrors()]);
    }else {
        echo json_encode(["status"=>false]);
    }

}

public function validarReportePas(){
  $validation =  \Config\Services::validation();
  $request= \Config\Services::request();
  $fechaInicio=$request->getPostGet('inputFechaInicioReportePlatos');
  $fechaFinal=$request->getPostGet('inputFechaHastaReportePlatos');
//Descomentado la validacion de fechas pasadas
  $validation->setRules([
            // 'inputFechaInicioReportePlatos' => 'required|validateDate['.$fechaInicio.']|valid_date',
            'inputFechaInicioReportePlatos' => 'required|validateDate['.$fechaInicio.']|valid_date',
            // 'inputFechaInicioReportePlatos'=>'required|validateDate['.$fechaFinal.']|valid_date',
            'inputFechaHastaReportePlatos'=>'required|validateDate['.$fechaFinal.']|valid_date',
            'inputTipoReporte'=>'required|in_list[1,2,3,4,5]',
      ],

      [   // Errores-Mensajes
  'inputFechaInicioReportePlatos' =>[
      'required'=>'Debe ingresar una fecha.',
       'validateDate'=>'Debe ingresar una fecha menor a la seleccionada. ',
      'valid_date'=>'Debe ingresar una fecha valida.'
  ],
  'inputFechaHastaReportePlatos' => [
      'required' => 'Debe ingresar una fecha.',
       'validateDate'=>'Debe ingresar una fecha menor a la seleccionada. ',
      'valid_date'=>'Debe ingresar una fecha valida.'
  ],
  'inputTipoReporte' => [
      'required' => 'Debe ingresar un tipo de reporte',
      'in_list' =>'Debe seleccionar una opcion valida'
  ]
]
);

if (!$validation->withRequest($this->request)->run()) {

    //return  redirect()->back()->with('errors',$validation->getErrors())->withInput();
    echo json_encode(["status"=>true,"data"=>$validation->getErrors()]);
}else {
  echo json_encode(["status"=>false]);
}

}

}
