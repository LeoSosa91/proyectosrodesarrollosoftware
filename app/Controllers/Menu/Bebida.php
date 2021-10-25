<?php namespace App\Controllers\Menu;
use App\Controllers\BaseController;
use Faker\Factory;

class Bebida extends BaseController{

	public function index(){   
		$model= model('BeverageModel');
		$bebidas=$model->orderBy('nombreBebida', 'asc')->findAll();
		$tipoBebidas=$model->groupBy('idCategoriaBebida')->orderBy('idCategoriaBebida', 'asc')->findColumn('idCategoriaBebida');
		$cardsBebidas='';
		$num=1;
		$db      = \Config\Database::connect();
		$builder = $db->table('categoriabebida');
		$query   = $builder->get();
		$data=$query->getResultArray();

		foreach ($tipoBebidas as $tipoBebida) {
			$cardsBebidas.='<button class="btn btn-dark mb-3 text-start" type="button" data-bs-toggle="collapse" data-bs-target="#multiCollapseExample'.$num.'" aria-expanded="false" aria-controls="multiCollapseExample'.$num.'"><span class="">';
			foreach ($data as $categoria) {
				$cardsBebidas.= ($tipoBebida==$categoria['idCategoriaBebida']) ?  $categoria['nombreCategoriaBebida']:"";
			
			}
			
			$cardsBebidas.='</span><span class="text-end">
			<span class="right-icon">
			  <i class="bi bi-chevron-down"></i>
			</span>
		  	</span></button>
			<div class="collapse multi-collapse" id="multiCollapseExample'.$num.'">';
			
			foreach ($bebidas as $bebida) {
			if ($tipoBebida==$bebida['idCategoriaBebida']) {
				$cardsBebidas.='<div class="row">
				<div class="col-10">
				<h6>'.$bebida['nombreBebida'].'</h6>
						</div>
				<div class="col-2 text-end">
				<h6>$'.$bebida['precioBebida'].'.00</h6>
				</div>
				</div>';
			}
			}
			$cardsBebidas.='</div>';
			$num++;
		}
		$data['title']="Bebidas";
		$data['bebidas']=$cardsBebidas;
		return view('Front/head',$data).view('Front/header').view('Front/sidebar').view('Clients/beverage',$data).view('Front/script_client');
	}
    public function buscarBebida()
	{
		$request= \Config\Services::request();
		$id=$request->getPostGet('id');
		$modelBebida= model('BeverageModel');
		$data=$modelBebida->getBeverageBy('idBebida',$id);
		echo json_encode(array("status" => true , 'data' => $data));
	}
    public function listarBebidas()
	{
		$modelBebida= model('BeverageModel');
		$data=$modelBebida->asObject()->orderBy('idCategoriaBebida', 'asc')->findAll();
		$db      = \Config\Database::connect();
		$builder = $db->table('categoriabebida');
		$query   = $builder->get();
		$tipoBebidas=$query->getResultArray();
		echo json_encode(array("tipo" => $tipoBebidas , 'data' => $data));
	}
	public function editarBebida()
	{
		$validation =  \Config\Services::validation();
		$request= \Config\Services::request();
        $validation->setRules([
			'inputNameDrink' => 'required|min_length[1]',
		  	'typeDrink'=>'required|in_list[1,2,3,4]',
			'inputPrice'=>'required',
			'stateDrink'=>'required|in_list[0,1]',
		],
		[   // Errores-Mensajes
			'inputNameDrink' =>[
				'required'=>'Debe ingresar un nombre de una bebida',
				'min_length'=>'Debe ingresar nombre de bebida valido',
			],
			'inputPrice' => [
				'required' => 'Debe ingresar un precio de bebida',
			],
			'typeDrink' => [
				'required' => 'Debe seleccionar una opcion de categoria de bebida',
				'in_list'=>'Debe seleccionar una opcion valida',
			],
			'stateDrink' => [
				'required' => 'Debe seleccionar una opcion de estado',
				'in_list'=>'Debe seleccionar una opcion valida',
			]
		]
		);

		if (!$validation->withRequest($this->request)->run()) {
			return  redirect()->back()->with('errors',$validation->getErrors())->withInput();
		}else {

			$data=array(
				// 'idBebida'=>$request->getVar('idBebida'),
				'nombreBebida'=>strtoupper($request->getVar('inputNameDrink')),
				'tipoBebida'=>intval($request->getVar('typeDrink')),
				'precioBebida'=>doubleval($request->getVar('inputPrice')),
				'updated_at'=>date('Y-m-d H:i:s'),
				'deleted_at'=>intval($request->getVar('stateDrink')),
			);
			
			$beverageModel= model('BeverageModel');
			if (false===$beverageModel->update($request->getVar('idBebida'),$data)) {
				return  redirect()->back()->with('msg',['type'=> 'danger', 'body'=>'Error al modificar bebida. Intentelo más tarde']);

			} else {
				return  redirect()->back()->with('msg',['type'=> 'success', 'body'=>'Se pudo modificar bebida con exito']);
			}
			
		}
	}
	public function agregarBebida()
    {
        $validation =  \Config\Services::validation();
		$request= \Config\Services::request();
        $faker = Factory::create();
		$validation->setRules([
			'inputNameDrink' => 'required|min_length[1]',
		  	'typeDrink'=>'required|in_list[1,2,3,4]',
			'inputPrice'=>'required',
			'stateDrink'=>'required|in_list[0,1]',
		],
		[   // Errores-Mensajes
			'inputNameDrink' =>[
				'required'=>'Debe ingresar un nombre de una bebida',
				'min_length'=>'Debe ingresar nombre de bebida valido',
			],
			'inputPrice' => [
				'required' => 'Debe ingresar un precio de bebida',
			],
			'typeDrink' => [
				'required' => 'Debe seleccionar una opcion de categoria de bebida',
				'in_list'=>'Debe seleccionar una opcion valida',
			],
			'stateDrink' => [
				'required' => 'Debe seleccionar una opcion de estado',
				'in_list'=>'Debe seleccionar una opcion valida',
			]
		]
		);

		if (!$validation->withRequest($this->request)->run()) {
			return  redirect()->back()->with('errors',$validation->getErrors())->withInput();
		}else {

			$data=array(
				'idBebida'=>$faker->unique()->uuid,
				'nombreBebida'=>strtoupper($request->getVar('inputNameDrink')),
				'tipoBebida'=>intval($request->getVar('typeDrink')),
				'precioBebida'=>doubleval($request->getVar('inputPrice')),
				'created_at'=>date('Y-m-d H:i:s'),
				'updated_at'=>date('Y-m-d H:i:s'),
				'deleted_at'=>intval($request->getVar('stateDrink')),
			);
			
			$beverageModel= model('BeverageModel');
			if (false===$beverageModel->insert($data)) {
				return  redirect()->back()->with('msg',['type'=> 'danger', 'body'=>'Error al agregar bebida. Intentelo más tarde']);

			} else {
				return  redirect()->back()->with('msg',['type'=> 'success', 'body'=>'Se pudo agregar bebida con exito']);
			}
			
		}
        
    }
}