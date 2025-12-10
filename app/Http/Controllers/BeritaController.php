<?php

namespace App\Http\Controllers;

use App\Services\BeritaService;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    protected $beritaService;

    public function __construct(BeritaService $beritaService)
    {
        $this->beritaService = $beritaService;
    }

    public function index()
    {
        return response()->json($this->beritaService->getAll());
    }

    public function show($id)
    {
        return response()->json($this->beritaService->getById($id));
    }

    public function store(Request $request)
    {
        $data = $this->beritaService->create($request->all());
        return response()->json($data, 201);
    }

    public function update(Request $request, $id)
    {
        return response()->json($this->beritaService->update($id, $request->all()));
    }

    public function destroy($id)
    {
        return response()->json(['deleted' => $this->beritaService->delete($id)]);
    }
}
