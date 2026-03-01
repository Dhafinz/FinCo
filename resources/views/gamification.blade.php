<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FinCo - Gamifikasi Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .user-info {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            text-align: center;
        }

        .user-info h2 {
            color: #667eea;
            margin-bottom: 10px;
        }

        .logout-btn {
            margin-top: 20px;
            padding: 10px 30px;
            background: #f44336;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
        }

        .level-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 40px;
            color: white;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .level-card::before {
            content: '🎮';
            position: absolute;
            font-size: 200px;
            opacity: 0.1;
            right: -50px;
            top: -50px;
        }

        .level-number {
            font-size: 4em;
            font-weight: bold;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .level-title {
            font-size: 1.5em;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .progress-container {
            background: rgba(255,255,255,0.2);
            border-radius: 50px;
            height: 30px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #FFD700, #FFA500);
            border-radius: 50px;
            transition: width 1s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #333;
        }

        .xp-info {
            display: flex;
            justify-content: space-between;
            font-size: 1.1em;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            text-align: center;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            font-size: 3em;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 2em;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #666;
            font-size: 1em;
        }

        .xp-history {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .xp-history h3 {
            color: #667eea;
            margin-bottom: 20px;
            font-size: 1.5em;
        }

        .xp-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            transition: background 0.3s;
        }

        .xp-item:hover {
            background: #f5f5f5;
        }

        .xp-source {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .xp-icon {
            font-size: 2em;
        }

        .xp-details {
            display: flex;
            flex-direction: column;
        }

        .xp-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 3px;
        }

        .xp-date {
            font-size: 0.9em;
            color: #999;
        }

        .xp-amount {
            font-size: 1.3em;
            font-weight: bold;
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎮 FinCo Gamification</h1>
            <p>Manage Your Finance, Level Up Your Life!</p>
        </div>

        <!-- User Info -->
        <div class="user-info">
            <h2>{{ $user->name }}</h2>
            <p class="username">@{{ $user->username }}</p>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>

        <!-- Level Card -->
        <div class="level-card">
            <div class="level-number">Level {{ $gamification['level'] }}</div>
            <div class="level-title">
                @if($gamification['level'] <= 10)
                    🌱 Pemula
                @elseif($gamification['level'] <= 25)
                    ⚡ Menengah
                @elseif($gamification['level'] <= 50)
                    🔥 Mahir
                @else
                    👑 Expert
                @endif
            </div>
            
            <div class="progress-container">
                <div class="progress-bar" style="width: {{ $gamification['progress_percentage'] }}%">
                    <span>{{ round($gamification['progress_percentage']) }}%</span>
                </div>
            </div>
            
            <div class="xp-info">
                <div><strong>Total XP:</strong> {{ $gamification['total_xp'] }}</div>
                <div><strong>Next Level:</strong> {{ $gamification['xp_needed'] }} XP</div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">🏆</div>
                <div class="stat-value">{{ $gamification['total_xp'] }}</div>
                <div class="stat-label">Total XP</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🏅</div>
                <div class="stat-value">{{ $gamification['badges'] }}</div>
                <div class="stat-label">Badges</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">⭐</div>
                <div class="stat-value">{{ $gamification['achievements'] }}</div>
                <div class="stat-label">Achievements</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">💰</div>
                <div class="stat-value">Rp {{ number_format($financialSummary['balance'], 0, ',', '.') }}</div>
                <div class="stat-label">Current Balance</div>
            </div>
        </div>

        <!-- Recent Transactions as XP History -->
        <div class="xp-history">
            <h3>📈 Recent XP Gains</h3>
            @forelse($recentTransactions as $transaction)
                <div class="xp-item">
                    <div class="xp-source">
                        <div class="xp-icon">{{ $transaction->category->icon }}</div>
                        <div class="xp-details">
                            <div class="xp-title">{{ $transaction->description }}</div>
                            <div class="xp-date">{{ $transaction->transaction_date->diffForHumans() }}</div>
                        </div>
                    </div>
                    <div class="xp-amount">+{{ $transaction->xp_earned }} XP</div>
                </div>
            @empty
                <p style="text-align: center; color: #999; padding: 20px;">
                    Belum ada transaksi. Mulai catat transaksi untuk dapat XP!
                </p>
            @endforelse
        </div>
    </div>
</body>
</html>