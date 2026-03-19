<div class="glass-card" style="height: 80vh; padding: 0; overflow: hidden; display: flex; flex-direction: column;">
    <div style="padding: 1rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; background: rgba(0,0,0,0.2);">
        <div>
            <h3 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                <span style="width: 10px; height: 10px; border-radius: 50%; background: var(--danger); display: inline-block; animation: pulse 2s infinite;"></span>
                Host Live Class: Batch <?= htmlspecialchars($batch_id) ?>
            </h3>
            <p style="margin: 0; color: var(--text-muted); font-size: 0.85rem; margin-top: 0.2rem;">You are the host (Jitsi Meet API)</p>
        </div>
        <a href="<?= BASE_URL ?>/teacher/dashboard" class="btn btn-danger btn-sm"><i class="fas fa-phone-slash"></i> End Class</a>
    </div>
    
    <div id="jitsi-container" style="flex: 1; width: 100%; background: #000;"></div>
</div>

<style>
@keyframes pulse {
    0% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.2); }
    100% { opacity: 1; transform: scale(1); }
}
</style>

<script src='https://meet.jit.si/external_api.js'></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const domain = 'meet.jit.si';
    const options = {
        roomName: 'NexusTuition_Batch_<?= htmlspecialchars($batch_id) ?>',
        width: '100%',
        height: '100%',
        parentNode: document.querySelector('#jitsi-container'),
        userInfo: {
            displayName: 'Teacher <?= htmlspecialchars($_SESSION['user_name'] ?? 'Teacher') ?>'
        },
        configOverwrite: {
            prejoinPageEnabled: true
        },
        interfaceConfigOverwrite: {
            SHOW_CHROME_EXTENSION_BANNER: false
        }
    };
    const api = new JitsiMeetExternalAPI(domain, options);
    
    // As host, make teacher moderator
    api.executeCommand('subject', 'Live Lecture Session');
});
</script>
