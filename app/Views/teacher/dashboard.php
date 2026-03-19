<?php // app/Views/teacher/dashboard.php ?>

<div class="grid-4">
    <div class="glass-card stat-card">
        <div class="stat-icon icon-blue"><i class="fas fa-chalkboard"></i></div>
        <div class="stat-info">
            <h3><?= number_format($stats['batches']) ?></h3>
            <p>Assigned Batches</p>
        </div>
    </div>
    <div class="glass-card stat-card">
        <div class="stat-icon icon-purple"><i class="fas fa-users"></i></div>
        <div class="stat-info">
            <h3><?= number_format($stats['total_students']) ?></h3>
            <p>My Students</p>
        </div>
    </div>
    <div class="glass-card stat-card">
        <div class="stat-icon icon-orange"><i class="fas fa-clock"></i></div>
        <div class="stat-info">
            <h3><?= number_format($stats['assignments_due']) ?></h3>
            <p>Pending Grading</p>
        </div>
    </div>
    <div class="glass-card stat-card">
        <div class="stat-icon icon-green"><i class="fas fa-envelope"></i></div>
        <div class="stat-info">
            <h3><?= number_format($stats['messages']) ?></h3>
            <p>New Messages</p>
        </div>
    </div>
</div>

<div class="grid-2">
    <div class="glass-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3>Today's Classes</h3>
            <button class="btn"><i class="fas fa-video"></i> Start Live Class</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Batch</th>
                    <th>Subject</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>10:00 AM</td>
                    <td>Class 10 Science - A</td>
                    <td>Physics</td>
                    <td><button class="btn btn-danger btn-sm">Take Attendance</button></td>
                </tr>
                <tr>
                    <td>12:30 PM</td>
                    <td>Class 12 Math</td>
                    <td>Calculus</td>
                    <td><button class="btn btn-sm">Take Attendance</button></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="glass-card">
        <h3 style="margin-bottom: 1.5rem;">Quick Links</h3>
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <a href="<?= BASE_URL ?>/teacher/assignments/upload" class="glass-card" style="display: flex; align-items: center; gap: 1rem; text-decoration: none; color: inherit; transition: transform 0.2s;">
                <div class="stat-icon icon-purple"><i class="fas fa-upload"></i></div>
                <div>
                    <h4 style="margin: 0; font-size: 1.1rem;">Upload Study Material</h4>
                    <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.2rem;">Share PDFs, notes, or assignments to a batch.</p>
                </div>
            </a>
            
            <a href="<?= BASE_URL ?>/teacher/announcements/new" class="glass-card" style="display: flex; align-items: center; gap: 1rem; text-decoration: none; color: inherit; transition: transform 0.2s;">
                <div class="stat-icon icon-blue"><i class="fas fa-bullhorn"></i></div>
                <div>
                    <h4 style="margin: 0; font-size: 1.1rem;">Post Announcement</h4>
                    <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.2rem;">Notify students about upcoming tests or changes.</p>
                </div>
            </a>
            
            <a href="<?= BASE_URL ?>/teacher/marks/enter" class="glass-card" style="display: flex; align-items: center; gap: 1rem; text-decoration: none; color: inherit; transition: transform 0.2s;">
                <div class="stat-icon icon-green"><i class="fas fa-star"></i></div>
                <div>
                    <h4 style="margin: 0; font-size: 1.1rem;">Enter Test Marks</h4>
                    <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.2rem;">Record scores for recent examinations.</p>
                </div>
            </a>
        </div>
    </div>
</div>
<style>
    .glass-card a.glass-card:hover { transform: translateY(-3px) scale(1.02); background: rgba(255, 255, 255, 0.05); }
    .btn-sm { padding: 0.25rem 0.5rem; font-size: 0.875rem; }
</style>
