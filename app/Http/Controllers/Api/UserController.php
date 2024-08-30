<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Resource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
    // Get filter parameters
    $status = $request->query('status');
    $name = $request->query('name');

    // Initialize the query
    $query = User::query();

    // Apply filters if provided
    if ($status) {
        $query->where('status', $status);
    }

    if ($name) {
        $query->where('name', 'like', '%' . $name . '%');
    }

    // Get all users with pagination, applying filters
    $users = $query->latest()->paginate(10);

        // Return collection of users as a resource
        return new Resource(true, 'List Data Nasabah', $users);
    }

    /**
     * Display the specified user.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {


        // Find user by id
        $user = User::find($id);

        // Check if user found
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Nasabah Tidak Ditemukan!',
                'data'    => null
            ], 404);
        }

        // Return single user as a resource
        return new Resource(true, 'Detail Nasabah!', $user);
    }

    /**
     * Store a newly created user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|string|min:6',
            'nik'         => 'required|string',
            'phone_number' => 'required|string',
            'address'     => 'required|string',
            'status'      => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create user
        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => bcrypt($request->password),
            'nik'         => $request->nik,
            'phone_number' => $request->phone_number,
            'address'     => $request->address,
            'status'      => $request->status,
        ]);

        // Return response
        return new Resource(true, 'Data Nasabah Berhasil Ditambahkan!', $user);
    }

    /**
     * Update the specified user.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string',
            'email'       => 'required|email|unique:users,email,' . $id,
            'password'    => 'nullable|string|min:6',
            'nik'         => 'required|string',
            'phone_number' => 'required|string',
            'address'     => 'required|string',
            'status'      => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Find user by id
        $user = User::find($id);

        // Check if user found
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Nasabah Tidak Ditemukan!',
                'data'    => null
            ], 404);
        }

        // Update user
        $user->update([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => $request->password ? bcrypt($request->password) : $user->password,
            'nik'         => $request->nik,
            'phone_number' => $request->phone_number,
            'address'     => $request->address,
            'status'      => $request->status,
        ]);

        // Return response
        return new Resource(true, 'Data Nasabah Berhasil Diperbarui!', $user);
    }

    /**
     * Remove the specified user.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Find user by id
        $user = User::find($id);

        // Check if user found
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Nasabah Tidak Ditemukan!',
                'data'    => null
            ], 404);
        }

        // Delete user
        $user->delete();

        // Return response
        return new Resource(true, 'Data Nasabah Berhasil Dihapus!', $user);
    }
}
