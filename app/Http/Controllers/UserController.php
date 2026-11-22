<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::with('media')->get());
    }

    public function show(User $user)
    {
        $user->load('media');

        return new UserResource($user);
    }

    public function addMedia(Request $request, User $user)
    {
        $validated = $request->validate([
            'media_id' => 'required|exists:media,id',
        ]);

        $user->media()->syncWithoutDetaching([$validated['media_id']]);

        return (new UserResource($user->load('media')))
            ->additional(['message' => 'Media berhasil ditambahkan ke koleksi user']);
    }

    public function removeMedia(User $user, int $mediaId)
    {
        $detached = $user->media()->detach($mediaId);

        if (!$detached) {
            return response()->json([
                'message' => 'Media tidak ditemukan di koleksi user ini',
            ], 404);
        }

        return (new UserResource($user->load('media')))
            ->additional(['message' => 'Media berhasil dihapus dari koleksi user']);
    }
}
