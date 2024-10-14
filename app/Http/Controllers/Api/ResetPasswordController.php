<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    /**
     * Handle the incoming reset password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request)
    {
        // Set validation
        $validator = Validator::make($request->all(), [
            'id_user'      => 'required',  // ID pengguna
            'new_password' => 'required|min:6|confirmed', // Password baru
        ]);

        // If validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Temukan pengguna berdasarkan id_user
        $user = User::where('id_user', $request->id_user)->first();

        // Jika pengguna tidak ditemukan
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        // Update password pengguna
        $user->password = bcrypt($request->new_password);
        $user->save();

        // Return response JSON password is reset
        return response()->json([
            'success' => true,
            'message' => 'Password has been reset successfully.',
        ], 200);
    }
}
