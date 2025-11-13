<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Аудиотека - {{ $collection->name }}</title>
    @vite(['resources/css/app.css'])
</head>
<body>
    
    <header class="main-header">
        <div class="container">
            <h1 class="logo">Аудиотека</h1>
            <nav class="nav-bar">
                <a href="{{ route('tracks.index') }}" class="nav-item">Мои треки</a>
                <a href="{{ route('collections.index') }}" class="nav-item">Коллекции</a>
                <a href="{{ route('profile.edit') }}" class="nav-item">Профиль</a>
            </nav>
        </div>
    </header>

    
    <main class="collections-container">
        <div class="container">
            <div class="collections-header">
                <h1 class="page-title">{{ $collection->name }}</h1>
                <div>
                    <a href="{{ route('collections.index') }}" class="new-collection-btn" style="text-decoration: none;">
                        ← Назад к коллекциям
                    </a>
                </div>
            </div>

            
            <div class="inside-collection">
                @foreach($tracks as $track)
                    <div class="track-card-horizontal">
                        <div class="track-cover-container-horizontal">
                            {{ substr($track->title, 0, 2) }}
                        </div>
                        
                        <div class="track-info-horizontal">
                            <div class="track-title-horizontal">{{ $track->title }}</div>
                            <div class="track-artist-horizontal">{{ $track->artist->name }}</div>
                            <div class="track-genre-horizontal">{{ $track->genre->name }}</div>
                        </div>
                        
                        <div class="track-actions-horizontal">
                            <button class="play-btn-horizontal">
                                ▶
                            </button>
                            
                            <form action="{{ route('collections.remove-track', [$collection->id, $track->id]) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="add-to-collection-horizontal" title="Удалить из коллекции">
                                    ×
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

                @if($tracks->isEmpty())
                    <div style="text-align: center; padding: 40px; color: #666;">
                        В этой коллекции пока нет треков
                    </div>
                @endif
            </div>
        </div>
    </main>
</body>
</html>