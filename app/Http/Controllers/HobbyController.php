<?php

namespace App\Http\Controllers;

use App\Hobby;
use Illuminate\Http\Request;

class HobbyController extends Controller
{
    public function createNew(Request $request, Hobby $hobby)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required',
                'category' => 'required',
                'description' => 'required'
            ]);

            $result = $hobby->createNew($validatedData);
            return apiSuccess($result);
        } catch (\Exception $e) {
            return apiFailure($e->getMessage());
        }
    }

    public function getAll(Hobby $hobby)
    {
        try {
            $results = $hobby->viewAll();
            return apiSuccess($results);
        } catch (\Exception $e) {
            return apiFailure($e->getMessage());
        }
    }

    public function get(Request $request, Hobby $hobby)
    {
        try {
            $data = $request->all();
            $result = $hobby->viewOne($data);
            return apiSuccess($result);
        } catch (\Exception $e) {
            return apiFailure($e->getMessage());
        }
    }

    public function updateHobby(Request $request, Hobby $hobby)
    {
        try {
            $data = $request->all();
            $result = $hobby->update($data);
            return apiSuccess($result);
        } catch (\Exception $e) {
            return apiFailure($e->getMessage());
        }
    }

    public function deleteHobby(Request $request, Hobby $hobby)
    {
        try {
            $data = $request->all();
            $result = $hobby->deleteOne($data);
            return apiSuccess($result);
        } catch (\Exception $e) {
            return apiFailure($e->getMessage());
        }
    }
}
