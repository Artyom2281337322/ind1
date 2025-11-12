<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $collections = Collection::where('user_id', $user->id)
                                ->withCount('tracks')
                                ->get();
        
        $addTrackId = $request->get('add_track');
        $trackToAdd = null;
        
        if ($addTrackId) {
            $trackToAdd = Track::find($addTrackId);
            
            if (!$trackToAdd || $trackToAdd->user_id !== $user->id) {
                return redirect()->route('tracks.index')
                    ->with('error', 'Трек не найден или у вас нет доступа');
            }
        }

        return view('collections.index', compact('collections', 'addTrackId', 'trackToAdd'));
    }

    public function show($id)
    {
        $collection = Collection::find($id);
        
        if (!$collection) {
            abort(404, 'Коллекция не найдена');
        }
        
        if ($collection->user_id !== Auth::id()) {
            abort(403);
        }
        
        $tracks = $collection->tracks()->with(['artist', 'genre'])->get();
        
        return view('collections.show', compact('collection', 'tracks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $user = Auth::user();
        
        $collection = Collection::create([
            'name' => $request->name,
            'user_id' => $user->id
        ]);

        return redirect()->route('collections.index')
            ->with('success', 'Коллекция создана успешно!');
    }

    public function update(Request $request, $id)
    {
        $collection = Collection::find($id);
        
        if (!$collection) {
            return redirect()->route('collections.index')
                ->with('error', 'Коллекция не найдена');
        }
        
        if ($collection->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $collection->update([
            'name' => $request->name
        ]);

        return redirect()->route('collections.index')
            ->with('success', 'Коллекция обновлена успешно!');
    }

    public function destroy($id)
    {
        $collection = Collection::find($id);
        
        if (!$collection) {
            return redirect()->route('collections.index')
                ->with('error', 'Коллекция не найдена');
        }
        
        if ($collection->user_id !== Auth::id()) {
            abort(403);
        }

        $collection->delete();

        return redirect()->route('collections.index')
            ->with('success', 'Коллекция удалена успешно!');
    }

    public function addTrack(Request $request, $id)
    {
        $collection = Collection::find($id);
        
        if (!$collection) {
            return redirect()->route('tracks.index')
                ->with('error', 'Коллекция не найдена');
        }
        
        if ($collection->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'track_id' => 'required|exists:tracks,id'
        ]);

        if (!$collection->tracks()->where('track_id', $request->track_id)->exists()) {
            $collection->tracks()->attach($request->track_id);
            
            return redirect()->route('tracks.index')
                ->with('success', 'Трек добавлен в коллекцию "' . $collection->name . '"!');
        }

        return redirect()->route('tracks.index')
            ->with('info', 'Трек уже есть в этой коллекции');
    }

    public function removeTrack($collectionId, $trackId)
    {
        $collection = Collection::find($collectionId);
        
        if (!$collection) {
            return redirect()->route('collections.index')
                ->with('error', 'Коллекция не найдена');
        }
        
        if ($collection->user_id !== Auth::id()) {
            abort(403);
        }

        $collection->tracks()->detach($trackId);

        return redirect()->route('collections.show', $collection)
            ->with('success', 'Трек удален из коллекции!');
    }
}