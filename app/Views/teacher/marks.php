<div class="glass-card" style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3>Enter Marks</h3>
    </div>
    
    <?php if(isset($success) && $success): ?>
        <div style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem; border: 1px solid rgba(16, 185, 129, 0.2);">
            <i class="fas fa-check-circle"></i> Marks saved successfully!
        </div>
    <?php endif; ?>

    <form method="GET" action="<?= BASE_URL ?>/teacher/marks" style="margin-bottom: 2rem; display: flex; gap: 1rem; align-items: flex-end;">
        <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Select Batch</label>
            <select name="batch" class="form-control" style="width: 100%; padding: 0.75rem; border-radius: 4px; border: 1px solid var(--border); background: rgba(15, 23, 42, 0.8); color: white;" onchange="this.form.submit()">
                <option value="">-- Choose a Class/Batch --</option>
                <?php foreach($batches as $batch): ?>
                    <option value="<?= $batch['id'] ?>" <?= ($selectedBatch == $batch['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($batch['batch_name'] . ' (' . $batch['subject_name'] . ')') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <?php if($selectedBatch && empty($students)): ?>
        <div style="text-align: center; padding: 2rem; background: rgba(0,0,0,0.2); border-radius: 8px;">
            <i class="fas fa-users-slash" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
            <p style="color: var(--text-muted);">No students are currently enrolled in this batch.</p>
        </div>
    <?php elseif($selectedBatch && !empty($students)): ?>
        <form method="POST" action="<?= BASE_URL ?>/teacher/marks/submit" style="background: rgba(0,0,0,0.1); padding: 1.5rem; border-radius: 8px;">
            <input type="hidden" name="batch_id" value="<?= htmlspecialchars($selectedBatch) ?>">
            <input type="hidden" name="subject_id" value="<?= htmlspecialchars($subject_id) ?>">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Exam / Test Name</label>
                    <input type="text" name="exam_name" required placeholder="e.g. Midterm 1" style="width: 100%; padding: 0.75rem; border-radius: 4px; border: 1px solid var(--border); background: rgba(15, 23, 42, 0.8); color: white; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Maximum Score</label>
                    <input type="number" name="max_score" required min="1" value="100" style="width: 100%; padding: 0.75rem; border-radius: 4px; border: 1px solid var(--border); background: rgba(15, 23, 42, 0.8); color: white; box-sizing: border-box;">
                </div>
            </div>

            <table style="margin-bottom: 1.5rem;">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th style="width: 150px;">Score Obtained</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($students as $student): ?>
                    <tr>
                        <td><?= htmlspecialchars($student['name']) ?></td>
                        <td>
                            <input type="number" name="scores[<?= $student['id'] ?>]" min="0" step="0.01" placeholder="Score" style="width: 100%; padding: 0.5rem; border-radius: 4px; border: 1px solid var(--border); background: rgba(15, 23, 42, 0.8); color: white; box-sizing: border-box;">
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div style="text-align: right;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Marks</button>
            </div>
        </form>
    <?php endif; ?>
</div>
