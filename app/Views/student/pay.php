<div class="glass-card" style="max-width: 500px; margin: 0 auto;">
    <h3 style="margin-bottom: 2rem; text-align: center;"><i class="fas fa-lock" style="color: var(--success);"></i> Secure Checkout</h3>
    
    <div style="background: rgba(0,0,0,0.2); padding: 1.5rem; border-radius: 8px; border: 1px solid var(--border); margin-bottom: 2rem; text-align: center;">
        <p style="color: var(--text-muted); margin: 0; font-size: 0.9rem;">Total Amount Due</p>
        <h1 style="margin: 0.5rem 0 0 0; color: #fff;">$<?= number_format($amount, 2) ?></h1>
    </div>

    <form action="<?= BASE_URL ?>/student/fees/process" method="POST">
        <input type="hidden" name="invoice_ids" value="<?= htmlspecialchars($invoice_ids) ?>">
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; color: var(--muted); font-size: 0.9rem;">Cardholder Name</label>
            <input type="text" required placeholder="e.g. John Doe" value="<?= htmlspecialchars($_SESSION['user_name'] ?? '') ?>" style="width: 100%; padding: 0.75rem; border-radius: 4px; border: 1px solid var(--border); background: rgba(15, 23, 42, 0.8); color: white;">
        </div>

        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem;">Card Number</label>
            <div style="position: relative;">
                <input type="text" required placeholder="0000 0000 0000 0000" maxlength="19" style="width: 100%; padding: 0.75rem 0.75rem 0.75rem 2.5rem; border-radius: 4px; border: 1px solid var(--border); background: rgba(15, 23, 42, 0.8); color: white;">
                <i class="far fa-credit-card" style="position: absolute; left: 12px; top: 14px; color: var(--text-muted);"></i>
            </div>
        </div>

        <div style="display: flex; gap: 1rem; margin-bottom: 2rem;">
            <div class="form-group" style="flex: 1;">
                <label style="display: block; margin-bottom: 0.5rem;">Expiry (MM/YY)</label>
                <input type="text" required placeholder="12/28" maxlength="5" style="width: 100%; padding: 0.75rem; border-radius: 4px; border: 1px solid var(--border); background: rgba(15, 23, 42, 0.8); color: white;">
            </div>
            <div class="form-group" style="flex: 1;">
                <label style="display: block; margin-bottom: 0.5rem;">CVC</label>
                <input type="password" required placeholder="123" maxlength="3" style="width: 100%; padding: 0.75rem; border-radius: 4px; border: 1px solid var(--border); background: rgba(15, 23, 42, 0.8); color: white;">
            </div>
        </div>

        <button type="submit" class="btn" style="width: 100%; font-size: 1.1rem; padding: 1rem; background: var(--success); color: white;"><i class="fas fa-check-circle"></i> Pay $<?= number_format($amount, 2) ?></button>
        <p style="text-align: center; color: var(--text-muted); font-size: 0.8rem; margin-top: 1rem;">
            <i class="fas fa-shield-alt"></i> Payments are processed via Demo Gateway. No real money gets deducted.
        </p>
    </form>
</div>
