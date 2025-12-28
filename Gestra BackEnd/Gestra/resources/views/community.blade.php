<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('css/style_community.css') }}?v={{ time() }}">
    <link rel="icon" href="{{ asset('assets/Logo atas/favicon.ico') }}" type="image/x-icon">
    <title>Gestra Community Page</title>
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
                <img src="{{ asset(session('user')['profile_photo_path'] ?? 'assets/default.png') }}" alt="Profile"
                    style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid white;">
                <a href="{{ route('logout') }}"
                    style="color: #ffcccc; text-decoration: none; font-weight: bold; font-size: 0.9em;">Logout</a>
            @else
                <a href="{{ route('login') }}"><button class="btn login">Login</button></a>
                <a href="{{ route('register') }}"><button class="btn daftar">Sign-Up</button></a>
            @endif
        </div>
    </div>

    <div class="main">
        <div class="community-intro">
            <h1>Selamat Datang di Komunitas Gestra!</h1>
            <p>Bagikan pengalaman Anda, tukar tips, dan terhubung dengan sesama.</p>

            @if(session('user'))
                <div style="margin-top: 20px;">
                    <select id="topic-input" class="input-custom">
                        <option value="" disabled selected>Pilih Topik...</option>
                        <option value="SIBITips">SIBI Tips</option>
                        <option value="SpeechToText">Speech To Text</option>
                        <option value="CommunityEvents">Community Events</option>
                        <option value="UserStories">User Stories</option>
                    </select>
                    <input type="text" id="title-input" class="input-custom" placeholder="Judul Cerita">
                    <textarea id="content-input" class="input-custom" rows="3"
                        placeholder="Tulis cerita Anda..."></textarea>

                    <button type="button" id="post-btn">Post Story</button>
                </div>
            @else
                <a href="{{ route('login') }}"><button type="button">Login to Post</button></a>
            @endif
        </div>

        <div class="community-content">
            <h2>Recent User Stories & Tips</h2>

            <div id="posts-container">
                @if($posts->isEmpty())
                    <p style="text-align: center; color: gray;">Belum ada cerita.</p>
                @else
                    @foreach($posts as $post)
                        <div class="community-posts">
                            <h3>{{ $post->title }} <span style="font-size: 0.6em; color: blue;">#{{ $post->topic }}</span></h3>

                            <p style="margin-bottom: 5px;">Oleh: {{ $post->author }} | {{ $post->created_at->diffForHumans() }}
                            </p>

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
                                    <form action="{{ route('community.comment', $post->id) }}" method="POST"
                                        style="margin-top: 10px; display: flex; gap: 5px;">
                                        @csrf
                                        <input type="text" name="comment_content" class="input-custom" style="margin-bottom: 0;"
                                            placeholder="Tulis komentar..." required>
                                        <button type="submit"
                                            style="border: none; background: blue; color: white; padding: 5px 15px; border-radius: 10px; cursor: pointer;">Kirim</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <a href="{{ route('community.all', ['topic' => request('topic')]) }}">
                <button>Load More</button>
            </a>

            <div class="community-topics">
                <h2>Browse Topics</h2>
                <ul>
                    @php
                        $topicsMap = [
                            'SIBITips' => 'SIBI Tips',
                            'SpeechToText' => 'Speech To Text',
                            'CommunityEvents' => 'Community Events',
                            'LearningResources' => 'Learning Resources',
                            'UserStories' => 'User Stories'
                        ];
                    @endphp

                    @foreach($topicsMap as $key => $label)
                        <li>
                            <a href="{{ route('community.index', ['topic' => $key]) }}">#{{ $label }}</a>
                            <p>{{ $topicCounts[$key] ?? 0 }}</p>
                        </li>
                    @endforeach

                    <li><a href="{{ route('community.index') }}" style="color: red;">Clear Filter</a></li>
                </ul>
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