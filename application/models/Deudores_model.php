<?php 



class Deudores_model extends MY_Model
{

	public $BOT_USER_ID = 1253;
	public $url_direct_work;
	public $url_trigger_job;

	function __construct()
	{
		parent::__construct();
		$this->load->helper('env');
		$this->url_direct_work = env('PAGOS_BASE_URL')."/api/querydebts";
		$this->url_trigger_job = env('PAGOS_BASE_URL')."/api/runvalidatesol/";
	}

	/**
	 * Trigged one action development
	 *
	 * @param int $sol_id
	 * @return Boolean
	 */
	public function runCallbackValidate($sol_id,$tokencallback=null){

		if(!env('PAGOS_ACTIVE_DEBTORS_EP')){
			
			return false;
		}
		return $this->genericRequest($this->url_trigger_job.$sol_id,
			[
				'TOKEN'=>$tokencallback,
				'url_callback'=>base_url().env('BOT_PATH_BACK').$sol_id
			],
			[
				'Content-Type: application/json; charset=UTF-8',
				'Accept: application/json'
			],
			'POST',
			env('PAGOS_PORT')
		);
	}
	
	public function isDebtor($nombre,$apellido_paterno,$apellido_materno,$document,$cip){
		if($this->env_validate()){
			try {
				$result  = $this->genericRequest(
					$this->url_direct_work,
					[
						'names'=>$nombre,
						'father_last_name'=>$apellido_paterno,
						'mother_last_name'=>$apellido_materno,
						'dni'=>$document,
						'cip'=>$cip
					],
					[
						'Content-Type: application/json; charset=UTF-8',
						'Accept: application/json'
					],
					'POST'
				);

			
				$object = json_decode($result);
				$data = $object->data;
				return $data->is_debtor;

			} catch (Exception $e) {
				throw new Exception("Error al buscar deudas");
			}
		}else{
			throw new Exception("No se encontro un url valida");
		}
	}

	private function env_validate(){

		return strlen(env('PAGOS_URL_DEBTORS_EP'))>0;
	}

	private function genericRequest($url,$body,$headers=[],$method='GET',$custom_port=null){
		
		$cu=curl_init($url);
		if ($cu === false) {
			throw new Exception('failed to initialize');
		}
		if($method=='POST'){
			curl_setopt($cu, CURLOPT_POST, true);
		}
		curl_setopt($cu, CURLOPT_POSTFIELDS, json_encode($body));
		curl_setopt($cu, CURLOPT_VERBOSE, true);
		curl_setopt($cu, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);
		if($custom_port!=null){
			curl_setopt($cu, CURLOPT_PORT, $custom_port);
		}
		
		$result = curl_exec($cu);

		if ($result === false) {
			throw new Exception(curl_error($cu), curl_errno($cu));
		}
		curl_close($cu);
		
		return $result;
	}
	
}
