<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //retrive all medical record
        $medical_records = Auth::user()->medical_records;

        return response()->json([
            'message' => 'Successfully retrieved all medical records',
            'data' => $medical_records
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
        //create new medical record
        $user_id = Auth::user()->id;

        //validate
        $request->validate([
            'date' => 'required|date',
            'diagnosis' => 'required|string',
            'prescription' => 'required|string',
            'notes' => 'required|string'
        ]);

        try {
            $medical_record = new MedicalRecord([
                'user_id' => $user_id,
                'date' => $request->date,
                'diagnosis' => $request->diagnosis,
                'prescription' => $request->prescription,
                'notes' => $request->notes
            ]);

            $medical_record->save();

            return response()->json([
                'message' => 'Successfully created new medical record',
                'data' => $medical_record
            ], 201);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed to create new medical record',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
