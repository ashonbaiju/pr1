<div class="glass-card" style="height: 80vh; padding: 0; display: flex; overflow: hidden; max-width: 1000px; margin: 0 auto;">
    
    <!-- Sidebar / Peer List -->
    <div style="width: 300px; border-right: 1px solid var(--border); display: flex; flex-direction: column; background: rgba(0,0,0,0.1);">
        <div style="padding: 1.5rem; border-bottom: 1px solid var(--border);">
            <h3 style="margin: 0; font-size: 1.2rem;">Contacts</h3>
            <input type="text" id="searchPeers" placeholder="Search users..." style="width: 100%; margin-top: 1rem; padding: 0.5rem 1rem; border-radius: 4px; border: 1px solid var(--border); background: rgba(15, 23, 42, 0.8); color: white;">
        </div>
        <div id="peerList" style="flex: 1; overflow-y: auto;">
            <!-- Rendered by JS -->
            <div style="padding: 2rem; text-align: center; color: var(--text-muted);"><i class="fas fa-spinner fa-spin"></i> Loading...</div>
        </div>
    </div>

    <!-- Active Chat Area -->
    <div style="flex: 1; display: flex; flex-direction: column; position: relative;" id="chatArea">
        
        <!-- Welcome Screen -->
        <div id="welcomeScreen" style="flex: 1; display: flex; align-items: center; justify-content: center; flex-direction: column; color: var(--text-muted);">
            <i class="fas fa-comments" style="font-size: 4rem; opacity: 0.5; margin-bottom: 1rem;"></i>
            <h3>Select a contact to start messaging</h3>
        </div>

        <!-- Conversation Screen (Hidden by default) -->
        <div id="conversationScreen" style="flex: 1; display: none; flex-direction: column;">
            <div style="padding: 1rem 1.5rem; border-bottom: 1px solid var(--border); background: rgba(0,0,0,0.3); display: flex; align-items: center; gap: 1rem;">
                <div class="avatar" style="background: var(--primary); width: 40px; height: 40px;" id="activeAvatar">U</div>
                <div>
                    <h4 style="margin: 0;" id="activeName">User Name</h4>
                    <span style="font-size: 0.8rem; color: var(--success);"><i class="fas fa-circle" style="font-size: 0.5rem;"></i> Active Now</span>
                </div>
            </div>
            
            <div id="messagesBox" style="flex: 1; overflow-y: auto; padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
                <!-- Messages JS injected here -->
            </div>
            
            <div style="padding: 1.5rem; border-top: 1px solid var(--border); background: rgba(0,0,0,0.2);">
                <form id="chatForm" style="display: flex; gap: 1rem;">
                    <input type="text" id="msgInput" placeholder="Type a message..." required autocomplete="off" style="flex: 1; padding: 0.75rem 1rem; border-radius: 4px; border: 1px solid var(--border); background: rgba(15, 23, 42, 0.8); color: white;">
                    <button type="submit" class="btn"><i class="fas fa-paper-plane"></i> Send</button>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    const baseUrl = '<?= BASE_URL ?>';
    let currentPeerId = null;
    let pollInterval = null;

    document.addEventListener('DOMContentLoaded', () => {
        loadPeers();

        document.getElementById('chatForm').addEventListener('submit', function(e) {
            e.preventDefault();
            sendMessage();
        });
    });

    async function loadPeers() {
        const res = await fetch(`${baseUrl}/api/chat/peers`);
        const peers = await res.json();
        
        const list = document.getElementById('peerList');
        list.innerHTML = '';
        
        peers.forEach(peer => {
            const div = document.createElement('div');
            div.className = 'peer-item';
            div.style.cssText = 'padding: 1rem 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05); cursor: pointer; display: flex; align-items: center; gap: 1rem; transition: background 0.2s;';
            div.innerHTML = `
                <div class="avatar" style="background: ${peer.role === 'teacher' ? 'var(--primary)' : 'var(--danger)'}; width: 35px; height: 35px;">${peer.name.charAt(0)}</div>
                <div>
                    <div style="font-weight: 600;">${peer.name}</div>
                    <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: capitalize;">${peer.role}</div>
                </div>
            `;
            
            div.addEventListener('mouseenter', () => div.style.background = 'rgba(255,255,255,0.05)');
            div.addEventListener('mouseleave', () => {
                if(currentPeerId !== peer.id) div.style.background = 'transparent';
            });
            
            div.addEventListener('click', () => {
                document.querySelectorAll('.peer-item').forEach(el => el.style.background = 'transparent');
                div.style.background = 'rgba(255,255,255,0.1)';
                openChat(peer);
            });
            list.appendChild(div);
        });
    }

    function openChat(peer) {
        currentPeerId = peer.id;
        document.getElementById('welcomeScreen').style.display = 'none';
        document.getElementById('conversationScreen').style.display = 'flex';
        document.getElementById('activeName').innerText = peer.name;
        document.getElementById('activeAvatar').innerText = peer.name.charAt(0);
        document.getElementById('activeAvatar').style.background = peer.role === 'teacher' ? 'var(--primary)' : 'var(--danger)';
        
        loadMessages();
        if (pollInterval) clearInterval(pollInterval);
        pollInterval = setInterval(loadMessages, 3000); // Poll every 3 seconds
    }

    async function loadMessages() {
        if (!currentPeerId) return;
        
        const res = await fetch(`${baseUrl}/api/chat/messages?peer_id=${currentPeerId}`);
        const msgs = await res.json();
        
        const box = document.getElementById('messagesBox');
        
        // Prevent re-rendering if no new messages (simple hack: check count)
        if(box.dataset.count == msgs.length) return;
        box.dataset.count = msgs.length;

        box.innerHTML = '';
        
        if (msgs.length === 0) {
            box.innerHTML = '<div style="text-align: center; color: var(--text-muted); margin-top: 2rem;">Say hello! This is the beginning of your chat history.</div>';
            return;
        }

        msgs.forEach(m => {
            const div = document.createElement('div');
            div.style.maxWidth = '80%';
            div.style.display = 'flex';
            div.style.flexDirection = 'column';
            
            if (m.is_mine) {
                div.style.alignSelf = 'flex-end';
                div.innerHTML = `
                    <div style="background: var(--primary); padding: 0.75rem 1rem; border-radius: 1rem 1rem 0 1rem; color: white;">${m.message}</div>
                    <div style="font-size: 0.7rem; color: var(--text-muted); text-align: right; margin-top: 4px;">${new Date(m.timestamp).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</div>
                `;
            } else {
                div.style.alignSelf = 'flex-start';
                div.innerHTML = `
                    <div style="background: rgba(255,255,255,0.1); padding: 0.75rem 1rem; border-radius: 1rem 1rem 1rem 0; color: white; border: 1px solid var(--border);">${m.message}</div>
                    <div style="font-size: 0.7rem; color: var(--text-muted); margin-top: 4px;">${new Date(m.timestamp).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</div>
                `;
            }
            box.appendChild(div);
        });
        
        box.scrollTop = box.scrollHeight;
    }

    async function sendMessage() {
        const input = document.getElementById('msgInput');
        const text = input.value.trim();
        if(!text || !currentPeerId) return;
        
        input.value = ''; // Clear immediately for UX
        
        await fetch(`${baseUrl}/api/chat/send`, {
            method: 'POST',
            body: JSON.stringify({
                receiver_id: currentPeerId,
                message: text
            }),
            headers: {'Content-Type': 'application/json'}
        });
        
        loadMessages(); // Force immediate reload
    }
</script>
