<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hobby;
use App\Notifications\ActionNotification;


class HobbyController extends Controller
{
    public function createNew(Request $request, Hobby $hobby)
    {
        try {
            // $validatedData = $request->validate([
            //     'name' => 'required',
            //     'category' => 'required',
            //     'description' => 'required'
            // ]);

            $result = $hobby->createNew($request->all());
            try {
                $message = "You have Successfully Created a Hobby";
                $newUser = auth()->user();
                $newUser->notify(new ActionNotification($newUser, $message, $message));
            } catch (\Exception $e) {
                // dd($e);
            }
            return apiSuccess($result);
        } catch (\Exception $e) {
            return apiFailure($e->getMessage());
        }
    }

    public function getAll()
    {
        try {
            $hobby = new Hobby();
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
            $result = $hobby->updateOne($data);
            return apiSuccess($result);
        } catch (\Exception $e) {
            return apiFailure($e->getMessage());
        }
    }

    public function deleteHobby($id, Hobby $hobby)
    {
        try {
            $data = ["id" => $id];
            $result = $hobby->deleteOne($data);
            try {
                $message = "You have Successfully Deleted a Hobby";
                $newUser = auth()->user();
                $newUser->notify(new ActionNotification($newUser, $message, $message));
            } catch (\Exception $e) {
                // dd($e);
             }
            return apiSuccess($result);
        } catch (\Exception $e) {
            return apiFailure($e->getMessage());
        }
    }
}
