<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Requirement;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use PhpSpec\Exception\Exception;
use Illuminate\Support\Facades\Request;

class RequirementController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $allRequirement = Requirement::where('agentId','=','2')->get();
        return $allRequirement;
	}

    /*public function getAllRequirement()
    {
        //Log::error('i m in all fun');
        $allRequirement = Requirement::where('agentId','=','2')->get();
//        $allRequirement = Requirement::where('agentId','=',$agentId)->get();
        return $allRequirement;
    }*/

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
        $requirement = Requirement::create(Request::all());
        return $requirement;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        try{
            $response = Requirement::where('agentId','=','2')->where('id','=',$id)->get();
            $statusCode = 200;
        }
        catch(Exception $e)
        {
            $response = [
                "error" => "Error while showing Requirment"
            ];
            $statusCode = 404;
        }

        return Response::json($response, $statusCode);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$requirement = Requirement::find($id);

        Log::info('i m update'.$requirement);
        Log::info('this array'. print_r(Request::all(), true));
        $requirement->area = Request::input('area');
        Log::info(' Final array'.$requirement);
        $requirement->save();
        return $requirement;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Requirement::destroy($id);
	}
}
