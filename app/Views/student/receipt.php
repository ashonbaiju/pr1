<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #INV-<?= str_pad($fee['id'], 4, '0', STR_PAD_LEFT) ?></title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #fff; color: #333; margin: 0; padding: 2rem; }
        .receipt-card { max-width: 600px; margin: 0 auto; border: 1px solid #ddd; padding: 3rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #eee; padding-bottom: 1.5rem; margin-bottom: 2rem; }
        .logo { font-size: 1.5rem; font-weight: bold; color: #2563eb; margin: 0;}
        .details-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem; }
        .details-grid div h4 { margin: 0; color: #6b7280; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;}
        .details-grid div p { margin: 0.5rem 0 0 0; font-size: 1.1rem; font-weight: 500;}
        table { width: 100%; border-collapse: collapse; margin-bottom: 2rem; }
        th, td { padding: 1rem; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f9fafb; color: #4b5563; font-weight: 600; }
        .total-row td { font-weight: bold; font-size: 1.2rem; }
        .footer { text-align: center; color: #9ca3af; font-size: 0.9rem; margin-top: 3rem; border-top: 1px solid #eee; padding-top: 1.5rem;}
        .status-badge { display: inline-block; padding: 0.25rem 0.75rem; background: #d1fae5; color: #065f46; border-radius: 9999px; font-weight: 600; font-size: 0.85rem;}
        @media print {
            body { padding: 0; background: #fff; }
            .receipt-card { border: none; box-shadow: none; max-width: 100%; padding: 0; }
            .print-btn { display: none; }
        }
    </style>
</head>
<body>
    <div style="text-align: center; margin-bottom: 2rem;" class="print-btn">
        <button onclick="window.print()" style="background: #2563eb; color: #fff; border: none; padding: 0.75rem 1.5rem; border-radius: 4px; font-size: 1rem; cursor: pointer; font-weight: bold;">🖨️ Print / Save as PDF</button>
        <a href="<?= BASE_URL ?>/student/fees" style="margin-left: 1rem; color: #4b5563; text-decoration: none;">&larr; Back to Portal</a>
    </div>

    <div class="receipt-card">
        <div class="header">
            <div>
                <h1 class="logo">Nexus Tuition</h1>
                <p style="color: #6b7280; margin-top: 0.5rem;">Official Payment Receipt</p>
            </div>
            <div style="text-align: right;">
                <h3 style="margin: 0; font-size: 1.2rem; color: #374151;">#INV-<?= str_pad($fee['id'], 4, '0', STR_PAD_LEFT) ?></h3>
                <span class="status-badge" style="margin-top: 0.5rem;">PAID IN FULL</span>
            </div>
        </div>

        <div class="details-grid">
            <div>
                <h4>Billed To</h4>
                <p><?= htmlspecialchars($student) ?></p>
            </div>
            <div>
                <h4>Payment Date</h4>
                <!-- Mocking the payment date to current date since it just got paid -->
                <p><?= date('F j, Y') ?></p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th style="text-align: right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Tuition Fee (<?= htmlspecialchars($fee['due_date']) ?>)</td>
                    <td style="text-align: right;">$<?= number_format($fee['amount'], 2) ?></td>
                </tr>
                <tr class="total-row">
                    <td style="text-align: right;">Total Paid:</td>
                    <td style="text-align: right;">$<?= number_format($fee['amount'], 2) ?></td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p>Thank you for your payment. This is a computer-generated document and requires no signature.</p>
            <p>Nexus Tuition Center &copy; <?= date('Y') ?></p>
        </div>
    </div>
</body>
</html>
