<?php // app/Views/admin/dashboard.php ?>

<div class="grid-4">
    <div class="glass-card stat-card">
        <div class="stat-icon icon-blue"><i class="fas fa-user-graduate"></i></div>
        <div class="stat-info">
            <h3><?= number_format($stats['students']) ?></h3>
            <p>Total Students</p>
        </div>
    </div>
    <div class="glass-card stat-card">
        <div class="stat-icon icon-purple"><i class="fas fa-chalkboard-teacher"></i></div>
        <div class="stat-info">
            <h3><?= number_format($stats['teachers']) ?></h3>
            <p>Active Teachers</p>
        </div>
    </div>
    <div class="glass-card stat-card">
        <div class="stat-icon icon-green"><i class="fas fa-book-open"></i></div>
        <div class="stat-info">
            <h3><?= number_format($stats['classes']) ?></h3>
            <p>Ongoing Classes</p>
        </div>
    </div>
    <div class="glass-card stat-card">
        <div class="stat-icon icon-orange"><i class="fas fa-money-bill-wave"></i></div>
        <div class="stat-info">
            <h3><?= htmlspecialchars($stats['fees_pending']) ?></h3>
            <p>Pending Fees</p>
        </div>
    </div>
</div>

<div class="grid-2">
    <div class="glass-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3>Recent Enrollments</h3>
            <a href="<?= BASE_URL ?>/admin/students" class="btn">View All</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Batch</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>John Doe</td>
                    <td>Class 10 Science</td>
                    <td>Oct 15, 2026</td>
                    <td><span style="color: var(--success)">Active</span></td>
                </tr>
                <tr>
                    <td>Sarah Smith</td>
                    <td>Class 12 Math</td>
                    <td>Oct 14, 2026</td>
                    <td><span style="color: var(--success)">Active</span></td>
                </tr>
                <tr>
                    <td>Mike Johnson</td>
                    <td>Physics Advance</td>
                    <td>Oct 14, 2026</td>
                    <td><span style="color: var(--warning)">Pending fee</span></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="glass-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3>System Alerts & Actions</h3>
        </div>
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <div style="padding: 1rem; background: rgba(239, 68, 68, 0.1); border-left: 4px solid #ef4444; border-radius: 4px;">
                <strong>Action Required:</strong> 5 Teachers have not uploaded assignments this week.
            </div>
            <div style="padding: 1rem; background: rgba(245, 158, 11, 0.1); border-left: 4px solid #fbbf24; border-radius: 4px;">
                <strong>Notice:</strong> 15 Students have pending fees past due date.
            </div>
            
            <h4 style="margin-top: 1rem;">Quick Actions</h4>
            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                <button class="btn"><i class="fas fa-plus"></i> Add User</button>
                <button class="btn"><i class="fas fa-calendar-alt"></i> Create Batch</button>
                <button class="btn"><i class="fas fa-bell"></i> Send Announcement</button>
            </div>
        </div>
    </div>
</div>
