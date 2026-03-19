<div class="grid-2">
    <div class="glass-card">
        <h3>Attendance Summary</h3>
        <div style="margin-top: 2rem; display: flex; justify-content: center;">
            <div style="width: 200px; height: 200px; border-radius: 50%; border: 15px solid <?= $percentage >= 75 ? 'var(--success)' : 'var(--danger)' ?>; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: bold;">
                <?= $percentage ?>%
            </div>
        </div>
        <p style="text-align: center; margin-top: 1rem; color: var(--text-muted);">Overall Present Rate</p>
    </div>

    <div class="glass-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3>Recent Records</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Subject</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($records)): ?>
                    <tr><td colspan="3" style="text-align: center; color: var(--text-muted); padding: 1rem;">No attendance recorded yet.</td></tr>
                <?php else: ?>
                    <?php foreach($records as $rec): ?>
                    <tr>
                        <td><?= htmlspecialchars($rec['date']) ?></td>
                        <td><?= htmlspecialchars($rec['batch_name']) ?></td>
                        <td>
                            <?php if($rec['status'] == 'present'): ?>
                                <span style="color: var(--success)">Present</span>
                            <?php else: ?>
                                <span style="color: var(--danger)">Absent</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
