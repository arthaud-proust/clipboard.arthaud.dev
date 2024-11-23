<?php

namespace App\Http\Controllers;

use App\Http\Requests\Media\StoreMediaRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use function redirect;

class MediaController extends Controller
{
    public function store(StoreMediaRequest $request): RedirectResponse
    {
        $request->user()->addMedia($request->file('file'))->toMediaCollection(diskName: 'local');

        return redirect()->route('home');
    }

    public function destroy(Media $media): RedirectResponse
    {
        Gate::authorize('delete', $media);

        $media->delete();

        return redirect()->route('home');
    }
}
