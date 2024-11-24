<?php

namespace App\Http\Controllers;

use App\Http\Requests\Text\StoreTextRequest;
use App\Http\Requests\Text\UpdateTextRequest;
use App\Models\Text;
use App\Stats\TransfersCountStat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use function redirect;
use function session;

class TextController extends Controller
{
    public function store(StoreTextRequest $request): RedirectResponse
    {
        $createdText = $request->user()->texts()->create($request->validated());

        app(TransfersCountStat::class)->increment();

        session()?->flash("focusTextId", $createdText->id);

        return redirect()->route('home');
    }

    public function update(UpdateTextRequest $request, Text $text): RedirectResponse
    {
        Gate::authorize('update', $text);

        $text->update($request->validated());

        session()?->flash("focusTextId", $text->id);

        return redirect()->route('home');
    }

    public function destroy(Text $text): RedirectResponse
    {
        Gate::authorize('delete', $text);

        $text->delete();

        return redirect()->route('home');
    }
}
