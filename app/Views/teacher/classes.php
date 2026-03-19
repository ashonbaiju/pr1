<div class="glass-card" style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3>My Classes & Batches</h3>
        <button class="btn btn-primary"><i class="fas fa-plus"></i> Add Batch</button>
    </div>
    <table>
        <thead>
            <tr>
                <th>Batch Name</th>
                <th>Subject</th>
                <th>Students</th>
                <th>Schedule</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <tbody>
            <?php if (empty($batches)): ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 2rem;">
                        <i class="fas fa-chalkboard" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
                        <p style="color: var(--text-muted);">No classes currently active.</p>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($batches as $batch): ?>
                    <tr>
                        <td style="font-weight: 600;"><?= htmlspecialchars($batch['batch_name']) ?> <span class="badge"><?= htmlspecialchars($batch['class_name']) ?></span></td>
                        <td><?= htmlspecialchars($batch['subject_name']) ?></td>
                        <td><?= htmlspecialchars($batch['student_count']) ?> Students</td>
                        <td>Scheduled</td>
                        <td>
                            <a href="<?= BASE_URL ?>/teacher/live?batch=<?= $batch['id'] ?>" class="btn btn-sm btn-danger">
                                <i class="fas fa-video"></i> Start Live
                            </a>
                            <a href="<?= BASE_URL ?>/teacher/attendance?batch=<?= $batch['id'] ?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-users"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<style>
.badge {
    background: rgba(79, 70, 229, 0.2);
    color: #818cf8;
    padding: 0.2rem 0.5rem;
    border-radius: 4px;
    font-size: 0.75rem;
    margin-left: 0.5rem;
}
</style>
