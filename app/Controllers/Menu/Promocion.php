<?php namespace App\Controllers\Menu;
use App\Controllers\BaseController;
class Promocion extends BaseController{
    public function listarPromociones()
	{
		$db      = \Config\Database::connect();
		return $db->table('promocion')->get()->getResultArray();
		
	}
	public function buscarPromocion()
	{
		$request= \Config\Services::request();
		$id=$request->getPostGet('id');
		$db      = \Config\Database::connect();
		$builder = $db->table('promocion');
		$query   = $builder->where('idPromocion', $id)->get();
		$data=$query->getResult();
		echo json_encode($data);
	}
	public function agregarPromocion(){
		$validation =  \Config\Services::validation();
		$request= \Config\Services::request();
		$validation->setRules([
			'inputDescripcionPromocion' => 'required|min_length[1]',
		  	'inputDescuentoPromocion'=>'required|regex_match[^(0|[1-9][0-9]?|100)$]',
			'inputFecIniPromocion'=>'required',
			'inputFecFinPromocion'=>'required',
		],
		[   // Errores-Mensajes
			'inputDescripcionPromocion' =>[
				'required'=>'Debe ingresar una descripcion de la promocion',
				'min_length'=>'Debe ingresar una descripcion de la promocion valido',
			],
			'inputDescuentoPromocion' => [
				'required' => 'Debe ingresar un valor de descuento',
				'regex_match'=>'Debe ingresar un valor entre 1 a 100 para un valor de descuento',
			],
			'inputFecIniPromocion' => [
				'required' => 'Debe ingresar una fecha de inicio de la promocion',
			],
			'inputFecFinPromocion' => [
				'required' => 'Debe ingresar una fecha de fin de la promocion',
			]
		]
		);
		
		if (!$validation->withRequest($this->request)->run()) {
			return  redirect()->back()->with('errors',$validation->getErrors())->withInput();
		}else {
			$data=array(
				'descripcionPromocion'=>strtoupper($request->getVar('inputDescripcionPromocion')),
				'descuentoPromocion'=>intval($request->getVar('inputDescuentoPromocion')),
				'fechaPromocionInicio'=>$request->getVar('inputFecIniPromocion'),
				'fechaPromocionFin'=>$request->getVar('inputFecFinPromocion'),
			);
			$db      = \Config\Database::connect();
			$builder = $db->table('promocion');

			if (false===$builder->insert($data)) {
				return  redirect()->back()->with('msg',['type'=> 'danger', 'body'=>'Error al agregar una promocion. Intentelo más tarde']);
			} else {
				return  redirect()->back()->with('msg',['type'=> 'success', 'body'=>'Se pudo agregar una promocion con exito']);
			}
			
		}
	}
	public function editarPromocion()
	{
		$validation =  \Config\Services::validation();
		$request= \Config\Services::request();
		//|regex_match["^(0|[1-9][0-9]?|100)$"]
		//'regex_match'=>'Debe ingresar un valor entre 1 a 100 para un valor de descuento',
        $validation->setRules([
			'inputDescripcionPromocion' => 'required|min_length[1]',
		  	'inputDescuentoPromocion'=>'required',
			'inputFecIniPromocion'=>'required',
			'inputFecFinPromocion'=>'required',
		],
		[   // Errores-Mensajes
			'inputDescripcionPromocion' =>[
				'required'=>'Debe ingresar una descripcion de la promocion',
				'min_length'=>'Debe ingresar una descripcion de la promocion valido',
			],
			'inputDescuentoPromocion' => [
				'required' => 'Debe ingresar un valor de descuento',
			],
			'inputFecIniPromocion' => [
				'required' => 'Debe ingresar una fecha de inicio de la promocion',
			],
			'inputFecFinPromocion' => [
				'required' => 'Debe ingresar una fecha de fin de la promocion',
			]
		]
		);

		if (!$validation->withRequest($this->request)->run()) {
			return  redirect()->back()->with('error',['type'=>'danger','body'=>$validation->getErrors()]);
		}else {
			$data=array(
				'descripcionPromocion'=>strtoupper($request->getVar('inputDescripcionPromocion')),
				'descuentoPromocion'=>intval($request->getVar('inputDescuentoPromocion')),
				'fechaPromocionInicio'=>$request->getVar('inputFecIniPromocion'),
				'fechaPromocionFin'=>$request->getVar('inputFecFinPromocion'),
			);
			$db      = \Config\Database::connect();
			$builder = $db->table('promocion');

			if (false===$builder->update($data, ['idPromocion' => $request->getVar('idPromocion')])) {
				return  redirect()->back()->with('msg',['type'=> 'danger', 'body'=>'Error al modificar promoción. Intentelo más tarde']);

			} else {
				return  redirect()->back()->with('msg',['type'=> 'success', 'body'=>'Se pudo modificar promoción con exito']);
			}
			
		}
	
	}
	public function consultarPromocion(){
		$db = \Config\Database::connect();
		$request= \Config\Services::request();
		$dniUsu=$request->getPostGet('idUser');
		$query = $db->query('select * from penalidadcliente where id_user = "'.$dniUsu.'" ');
		$results = $query->getResultArray();
		$descuento=null;
		$idpromo=null;
  
		if (count($results) == 0) {
  
			$query2 = $db->query('select * from promocion where fechaPromocionInicio <= "'.date("Y-m-d").'" and fechaPromocionFin >= "'.date("Y-m-d").'" ');
			$auxPromo = [];
			$promociones = $query2->getResultArray();
			if (count($promociones) > 1) {
			  $numeroRan=rand(0,count($promociones));
			  $auxPromo = $promociones[$numeroRan];
			}if (count($promociones) == 1) {
			  $auxPromo = $promociones[0];
			}if (count($promociones) == 0) {
			  $data=array(
			  'idPromocion'=>0,
				  'descuentoPromocion'=>0,);
				  $auxPromo = $data;
			}
		echo json_encode(array("status" => "false-en promocion" , 'data' => $auxPromo));
		}else {
			$data=array(
				'idPromocion'=>0,
					'descuentoPromocion'=>0,
				);
			echo json_encode(array("status" => "false-en penalidades" , 'data' => $data));
  
		}
	}
}