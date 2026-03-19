<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus Tuition - <?= htmlspecialchars($title ?? 'Portal') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #818cf8;
            --bg-dark: #0f172a;
            --sidebar-bg: #1e293b;
            --card-bg: rgba(30, 41, 59, 0.6);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border: rgba(255, 255, 255, 0.08);
            --success: #10b981;
            --warning: #f59e0b;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
            z-index: 100;
        }

        .brand {
            padding: 1.5rem;
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(to right, #818cf8, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            border-bottom: 1px solid var(--border);
        }

        .nav-links {
            flex: 1;
            padding: 1.5rem 0;
            overflow-y: auto;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.875rem 1.5rem;
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.2s;
            font-weight: 500;
        }

        .nav-link i {
            width: 24px;
            font-size: 1.1rem;
            margin-right: 0.75rem;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(79, 70, 229, 0.1);
            color: var(--primary-light);
            border-right: 3px solid var(--primary);
        }

        .user-profile {
            padding: 1.5rem;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .avatar {
            width: 40px; height: 40px;
            border-radius: 50%;
            background: var(--primary);
            display: flex; align-items: center; justify-content: center;
            font-weight: 600;
        }

        .user-info div { font-size: 0.875rem; }
        .user-info .role { font-size: 0.75rem; color: var(--primary-light); text-transform: uppercase; letter-spacing: 0.5px;}

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            width: calc(100% - 260px);
        }

        .top-header {
            height: 70px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .mobile-toggle {
            display: none;
            background: none; border: none; color: white;
            font-size: 1.5rem; cursor: pointer;
        }

        .content-area {
            padding: 2rem;
            flex: 1;
            overflow-y: auto;
        }

        /* Glass Cards */
        .glass-card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }

        /* Basic Grid */
        .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2rem; }
        .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; }

        .stat-card {
            display: flex; align-items: center; gap: 1rem;
        }
        .stat-icon {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center; font-size: 1.5rem;
        }
        .icon-blue { background: rgba(59, 130, 246, 0.2); color: #60a5fa; }
        .icon-green { background: rgba(16, 185, 129, 0.2); color: #34d399; }
        .icon-purple { background: rgba(167, 139, 250, 0.2); color: #c084fc; }
        .icon-orange { background: rgba(245, 158, 11, 0.2); color: #fbbf24; }
        
        .stat-info h3 { font-size: 1.5rem; font-weight: 700; margin-bottom: 0.25rem; }
        .stat-info p { color: var(--text-muted); font-size: 0.875rem; }

        .btn {
            background: var(--primary); color: white; border: none; padding: 0.5rem 1rem;
            border-radius: 0.5rem; font-weight: 500; cursor: pointer; text-decoration: none;
            display: inline-block; transition: background 0.2s;
        }
        .btn:hover { background: var(--primary-light); }
        .btn-danger { background: rgba(239, 68, 68, 0.2); color: #f87171; }
        .btn-danger:hover { background: #ef4444; color: white; }

        /* Tables */
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 1rem; text-align: left; border-bottom: 1px solid var(--border); }
        th { color: var(--text-muted); font-weight: 600; font-size: 0.875rem; text-transform: uppercase; }
        tr:hover { background: rgba(255, 255, 255, 0.02); }

        /* Responsive */
        @media (max-width: 1024px) {
            .grid-4 { grid-template-columns: repeat(2, 1fr); }
            .grid-2 { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                height: 100vh;
                transform: translateX(-100%);
            }
            .sidebar.active { transform: translateX(0); }
            .main-content { width: 100%; }
            .mobile-toggle { display: block; }
            .grid-4 { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    
    <div class="sidebar" id="sidebar">
        <div class="brand">Nexus Tuition</div>
        <div class="nav-links">
            <?php foreach($links as $link): ?>
                <a href="<?= BASE_URL . $link['url'] ?>" class="nav-link <?= ($currentUrl == $link['url']) ? 'active' : '' ?>">
                    <i class="<?= $link['icon'] ?>"></i> <?= $link['label'] ?>
                </a>
            <?php endforeach; ?>
        </div>
        <div class="user-profile">
            <div class="avatar"><?= substr($_SESSION['user_name'], 0, 1) ?></div>
            <div class="user-info">
                <div><?= htmlspecialchars($_SESSION['user_name']) ?></div>
                <div class="role"><?= htmlspecialchars($_SESSION['user_role']) ?></div>
            </div>
        </div>
    </div>

    <div class="main-content">
        <header class="top-header">
            <button class="mobile-toggle" id="mobileToggle"><i class="fas fa-bars"></i></button>
            <div class="page-title" style="font-weight: 600; font-size: 1.1rem;"><?= htmlspecialchars($title ?? 'Dashboard') ?></div>
            <div style="display: flex; gap: 1rem; align-items: center;">
                <a href="<?= BASE_URL ?>/messages" style="color: white; font-size: 1.2rem; position: relative;">
                    <i class="fas fa-envelope"></i>
                    <span style="position: absolute; top: -5px; right: -8px; background: var(--danger); font-size: 0.6rem; padding: 2px 4px; border-radius: 50%;">+</span>
                </a>
                <a href="<?= BASE_URL ?>/logout" class="btn btn-danger btn-sm"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </header>
        
        <main class="content-area">
            <?= $content ?? '' ?>
        </main>
    </div>

    <script>
        document.getElementById('mobileToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
</body>
</html>
