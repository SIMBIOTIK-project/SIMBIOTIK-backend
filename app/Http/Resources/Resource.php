<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Resource extends JsonResource
{
    // Define properti untuk status dan pesan
    public $status;
    public $message;

    /**
     * __construct
     *
     * @param  bool $status
     * @param  string $message
     * @param  mixed $resource
     * @return void
     */
    public function __construct($status, $message, $resource)
    {
        // Pastikan resource diproses oleh parent JsonResource
        parent::__construct($resource);

        // Inisialisasi properti
        $this->status  = $status;
        $this->message = $message;
        $this->resource = $resource;  // Ini perlu untuk mengakses resource
    }

    /**
     * toArray
     *
     * @param  Request $request
     * @return array
     */
    public function toArray($request): array
    {
        // Pastikan resource adalah instance dari LengthAwarePaginator
        if ($this->resource instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            return [
                'success' => $this->status,
                'message' => $this->message,
                'result'  => [
                    'total_data'   => $this->resource->total(),
                    'current_page' => $this->resource->currentPage(),
                    'per_page'     => $this->resource->perPage(),
                    'total_pages'  => $this->resource->lastPage(),
                    'data'         => $this->resource->items(),
                ],
            ];
        }

        // Jika resource bukan paginasi, kembalikan sesuai keinginan Anda
        return [
            'success' => $this->status,
            'message' => $this->message,
            'data'    => $this->resource
        ];
    }
}
