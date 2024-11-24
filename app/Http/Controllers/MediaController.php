<?php

namespace App\Http\Controllers;

use App\Http\Requests\Media\StoreMediaRequest;
use App\Models\Media;
use App\Stats\SizeTransferredStat;
use App\Stats\TransfersCountStat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use function app;
use function redirect;

class MediaController extends Controller
{
    public function store(StoreMediaRequest $request): RedirectResponse
    {
        $media = $request->user()->addMedia($request->file('file'))->toMediaCollection();

        app(TransfersCountStat::class)->increment();
        app(SizeTransferredStat::class)->add($media->size);

        return redirect()->route('home');
    }

    public function destroy(Media $media): RedirectResponse
    {
        Gate::authorize('delete', $media);

        $media->delete();

        return redirect()->route('home');
    }
}
