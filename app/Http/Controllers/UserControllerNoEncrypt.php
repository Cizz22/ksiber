<?php

namespace App\Http\Controllers;

use App\Models\PersonalInformation;
use App\Models\PersonalInformationNoEncrypt;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserControllerNoEncrypt extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Retrive all user information
        $personal_information = Auth::user()->personalInformationNoEncrypt;

        return response()->json([
            'message' => 'Successfully retrieved all user information',
            'data' => $personal_information
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Create new Personal Information
        $user_id = Auth::user()->id;

        //Validate
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'date_of_birth' => 'required|date',
            'NIK' => 'required|string',
            'phone_number' => 'required|string'
        ]);

        try {
            $personal_information = new PersonalInformationNoEncrypt([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'date_of_birth' => $request->date_of_birth,
                'NIK' => $request->NIK,
                'phone_number' => $request->phone_number,
                'user_id' => $user_id
            ]);
            //Create dummy request for postman


            $personal_information->save();

            return response()->json([
                'message' => 'Successfully created new personal information',
                'data' => $personal_information
            ], 201);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed to create new personal information',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
