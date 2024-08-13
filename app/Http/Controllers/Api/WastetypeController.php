<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Resources\Resource;
use App\Models\Wastetype;
use Illuminate\Support\Facades\Validator;

class WastetypeController extends Controller
{
    /**
     * index
     * 
     * @return void
     */
    public function index()
    {
        //get all wasteType
        $wasteTypes = Wastetype::latest()->paginate(10);

        //return collection of post as a resource
        return new Resource(true, 'List Data Waste Type', $wasteTypes);
    }

    /**
     * store
     * 
     * @param mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'type'  => 'required',
            'price' => 'required',
        ]);

        //check if type already exists
        $existingWasteType = Wastetype::where('type', $request->type)->first();
        if ($existingWasteType) {
            return response()->json([
                'success' => false,
                'message' => 'Jenis Sampah Sudah Ada!',
                'data'    => null
            ], 409); // 409 Conflict
        }

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create wastetypes
        $wasteTypes = Wastetype::create([
            'type'  => $request->type,
            'price' => $request->price,
        ]);

        //return response
        return new Resource(true, 'Data Jenis Sampah Berhasil Ditambahkan!', $wasteTypes);
    }

    /**
     * show
     * 
     * @param mixed $id
     * @return void
     */
    public function show($id)
    {
        //find wastetype by id
        $wasteType = Wastetype::find($id);

        //check if wastetype found
        if(!$wasteType) {
            return response()->json([
                'success' => false,
                'message' => 'Jenis Sampah Tidak Ditemukan!',
                'data'    => null
            ], 404);
        }

        //return single post a resource
        return new Resource(true, 'Detail Jenis Sampah!', $wasteType);
    }

    /**
     * 
     * @param mixed $request
     * @param mixed $id
     * @return void
     */
    public function update(Request $request, $id)
    {
         // Define validation rules
    $validator = Validator::make($request->all(), [
        'type'  => 'required',
        'price' => 'required',
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    // Find wastetype by id
    $wasteType = Wastetype::find($id);

    // Check if wastetype found
    if (!$wasteType) {
        return response()->json([
            'success' => false,
            'message' => 'Jenis Sampah Tidak Ditemukan!',
            'data'    => null
        ], 404);
    }

    // Check if the type already exists (excluding the current record)
    $existingWasteType = Wastetype::where('type', $request->type)
        ->where('id', '!=', $id) // Exclude the current record
        ->first();
    
    if ($existingWasteType) {
        return response()->json([
            'success' => false,
            'message' => 'Jenis Sampah Sudah Ada!',
            'data'    => null
        ], 409); // 409 Conflict
    }

    // Update wastetype
    $wasteType->update([
        'type'  => $request->type,
        'price' => $request->price,
    ]);

    // Return response
    return new Resource(true, 'Data Jenis Sampah Berhasil Diperbarui!', $wasteType);
    }

    /**
     * destroy
     * 
     * @param mixed $id
     * @return void
     */
    public function destroy($id)
    {
        //find wastetype by ID
        $wasteType = Wastetype::find($id);

        //delete wastetype
        $wasteType->delete();

        //return response 
        return new Resource(true, 'Data Jenis Sampbah Berhasil Dihapus!', $wasteType);
    }
}
