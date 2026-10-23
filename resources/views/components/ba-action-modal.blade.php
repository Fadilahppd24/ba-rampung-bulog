{{-- Modal bersama untuk BA aktif dan Riwayat Sampah. Tidak ada CDN/dependensi baru. --}}
<style>
.ba-dialog-overlay{position:fixed;inset:0;z-index:99999;display:none;align-items:center;justify-content:center;padding:20px;background:rgba(3,14,29,.65);backdrop-filter:blur(7px);-webkit-backdrop-filter:blur(7px)}
.ba-dialog-overlay.is-open{display:flex;animation:baOverlayIn .18s ease-out}
.ba-dialog{width:min(440px,100%);border-radius:24px;padding:28px;background:#fff;color:#132943;border:1px solid rgba(15,42,74,.12);box-shadow:0 30px 90px rgba(0,0,0,.30);animation:baDialogIn .2s ease-out}
.ba-dialog-icon{display:grid;place-items:center;width:58px;height:58px;border-radius:18px;background:#fff2de;color:#d97706;border:1px solid rgba(242,140,40,.28);margin-bottom:17px}
.ba-dialog[data-kind="danger"] .ba-dialog-icon,.ba-dialog[data-kind="error"] .ba-dialog-icon{background:#fff0f0;color:#dc2626;border-color:rgba(220,38,38,.20)}
.ba-dialog[data-kind="success"] .ba-dialog-icon,.ba-dialog[data-kind="restore"] .ba-dialog-icon{background:#eafaf2;color:#059669;border-color:rgba(5,150,105,.20)}
.ba-dialog-title{font-size:22px;font-weight:800;letter-spacing:-.02em;color:#0B2545;margin:0}
.ba-dialog-desc{font-size:14px;line-height:1.65;color:#64748b;margin-top:9px;overflow-wrap:anywhere}
.ba-dialog-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:26px}
.ba-dialog-btn{min-height:43px;border:1px solid transparent;border-radius:12px;padding:9px 18px;font-size:13px;font-weight:800;cursor:pointer;transition:transform .15s ease,filter .15s ease}
.ba-dialog-btn:hover{transform:translateY(-1px);filter:brightness(1.06)}
.ba-dialog-btn:focus-visible{outline:3px solid #f59e0b;outline-offset:3px}
.ba-dialog-cancel{background:#f1f5f9;color:#475569;border-color:#dbe4ee}
.ba-dialog-accept{color:white;background:linear-gradient(135deg,#e88b21,#d97706)}
.ba-dialog[data-kind="danger"] .ba-dialog-accept{background:linear-gradient(135deg,#ef4444,#b91c1c)}
.ba-dialog[data-kind="restore"] .ba-dialog-accept{background:linear-gradient(135deg,#059669,#047857)}
.ba-dialog[data-kind="error"] .ba-dialog-accept,.ba-dialog[data-kind="success"] .ba-dialog-accept{background:linear-gradient(135deg,#164b8f,#123f7a)}
html.dark-theme .ba-dialog{background:#10263e;color:#e5eef7;border-color:rgba(148,163,184,.23);box-shadow:0 30px 90px rgba(0,0,0,.55)}
html.dark-theme .ba-dialog-title{color:#f8fafc}
html.dark-theme .ba-dialog-desc{color:#b9c9dc}
html.dark-theme .ba-dialog-cancel{background:#203952;color:#e5eef7;border-color:#38526d}
html.dark-theme .ba-dialog-icon{background:#43321d;color:#fbbf24;border-color:#795026}
html.dark-theme .ba-dialog[data-kind="danger"] .ba-dialog-icon,html.dark-theme .ba-dialog[data-kind="error"] .ba-dialog-icon{background:#44272d;color:#fca5a5;border-color:#78404a}
html.dark-theme .ba-dialog[data-kind="success"] .ba-dialog-icon,html.dark-theme .ba-dialog[data-kind="restore"] .ba-dialog-icon{background:#173e37;color:#6ee7b7;border-color:#28675a}
@keyframes baOverlayIn{from{opacity:0}to{opacity:1}}
@keyframes baDialogIn{from{opacity:0;transform:translateY(12px) scale(.97)}to{opacity:1;transform:translateY(0) scale(1)}}
@media(max-width:480px){.ba-dialog{padding:22px}.ba-dialog-actions{flex-direction:column-reverse}.ba-dialog-btn{width:100%}}
@media(prefers-reduced-motion:reduce){.ba-dialog-overlay,.ba-dialog{animation:none}}
</style>
<div id="baActionOverlay" class="ba-dialog-overlay" aria-hidden="true">
    <div id="baActionDialog" class="ba-dialog" data-kind="warning" role="alertdialog" aria-modal="true" aria-labelledby="baDialogTitle" aria-describedby="baDialogDesc" tabindex="-1">
        <div class="ba-dialog-icon" aria-hidden="true">
            <svg id="baDialogSymbol" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3 2 20h20L12 3Z"/><path d="M12 9v5M12 17h.01"/></svg>
        </div>
        <h2 class="ba-dialog-title" id="baDialogTitle">Konfirmasi</h2>
        <p class="ba-dialog-desc" id="baDialogDesc"></p>
        <div class="ba-dialog-actions">
            <button id="baDialogCancel" class="ba-dialog-btn ba-dialog-cancel" type="button">Batal</button>
            <button id="baDialogAccept" class="ba-dialog-btn ba-dialog-accept" type="button">Ya, lanjutkan</button>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.getElementById('baActionOverlay');
    const panel = document.getElementById('baActionDialog');
    const title = document.getElementById('baDialogTitle');
    const desc = document.getElementById('baDialogDesc');
    const accept = document.getElementById('baDialogAccept');
    const cancel = document.getElementById('baDialogCancel');
    if (!overlay || !panel || !title || !desc || !accept || !cancel) return;

    let activeForm = null;
    let previousFocus = null;
    let submitting = false;
    const mark = document.getElementById('baDialogSymbol');
    const icons = {
        warning: '<path d="M12 3 2 20h20L12 3Z"/><path d="M12 9v5M12 17h.01"/>',
        danger: '<path d="M3 6h18M8 6V4h8v2m3 0-1 15H6L5 6m5 4v7m4-7v7"/>',
        restore: '<path d="M3 12a9 9 0 1 0 3-6.7M3 3v6h6"/><path d="m9 12 2 2 4-4"/>',
        success: '<circle cx="12" cy="12" r="9"/><path d="m8 12 3 3 5-6"/>',
        error: '<circle cx="12" cy="12" r="9"/><path d="M12 7v6M12 17h.01"/>'
    };
    function closeDialog() {
        overlay.classList.remove('is-open');
        overlay.setAttribute('aria-hidden', 'true');
        activeForm = null;
        submitting = false;
        accept.disabled = false;
        if (previousFocus?.isConnected) previousFocus.focus();
    }
    function showDialog({kind='warning',heading,message,confirmText='OK',form=null}) {
        previousFocus = document.activeElement;
        activeForm = form;
        panel.dataset.kind = kind;
        mark.innerHTML = icons[kind] || icons.warning;
        title.textContent = heading;
        desc.textContent = message;
        accept.textContent = confirmText;
        cancel.hidden = !form;
        overlay.classList.add('is-open');
        overlay.setAttribute('aria-hidden','false');
        accept.focus();
    }
    const messages = {
        trash: ['Pindahkan BA ke Riwayat Sampah?', 'BA ini akan disembunyikan dari Daftar BA Rampung dan masih bisa dipulihkan.', 'Ya, Pindahkan', 'warning'],
        restore: ['Pulihkan BA Rampung?', 'BA ini akan dikembalikan ke Daftar BA Rampung.', 'Ya, Restore', 'restore'],
        permanent: ['Hapus BA secara permanen?', 'Data BA ini akan dihapus secara permanen dan tidak bisa dipulihkan kembali.', 'Hapus Permanen', 'danger']
    };

    // Delegasi form: aman untuk tabel yang diganti otomatis oleh AJAX polling.
    document.addEventListener('submit', (event) => {
        const form = event.target;
        if (!(form instanceof HTMLFormElement) || !form.matches('[data-ba-confirm]')) return;
        event.preventDefault();
        if (submitting) return;
        const action = form.dataset.baConfirm;
        let config = messages[action];
        if (action === 'bulk') {
            const selected = document.querySelectorAll('input.trash-check:checked');
            if (!selected.length) {
                showDialog({kind:'error', heading:'Belum ada BA dipilih', message:'Centang minimal satu BA Rampung terlebih dahulu.'});
                return;
            }
            const type = form.querySelector('select[name="action"]')?.value;
            if (!['restore','delete'].includes(type)) {
                showDialog({kind:'error', heading:'Pilihan tidak valid', message:'Pilih tindakan Restore atau Hapus Permanen.'});
                return;
            }
            const n = selected.length;
            config = type === 'restore'
                ? ['Pulihkan BA terpilih?', `${n} BA Rampung akan dikembalikan ke daftar aktif.`, 'Ya, Restore', 'restore']
                : ['Hapus permanen BA terpilih?', `${n} BA Rampung akan dihapus secara permanen dan tidak bisa dipulihkan.`, 'Hapus Permanen', 'danger'];
        }
        if (!config) return;
        const label = form.dataset.baLabel || '';
        showDialog({kind:config[3],heading:config[0],message:config[1] + (label ? ` Nomor BA: ${label}.` : ''),confirmText:config[2],form});
    }, true);

    accept.addEventListener('click', () => {
        if (!activeForm) { closeDialog(); return; }
        if (submitting) return;
        submitting = true;
        accept.disabled = true;
        // Native submit mengirim CSRF dan method spoofing tanpa memanggil confirm() lagi.
        HTMLFormElement.prototype.submit.call(activeForm);
    });
    cancel.addEventListener('click', closeDialog);
    overlay.addEventListener('click', event => { if (event.target === overlay && !submitting) closeDialog(); });
    document.addEventListener('keydown', event => {
        if (!overlay.classList.contains('is-open')) return;
        if (event.key === 'Escape' && !submitting) { event.preventDefault(); closeDialog(); }
        if (event.key === 'Tab') {
            const controls = [cancel,accept].filter(el => !el.hidden && !el.disabled);
            if (!controls.length) return;
            const i = controls.indexOf(document.activeElement);
            if (event.shiftKey && i <= 0) { event.preventDefault(); controls.at(-1).focus(); }
            else if (!event.shiftKey && i === controls.length - 1) { event.preventDefault(); controls[0].focus(); }
        }
    });

    @if(session('success'))
        showDialog({kind:'success',heading:'Berhasil!',message:@json(session('success'))});
    @elseif(session('error') || $errors->any())
        showDialog({kind:'error',heading:'Aksi belum berhasil',message:@json(session('error') ?? $errors->first())});
    @endif
});
</script>
