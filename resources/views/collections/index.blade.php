<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Аудиотека - Коллекции</title>
    @vite(['resources/css/app.css'])
</head>
<body>
   
    <header class="main-header">
        <div class="container">
            <h1 class="logo">Аудиотека</h1>
            <nav class="nav-bar">
                <a class="nav-item" href="{{ route('tracks.index') }}">Мои треки</a>
                <div class="nav-item active">Коллекции</div>
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

    
    <main class="collections-container">
        <div class="container">
            @if($addTrackId)
                <div class="add-track-mode">
                    <h2>Выберите коллекцию для добавления трека</h2>
                    <p>Добавляемый трек: <strong>{{ $trackToAdd->title }}</strong> - {{ $trackToAdd->artist->name }}</p>
                </div>
            @else
                <div class="collections-header">
                    <h1 class="page-title">Мои коллекции</h1>
                    <button class="new-collection-btn" onclick="openCreateModal()">+ Добавить коллекцию</button>
                </div>
            @endif

           
            <div class="collections-grid">
                @foreach($collections as $collection)
                    @if($addTrackId)
                        
                        <form action="{{ route('collections.add-track', $collection->id) }}" method="POST" class="collection-card">
                            @csrf
                            <input type="hidden" name="track_id" value="{{ $addTrackId }}">
                            <div class="collection-cover">
                                <div class="track-count">{{ $collection->tracks_count }} треков</div>
                            </div>
                            <div class="collection-info">
                                <h3>{{ $collection->name }}</h3>
                                <button type="submit" class="save-btn" style="width: 100%; margin-top: 10px;">
                                    Добавить в эту коллекцию
                                </button>
                            </div>
                        </form>
                    @else
                       
                        <div class="collection-card">
                            <div class="collection-cover">
                                <a href="{{ route('collections.show', $collection->id) }}" style="text-decoration: none; color: inherit; display: block;">
                                    <div class="track-count">{{ $collection->tracks_count }} треков</div>
                                </a>
                            </div>
                            <div class="collection-info">
                                <a href="{{ route('collections.show', $collection->id) }}" style="text-decoration: none; color: inherit;">
                                    <h3>{{ $collection->name }}</h3>
                                </a>
                                <div class="collection-actions">
                                    <button type="button" class="edit-btn" onclick="openEditModal('{{ $collection->id }}', '{{ $collection->name }}')">
                                        ✎
                                    </button>
                                    <form action="{{ route('collections.destroy', $collection->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn" onclick="return confirm('Удалить коллекцию?')">
                                            ×
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

                @if($collections->isEmpty() && !$addTrackId)
                    <div class="no-collections">
                        У вас пока нет коллекций
                    </div>
                @endif
            </div>

            @if($addTrackId)
                <div style="text-align: center; margin-top: 30px;">
                    <a href="{{ route('tracks.index') }}" class="btn-primary" style="display: inline-block; width: auto; padding: 10px 20px;">
                        Отмена
                    </a>
                </div>
            @endif
        </div>
    </main>

    
    <div id="createModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 30px; border-radius: 12px; width: 90%; max-width: 400px;">
            <h3 style="margin-top: 0;">Создать коллекцию</h3>
            <form action="{{ route('collections.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Название коллекции</label>
                    <input type="text" name="name" required class="form-group input">
                </div>
                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" class="btn-primary">Создать</button>
                    <button type="button" onclick="closeCreateModal()" class="btn-primary" style="background: #6c757d;">Отмена</button>
                </div>
            </form>
        </div>
    </div>

   
    <div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 30px; border-radius: 12px; width: 90%; max-width: 400px;">
            <h3 style="margin-top: 0;">Редактировать коллекцию</h3>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Название коллекции</label>
                    <input type="text" name="name" id="editCollectionName" required class="form-group input">
                </div>
                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" class="btn-primary">Сохранить</button>
                    <button type="button" onclick="closeEditModal()" class="btn-primary" style="background: #6c757d;">Отмена</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openCreateModal() {
            document.getElementById('createModal').style.display = 'block';
        }

        function closeCreateModal() {
            document.getElementById('createModal').style.display = 'none';
        }

        function openEditModal(collectionId, collectionName) {
            document.getElementById('editCollectionName').value = collectionName;
            document.getElementById('editForm').action = '/collections/' + collectionId;
            document.getElementById('editModal').style.display = 'block';
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        
        window.onclick = function(event) {
            const createModal = document.getElementById('createModal');
            const editModal = document.getElementById('editModal');
            
            if (event.target === createModal) {
                closeCreateModal();
            }
            if (event.target === editModal) {
                closeEditModal();
            }
        }

        
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.edit-btn');
            const deleteButtons = document.querySelectorAll('.delete-btn');
            
            editButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    e.preventDefault();
                });
            });
            
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    
                });
            });
        });
    </script>
</body>
</html>