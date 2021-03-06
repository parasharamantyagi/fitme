<?php
namespace App\Validators;

use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Validator;
use App\Validators\BaseValidator;
use Illuminate\Validation\Rule;

trait ProductValidator
{
    use BaseValidator;
 
    public $response;

    /**
     * @param   : Request $request
     * @return  : \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @method  : addMusicFileValidations
     * @purpose : Validation rule for add page
     */
	 
	public function agentNewFeatureValidations(Request $request,$input){
		try{
            $validations = $input;
			unset($validations['materialid2']);
			unset($validations['materialid3']);
			unset($validations['materialid4']);
			unset($validations['materialid5']);
            $validator = Validator::make($request->all(), $validations);
            $this->response = $this->validateData($validator);
        }catch(\Exception $e){
            $this->response = $e->getMessage();
        }
        return $this->response;
	}
	
	public function agentSignatureValidations(Request $request){
		try{
            $validations = array(
                'signature' => 'required'
            );
            $validator = Validator::make($request->all(),$validations);
            $this->response = $this->validateData($validator);
        }catch(\Exception $e){
            $this->response = $e->getMessage();
        }
        return $this->response;
	}
	
	public function agentScheduleValidations(Request $request){
		try{
            $validations = array(
                'available_from' => 'required',
                'available_to' => 'required',
            );
            $validator = Validator::make($request->all(),$validations);
            $this->response = $this->validateData($validator);
        }catch(\Exception $e){
            $this->response = $e->getMessage();
        }
        return $this->response;
	}
	
    public function agentSignupValidations(Request $request){
        try{
            $validations = array(
                'email' => 'required|email|unique:users',
                'first_name'    => 'required',
                'last_name'     => 'required',
                'phone'         => 'required',
                'identity_card'      => 'required', 
                'social_security_number' => 'required',
                'agent_type'    => 'required',
                'cv'    => 'required',
                'iban'    => 'required',
                'home_address'          => 'required',
                'work_location_address' => 'required',
                'is_vehicle' => 'required',
                'is_subcontractor' => 'required',
                'supplier_company' => 'required_if:is_subcontractor,1',
                'terms_conditions' => 'required',
            );
            $validator = Validator::make($request->all(),$validations);
            $this->response = $this->validateData($validator);
        }catch(\Exception $e){
            $this->response = $e->getMessage();
        }
        return $this->response;
    }
	
	
}
