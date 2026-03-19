<div class="glass-card" style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3>Exam Performance</h3>
        <select class="btn" style="background: rgba(255,255,255,0.1); border: 1px solid var(--border);">
            <option>Semester 1</option>
            <option>Semester 2</option>
        </select>
    </div>
    <table>
        <thead>
            <tr>
                <th>Exam Name</th>
                <th>Subject</th>
                <th>Score</th>
                <th>Max Score</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
        <tbody>
            <?php if(empty($marks)): ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 1rem;">No marks recorded yet.</td>
                </tr>
            <?php else: ?>
                <?php foreach($marks as $mark): ?>
                    <?php 
                        $percent = ($mark['score'] / $mark['max_score']) * 100;
                        if ($percent >= 90) { $grade = 'A+'; $color = 'var(--success)'; }
                        elseif ($percent >= 80) { $grade = 'A'; $color = 'var(--success)'; }
                        elseif ($percent >= 70) { $grade = 'B'; $color = 'var(--success)'; }
                        elseif ($percent >= 60) { $grade = 'C'; $color = 'var(--warning)'; }
                        elseif ($percent >= 50) { $grade = 'D'; $color = 'var(--warning)'; }
                        else { $grade = 'F'; $color = 'var(--danger)'; }
                    ?>
                <tr>
                    <td><?= htmlspecialchars($mark['exam_name']) ?></td>
                    <td><?= htmlspecialchars($mark['subject_name']) ?></td>
                    <td><?= htmlspecialchars($mark['score']) ?></td>
                    <td><?= htmlspecialchars($mark['max_score']) ?></td>
                    <td><span style="color: <?= $color ?>; font-weight: bold;"><?= $grade ?></span></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
