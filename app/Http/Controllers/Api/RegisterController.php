<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //set validation
        $validator = Validator::make($request-> all(), [
            'name'          => 'required',
            'email'         => 'required|email|unique:users',
            'password'      => 'required|min:6|confirmed',
            'nik'           => 'required',
            'phone_number'  => 'required',
            'address'       => 'required',
            'status'        => 'required'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Tentukan prefix ID berdasarkan status
        $prefix = '';
        switch ($request->status) {
            case 'nasabah':
                $prefix = 'NAS';
                break;
            case 'admin':
                $prefix = 'ADM';
                break;
            case 'owner':
                $prefix = 'OWN';
                break;
        }
        
        // Ambil ID terakhir yang ada berdasarkan prefix
        $lastUser = User::where('id', 'like', "$prefix%")->orderBy('id', 'desc')->first();
        $lastIdNumber = $lastUser ? intval(substr($lastUser->id, 3)) : 0;
        $newIdNumber = $lastIdNumber + 1;
        
        // Buat ID baru
        $newId = $prefix . str_pad($newIdNumber, 3, '0', STR_PAD_LEFT);
        

        //create user
        $user = User::create([
            'id_user'       => $newId,
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => bcrypt($request->password),
            'nik'           => $request->nik,
            'phone_number'  => $request->phone_number,
            'address'       => $request->address,
            'status'        => $request->status
        ]);

        //return response JSON user is created
        if($user) {
            return response()->json([
                'success' => true,
                'user'    => $user,
            ], 200);
        }

        //return JSON process insert failed
        return response()->json([
            'success' => false,
        ], 409);
    }
}
