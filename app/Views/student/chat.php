<div class="glass-card" style="display: flex; flex-direction: column; height: 75vh;">
    <div style="padding-bottom: 1rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 1rem;">
        <div class="stat-icon icon-blue"><i class="fas fa-robot"></i></div>
        <div>
            <h3 style="margin: 0;">Nexus AI Tutor</h3>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.2rem;">Always online to help with your studies.</p>
        </div>
    </div>
    
    <div id="chat-box" style="flex: 1; overflow-y: auto; padding: 1.5rem 0; display: flex; flex-direction: column; gap: 1.5rem;">
        <!-- Initial AI Greeting -->
        <div class="message ai" style="margin-bottom: 1rem; display: flex; align-items: flex-start; gap: 1rem;">
            <div class="avatar" style="width: 40px; height: 40px; border-radius: 50%; background: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: bold;"><i class="fas fa-robot"></i></div>
            <div class="bubble" style="background: rgba(30, 41, 59, 0.8); padding: 1rem; border-radius: 1rem; border-top-left-radius: 0; max-width: 80%; border: 1px solid rgba(255,255,255,0.1);">
                <p style="margin: 0; line-height: 1.5;">Hello <?= htmlspecialchars($_SESSION['user_name'] ?? 'Student') ?>! I am your AI assistant powered by Gemini. Ask me any educational question!</p>
            </div>
        </div>
    </div>
    
    <div style="padding-top: 1rem; border-top: 1px solid var(--border); display: flex; gap: 1rem;">
        <input type="text" id="ai-input" placeholder="Ask your AI tutor a question... (e.g. What is gravity?)" style="flex: 1; padding: 1rem; border-radius: 0.5rem; border: 1px solid var(--border); background: rgba(0,0,0,0.2); color: white;">
        <button id="ai-send" class="btn" style="padding: 0 1.5rem;"><i class="fas fa-paper-plane"></i> Send</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const chatBox = document.getElementById('chat-box');
    const input = document.getElementById('ai-input');
    const sendBtn = document.getElementById('ai-send');

    const sendMessage = async () => {
        const text = input.value.trim();
        if (!text) return;
        
        input.value = '';
        input.disabled = true;
        sendBtn.disabled = true;

        // User message
        const userHtml = `
            <div style="display: flex; justify-content: flex-end; width: 100%;">
                <div style="max-width: 80%; background: var(--primary); color: white; padding: 1rem; border-radius: 1rem 1rem 0 1rem;">
                    ${text}
                </div>
            </div>`;
        chatBox.insertAdjacentHTML('beforeend', userHtml);
        
        // Typing indicator
        const typingId = 'typing-' + Date.now();
        const typingHtml = `
            <div id="${typingId}" style="display: flex; gap: 1rem; max-width: 80%;">
                <div class="avatar" style="background: var(--primary); width: 35px; height: 35px;"><i class="fas fa-robot"></i></div>
                <div style="background: rgba(255,255,255,0.05); padding: 1rem; border-radius: 0 1rem 1rem 1rem; color: var(--text-muted);">
                    <i class="fas fa-ellipsis-h fa-fade"></i> Thinking...
                </div>
            </div>`;
        chatBox.insertAdjacentHTML('beforeend', typingHtml);
        chatBox.scrollTop = chatBox.scrollHeight;

        try {
            const res = await fetch('<?= BASE_URL ?>/api/ai/chat', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ message: text })
            });
            const data = await res.json();
            
            document.getElementById(typingId).remove();
            
            // AI Response
            const aiHtml = `
                <div style="display: flex; gap: 1rem; max-width: 80%;">
                    <div class="avatar" style="background: var(--primary); width: 35px; height: 35px;">AI</div>
                    <div style="background: rgba(79, 70, 229, 0.1); padding: 1rem; border-radius: 0 1rem 1rem 1rem; border: 1px solid rgba(79, 70, 229, 0.2); color: white; line-height: 1.5;">
                        ${data.reply}
                    </div>
                </div>`;
            chatBox.insertAdjacentHTML('beforeend', aiHtml);
        } catch (e) {
            document.getElementById(typingId).innerHTML = '<span style="color: var(--danger)">Connection error. Please try again.</span>';
        }

        chatBox.scrollTop = chatBox.scrollHeight;
        input.disabled = false;
        sendBtn.disabled = false;
        input.focus();
    };

    sendBtn.addEventListener('click', sendMessage);
    input.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendMessage();
    });
});
</script>
