<?php

namespace App\Http\Controllers;

use App\Http\Requests\Media\StoreMediaRequest;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use function redirect;

class MediaController extends Controller
{
    public function store(StoreMediaRequest $request): RedirectResponse
    {
        $request->user()->addMedia($request->file('file'))->toMediaCollection();

        return redirect()->route('home');
    }

    public function destroy(Media $media): RedirectResponse
    {
        Gate::authorize('delete', $media);

        $media->delete();

        return redirect()->route('home');
    }
}
