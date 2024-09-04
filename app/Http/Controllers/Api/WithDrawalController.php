<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Resource;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WithDrawalController extends Controller
{
    public function index(Request $request)
    {
        // Get the id_user from the request, if exists
        $id_user = $request->query('id_user');

        // Query withdrawal with option
        $withdrawal = Withdrawal::with(['user'])
            ->when($id_user, function($query, $id_user) {
                return $query->where('id_user', $id_user);
            })
            ->latest()
            ->paginate(10);

        // Return collection of withdrawals as a resource
        return new Resource(true, 'List Data Withdrawal', $withdrawal);
    }

    public function store(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'id_user'   => 'required|exists:users,id_user',
            'price'     => 'required|integer',
            'status'    => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $userId = auth()->user()->id_user;

        // Create withdrawal
        $withdrawal = Withdrawal::create([
            'id_user'       => $request->id_user,
            'price'         => $request->price,
            'status'        => $request->status,
            'created_by'    => $userId,
        ]);

        // Return response
        return new Resource(true, 'Data Withdrawal Berhasil Ditambahkan!', $withdrawal);
    }

    public function show($id)
    {
        // Find withdrawal 
        $withdrawal = Withdrawal::with(['user'])->where('id_user', $id)->first();

        // Check if withdrawal found
        if (!$withdrawal) {
            return response()->json([
                'success'   => false,
                'message'   => 'Withdrawal tidak ditemukan',
                'data'      => null
            ]);
        }

        // Return single withdrawal as a resource
        return new Resource(true, 'Withdrawal untuk pengguna!', $withdrawal);
    }

    public function update(Request $request, $id)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'id_user'   => 'required|exists:users,id_user',
            'price'     => 'required|integer',
            'status'    => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Find withdrawal by id
        $withdrawal = Withdrawal::where('id_user', $id)->first();

        // Check if withdrawal found
        if (!$withdrawal) {
            return response()->json([
                'success'   => false,
                'message'   => 'Withdrawal Tidak Ditemukan!',
                'data'      => null
            ], 404);
        }

        // Update withdrawal
        $withdrawal->update([
            'id_user'   => $request->id_user,
            'price'     => $request->price,
            'status'    => $request->status,
        ]);

        // Return response
        return new Resource(true, 'Data Withdrawal Berhasil Diperbarui', $withdrawal);
    }

    public function destroy($id)
    {
        // Find withdrawal by id
        $withdrawal = Withdrawal::where('id', $id)->first();

        // Check if withdrawal found
        if (!$withdrawal) {
            return response()->json([
                'success'   => false,
                'message'   => 'Withdrawal Tidak Ditemukan!',
                'data'      => null
            ], 404);
        }

        // Delete withdrawal
        $withdrawal->delete();

        // Return response
        return new Resource(true, 'Data withdrawal berhasil dihapus', $withdrawal);
    }
}
