<?php

namespace App\Http\Controllers;

use App\Models\NewEncryption;
use App\Models\PersonalInformation;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewEncryptionController extends Controller
{

    function encryptData($data)
    {
        $encryptedData = '';
        for ($i = 0; $i < strlen($data); $i++) {
            $char = $data[$i];
            // Shift the character by 1
            $encryptedChar = chr(ord($char) + 1);
            $encryptedData .= $encryptedChar;
        }
        return $encryptedData;
    }
    function decryptData($encryptedData)
    {
        $decryptedData = '';
        for ($i = 0; $i < strlen($encryptedData); $i++) {
            $char = $encryptedData[$i];
            // Shift the character back by 1
            $decryptedChar = chr(ord($char) - 1);
            $decryptedData .= $decryptedChar;
        }
        return $decryptedData;
    }

    function decryptDateOfBirth($data)
    {
        // Decrypt the data
        $decryptedData = $this->decryptData($data);

        // Convert the decrypted data back to the date format
        $dateOfBirth = date('Y-m-d', strtotime($decryptedData));

        return $dateOfBirth;
    }


    // public function index()
    // {
    //     try {
    //         $personal_information = Auth::user()->newEncryption;
    //         $decryptedData = $personal_information->map(function ($item) {
    //             $decryptedItem = [
    //                 'first_name' => $this->decryptData($item->first_name),
    //                 'last_name' => $this->decryptData($item->last_name),
    //                 'date_of_birth' => $this->decryptData($item->date_of_birth),
    //                 'NIK' => $this->decryptData($item->NIK),
    //                 'phone_number' => $this->decryptData($item->phone_number),
    //                 'user_id' => $item->user_id
    //             ];
    //             return $decryptedItem;
    //         });

    //         return response()->json([
    //             'message' => 'Successfully retrieved personal information',
    //             'data' => $decryptedData
    //         ], 200);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'message' => 'Failed to retrieve personal information',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }


    // }

    public function index()
    {
        try {
            $personal_information = Auth::user()->newEncryption;

            $decryptedData = [
                'first_name' => $this->decryptData($personal_information->first_name),
                'last_name' => $this->decryptData($personal_information->last_name),
                'date_of_birth' => $this->decryptDateOfBirth($personal_information->date_of_birth),
                'NIK' => $this->decryptData($personal_information->NIK),
                'phone_number' => $this->decryptData($personal_information->phone_number),
                'user_id' => $personal_information->user_id
            ];

            return response()->json([
                'message' => 'Successfully retrieved personal information',
                'data' => $decryptedData
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve personal information',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function store(Request $request)
    {
        // Create new Personal Information
        $user_id = Auth::user()->id;

        // Validate
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'date_of_birth' => 'required|date',
            'NIK' => 'required|string',
            'phone_number' => 'required|string'
        ]);

        try {
            $personal_information = new NewEncryption([
                'first_name' => $this->encryptData($request->first_name),
                'last_name' => $this->encryptData($request->last_name),
                'date_of_birth' => $this->encryptData(urlencode($request->date_of_birth)),
                'NIK' => $this->encryptData($request->NIK),
                'phone_number' => $this->encryptData($request->phone_number),
                'user_id' => $user_id
            ]);

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
