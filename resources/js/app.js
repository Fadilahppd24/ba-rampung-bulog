import Alpine from 'alpinejs';

/**
 * Shared Alpine component for the BA Rampung create/edit forms.
 * Purely a client-side preview — the server always recomputes
 * hari/tahun/rendemen from the submitted data on save.
 */
window.baForm = function (initial) {
    return {
        gabah: initial.gabah || 0,
        beras: initial.beras || 0,
        menir: initial.menir || 0,
        bekatul: initial.bekatul || 0,
        tanggal: initial.tanggal,

        get hariNama() {
            if (!this.tanggal) return '-';

            const hari = [
                'Minggu',
                'Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                "Jum'at",
                'Sabtu'
            ];

            return hari[
                new Date(this.tanggal + 'T00:00:00').getDay()
            ];
        },

        get bulanTahunNama() {
            if (!this.tanggal) return '-';

            const tanggal = new Date(this.tanggal + 'T00:00:00');

            const bulan = [
                'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            ];

            return `${bulan[tanggal.getMonth()]} ${tanggal.getFullYear()}`;
        },

        get tahunNama() {
            return this.tanggal ? this.tanggal.split('-')[0] : '-';
        },

        rendemen(nilai) {
            if (!this.gabah || this.gabah <= 0) return '0.00';

            return ((nilai / this.gabah) * 100).toFixed(2);
        },
    };
};

window.Alpine = Alpine;
Alpine.start();