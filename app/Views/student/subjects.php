<div class="glass-card" style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3>My Enrolled Subjects</h3>
    </div>
    <table>
        <thead>
            <tr>
                <th>Subject Name</th>
                <th>Assigned Teacher</th>
                <th>Schedule</th>
                <th>Live Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($batches)): ?>
                <tr><td colspan="4" style="text-align: center; color: var(--text-muted); padding: 1rem;">No subjects enrolled yet.</td></tr>
            <?php else: ?>
                <?php foreach($batches as $batch): ?>
                <tr>
                    <td><?= htmlspecialchars($batch['subject_name']) ?> <span style="font-size: 0.8rem; color: var(--text-muted);">(<?= htmlspecialchars($batch['batch_name']) ?>)</span></td>
                    <td><?= htmlspecialchars($batch['teacher_name']) ?></td>
                    <td>Assigned</td>
                    <td>
                        <!-- Jitsi Live Integration coming soon -->
                        <a href="<?= BASE_URL ?>/student/live?batch=<?= $batch['id'] ?>" class="btn btn-sm"><i class="fas fa-video"></i> Join Live</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
