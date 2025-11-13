<?php

namespace App\Http\Controllers;

use App\Models\Track;
use App\Models\Genre;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackController extends Controller
{
    public function index(Request $request)
    {
        $query = Track::with(['artist', 'genre']);

        
        if ($request->has('genre') && $request->genre != 'all') {
            $query->where('genre_id', $request->genre);
        }

        
        if ($request->has('artist') && $request->artist != 'all') {
            $query->where('artist_id', $request->artist);
        }

        $tracks = $query->get();
        $genres = Genre::all();
        $artists = Artist::all();

        return view('tracks.index', compact('tracks', 'genres', 'artists'));
    }

    public function store(Request $request)
    {
        
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'artist_id' => 'required|exists:artists,id',
            'genre_id' => 'required|exists:genres,id',
            'duration' => 'required|integer|min:1'
        ]);

       
        Track::create([
            'title' => $request->title,
            'artist_id' => $request->artist_id,
            'genre_id' => $request->genre_id,
            'duration' => $request->duration,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('tracks.index')
            ->with('success', 'Трек успешно добавлен!');
    }
}