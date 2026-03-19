<div class="grid-2">
    <div class="glass-card">
        <div style="margin-bottom: 1.5rem;">
            <h3>Submit a Bug Report or Support Request</h3>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.5rem;">If you are experiencing technical difficulties, issues joining live classes, or missing grades, please fill out the form below.</p>
        </div>
        
        <form action="#" method="POST">
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-size: 0.875rem; color: var(--text-muted);">Issue Type</label>
                <select style="width: 100%; padding: 0.75rem 1rem; background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 0.5rem; color: var(--text-main);">
                    <option>Cannot join Live Class</option>
                    <option>Missing Assignment / Material</option>
                    <option>Fee Payment Issue</option>
                    <option>UI Bug / Error Page</option>
                    <option>Other</option>
                </select>
            </div>
            
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-size: 0.875rem; color: var(--text-muted);">Subject of Issue</label>
                <input type="text" placeholder="Brief description of the problem" style="width: 100%; padding: 0.75rem 1rem; background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 0.5rem; color: var(--text-main);">
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-size: 0.875rem; color: var(--text-muted);">Detailed Description</label>
                <textarea rows="5" placeholder="Please provide as many details as possible..." style="width: 100%; padding: 0.75rem 1rem; background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 0.5rem; color: var(--text-main); font-family: inherit; resize: vertical;"></textarea>
            </div>
            
            <button type="button" class="btn" style="width: 100%;" onclick="alert('Support ticket submitted successfully. An Admin will review it shortly.')">Submit Ticket</button>
        </form>
    </div>

    <div class="glass-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3>My Previous Tickets</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Ticket ID</th>
                    <th>Issue Type</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#TK-8021</td>
                    <td>Cannot join Live Class</td>
                    <td><span style="color: var(--success)">Resolved</span></td>
                    <td>Oct 10, 2026</td>
                </tr>
                <tr>
                    <td>#TK-7955</td>
                    <td>Missing Assignment</td>
                    <td><span style="color: var(--success)">Resolved</span></td>
                    <td>Sep 28, 2026</td>
                </tr>
            </tbody>
        </table>
        
        <div style="margin-top: 2rem; padding: 1.5rem; background: rgba(59, 130, 246, 0.1); border-radius: 0.5rem; border: 1px solid rgba(59, 130, 246, 0.2);">
            <h4 style="color: #60a5fa; margin-bottom: 0.5rem;"><i class="fas fa-info-circle"></i> Support Hours</h4>
            <p style="font-size: 0.9rem; color: var(--text-muted); line-height: 1.5;">Our IT Admin team is active Monday through Friday, 9:00 AM to 5:00 PM. Tickets submitted over the weekend will be handled on Monday.</p>
        </div>
    </div>
</div>
