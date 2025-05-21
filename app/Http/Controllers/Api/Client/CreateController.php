<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\CreateRequest;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class CreateController extends Controller
{
    public function __invoke(CreateRequest $request)
    {
        $data = $request->validated();

        if (!isset($data['manager_id']) && Auth::user()->hasRole('manager')) {
            $data['manager_id'] = Auth::id();
        }

        // if (
        //     isset($data['manager_id']) &&
        //     Auth::user()->hasAnyRole(['admin', 'head'])
        // ) {
        //     return response()->json([
        //         'message' => 'You cannot assign other managers'
        //     ], 403);
        // }

        $client = Client::create($data);

        return response()->json([
            'message' => 'Client created successfully.',
            'client' => $client,
        ], 201);
    }
}
