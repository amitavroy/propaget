<?php namespace App\Http\Controllers\Property;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Properties;
use Auth;
use Aws\CloudFront\Exception\Exception;
use Illuminate\Support\Facades\Response;
use Request;

class PropertyController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        //$userId = Auth::user()->id;
        $userId = 2;
        $properties = Properties::where('agentId', '=', $userId)->get();
        return $properties;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        try {
            //$userId = Auth::user()->id;
            $propertyData = Request::all();
            $prop = new Properties;
            $prop->agentId = 2;
            $prop->clientId = 1;
            $prop->title = $propertyData['title'];
            $prop->description = $propertyData['description'];
            $prop->clientEmail = $propertyData['clientEmail'];
            $prop->address = $propertyData['address'];
            $prop->location = $propertyData['location'];
            $prop->area = $propertyData['area'];
            $prop->price = $propertyData['price'];
            $prop->type = $propertyData['type'];
            $prop->save();

            if (!$prop->save()) {
                $errors = $prop->getErrors()->all();
                $data = $errors;
                $message = 'Requirement not added.';
                return Response::json(array('message' => $message ,'data'=>$data), Config::get('statuscode.validationFailCode'));
            }

            $data = $prop;
            $message = 'Property added successfully';
            return Response::json(array('message' => $message ,'data'=>$data), Config::get('statuscode.successCode'));

        } catch (Exception $e) {

            $data = '';
            $message = 'Property not Added.';
            return Response::json(array('message' => $message ,'data'=>$data), Config::get('statuscode.internalServerErrorCode'));
        }

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $response = Properties::where('agentId','=','2')->where('id','=',$id)->get();
        return $response;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $property = Properties::find($id);
        return $property;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        try{
            //$user = User::find(1);
            $propertyData = Request::all();
            $pro = Properties::find($id);
            $pro->agentId = 2;
            $pro->clientId = 1;
            $pro->title = $propertyData['title'];
            $pro->description = $propertyData['description'];
            $pro->clientEmail = $propertyData['clientEmail'];
            $pro->address = $propertyData['address'];
            $pro->location = $propertyData['location'];
            $pro->area = $propertyData['area'];
            $pro->price = $propertyData['price'];
            $pro->type = $propertyData['type'];
            $pro->save();

            $errors = $pro->getErrors()->all();
            //Log::info('this update'. print_r($errors, true));
            if (empty($errors))
            {
                $data = $pro;
                $message = 'Property updated successfully';
                return Response::json(array('message' => $message ,'data'=>$data), Config::get('statuscode.successCode'));
            }
            else
            {
                $data = $errors;
                $message = 'Property not updated.';
                return Response::json(array('message' => $message ,'data'=>$data), Config::get('statuscode.validationFailCode'));
            }
        }
        catch(Exception $e)
        {
            $data = $id;
            $message = 'Property not updated.';
            return Response::json(array('message' => $message ,'data'=>$data), Config::get('statuscode.internalServerErrorCode'));
        }


    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        try
        {
            //Log::error('i m in delete'.$id);
            Properties::destroy($id);
            $data = $id;
            $message = 'Property Deleted.';
            return Response::json(array('message' => $message ,'data'=>$data), Config::get('statuscode.successCode'));
        }
        catch(Exception $e)
        {
            $data = $id;
            $message = 'Property not Deleted.';
            return Response::json(array('message' => $message ,'data'=>$data), Config::get('statuscode.internalServerErrorCode'));
        }
	}

}
