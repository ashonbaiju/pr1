<div class="glass-card" style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3>Enroll Student & Assign Fees</h3>
    </div>
    
    <?php if(isset($success) && $success): ?>
        <div style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem; border: 1px solid rgba(16, 185, 129, 0.2);">
            <i class="fas fa-check-circle"></i> Student enrolled and fees issued successfully!
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/admin/enrollments/submit" style="background: rgba(0,0,0,0.1); padding: 1.5rem; border-radius: 8px;">
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Select Student</label>
            <select name="student_id" required class="form-control" style="width: 100%; padding: 0.75rem; border-radius: 4px; border: 1px solid var(--border); background: rgba(15, 23, 42, 0.8); color: white;">
                <option value="">-- Choose a Student --</option>
                <?php foreach($students as $student): ?>
                    <option value="<?= $student['id'] ?>">
                        <?= htmlspecialchars($student['name'] . ' (' . $student['email'] . ')') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Select Classes / Batches</label>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem; background: rgba(15, 23, 42, 0.5); padding: 1rem; border-radius: 4px; border: 1px solid var(--border);">
                <?php foreach($batches as $batch): ?>
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="batches[]" value="<?= $batch['id'] ?>" style="accent-color: var(--primary); width: 1.2rem; height: 1.2rem;">
                        <span><?= htmlspecialchars($batch['batch_name'] . ' - ' . $batch['subject_name']) ?> <small style="color:var(--text-muted);">(<?= htmlspecialchars($batch['class_name']) ?>)</small></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <hr style="border-color: rgba(255,255,255,0.1); margin: 2rem 0;">
        <h4 style="margin-bottom: 1rem;">Generate Invoice (Optional)</h4>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Fee Amount ($)</label>
                <input type="number" name="fee_amount" min="0" step="0.01" placeholder="e.g. 500.00" style="width: 100%; padding: 0.75rem; border-radius: 4px; border: 1px solid var(--border); background: rgba(15, 23, 42, 0.8); color: white; box-sizing: border-box;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Due Date</label>
                <input type="date" name="due_date" min="<?= date('Y-m-d') ?>" style="width: 100%; padding: 0.75rem; border-radius: 4px; border: 1px solid var(--border); background: rgba(15, 23, 42, 0.8); color: white; box-sizing: border-box;">
            </div>
        </div>

        <div style="text-align: right; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus"></i> Complete Enrollment</button>
        </div>

    </form>
</div>
