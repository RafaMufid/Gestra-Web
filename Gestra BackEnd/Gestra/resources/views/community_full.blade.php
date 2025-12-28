<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="stylesheet" href="{{ asset('css/style_community.css') }}?v={{ time() }}">
    <link rel="icon" href="{{ asset('assets/Logo atas/favicon.ico') }}" type="image/x-icon">
    <title>All Community Posts</title>
</head>

<body>
    <div class="nav">
        <div class="logo">
            <img src="{{ asset('assets/gestra.png') }}" alt="Gestra Logo">
        </div>
        <div class="list">
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="">About</a></li>
                <li><a href="">Contact</a></li>
            </ul>
        </div>
        
        <div class="akun">
            @if(session('user'))
                <span style="color: white; font-weight: bold;">Hi, {{ session('user')['username'] }}</span>
                <img src="{{ asset(session('user')['profile_photo_path'] ?? 'assets/default.png') }}" 
                     alt="Profile" 
                     style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid white;">
                <a href="{{ route('logout') }}" style="color: #ffcccc; text-decoration: none; font-weight: bold; font-size: 0.9em;">Logout</a>
            @else
                <a href="{{ route('login') }}"><button class="btn login">Login</button></a>
                <a href="{{ route('register') }}"><button class="btn daftar">Sign-Up</button></a>
            @endif
        </div>
    </div>

    <div class="main">
        
        <div class="community-intro">
            <h1>Semua Postingan Komunitas</h1>
            <p>Menjelajahi seluruh cerita, tips, dan diskusi dari pengguna Gestra.</p>
            
            <a href="{{ route('community.index') }}">
                <button type="button">Kembali ke Halaman Utama</button>
            </a>
        </div>

        <div class="community-content">
            <h2>All User Stories & Tips</h2>
            
            <div id="posts-container">
                @if($posts->isEmpty())
                    <p style="text-align: center; color: gray;">Belum ada cerita.</p>
                @else
                    @foreach($posts as $post)
                    <div class="community-posts">
                        <h3>{{ $post->title }} <span style="font-size: 0.6em; color: blue;">#{{ $post->topic }}</span></h3>
                        <p style="margin-bottom: 5px;">Oleh: {{ $post->author }} | {{ $post->created_at->diffForHumans() }}</p>
                        <p>{{ $post->content }}</p>
                        
                        <div class="community-buttons">
                            <button type="button" class="like-btn" data-id="{{ $post->id }}">
                                Like ({{ $post->likes }})
                            </button>
                            <button type="button" class="comment-toggle-btn" data-id="{{ $post->id }}">
                                Comment ({{ $post->comments->count() }})
                            </button>
                        </div>

                        <div id="comment-box-{{ $post->id }}" class="comment-section">
                            @foreach($post->comments as $comment)
                                <div style="border-bottom: 1px solid #eee; padding: 5px 0; margin-bottom: 5px;">
                                    <strong style="color: blue;">{{ $comment->author }}:</strong> {{ $comment->content }}
                                </div>
                            @endforeach

                            @if(session('user'))
                                <form action="{{ route('community.comment', $post->id) }}" method="POST" style="margin-top: 10px; display: flex; gap: 5px;">
                                    @csrf
                                    <input type="text" name="comment_content" class="input-custom" style="margin-bottom: 0;" placeholder="Tulis komentar..." required>
                                    <button type="submit" style="border: none; background: blue; color: white; padding: 5px 15px; border-radius: 10px; cursor: pointer;">Kirim</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <div class="kontak">
        <div class="footer-content">
            <p>© 2025 Gestra. All rights reserved.</p>
            <div class="social-links">
                <a href="#">Facebook</a>
                <a href="#">Twitter</a>
                <a href="#">Instagram</a>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/script_community.js') }}?v={{ time() }}"></script>
</body>
</html>