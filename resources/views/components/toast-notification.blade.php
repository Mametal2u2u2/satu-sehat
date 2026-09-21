<div x-data="{
        notifications: [],
        add(type, message, title = '') {
            const id = Date.now() + Math.random().toString(36).substring(2, 7);
            if (!title) {
                title = type === 'success' ? 'Berhasil' : (type === 'error' ? 'Gagal' : 'Informasi');
            }
            this.notifications.push({ id, type, message, title });
            setTimeout(() => this.remove(id), 5000);
        },
        remove(id) {
            this.notifications = this.notifications.filter(n => n.id !== id);
        }
    }"
    @notify.window="add($event.detail.type || 'info', $event.detail.message, $event.detail.title)"
    class="fixed top-5 right-5 z-50 flex flex-col gap-3 max-w-sm w-full pointer-events-none"
    style="display: none;"
    x-show="notifications.length > 0">

    <template x-for="item in notifications" :key="item.id">
        <div x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-2 scale-95"
             class="pointer-events-auto w-full bg-white rounded-2xl shadow-xl border p-4 flex items-start gap-3 relative overflow-hidden"
             :class="{
                 'border-emerald-200 bg-emerald-50/40': item.type === 'success',
                 'border-red-200 bg-red-50/40': item.type === 'error',
                 'border-amber-200 bg-amber-50/40': item.type === 'warning',
                 'border-blue-200 bg-blue-50/40': item.type === 'info'
             }">

            <!-- Accent line indicator -->
            <div class="absolute left-0 top-0 bottom-0 w-1.5"
                 :class="{
                     'bg-emerald-600': item.type === 'success',
                     'bg-red-600': item.type === 'error',
                     'bg-amber-500': item.type === 'warning',
                     'bg-blue-600': item.type === 'info'
                 }"></div>

            <!-- Icon -->
            <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 ml-1"
                 :class="{
                     'bg-emerald-100 text-emerald-700': item.type === 'success',
                     'bg-red-100 text-red-700': item.type === 'error',
                     'bg-amber-100 text-amber-700': item.type === 'warning',
                     'bg-blue-100 text-blue-700': item.type === 'info'
                 }">
                <!-- Success Checkmark -->
                <template x-if="item.type === 'success'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </template>
                <!-- Error X -->
                <template x-if="item.type === 'error'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </template>
                <!-- Warning / Info -->
                <template x-if="item.type === 'warning' || item.type === 'info'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </template>
            </div>

            <!-- Message content -->
            <div class="flex-1 min-w-0 pt-0.5">
                <p class="text-xs font-black"
                   :class="{
                       'text-emerald-950': item.type === 'success',
                       'text-red-950': item.type === 'error',
                       'text-amber-950': item.type === 'warning',
                       'text-blue-950': item.type === 'info'
                   }"
                   x-text="item.title"></p>
                <p class="text-xs font-medium text-slate-600 mt-0.5 leading-relaxed break-words" x-text="item.message"></p>
            </div>

            <!-- Close button -->
            <button @click="remove(item.id)" type="button" class="text-slate-400 hover:text-slate-700 p-1 rounded-lg hover:bg-white/60 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </template>
</div>

<!-- Server-side session & error listener trigger -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('success'))
            window.dispatchEvent(new CustomEvent('notify', {
                detail: { type: 'success', title: 'Berhasil', message: @json(session('success')) }
            }));
        @endif

        @if (session('status'))
            window.dispatchEvent(new CustomEvent('notify', {
                detail: { type: 'info', title: 'Informasi', message: @json(session('status')) }
            }));
        @endif

        @if (session('error'))
            window.dispatchEvent(new CustomEvent('notify', {
                detail: { type: 'error', title: 'Gagal', message: @json(session('error')) }
            }));
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $err)
                window.dispatchEvent(new CustomEvent('notify', {
                    detail: { type: 'error', title: 'Validasi Gagal', message: @json($err) }
                }));
            @endforeach
        @endif
    });
</script>
