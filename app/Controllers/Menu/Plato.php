<?php namespace App\Controllers\Menu;
use App\Controllers\BaseController;
use Faker\Factory;
class Plato extends BaseController{

	public function index()
	{
		$model= model('FoodModel');
		$platos=$model->where('deleted_at',null)->orderBy('nombrePlato', 'asc')->findAll();
		$cardsPlatos='';
		$num=1;
		$db      = \Config\Database::connect();
		$categorias = $db->table('categoriaplato')->get()->getResultArray();
		
		foreach ($categorias as $categoria) {
			$cardsPlatos.='<div class="accordion-item"> 
							<h2 class="accordion-header border border-dark" id="flush-heading'.$num.'">
							<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse'.$num.'" aria-expanded="false" aria-controls="flush-collapse'.$num.'">'.$categoria['nombreCategoriaPlato'].'</button>
							</h2>
							<div id="flush-collapse'.$num.'" class="accordion-collapse collapse" aria-labelledby="flush-heading'.$num.'" data-bs-parent="#accordionFlushExample">
							<div class="accordion-body">';
				foreach ($platos as $plato) {
					if ($plato['idCategoriaPlato']==$categoria['idCategoriaPlato']) {
						$cardsPlatos.='<div class="row">
											<div class="col-10">
											<h6>'.$plato['nombrePlato'].'</h6>
											<p>'.$plato['descripcionPlato'].'</p>
											</div>
											
											<div class="col-2 text-end">
											<h6>$'.$plato['precioPlato'].'.00</h6>
											</div>
											<hr>
										</div>';
					}
				}
				$cardsPlatos.='</div></div></div>';

			$num++;
		}
		$data['title']="Platos";
		$data['platos']=$cardsPlatos;
		return view('Front/head',$data).view('Front/header').view('Front/sidebar').view('Clients/food',$data);
	}
	public function buscarPlato()
	{
		$request= \Config\Services::request();
		$id=$request->getPostGet('id');
		$modelPlatos= model('FoodModel');
		$data=$modelPlatos->getFoodBy('idPlato',$id);
		echo json_encode(array("status" => true , 'data' => $data));
	}
    public function listarPlatos()
	{
		$modelPlatos= model('FoodModel');
		$data=$modelPlatos->asObject()->orderBy('idCategoriaPlato', 'asc')->findAll();
		$db      = \Config\Database::connect();
		$builder = $db->table('categoriaplato');
		$query   = $builder->get();
		$tipoPlatos=$query->getResultArray();
		echo json_encode(array("tipo" => $tipoPlatos , 'data' => $data));
	}
	public function modificarPlato()
	{
		$validation =  \Config\Services::validation();
		$request= \Config\Services::request();
		$validation->setRules([
			'inputNameFood' => 'required|min_length[1]',
		  	'typeFood'=>'required|in_list[1,2,3,4]',
			'inputIngredientes'=>'required|min_length[1]',
			'inputPrice'=>'required',
			'stateFood'=>'required|in_list[0,1]',
		],
		[   // Errores-Mensajes
			'inputNameFood' =>[
				'required'=>'Debe ingresar un nombre de un plato',
				'min_length'=>'Debe ingresar nombre de plato valido',
			],
			'inputIngredientes' => [
				'required' => 'Debe ingresar ingredientes/descripción del plato',
				'min_length'=>'Debe ingresar ingredientes/descripción de plato valido',
			],
			'inputPrice' => [
				'required' => 'Debe ingresar un precio de plato',
			],
			'typeFood' => [
				'required' => 'Debe seleccionar una opcion de categoria de plato',
				'in_list'=>'Debe seleccionar una opcion valida',
			],
			'stateFood' => [
				'required' => 'Debe seleccionar una opcion de estado',
				'in_list'=>'Debe seleccionar una opcion valida',
			]
		]
		);

		if (!$validation->withRequest($this->request)->run()) {
			return  redirect()->back()->with('errors',$validation->getErrors())->withInput();
		}else {
			$data=array(
				'nombrePlato'=>strtoupper($request->getVar('inputNameFood')),
				'idCategoriaPlato'=>intval($request->getVar('typeFood')),
				'descripcionPlato'=>strtoupper($request->getVar('inputIngredientes')),
				'precioPlato'=>doubleval($request->getVar('inputPrice')),
				'updated_at'=>date('Y-m-d H:i:s'),
				'deleted_at'=>($request->getVar('stateFood')=="0") ? null : date('Y-m-d H:i:s')
			);
			$foodModel= model('FoodModel');
			if (false===$foodModel->update($request->getVar('idPlato'),$data)) {
				return  redirect()->back()->with('msg',['type'=> 'danger', 'body'=>'Error al modificar el plato. Intentelo más tarde']);
			} else {
				return  redirect()->back()->with('msg',['type'=> 'success', 'body'=>'Se pudo modificar el plato con exito']);
			}
		}
		
	}
    public function agregarPlato()
    {
        $validation =  \Config\Services::validation();
		$request= \Config\Services::request();
        $faker = Factory::create();
		$validation->setRules([
			'inputNameFood' => 'required|min_length[1]',
		  	'typeFood'=>'required|in_list[1,2,3,4]',
			'inputIngredientes'=>'required|min_length[1]',
			'inputPrice'=>'required',
			'stateFood'=>'required|in_list[0,1]',
		],
		[   // Errores-Mensajes
			'inputNameFood' =>[
				'required'=>'Debe ingresar un nombre de un plato',
				'min_length'=>'Debe ingresar nombre de plato valido',
			],
			'inputIngredientes' => [
				'required' => 'Debe ingresar ingredientes/descripción del plato',
				'min_length'=>'Debe ingresar ingredientes/descripción de plato valido',
			],
			'inputPrice' => [
				'required' => 'Debe ingresar un precio de plato',
			],
			'typeFood' => [
				'required' => 'Debe seleccionar una opcion de categoria de plato',
				'in_list'=>'Debe seleccionar una opcion valida',
			],
			'stateFood' => [
				'required' => 'Debe seleccionar una opcion de estado',
				'in_list'=>'Debe seleccionar una opcion valida',
			]
		]
		);

		if (!$validation->withRequest($this->request)->run()) {
			return  redirect()->back()->with('errors',$validation->getErrors())->withInput();
		}else {

			$data=array(
				'idPlato'=>$faker->unique()->uuid,
				'nombrePlato'=>strtoupper($request->getVar('inputNameFood')),
				'idCategoriaPlato'=>intval($request->getVar('typeFood')),
				'descripcionPlato'=>strtoupper($request->getVar('inputIngredientes')),
				'precioPlato'=>doubleval($request->getVar('inputPrice')),
				'created_at'=>date('Y-m-d H:i:s'),
				'updated_at'=>date('Y-m-d H:i:s'),
				'deleted_at'=>($request->getVar('stateFood')=="0") ? null : date('Y-m-d H:i:s')
			);
			//dd($data);
			$foodModel= model('FoodModel');
			if (false===$foodModel->insert($data)) {
				return  redirect()->back()->with('msg',['type'=> 'danger', 'body'=>'Error al agregar plato. Intentelo más tarde']);

			} else {
				return  redirect()->back()->with('msg',['type'=> 'success', 'body'=>'Se pudo agregar plato con exito']);
			}
			
		}
        
    }
}