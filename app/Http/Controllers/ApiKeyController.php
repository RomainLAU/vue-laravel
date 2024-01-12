<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use App\Models\Track;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ApiKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = request()->user();
        $apiKey = $user->apiKey;

        if ($apiKey === null) {
            $apiKey = Str::random(60);
        }

        return Inertia::render("ApiKey/Index", [
            "apiKey" => $apiKey,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $this->validate($request, [
            "name" => "required",
            "apiKey" => ["required", "unique:api_keys,key", "min:60", "max:60"],
        ]);

        $user_id = auth()->user()->id;


        ApiKey::create([
            'uuid' => Str::uuid(),
            'user_id' => $user_id,
            'name' => $request->name,
            'key' => $request->apiKey,
        ]);

        return redirect()->route('tracks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ApiKey $apiKey)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ApiKey $apiKey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ApiKey $apiKey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApiKey $apiKey)
    {
        $apiKey->delete();

        $tracks = Track::where('display', true)
        ->orderBy('id', 'desc')
        ->get();

        return redirect()->route('tracks.index', [
            'tracks' => $tracks]
        );
    }
}
