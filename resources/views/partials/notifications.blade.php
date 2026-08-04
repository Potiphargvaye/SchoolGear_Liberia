<!-- ================================ 
     NOTIFICATION CONTAINER
================================ -->
<div id="notificationContainer"
     class="fixed top-5 right-5 z-[9999] space-y-3">
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    function showNotification(message, type = 'info') {
        const container = document.getElementById('notificationContainer');
        const notif = document.createElement('div');

        // Base Tailwind classes
        notif.className = `
            px-4 py-3 rounded-lg shadow-lg
            text-white font-semibold
            transform transition-all duration-300
            -translate-y-2 opacity-0
            flex items-center gap-2
        `;

        // Type-based styling
        if (type === 'success') {
            notif.classList.add('bg-green-600');
        } else if (type === 'error') {
            notif.classList.add('bg-red-600');
        } else {
            notif.classList.add('bg-blue-600');
        }

        notif.innerHTML = `<span>${message}</span>`;
        container.appendChild(notif);

        // Show animation
        setTimeout(() => {
            notif.classList.remove('-translate-y-2', 'opacity-0');
        }, 100);

        // Hide & remove
        setTimeout(() => {
            notif.classList.add('opacity-0');
            setTimeout(() => notif.remove(), 800);
        }, 8000);
    }

    /* ----------------------------------
       SESSION & VALIDATION ERRORS
    ---------------------------------- */
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            showNotification(@js($error), "error");
        @endforeach
    @endif

    @if (session('login_error'))
        showNotification(@js(session('login_error')), "error");
    @endif

    @if (session('login_success'))
        showNotification(@js(session('login_success')), "success");
    @endif

    @if (session('success'))
        showNotification(@js(session('success')), "success");
    @endif

    @if (session('error'))
        showNotification(@js(session('error')), "error");
    @endif

    /* ----------------------------------
       LIVEWIRE v3 BROWSER EVENTS
    ---------------------------------- */
    window.addEventListener('student-added', e => {
        showNotification(e.detail?.message ?? "Student added successfully!", "success");
    });

    window.addEventListener('student-updated', e => {
        showNotification(e.detail?.message ?? "Student updated successfully!", "success");
    });

    window.addEventListener('student-deleted', e => {
        showNotification(e.detail?.message ?? "Student deleted successfully!", "success");
    });

    window.addEventListener('student-error', e => {
        showNotification(e.detail?.message ?? "Something went wrong.", "error");
    });

    window.addEventListener('notify', e => {
        showNotification(e.detail?.message ?? "Notification", e.detail?.type ?? "info");
    });
});
</script>
