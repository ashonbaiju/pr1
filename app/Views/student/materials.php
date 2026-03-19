<div class="glass-card" style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3>Shared Study Materials</h3>
        <input type="text" placeholder="Search Materials..." style="padding: 0.5rem; border-radius: 4px; border: 1px solid var(--border); background: rgba(0,0,0,0.2); color: white;">
    </div>
    
    <div class="grid-4" style="grid-template-columns: repeat(3, 1fr);">
        <?php if(empty($materials)): ?>
            <p style="color: var(--text-muted);">No materials have been shared with your batches yet.</p>
        <?php else: ?>
            <?php foreach($materials as $material): ?>
            <div class="glass-card" style="display: flex; align-items: center; gap: 1rem;">
                <div class="stat-icon icon-blue" style="font-size: 2rem;">
                    <?php if($material['type'] == 'pdf'): ?><i class="fas fa-file-pdf"></i>
                    <?php else: ?><i class="fas fa-file-alt"></i><?php endif; ?>
                </div>
                <div>
                    <h4 style="margin: 0; font-size: 1rem;"><?= htmlspecialchars($material['title']) ?></h4>
                    <p style="color: var(--text-muted); font-size: 0.8rem;">By <?= htmlspecialchars($material['teacher_name']) ?></p>
                    <a href="<?= BASE_URL ?>/uploads/materials/<?= htmlspecialchars($material['file_path']) ?>" download style="color: #60a5fa; font-size: 0.85rem; text-decoration: none; display: inline-block; margin-top: 0.5rem;"><i class="fas fa-download"></i> Download</a>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
