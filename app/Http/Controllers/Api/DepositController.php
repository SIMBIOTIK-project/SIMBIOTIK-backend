<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Resource;
use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepositController extends Controller
{
    /**
     * index
     * 
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        // Get the id_user from the request, if exsits
        $id_user = $request->query('id_user');

        // Query deposits with optional filtering by id_user
        $deposits = Deposit::with(['user', 'wastetype'])
            ->when($id_user, function ($query, $id_user) {
                return $query->where('id_user', $id_user);
            })
            ->latest()
            ->paginate(10);

        //return collection of deposits as a resource
        return new Resource(true, 'List Data Deposit', $deposits);
    }

    /**
     * store
     * 
     * @param mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'id_user'       => 'required|exists:users,id_user',
            'id_wastetype'  => 'required|exists:wastetypes,id',
            'weight'        => 'required|numeric',
            'price'         => 'required|integer',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $userId = auth()->user()->id_user;

        //Create deposit
        $deposit = Deposit::create([
            'id_user'       => $request->id_user,
            'id_wastetype'  => $request->id_wastetype,
            'weight'        => $request->weight,
            'price'         => $request->price,
            'created_by'    => $userId,
        ]);

        // Return response
        return new Resource(true, 'Data Deposit Berhasil Ditambahkan!', $deposit);
    }

    /**
     * show
     * 
     * @param mixed $id_user
     * @return void
     */
    public function show($id)
    {
        //Find deposit by id_user with related user and wastetype
        $deposit = Deposit::with(['user', 'wastetype'])->where('id_user', $id)->first();

        // Check if deposit found
        if (!$deposit) {
            return response()->json([
                'success' => false,
                'message' => 'Deposit tidak ditemukan!',
                'data'    => null
            ], 404);
        }

        // Return single deposit as a resource
        return new Resource(true, 'Deposit untuk pengguna!', $deposit);
    }

    /**
     * update
     * 
     * @param mixed $request
     * @param mixed $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'id_user'       => 'required|exists:users,id_user',
            'id_wastetype'  => 'required|exists:wastetype,id',
            'weight'        => 'required|numeric',
            'price'         => 'required|numeric',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Find deposit by id
        $deposit = Deposit::where('id_user', $id)->first();

        // Check if deposit found
        if (!$deposit) {
            return response()->json([
                'success'   => false,
                'message'   => 'Deposit Tidak Ditemukan!',
                'data'      => null
            ], 404);
        }

        // Update deposit
        $deposit->update([
            'id_user'       => $request->id_user,
            'id_wastetype'  => $request->id_wastetype,
            'weight'        => $request->weight,
            'price'         => $request->price,
        ]);

        // Return response
        return new Resource(true, 'Data Deposit Berhasil Diperbarui', $deposit);
    }

    /**
     * destroy
     * 
     * @param mixed $id
     * @return void
     */
    public function destroy($id)
    {
        // Find deposit by ID
        $deposit = Deposit::where('id', $id)->first();

        // Check if deposit found
        if (!$deposit) {
            return response()->json([
                'success'  => false,
                'message'  => 'Deposit Tidak Ditemukan!',
                'data'     => null
            ], 404);
        }

        // Delete deposit
        $deposit->delete();

        // Return response
        return new Resource(true, 'Data deposit berhasil dihapus', $deposit);
    }
}
