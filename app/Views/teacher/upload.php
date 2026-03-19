<div class="glass-card" style="max-width: 600px; margin: 0 auto;">
    <h3 style="margin-bottom: 2rem;">Upload Study Material</h3>
    
    <?php if(isset($_GET['success'])): ?>
        <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid #34d399; color: #34d399; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
            <i class="fas fa-check-circle"></i> File uploaded and shared with students successfully!
        </div>
    <?php endif; ?>
    <?php if(isset($_GET['error'])): ?>
        <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid #f87171; color: #f87171; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
            <i class="fas fa-exclamation-triangle"></i> Failed to upload file. Please try again.
        </div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>/teacher/materials/upload" method="POST" enctype="multipart/form-data">
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem;">Title / Chapter Name</label>
            <input type="text" name="title" required placeholder="e.g. Chapter 4: Thermodynamics" style="width: 100%; padding: 0.75rem; border-radius: 4px; border: 1px solid var(--border); background: rgba(0,0,0,0.2); color: white;">
        </div>

        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem;">Select Batch</label>
            <select name="batch_id" required style="width: 100%; padding: 0.75rem; border-radius: 4px; border: 1px solid var(--border); background: rgba(15, 23, 42, 0.8); color: white;">
                <?php foreach($batches as $batch): ?>
                    <option value="<?= $batch['id'] ?>"><?= htmlspecialchars($batch['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem;">Material Type</label>
            <select name="type" required style="width: 100%; padding: 0.75rem; border-radius: 4px; border: 1px solid var(--border); background: rgba(15, 23, 42, 0.8); color: white;">
                <option value="pdf">PDF Notes</option>
                <option value="assignment">Assignment / Homework</option>
            </select>
        </div>
        
        <div class="form-group" style="margin-bottom: 2rem;">
            <label style="display: block; margin-bottom: 0.5rem;">Attach File</label>
            <div style="border: 2px dashed rgba(255,255,255,0.2); padding: 2rem; border-radius: 8px; text-align: center; background: rgba(0,0,0,0.1);">
                <i class="fas fa-cloud-upload-alt" style="font-size: 2.5rem; color: #818cf8; margin-bottom: 1rem;"></i>
                <input type="file" name="material_file" required accept=".pdf,.doc,.docx" style="display: block; margin: 0 auto;">
                <p style="margin-top: 1rem; color: var(--text-muted); font-size: 0.85rem;">Max Size: 10MB. Allowed: PDF, DOC.</p>
            </div>
        </div>

        <button type="submit" class="btn" style="width: 100%; font-size: 1.1rem; padding: 1rem;"><i class="fas fa-upload"></i> Upload & Share to Batch</button>
    </form>
</div>
