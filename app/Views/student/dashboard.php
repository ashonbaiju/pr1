<?php // app/Views/student/dashboard.php ?>

<div class="grid-4">
    <div class="glass-card stat-card">
        <div class="stat-icon icon-green"><i class="fas fa-check-circle"></i></div>
        <div class="stat-info">
            <h3><?= number_format($attendance_percentage ?? 0) ?>%</h3>
            <p>Overall Attendance</p>
        </div>
    </div>
    <div class="glass-card stat-card">
        <div class="stat-icon icon-orange"><i class="fas fa-tasks"></i></div>
        <div class="stat-info">
            <h3><?= number_format($stats['assignments_pending'] ?? 0) ?></h3>
            <p>Pending Homework</p>
        </div>
    </div>
    <div class="glass-card stat-card">
        <div class="stat-icon icon-blue"><i class="fas fa-file-invoice"></i></div>
        <div class="stat-info">
            <h3><?= htmlspecialchars($stats['fee_status'] ?? 'N/A') ?></h3>
            <p>Fee Status</p>
        </div>
    </div>
    <div class="glass-card stat-card">
        <div class="stat-icon icon-purple"><i class="fas fa-medal"></i></div>
        <div class="stat-info">
            <h3>Grade <?= htmlspecialchars($stats['overall_grade'] ?? 'N/A') ?></h3>
            <p>Current Performance</p>
        </div>
    </div>
</div>

<div class="grid-2">
    <div class="glass-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3>My Subjects & Upcoming Classes</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Teacher</th>
                    <th>Next Class</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Physics</td>
                    <td>Mr. Anderson</td>
                    <td>Today, 10:00 AM</td>
                    <td><button class="btn btn-sm"><i class="fas fa-video"></i> Join Live</button></td>
                </tr>
                <tr>
                    <td>Mathematics</td>
                    <td>Mrs. Smith</td>
                    <td>Tomorrow, 09:00 AM</td>
                    <td><button class="btn btn-sm btn-danger" disabled>Starts Tomorrow</button></td>
                </tr>
                <tr>
                    <td>Chemistry</td>
                    <td>Dr. White</td>
                    <td>Wed, 11:30 AM</td>
                    <td><button class="btn btn-sm btn-danger" disabled>Starts Wed</button></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="glass-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3>Recent Announcements</h3>
            <a href="<?= BASE_URL ?>/student/announcements" class="btn btn-sm">View All</a>
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <div style="padding: 1rem; background: rgba(59, 130, 246, 0.1); border-left: 4px solid #3b82f6; border-radius: 4px;">
                <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.25rem;">From: Admin | Yesterday</div>
                <strong>Reminder:</strong> Semester 1 Fees are due by next Friday. Please process the payment in the 'Fee Status' tab.
            </div>
            
            <div style="padding: 1rem; background: rgba(167, 139, 250, 0.1); border-left: 4px solid #a78bfa; border-radius: 4px;">
                <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.25rem;">From: Mr. Anderson | 2 hours ago</div>
                <strong>Notice:</strong> I have uploaded the New Chapter 4 Notes. Please review them before tomorrow's live class.
                <br>
                <a href="<?= BASE_URL ?>/student/materials" style="color: #a78bfa; text-decoration: none; font-size: 0.9rem; margin-top: 0.5rem; display: inline-block;"><i class="fas fa-download"></i> View Material</a>
            </div>
        </div>
    </div>
</div>
