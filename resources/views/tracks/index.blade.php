<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Аудиотека - Мои треки</title>
    @vite(['resources/css/app.css'])
</head>

<body>
    
    <header class="main-header">
        <div class="container">
            <h1 class="logo">Аудиотека</h1>
            <nav class="nav-bar">
                <div class="nav-item active">Мои треки</div>
                <a href="{{ route('collections.index') }}" class="nav-item">Коллекции</a>
                <a href="{{ route('profile.edit') }}" class="nav-item">Профиль</a>
                <form method="POST" action="{{ route('logout') }}" class="nav-item">
                    @csrf
                    <button class="nav-item-button">
                        Выйти
                    </button>
                </form>
            </nav>
        </div>
    </header>

    
    <main class="audio-library">
        <div class="container">
            <h1 class="page-title">Мои треки</h1>


            @auth
            <div class="filters-section">
                <h3 style="margin-top: 0; margin-bottom: 20px;">Добавить новый трек</h3>
                <form method="POST" action="{{ route('tracks.store') }}">
                    @csrf
                    <div class="filters-row">
                        <div class="form-group" style="min-width: 200px;">
                            <label>Название трека</label>
                            <input type="text" name="title" required class="form-group input" placeholder="Введите название трека">
                        </div>

                        <div class="form-group" style=" min-width: 150px;">
                            <label>Исполнитель</label>
                            <select name="artist_id" required class="filter-select">
                                <option value="">Выберите исполнителя</option>
                                @foreach($artists as $artist)
                                <option value="{{ $artist->id }}">{{ $artist->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group" style=" min-width: 150px;">
                            <label>Жанр</label>
                            <select name="genre_id" required class="filter-select">
                                <option value="">Выберите жанр</option>
                                @foreach($genres as $genre)
                                <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group" style=" min-width: 120px;">
                            <label>Длительность (сек)</label>
                            <input type="number" name="duration" required class="form-group input" placeholder="180" min="1" max="3600">
                        </div>

                        <button type="submit" class="apply-btn" style="align-self: flex-end;">
                            Добавить трек
                        </button>
                    </div>
                </form>
            </div>
            @endauth

           
            @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

          
            <div class="filters-section">
                <form method="GET" action="{{ route('tracks.index') }}">
                    <div class="filters-row">
                        <div class="filter-group">
                            <label>Жанр</label>
                            <select name="genre" class="filter-select">
                                <option value="all">Все</option>
                                @foreach($genres as $genre)
                                <option value="{{ $genre->id }}"
                                    {{ request('genre') == $genre->id ? 'selected' : '' }}>
                                    {{ $genre->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>Исполнитель</label>
                            <select name="artist" class="filter-select">
                                <option value="all">Все</option>
                                @foreach($artists as $artist)
                                <option value="{{ $artist->id }}"
                                    {{ request('artist') == $artist->id ? 'selected' : '' }}>
                                    {{ $artist->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="apply-btn">Применить</button>
                    </div>
                </form>
            </div>

            
            <div class="tracks-grid">
                @foreach($tracks as $track)
                <div class="track-card">
                    <div class="track-cover-container">
                        {{ substr($track->title, 0, 2) }}
                    </div>

                    <div class="track-info">
                        <div class="track-title">{{ $track->title }}</div>
                        <div class="track-artist">{{ $track->artist->name }}</div>
                        <div class="track-genre">{{ $track->genre->name }}</div>
                        <div class="track-duration" style="color: #888; font-size: 12px; margin-top: 5px;">
                            {{ floor($track->duration / 60) }}:{{ str_pad($track->duration % 60, 2, '0', STR_PAD_LEFT) }}
                        </div>
                    </div>

                    <div class="track-actions">
                        <button class="play-btn">
                            ▶
                        </button>

                        @auth
                        <a href="{{ route('collections.index', ['add_track' => $track->id]) }}" class="add-to-collection-btn" title="Добавить в коллекцию">
                            +
                        </a>
                        @else
                        <a href="{{ route('login') }}" class="add-to-collection-btn" title="Добавить в коллекцию">
                            +
                        </a>
                        @endauth
                    </div>
                </div>
                @endforeach

                @if($tracks->isEmpty())
                <div class="no-tracks">Треки не найдены</div>
                @endif
            </div>


            @guest
            <div class="guest-message">
                <p>Для доступа к полному функционалу <a href="{{ route('login') }}">войдите в систему</a></p>
            </div>
            @endguest
        </div>
    </main>
</body>

</html>