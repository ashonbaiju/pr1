<div class="grid-2">
    <?php if(isset($success) && $success): ?>
        <div style="grid-column: 1 / -1; background: rgba(16, 185, 129, 0.1); border: 1px solid #34d399; color: #34d399; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
            <i class="fas fa-check-circle"></i> Payment successful! Thank you.
        </div>
    <?php endif; ?>
    <div class="glass-card">
        <h3>Current Fee Status</h3>
        <div style="margin-top: 2rem; display: flex; flex-direction: column; align-items: center;">
            <?php if($pendingCount == 0): ?>
                <div style="width: 120px; height: 120px; border-radius: 50%; background: rgba(16, 185, 129, 0.2); color: #34d399; display: flex; align-items: center; justify-content: center; font-size: 3rem; margin-bottom: 1rem;">
                    <i class="fas fa-check"></i>
                </div>
                <h2 style="margin: 0;">Fully Paid</h2>
                <p style="color: var(--text-muted); margin-top: 0.5rem;">No pending dues.</p>
            <?php else: ?>
                <div style="width: 120px; height: 120px; border-radius: 50%; background: rgba(239, 68, 68, 0.2); color: #ef4444; display: flex; align-items: center; justify-content: center; font-size: 3rem; margin-bottom: 1rem;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h2 style="margin: 0;"><?= $pendingCount ?> Invoice(s) Pending</h2>
                <a href="<?= BASE_URL ?>/student/fees/pay" class="btn" style="margin-top: 1rem;"><i class="fas fa-credit-card"></i> Pay Now</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="glass-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3>Payment History</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Invoice ID</th>
                    <th>Due Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Receipt</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($fees)): ?>
                    <tr><td colspan="5" style="text-align: center; color: var(--text-muted); padding: 1rem;">No fee records found.</td></tr>
                <?php else: ?>
                    <?php foreach($fees as $fee): ?>
                    <tr>
                        <td>#INV-<?= htmlspecialchars(str_pad($fee['id'], 4, '0', STR_PAD_LEFT)) ?></td>
                        <td><?= htmlspecialchars($fee['due_date']) ?></td>
                        <td>$<?= htmlspecialchars(number_format($fee['amount'], 2)) ?></td>
                        <td>
                            <?php if($fee['status'] == 'paid'): ?>
                                <span style="color: var(--success)">Paid</span>
                            <?php else: ?>
                                <span style="color: var(--danger)">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td><a href="<?= BASE_URL ?>/student/fees/receipt?id=<?= $fee['id'] ?>" class="btn btn-sm" style="background: rgba(255,255,255,0.1);"><i class="fas fa-download"></i></a></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
