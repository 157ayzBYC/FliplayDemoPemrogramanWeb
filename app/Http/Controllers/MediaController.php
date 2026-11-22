<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = Media::with('users');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        return MediaResource::collection($query->latest()->get());
    }

    public function store(StoreMediaRequest $request)
    {
        $media = Media::create($request->validated());

        return (new MediaResource($media))
            ->additional(['message' => 'Media berhasil ditambahkan'])
            ->response()
            ->setStatusCode(201);
    }

    public function show(Media $media)
    {
        $media->load('users');

        return new MediaResource($media);
    }

    public function update(StoreMediaRequest $request, Media $media)
    {
        $media->update($request->validated());

        return (new MediaResource($media->load('users')))
            ->additional(['message' => 'Media berhasil diperbarui']);
    }

    public function destroy(Media $media)
    {
        $media->delete();

        return response()->json([
            'message' => 'Media berhasil dihapus',
        ], 200);
    }
}
