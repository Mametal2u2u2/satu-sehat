@php
    $user = auth()->user();
    $isStaff = $user && $user->hasAnyRole(['Super Admin', 'Admin Klinik', 'Dokter', 'Perawat', 'Fisioterapis', 'Apoteker', 'Approver']);
@endphp

<x-app-layout>
    <div x-data="{ 
        init() {
            const urlParams = new URLSearchParams(window.location.search);
            @if($isStaff)
            if (urlParams.get('modal') === 'tambah' || urlParams.get('modal') === 'tambah-rm') {
                this.showTambahModal = true;
            }
            @endif
            if (urlParams.get('modal') === 'cetak') {
                this.showCetakModal = true;
            }
            if (urlParams.get('tab') === 'resep') {
                this.activeTab = 'resep';
            }
        },
        showTambahModal: false, 
        showCetakModal: false,
        activeTab: 'kunjungan',
        searchQuery: '',
        activePatientId: 'RM-2023-0142',
        printMode: 'all', // 'all' or 'single'
        selectedVisitForPrint: null,
        toast: {
            show: false,
            message: '',
            type: 'success'
        },
        patients: [
            {
                id: 'RM-2023-0142',
                name: 'Budi Santoso',
                nik: '3174091204890001',
                gender: 'Laki-laki',
                age: 34,
                dob: '12 April 1989',
                blood: 'O',
                phone: '0812-3456-7890',
                address: 'Jl. Rasuna Said No. 45, RT 02/RW 05, Jakarta Selatan',
                allergies: 'Penicillin, Seafood',
                insurance: 'BPJS Kesehatan (000123984712)',
                last_visit: 'Hari Ini, 09:15',
                avatar_color: 'from-blue-600 to-indigo-700',
                initials: 'BS',
                demographics: {
                    occupation: 'Pegawai Swasta',
                    marital_status: 'Menikah',
                    emergency_contact: 'Siti Aminah (Istri) - 0813-8899-1122',
                    registered_since: '10 Januari 2021'
                },
                lab_results: [
                    { date: '14 Okt 2023', test_name: 'Darah Lengkap (CBC)', result: 'Hemoglobin: 14.2 g/dL, Leukosit: 9.800 /uL, Trombosit: 250.000 /uL', status: 'Normal', doctor: 'dr. Rina Kusuma' },
                    { date: '14 Okt 2023', test_name: 'Gula Darah Sewaktu (GDS)', result: '110 mg/dL (Normal: < 140 mg/dL)', status: 'Normal', doctor: 'dr. Rina Kusuma' },
                    { date: '02 Ags 2023', test_name: 'Kolesterol Total', result: '185 mg/dL (Normal: < 200 mg/dL)', status: 'Normal', doctor: 'dr. Budi Santoso' }
                ],
                procedures: [
                    { date: '14 Okt 2023', title: 'Pemeriksaan Tanda Vital & Konseling Kesehatan', poli: 'Poli Umum', doctor: 'dr. Rina Kusuma', status: 'Selesai' },
                    { date: '02 Ags 2023', title: 'Penambalan Gigi Komposit (Light Curing)', poli: 'Poli Gigi', doctor: 'drg. Hendra P.', status: 'Selesai' }
                ],
                visits: [
                    {
                        id: 'VIS-2023-098',
                        date: '14 Okt 2023',
                        time: '09:15 WIB',
                        date_display: 'Hari Ini',
                        date_sub: '14 Okt 2023',
                        poli: 'Poli Umum',
                        doctor: 'dr. Rina Kusuma',
                        doctor_sip: 'SIP: 446.1/092/DINKES/2021',
                        status: 'Selesai',
                        status_color: 'green',
                        anamnesa: 'Pasien mengeluh demam sejak 3 hari yang lalu, disertai batuk kering dan sedikit pusing. Nyeri pada persendian dan tenggorokan gatal.',
                        vitals: {
                            bp: '120/80 mmHg',
                            temp: '38.2 °C',
                            hr: '88 x/m',
                            rr: '20 x/m',
                            weight: '68 kg',
                            height: '172 cm'
                        },
                        diagnosis_code: 'J06.9',
                        diagnosis_name: 'Acute upper respiratory infection, unspecified (ISPA)',
                        prescriptions: [
                            { name: 'Paracetamol 500mg', dosage: '3x1 tablet sesudah makan (bila demam)', qty: '10 tab' },
                            { name: 'Ambroxol 30mg', dosage: '3x1 tablet sesudah makan', qty: '10 tab' },
                            { name: 'Vitamin C 500mg', dosage: '1x1 tablet sesudah makan', qty: '10 tab' }
                        ],
                        actions: 'Pemeriksaan Tanda Vital, Edukasi Hidrasi & Istirahat Mandiri',
                        notes: 'Istirahat tirah baring minimal 3 hari, banyak konsumsi air mineral hangat. Bila demam > 39°C atau tidak turun dalam 3 hari, segera kontrol ulang.'
                    },
                    {
                        id: 'VIS-2023-045',
                        date: '02 Ags 2023',
                        time: '14:30 WIB',
                        date_display: '02 Ags',
                        date_sub: '2023',
                        poli: 'Poli Gigi',
                        doctor: 'drg. Hendra P.',
                        doctor_sip: 'SIP: 446.2/115/DINKES/2020',
                        status: 'Selesai',
                        status_color: 'gray',
                        anamnesa: 'Gigi geraham bawah kiri terasa ngilu tajam saat minum minuman dingin dan mengunyah makanan manis sejak 1 minggu terakhir.',
                        vitals: {
                            bp: '118/78 mmHg',
                            temp: '36.5 °C',
                            hr: '76 x/m',
                            rr: '18 x/m',
                            weight: '68 kg',
                            height: '172 cm'
                        },
                        diagnosis_code: 'K02.1',
                        diagnosis_name: 'Caries of dentin (Karies Dentin Gigi 36)',
                        prescriptions: [
                            { name: 'Asam Mefenamat 500mg', dosage: '3x1 kaplet sesudah makan (jika nyeri)', qty: '6 kap' },
                            { name: 'Chlorhexidine Gargle 0.2%', dosage: '2x sehari kumur 1 menit', qty: '1 btl' }
                        ],
                        actions: 'Pembersihan kavitas, etsa, bonding, dan Penambalan Komposit Resin (Light Curing Restoration)',
                        notes: 'Hindari mengunyah makanan terlalu keras pada sisi kiri selama 24 jam. Jaga kebersihan sela gigi.'
                    }
                ]
            },
            {
                id: 'RM-2023-0881',
                name: 'Siti Rahayu',
                nik: '3275015506950003',
                gender: 'Perempuan',
                age: 28,
                dob: '15 Juni 1995',
                blood: 'A',
                phone: '0857-1234-5678',
                address: 'Jl. Cipayung Raya No. 12, Jakarta Timur',
                allergies: 'Sulfonamide',
                insurance: 'Asuransi Mandiri Inhealth',
                last_visit: 'Kemarin, 14:30',
                avatar_color: 'from-pink-600 to-rose-700',
                initials: 'SR',
                demographics: {
                    occupation: 'Tenaga Pengajar / Guru',
                    marital_status: 'Belum Menikah',
                    emergency_contact: 'Bambang Rahayu (Ayah) - 0812-9900-4433',
                    registered_since: '05 Mei 2022'
                },
                lab_results: [
                    { date: '13 Okt 2023', test_name: 'Darah Lengkap & LED', result: 'Hb: 12.8 g/dL, Leukosit: 7.200 /uL, LED: 15 mm/jam', status: 'Normal', doctor: 'dr. Sari Dewi' }
                ],
                procedures: [
                    { date: '13 Okt 2023', title: 'Pemeriksaan Kesehatan Berkala & Skrining Asam Lambung', poli: 'Poli Umum', doctor: 'dr. Sari Dewi', status: 'Selesai' }
                ],
                visits: [
                    {
                        id: 'VIS-2023-095',
                        date: '13 Okt 2023',
                        time: '14:30 WIB',
                        date_display: 'Kemarin',
                        date_sub: '13 Okt 2023',
                        poli: 'Poli Umum',
                        doctor: 'dr. Sari Dewi',
                        doctor_sip: 'SIP: 446.1/088/DINKES/2022',
                        status: 'Selesai',
                        status_color: 'green',
                        anamnesa: 'Nyeri ulu hati terasa perih terbakar (heartburn), mual terutama saat terlambat makan, perut kembung dan sering bersendawa sejak 4 hari.',
                        vitals: {
                            bp: '110/70 mmHg',
                            temp: '36.6 °C',
                            hr: '82 x/m',
                            rr: '18 x/m',
                            weight: '52 kg',
                            height: '160 cm'
                        },
                        diagnosis_code: 'K29.7',
                        diagnosis_name: 'Gastritis, unspecified (Dispepsia / Maag Akut)',
                        prescriptions: [
                            { name: 'Omeprazole 20mg', dosage: '2x1 kapsul 30 menit sebelum makan', qty: '14 kap' },
                            { name: 'Antasida Doen Suspensi', dosage: '3x1 sendok makan 1 jam setelah makan', qty: '1 btl' },
                            { name: 'Domperidone 10mg', dosage: '3x1 tablet sebelum makan (bila mual)', qty: '10 tab' }
                        ],
                        actions: 'Palpasi Abdomen Epigastrium, Edukasi Pola Makan Teratur',
                        notes: 'Hindari makanan pedas, asam, kopi, dan santan. Makan dengan porsi kecil tapi sering (small frequent feeding).'
                    }
                ]
            },
            {
                id: 'RM-2023-1004',
                name: 'Ahmad Fauzi',
                nik: '3175082109780004',
                gender: 'Laki-laki',
                age: 45,
                dob: '21 September 1978',
                blood: 'B',
                phone: '0813-7766-5544',
                address: 'Komp. Polri Ciracas Blok B No. 9, Jakarta Timur',
                allergies: 'Tidak ada alergi yang diketahui',
                insurance: 'BPJS Kesehatan (000287163911)',
                last_visit: '12 Okt 2023',
                avatar_color: 'from-amber-600 to-orange-700',
                initials: 'AF',
                demographics: {
                    occupation: 'PNS',
                    marital_status: 'Menikah',
                    emergency_contact: 'Nurul Hidayah (Istri) - 0812-3344-5566',
                    registered_since: '18 Agustus 2021'
                },
                lab_results: [
                    { date: '12 Okt 2023', test_name: 'Profil Lipid & Glukosa', result: 'GDS: 135 mg/dL, Kolesterol: 240 mg/dL (Tinggi), Asam Urat: 6.8 mg/dL', status: 'Perhatian', doctor: 'dr. Budi Santoso' }
                ],
                procedures: [
                    { date: '12 Okt 2023', title: 'Pemeriksaan EKG & Tensi Berkala Hipertensi', poli: 'Poli Umum', doctor: 'dr. Budi Santoso', status: 'Selesai' }
                ],
                visits: [
                    {
                        id: 'VIS-2023-091',
                        date: '12 Okt 2023',
                        time: '10:00 WIB',
                        date_display: '12 Okt',
                        date_sub: '2023',
                        poli: 'Poli Umum',
                        doctor: 'dr. Budi Santoso',
                        doctor_sip: 'SIP: 446.1/045/DINKES/2019',
                        status: 'Selesai',
                        status_color: 'green',
                        anamnesa: 'Pasien kontrol rutin tensi tinggi dan cek lab kolesterol. Mengeluh tengkuk terasa kaku dan sering tegang jika kurang tidur.',
                        vitals: {
                            bp: '145/95 mmHg',
                            temp: '36.7 °C',
                            hr: '84 x/m',
                            rr: '18 x/m',
                            weight: '78 kg',
                            height: '168 cm'
                        },
                        diagnosis_code: 'I10',
                        diagnosis_name: 'Essential (primary) hypertension & Hypercholesterolemia',
                        prescriptions: [
                            { name: 'Amlodipine 10mg', dosage: '1x1 tablet malam hari', qty: '30 tab' },
                            { name: 'Atorvastatin 20mg', dosage: '1x1 tablet malam hari', qty: '30 tab' }
                        ],
                        actions: 'Pemeriksaan EKG, Evaluasi Faktor Risiko Kardiovaskular',
                        notes: 'Kurangi konsumsi garam dan lemak jenuh. Olahraga jalan cepat 30 menit minimal 3 kali seminggu. Kontrol tensi 1 bulan lagi.'
                    }
                ]
            },
            {
                id: 'RM-2022-0455',
                name: 'Dewi Lestari',
                nik: '3171026408040002',
                gender: 'Perempuan',
                age: 19,
                dob: '24 Agustus 2004',
                blood: 'AB',
                phone: '0896-5544-3322',
                address: 'Jl. Bambu Apus No. 88, Cipayung, Jakarta Timur',
                allergies: 'Aspirin',
                insurance: 'Umum / Pribadi',
                last_visit: '05 Okt 2023',
                avatar_color: 'from-purple-600 to-violet-700',
                initials: 'DL',
                demographics: {
                    occupation: 'Mahasiswi',
                    marital_status: 'Belum Menikah',
                    emergency_contact: 'Sri Lestari (Ibu) - 0812-7788-9900',
                    registered_since: '14 Februari 2022'
                },
                lab_results: [],
                procedures: [
                    { date: '05 Okt 2023', title: 'Nasal Irrigation & Tes Alergi Sederhana', poli: 'Poli THT', doctor: 'dr. Maya Putri', status: 'Selesai' }
                ],
                visits: [
                    {
                        id: 'VIS-2023-080',
                        date: '05 Okt 2023',
                        time: '11:15 WIB',
                        date_display: '05 Okt',
                        date_sub: '2023',
                        poli: 'Poli Umum',
                        doctor: 'dr. Maya Putri',
                        doctor_sip: 'SIP: 446.3/077/DINKES/2021',
                        status: 'Selesai',
                        status_color: 'green',
                        anamnesa: 'Hidung tersumbat bergantian kanan dan kiri terutama di pagi hari berhawa dingin. Bersin-bersin > 5 kali berurutan, mata terasa gatal berair.',
                        vitals: {
                            bp: '115/75 mmHg',
                            temp: '36.4 °C',
                            hr: '78 x/m',
                            rr: '18 x/m',
                            weight: '50 kg',
                            height: '158 cm'
                        },
                        diagnosis_code: 'J30.1',
                        diagnosis_name: 'Allergic rhinitis due to pollen / seasonal (Rhinitis Alergi)',
                        prescriptions: [
                            { name: 'Cetirizine 10mg', dosage: '1x1 tablet malam hari', qty: '10 tab' },
                            { name: 'Oxymetazoline Nasal Spray 0.05%', dosage: '2x semprot sehari maks 3 hari', qty: '1 btl' }
                        ],
                        actions: 'Rinoskopi Anterior, Edukasi Pengendalian Alergen Lingkungan',
                        notes: 'Gunakan masker saat membersihkan kamar, hindari paparan debu, bulu hewan, dan suhu dingin berlebih.'
                    }
                ]
            },
            {
                id: 'RM-2023-1102',
                name: 'Rudi Hermawan',
                nik: '3174051010710005',
                gender: 'Laki-laki',
                age: 52,
                dob: '10 Oktober 1971',
                blood: 'O',
                phone: '0811-9988-7766',
                address: 'Jl. Penganten Ali No. 20, Ciracas, Jakarta Timur',
                allergies: 'Tidak ada',
                insurance: 'BPJS Kesehatan (000341258900)',
                last_visit: '28 Sep 2023',
                avatar_color: 'from-emerald-600 to-teal-700',
                initials: 'RH',
                demographics: {
                    occupation: 'Wiraswasta',
                    marital_status: 'Menikah',
                    emergency_contact: 'Wati Hermawan (Istri) - 0812-4455-6677',
                    registered_since: '28 September 2023'
                },
                lab_results: [
                    { date: '28 Sep 2023', test_name: 'Gula Darah Puasa (GDP) & HbA1c', result: 'GDP: 145 mg/dL, HbA1c: 7.1% (Indikasi DM Tipe 2)', status: 'Tinggi', doctor: 'dr. Rina Kusuma' }
                ],
                procedures: [
                    { date: '28 Sep 2023', title: 'Skrining Kaki Diabetik & Konsultasi Gizi', poli: 'Poli Umum', doctor: 'dr. Rina Kusuma', status: 'Selesai' }
                ],
                visits: [
                    {
                        id: 'VIS-2023-072',
                        date: '28 Sep 2023',
                        time: '08:45 WIB',
                        date_display: '28 Sep',
                        date_sub: '2023',
                        poli: 'Poli Umum',
                        doctor: 'dr. Rina Kusuma',
                        doctor_sip: 'SIP: 446.1/092/DINKES/2021',
                        status: 'Selesai',
                        status_color: 'green',
                        anamnesa: 'Badan terasa lemas cepat lelah, sering buang air kecil di malam hari (> 3x), sering merasa haus dan lapar berlebih.',
                        vitals: {
                            bp: '130/85 mmHg',
                            temp: '36.6 °C',
                            hr: '80 x/m',
                            rr: '18 x/m',
                            weight: '74 kg',
                            height: '165 cm'
                        },
                        diagnosis_code: 'E11.9',
                        diagnosis_name: 'Type 2 diabetes mellitus without complications',
                        prescriptions: [
                            { name: 'Metformin 500mg', dosage: '2x1 tablet bersama/sesudah makan', qty: '60 tab' },
                            { name: 'Vitamin B Kompleks', dosage: '1x1 tablet sesudah makan', qty: '30 tab' }
                        ],
                        actions: 'Pemeriksaan Glukosa Darah, Edukasi 3J (Jadwal, Jumlah, Jenis Makanan)',
                        notes: 'Batasi asupan gula sederhana dan karbohidrat olahan tinggi. Konsultasi lanjutan 2 minggu untuk evaluasi GDP.'
                    }
                ]
            }
        ],
        newRecord: {
            mode: 'existing', // 'existing' or 'new'
            patient_id: 'RM-2023-0142',
            new_name: '',
            new_nik: '',
            new_gender: 'Laki-laki',
            new_age: '',
            new_blood: 'O',
            new_phone: '',
            new_address: '',
            new_allergies: '',
            poli: 'Poli Umum',
            doctor: 'dr. Rina Kusuma',
            doctor_sip: 'SIP: 446.1/092/DINKES/2021',
            date: 'Hari Ini',
            time: '09:30 WIB',
            anamnesa: '',
            allergies: '',
            bp: '120/80',
            temp: '36.5',
            hr: '80',
            rr: '20',
            weight: '65',
            height: '168',
            diagnosis_code: 'J06.9',
            diagnosis_name: 'Acute upper respiratory infection, unspecified',
            actions: '',
            notes: '',
            prescriptions: [
                { name: 'Paracetamol 500mg', dosage: '3x1 tablet sesudah makan', qty: '10 tab' }
            ]
        },
        doctorsList: [
            { name: 'dr. Rina Kusuma', poli: 'Poli Umum', sip: 'SIP: 446.1/092/DINKES/2021' },
            { name: 'dr. Budi Santoso', poli: 'Poli Umum', sip: 'SIP: 446.1/045/DINKES/2019' },
            { name: 'drg. Hendra P.', poli: 'Poli Gigi', sip: 'SIP: 446.2/115/DINKES/2020' },
            { name: 'dr. Sari Dewi', poli: 'Poli Anak', sip: 'SIP: 446.1/088/DINKES/2022' },
            { name: 'dr. Maya Putri', poli: 'Poli Umum', sip: 'SIP: 446.3/077/DINKES/2021' }
        ],
        updateDoctorByPoli() {
            let found = this.doctorsList.find(d => d.poli === this.newRecord.poli);
            if (found) {
                this.newRecord.doctor = found.name;
                this.newRecord.doctor_sip = found.sip;
            }
        },
        updateDoctorSip() {
            let found = this.doctorsList.find(d => d.name === this.newRecord.doctor);
            if (found) {
                this.newRecord.doctor_sip = found.sip;
            }
        },
        addPrescriptionItem() {
            this.newRecord.prescriptions.push({ name: '', dosage: '', qty: '' });
        },
        removePrescriptionItem(index) {
            if (this.newRecord.prescriptions.length > 1) {
                this.newRecord.prescriptions.splice(index, 1);
            }
        },
        get activePatient() {
            return this.patients.find(p => p.id === this.activePatientId) || this.patients[0];
        },
        get filteredPatients() {
            if (!this.searchQuery.trim()) return this.patients;
            let q = this.searchQuery.toLowerCase();
            return this.patients.filter(p => 
                p.name.toLowerCase().includes(q) || 
                p.id.toLowerCase().includes(q) || 
                (p.nik && p.nik.includes(q))
            );
        },
        openTambahModal(preselectedId = null) {
            if (preselectedId) {
                this.newRecord.patient_id = preselectedId;
                this.newRecord.mode = 'existing';
            } else {
                this.newRecord.patient_id = this.activePatientId;
            }
            this.newRecord.anamnesa = '';
            this.newRecord.actions = '';
            this.newRecord.notes = '';
            this.newRecord.diagnosis_code = 'J06.9';
            this.newRecord.diagnosis_name = 'Acute upper respiratory infection, unspecified';
            this.newRecord.prescriptions = [
                { name: 'Paracetamol 500mg', dosage: '3x1 tablet sesudah makan', qty: '10 tab' }
            ];
            this.showTambahModal = true;
        },
        saveRekamMedis() {
            let targetPatient = null;
            let today = new Date();
            let dateStr = today.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
            let timeStr = today.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB';

            if (this.newRecord.mode === 'new') {
                if (!this.newRecord.new_name.trim()) {
                    alert('Silakan masukkan nama pasien baru.');
                    return;
                }
                // Generate new RM
                let newId = 'RM-2023-' + String(Math.floor(1000 + Math.random() * 9000));
                let initials = this.newRecord.new_name.split(' ').map(w => w[0]).slice(0, 2).join('').toUpperCase();
                
                targetPatient = {
                    id: newId,
                    name: this.newRecord.new_name,
                    nik: this.newRecord.new_nik || '317' + Math.floor(1000000000000 + Math.random() * 9000000000000),
                    gender: this.newRecord.new_gender,
                    age: parseInt(this.newRecord.new_age) || 30,
                    dob: '01 Januari 1993',
                    blood: this.newRecord.new_blood,
                    phone: this.newRecord.new_phone || '0812-0000-0000',
                    address: this.newRecord.new_address || 'DKI Jakarta',
                    allergies: this.newRecord.new_allergies || 'Tidak ada',
                    insurance: 'BPJS Kesehatan',
                    last_visit: 'Hari Ini, ' + timeStr.replace(' WIB', ''),
                    avatar_color: 'from-emerald-600 to-teal-700',
                    initials: initials || 'PX',
                    demographics: {
                        occupation: 'Umum',
                        marital_status: 'Belum Menikah',
                        emergency_contact: 'Keluarga Pasien',
                        registered_since: dateStr
                    },
                    lab_results: [],
                    procedures: [],
                    visits: []
                };

                this.patients.unshift(targetPatient);
                this.activePatientId = targetPatient.id;
            } else {
                targetPatient = this.patients.find(p => p.id === this.newRecord.patient_id);
                if (!targetPatient) return;
                targetPatient.last_visit = 'Hari Ini, ' + timeStr.replace(' WIB', '');
                this.activePatientId = targetPatient.id;
            }

            // Filter valid prescriptions
            let validPrescriptions = this.newRecord.prescriptions.filter(p => p.name && p.name.trim() !== '');

            let newVisit = {
                id: 'VIS-' + today.getFullYear() + '-' + String(Math.floor(100 + Math.random() * 900)),
                date: dateStr,
                time: timeStr,
                date_display: 'Hari Ini',
                date_sub: dateStr,
                poli: this.newRecord.poli,
                doctor: this.newRecord.doctor,
                doctor_sip: this.newRecord.doctor_sip,
                status: 'Selesai',
                status_color: 'green',
                anamnesa: this.newRecord.anamnesa || 'Pemeriksaan rutin keluhan umum pasien.',
                vitals: {
                    bp: (this.newRecord.bp || '120/80') + ' mmHg',
                    temp: (this.newRecord.temp || '36.5') + ' °C',
                    hr: (this.newRecord.hr || '80') + ' x/m',
                    rr: (this.newRecord.rr || '20') + ' x/m',
                    weight: (this.newRecord.weight || '65') + ' kg',
                    height: (this.newRecord.height || '168') + ' cm'
                },
                diagnosis_code: this.newRecord.diagnosis_code || 'Z00.0',
                diagnosis_name: this.newRecord.diagnosis_name || 'General medical examination',
                prescriptions: validPrescriptions.length > 0 ? validPrescriptions : [
                    { name: 'Vitamin C 500mg', dosage: '1x1 tablet sesudah makan', qty: '10 tab' }
                ],
                actions: this.newRecord.actions || 'Pemeriksaan Tanda Vital & Konsultasi Medis',
                notes: this.newRecord.notes || 'Jaga pola makan sehat, hidrasi cukup, dan istirahat teratur.'
            };

            targetPatient.visits.unshift(newVisit);

            // Add to procedures if applicable
            if (this.newRecord.actions) {
                targetPatient.procedures.unshift({
                    date: dateStr,
                    title: this.newRecord.actions,
                    poli: this.newRecord.poli,
                    doctor: this.newRecord.doctor,
                    status: 'Selesai'
                });
            }

            this.showTambahModal = false;
            this.showToast('Rekam Medis Pasien ' + targetPatient.name + ' berhasil ditambahkan!');
        },
        openCetak(mode = 'all', visit = null) {
            this.printMode = mode;
            this.selectedVisitForPrint = visit;
            this.showCetakModal = true;
        },
        executePrint() {
            window.print();
        },
        showToast(msg, type = 'success') {
            this.toast.message = msg;
            this.toast.type = type;
            this.toast.show = true;
            setTimeout(() => {
                this.toast.show = false;
            }, 4000);
        }
    }"
    x-on:open-modal.window="if ($event.detail.name === 'tambah-rm' || $event.detail.name === 'tambah') showTambahModal = true; if ($event.detail.name === 'cetak') showCetakModal = true;"        <!-- Toast Notification -->
        <div x-show="toast.show" 
             x-transition:enter="transition ease-out duration-200 transform"
             x-transition:enter-start="opacity-0 translate-y-1 scale-98"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-150 transform"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-1 scale-98"
             class="fixed top-4 right-4 z-50 max-w-sm bg-white border border-slate-200 shadow-lg rounded-lg p-3.5 flex items-center gap-3 text-xs text-slate-800"
             style="display: none;">
            <div class="w-8 h-8 rounded-md bg-teal-50 text-teal-700 flex items-center justify-center shrink-0 border border-teal-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-bold text-slate-900">Notifikasi Sistem</p>
                <p class="text-slate-600 mt-0.5 truncate" x-text="toast.message"></p>
            </div>
            <button @click="toast.show = false" class="text-slate-400 hover:text-slate-600 p-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Top Header & Action Buttons -->
        <div class="mb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-4 border-b border-slate-200 print:hidden">
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-lg font-bold text-slate-900 tracking-tight">
                        @if($isStaff)
                            Rekam Medis Elektronik (RME)
                        @else
                            Riwayat Rekam Medis Pasien
                        @endif
                    </h2>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-teal-50 text-teal-800 border border-teal-200">
                        Klinik Pratama LPSK
                    </span>
                </div>
                <p class="text-slate-500 text-xs mt-0.5">
                    @if($isStaff)
                        Kelola riwayat kesehatan pasien, anamnesa, pemeriksaan fisik, diagnosa ICD-10, dan terapi resep klinik.
                    @else
                        Pantau riwayat kunjungan, hasil pemeriksaan fisik, diagnosa dokter, dan terapi obat Anda secara transparan.
                    @endif
                </p>
            </div>
            <div class="flex items-center gap-2">
                <button @click="openCetak('all', null)" class="px-3 py-1.5 bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-medium rounded-lg shadow-2xs transition-colors flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>Cetak Resume</span>
                </button>
                @if($isStaff)
                <button @click="openTambahModal()" class="px-3.5 py-1.5 bg-teal-700 hover:bg-teal-800 text-white text-xs font-semibold rounded-lg shadow-2xs transition-colors flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    <span>Tambah Rekam Medis</span>
                </button>
                @endif
            </div>
        </div>

        <!-- Main Layout Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-5 print:hidden">
            
            <!-- Sidebar Filter / Patient List -->
            <div class="lg:col-span-1 space-y-3">
                @if($isStaff)
                    <!-- Search Box -->
                    <div class="relative w-full">
                        <input type="text" 
                               x-model="searchQuery" 
                               placeholder="Cari No. RM, NIK, atau Nama..." 
                               class="w-full pl-9 pr-3 py-2 rounded-lg border border-slate-300 text-xs focus:ring-1 focus:ring-teal-700 focus:border-teal-700 bg-white placeholder-slate-400">
                        <svg class="w-4 h-4 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>

                    <!-- Patient Card List -->
                    <div class="bg-white border border-slate-200 rounded-lg shadow-2xs overflow-hidden">
                        <div class="px-3.5 py-2.5 bg-slate-50 border-b border-slate-200 flex justify-between items-center">
                            <span class="font-bold text-slate-700 text-xs uppercase tracking-wider">Daftar Pasien (<span x-text="filteredPatients.length"></span>)</span>
                            <span class="text-[10px] font-mono text-slate-500">RME LPSK</span>
                        </div>
                        <div class="divide-y divide-slate-100 max-h-[560px] overflow-y-auto">
                            <template x-for="p in filteredPatients" :key="p.id">
                                <div @click="activePatientId = p.id" 
                                     class="p-3 cursor-pointer transition-colors flex items-start gap-2.5 select-none"
                                     :class="activePatientId === p.id ? 'bg-teal-50/70 border-l-4 border-teal-700' : 'hover:bg-slate-50 border-l-4 border-transparent'">
                                    <div class="w-8 h-8 rounded bg-slate-100 border border-slate-200 text-slate-700 flex items-center justify-center font-bold text-xs shrink-0"
                                         :class="activePatientId === p.id ? 'bg-teal-700 text-white border-teal-700' : ''">
                                        <span x-text="p.initials"></span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between gap-1">
                                            <div class="font-semibold text-xs text-slate-900 truncate" x-text="p.name"></div>
                                            <span class="text-[10px] font-mono text-slate-500 shrink-0" x-text="p.blood ? 'Gol ' + p.blood : ''"></span>
                                        </div>
                                        <div class="text-[11px] font-mono text-teal-800 font-medium" x-text="p.id"></div>
                                        <div class="text-[10px] text-slate-400 mt-0.5 truncate flex items-center gap-1">
                                            <svg class="w-3 h-3 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span x-text="p.last_visit"></span>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <div x-show="filteredPatients.length === 0" class="p-6 text-center text-slate-400 text-xs">
                                Tidak ada data pasien yang cocok.
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Patient Profile Overview Card -->
                    <div class="bg-white border border-slate-200 rounded-lg p-4 shadow-2xs space-y-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-10 h-10 rounded-lg bg-teal-700 text-white flex items-center justify-center font-bold text-xs shrink-0" x-text="activePatient.initials"></div>
                            <div class="min-w-0 flex-1">
                                <h3 class="font-bold text-xs text-slate-900 truncate" x-text="activePatient.name"></h3>
                                <p class="text-[11px] font-mono text-teal-800 font-semibold" x-text="activePatient.id"></p>
                            </div>
                        </div>

                        <div class="pt-2.5 border-t border-slate-100 space-y-1.5 text-xs">
                            <div class="flex justify-between">
                                <span class="text-slate-500">Penjamin:</span>
                                <span class="font-semibold text-slate-800" x-text="activePatient.insurance"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Gol. Darah:</span>
                                <span class="font-semibold text-slate-800" x-text="activePatient.blood || '-'"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Riwayat Alergi:</span>
                                <span class="font-semibold text-rose-700 truncate max-w-[130px]" x-text="activePatient.allergies"></span>
                            </div>
                        </div>

                        <div class="pt-1">
                            <a href="{{ route('antrian.index', ['modal' => 'daftar']) }}" class="w-full py-2 px-3 bg-teal-700 hover:bg-teal-800 text-white font-medium text-xs rounded-lg flex items-center justify-center gap-1.5 transition-colors shadow-2xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>Daftar Kunjungan Baru</span>
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Main Detail Area -->
            <div class="lg:col-span-3">
                <div class="bg-white border border-slate-200 rounded-lg shadow-2xs mb-5 overflow-hidden">
                    <!-- Header Card Detail (Active Patient Profile) -->
                    <div class="p-4 sm:p-5 border-b border-slate-200 flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center bg-slate-900 text-white">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-lg bg-teal-800 border border-teal-700 text-white flex items-center justify-center text-lg font-bold shrink-0">
                                <span x-text="activePatient.initials"></span>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h2 class="text-base font-bold tracking-tight text-white" x-text="activePatient.name"></h2>
                                    <span class="bg-slate-800 text-teal-300 text-[10px] font-semibold px-2 py-0.5 rounded border border-slate-700" x-text="activePatient.insurance"></span>
                                </div>
                                <div class="flex flex-wrap items-center gap-2 text-xs text-slate-300 mt-1">
                                    <span class="font-mono bg-slate-800 px-1.5 py-0.5 rounded text-[11px] text-teal-300 border border-slate-700" x-text="activePatient.id"></span>
                                    <span class="text-slate-400">&bull;</span>
                                    <span x-text="activePatient.gender + ', ' + activePatient.age + ' Thn'"></span>
                                    <span class="text-slate-400">&bull;</span>
                                    <span x-text="'Gol: ' + activePatient.blood"></span>
                                    <span x-show="activePatient.allergies && activePatient.allergies !== 'Tidak ada'" class="bg-rose-950 text-rose-300 border border-rose-800 px-2 py-0.5 rounded text-[10px] font-medium" x-text="'Alergi: ' + activePatient.allergies"></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 w-full sm:w-auto justify-end shrink-0">
                            @if($isStaff)
                            <button @click="openTambahModal(activePatient.id)" class="bg-teal-700 hover:bg-teal-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors flex items-center gap-1.5 cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                <span>Rekam Baru</span>
                            </button>
                            @endif
                            <button @click="openCetak('all', null)" class="bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors flex items-center gap-1.5 cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                <span>Cetak Riwayat</span>
                            </button>
                        </div>
                    </div>

                    <!-- Clean Enterprise Tabs -->
                    <div class="border-b border-slate-200 px-4 sm:px-6 bg-slate-50">
                        <nav class="-mb-px flex space-x-6 overflow-x-auto text-xs">
                            <button @click="activeTab = 'kunjungan'" 
                                    :class="activeTab === 'kunjungan' ? 'border-teal-700 text-teal-800 font-bold bg-white' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 font-medium'"
                                    class="whitespace-nowrap py-3 px-3 border-b-2 transition-colors flex items-center gap-1.5 cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                Riwayat Kunjungan (<span x-text="activePatient.visits.length"></span>)
                            </button>
                            <button @click="activeTab = 'resep'" 
                                    :class="activeTab === 'resep' ? 'border-teal-700 text-teal-800 font-bold bg-white' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 font-medium'"
                                    class="whitespace-nowrap py-3 px-3 border-b-2 transition-colors flex items-center gap-1.5 cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                Resep Obat
                            </button>
                            <button @click="activeTab = 'demografi'" 
                                    :class="activeTab === 'demografi' ? 'border-teal-700 text-teal-800 font-bold bg-white' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 font-medium'"
                                    class="whitespace-nowrap py-3 px-3 border-b-2 transition-colors flex items-center gap-1.5 cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Data Demografi
                            </button>
                            <button @click="activeTab = 'lab'" 
                                    :class="activeTab === 'lab' ? 'border-teal-700 text-teal-800 font-bold bg-white' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 font-medium'"
                                    class="whitespace-nowrap py-3 px-3 border-b-2 transition-colors flex items-center gap-1.5 cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                Hasil Lab (<span x-text="activePatient.lab_results ? activePatient.lab_results.length : 0"></span>)
                            </button>
                            <button @click="activeTab = 'tindakan'" 
                                    :class="activeTab === 'tindakan' ? 'border-teal-700 text-teal-800 font-bold bg-white' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 font-medium'"
                                    class="whitespace-nowrap py-3 px-3 border-b-2 transition-colors flex items-center gap-1.5 cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                Tindakan Medis (<span x-text="activePatient.procedures ? activePatient.procedures.length : 0"></span>)
                            </button>
                        </nav>
                    </div>

                    <!-- Content Area -->
                    <div class="p-4 sm:p-5 bg-slate-50/60">
                        
                        <!-- TAB 1: RIWAYAT KUNJUNGAN -->
                        <div x-show="activeTab === 'kunjungan'" class="space-y-4">
                            <template x-for="(visit, idx) in activePatient.visits" :key="visit.id || idx">
                                <div class="relative pl-6 sm:pl-28 py-2 group">
                                    <!-- Date Badge Left Column -->
                                    <div class="hidden sm:block absolute left-0 top-3 text-xs font-bold text-slate-800 w-24 text-right">
                                        <span x-text="visit.date_display"></span>
                                        <br>
                                        <span class="text-[10px] font-mono font-normal text-slate-400" x-text="visit.date_sub || visit.date"></span>
                                    </div>
                                    
                                    <!-- Timeline Dot and Line -->
                                    <div class="absolute left-0 sm:left-24 top-4.5 w-3.5 h-3.5 rounded-full border-2 border-white shadow-xs z-10"
                                         :class="idx === 0 ? 'bg-teal-700 ring-2 ring-teal-200' : 'bg-slate-400'"></div>
                                    <div class="absolute left-1.5 sm:left-[103px] top-8 bottom-[-1rem] w-px bg-slate-200 group-last:hidden"></div>
                                    
                                    <!-- Card Content -->
                                    <div class="bg-white border border-slate-200 shadow-2xs rounded-lg p-4 ml-0 sm:ml-2 hover:border-slate-300 transition-colors">
                                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2 mb-3 pb-2.5 border-b border-slate-100">
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <h4 class="font-bold text-sm text-slate-900" x-text="visit.poli"></h4>
                                                    <span class="text-[10px] font-mono px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200" x-text="visit.id"></span>
                                                </div>
                                                <p class="text-xs text-slate-500 mt-0.5">
                                                    Ditangani oleh <span class="font-semibold text-slate-800" x-text="visit.doctor"></span> &bull; <span class="text-slate-400 font-mono" x-text="visit.time"></span>
                                                </p>
                                            </div>
                                            <div class="flex items-center gap-2 shrink-0">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-teal-50 text-teal-800 border border-teal-200" x-text="visit.status"></span>
                                                <button @click="openCetak('single', visit)" class="p-1 text-slate-400 hover:text-teal-700 hover:bg-slate-50 rounded transition-colors" title="Cetak Lembar Kunjungan">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <div class="space-y-3 text-xs">
                                            <!-- Anamnesa & Vitals Grid -->
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                <div class="bg-slate-50 rounded-lg p-3 border border-slate-200">
                                                    <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                                                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                                                        Anamnesa & Keluhan Utama
                                                    </div>
                                                    <p class="text-slate-800 leading-relaxed text-xs" x-text="visit.anamnesa"></p>
                                                </div>

                                                <div class="bg-slate-50 rounded-lg p-3 border border-slate-200">
                                                    <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                                                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                                        Tanda-tanda Vital (TTV)
                                                    </div>
                                                    <div class="grid grid-cols-3 gap-1.5 text-xs">
                                                        <div class="bg-white p-1.5 rounded border border-slate-200 text-center">
                                                            <span class="text-slate-400 block text-[9px]">TD</span>
                                                            <span class="font-bold text-slate-800 font-mono text-xs" x-text="visit.vitals.bp"></span>
                                                        </div>
                                                        <div class="bg-white p-1.5 rounded border border-slate-200 text-center">
                                                            <span class="text-slate-400 block text-[9px]">Suhu</span>
                                                            <span class="font-bold text-slate-800 font-mono text-xs" x-text="visit.vitals.temp"></span>
                                                        </div>
                                                        <div class="bg-white p-1.5 rounded border border-slate-200 text-center">
                                                            <span class="text-slate-400 block text-[9px]">Nadi</span>
                                                            <span class="font-bold text-slate-800 font-mono text-xs" x-text="visit.vitals.hr"></span>
                                                        </div>
                                                        <div class="bg-white p-1.5 rounded border border-slate-200 text-center">
                                                            <span class="text-slate-400 block text-[9px]">Resp</span>
                                                            <span class="font-bold text-slate-800 font-mono text-xs" x-text="visit.vitals.rr"></span>
                                                        </div>
                                                        <div class="bg-white p-1.5 rounded border border-slate-200 text-center">
                                                            <span class="text-slate-400 block text-[9px]">BB</span>
                                                            <span class="font-bold text-slate-800 font-mono text-xs" x-text="visit.vitals.weight || '-'"></span>
                                                        </div>
                                                        <div class="bg-white p-1.5 rounded border border-slate-200 text-center">
                                                            <span class="text-slate-400 block text-[9px]">TB</span>
                                                            <span class="font-bold text-slate-800 font-mono text-xs" x-text="visit.vitals.height || '-'"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Diagnosis Box -->
                                            <div class="bg-amber-50/60 rounded-lg p-2.5 border border-amber-200">
                                                <div class="text-[10px] font-bold text-amber-800 uppercase tracking-wider mb-0.5 flex items-center gap-1.5">
                                                    <svg class="w-3 h-3 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                    Diagnosa ICD-10
                                                </div>
                                                <p class="text-xs font-semibold text-slate-900">
                                                    <span class="font-mono bg-amber-100 text-amber-900 px-1.5 py-0.5 rounded text-[11px] border border-amber-300" x-text="visit.diagnosis_code"></span>
                                                    <span class="ml-1" x-text="visit.diagnosis_name"></span>
                                                </p>
                                            </div>
                                            
                                            <!-- Prescription & Medication Box -->
                                            <div class="bg-slate-50 rounded-lg p-2.5 border border-slate-200">
                                                <div class="text-[10px] font-bold text-slate-700 uppercase tracking-wider mb-2 flex items-center justify-between">
                                                    <span class="flex items-center gap-1.5">
                                                        <svg class="w-3 h-3 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                                        Resep Obat & Terapi
                                                    </span>
                                                    <span class="text-[10px] text-teal-800 font-mono font-medium bg-teal-50 border border-teal-200 px-2 py-0.5 rounded">R/ Farmasi</span>
                                                </div>
                                                <div class="space-y-1.5">
                                                    <template x-for="(rx, rIdx) in visit.prescriptions" :key="rIdx">
                                                        <div class="flex items-center justify-between bg-white p-2 rounded border border-slate-200 text-xs">
                                                            <div class="flex items-center gap-2">
                                                                <span class="w-4 h-4 rounded bg-slate-100 text-slate-600 font-mono font-bold flex items-center justify-center text-[10px]" x-text="rIdx + 1"></span>
                                                                <div>
                                                                    <span class="font-semibold text-slate-900" x-text="rx.name"></span>
                                                                    <span class="text-slate-500 text-[11px] ml-1.5" x-text="'(' + rx.dosage + ')'"></span>
                                                                </div>
                                                            </div>
                                                            <span class="font-mono text-teal-800 bg-teal-50 border border-teal-200 px-1.5 py-0.5 rounded font-medium text-[11px]" x-text="rx.qty"></span>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>

                                            <!-- Notes & Actions -->
                                            <div x-show="visit.notes || visit.actions" class="text-xs text-slate-600 bg-slate-50 p-2.5 rounded-lg border border-slate-200">
                                                <div x-show="visit.actions" class="mb-0.5">
                                                    <span class="font-bold text-slate-700">Tindakan: </span>
                                                    <span x-text="visit.actions"></span>
                                                </div>
                                                <div x-show="visit.notes">
                                                    <span class="font-bold text-slate-700">Catatan Dokter: </span>
                                                    <span x-text="visit.notes"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <div x-show="activePatient.visits.length === 0" class="text-center py-10 bg-white rounded-lg border border-dashed border-slate-300">
                                <svg class="w-8 h-8 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <p class="text-xs font-semibold text-slate-700">Belum ada riwayat kunjungan.</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">Silakan buat lembar rekam medis pertama untuk pasien ini.</p>
                                @if($isStaff)
                                <button @click="openTambahModal(activePatient.id)" class="mt-3 px-3 py-1.5 bg-teal-700 hover:bg-teal-800 text-white text-xs font-semibold rounded-lg shadow-2xs transition-colors">
                                    Tambah Rekam Medis
                                </button>
                                @endif
                            </div>
                        </div>

                        <!-- TAB 2: DATA DEMOGRAFI -->
                        <div x-show="activeTab === 'demografi'" class="bg-white rounded-lg p-5 border border-slate-200 space-y-4">
                            <h3 class="font-bold text-slate-900 text-sm border-b border-slate-200 pb-2.5">Informasi Demografi & Rekam Pasien</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                                <div class="p-2.5 bg-slate-50 rounded border border-slate-200">
                                    <span class="text-[10px] text-slate-500 font-medium block">Nomor Rekam Medis (No. RM)</span>
                                    <span class="font-bold font-mono text-teal-800 text-sm" x-text="activePatient.id"></span>
                                </div>
                                <div class="p-2.5 bg-slate-50 rounded border border-slate-200">
                                    <span class="text-[10px] text-slate-500 font-medium block">Nomor Induk Kependudukan (NIK)</span>
                                    <span class="font-bold text-slate-800 font-mono text-sm" x-text="activePatient.nik"></span>
                                </div>
                                <div>
                                    <span class="text-[10px] text-slate-500 font-medium block">Nama Lengkap</span>
                                    <span class="font-semibold text-slate-900" x-text="activePatient.name"></span>
                                </div>
                                <div>
                                    <span class="text-[10px] text-slate-500 font-medium block">Jenis Kelamin & Usia</span>
                                    <span class="font-semibold text-slate-900" x-text="activePatient.gender + ', ' + activePatient.age + ' Tahun'"></span>
                                </div>
                                <div>
                                    <span class="text-[10px] text-slate-500 font-medium block">Tanggal Lahir</span>
                                    <span class="font-semibold text-slate-900" x-text="activePatient.dob"></span>
                                </div>
                                <div>
                                    <span class="text-[10px] text-slate-500 font-medium block">Golongan Darah</span>
                                    <span class="font-bold text-rose-700 bg-rose-50 border border-rose-200 px-2 py-0.5 rounded text-[11px]" x-text="activePatient.blood"></span>
                                </div>
                                <div>
                                    <span class="text-[10px] text-slate-500 font-medium block">Nomor Telepon / WhatsApp</span>
                                    <span class="font-semibold text-slate-900" x-text="activePatient.phone"></span>
                                </div>
                                <div>
                                    <span class="text-[10px] text-slate-500 font-medium block">Pekerjaan</span>
                                    <span class="font-semibold text-slate-900" x-text="activePatient.demographics ? activePatient.demographics.occupation : '-'"></span>
                                </div>
                                <div class="md:col-span-2">
                                    <span class="text-[10px] text-slate-500 font-medium block">Alamat Domisili</span>
                                    <span class="font-semibold text-slate-900" x-text="activePatient.address"></span>
                                </div>
                                <div>
                                    <span class="text-[10px] text-slate-500 font-medium block">Kontak Darurat</span>
                                    <span class="font-semibold text-slate-900" x-text="activePatient.demographics ? activePatient.demographics.emergency_contact : '-'"></span>
                                </div>
                                <div>
                                    <span class="text-[10px] text-slate-500 font-medium block">Status Jaminan / Asuransi</span>
                                    <span class="font-semibold text-teal-800" x-text="activePatient.insurance"></span>
                                </div>
                                <div class="md:col-span-2 bg-rose-50 p-3 rounded-lg border border-rose-200">
                                    <span class="text-[10px] text-rose-800 font-bold uppercase tracking-wider block mb-0.5">Riwayat Alergi Obat / Makanan</span>
                                    <span class="font-semibold text-rose-900 text-xs" x-text="activePatient.allergies || 'Tidak ada riwayat alergi yang dilaporkan.'"></span>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 3: HASIL LAB -->
                        <div x-show="activeTab === 'lab'" class="bg-white rounded-lg p-5 border border-slate-200 space-y-4">
                            <div class="flex justify-between items-center border-b border-slate-200 pb-2.5">
                                <h3 class="font-bold text-slate-900 text-sm">Riwayat Pemeriksaan Laboratorium</h3>
                                <span class="text-[11px] text-slate-500 font-mono">Laboratorium Klinik LPSK</span>
                            </div>
                            <div class="space-y-2.5">
                                <template x-for="(lab, lIdx) in activePatient.lab_results" :key="lIdx">
                                    <div class="p-3 rounded-lg border border-slate-200 bg-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-slate-900 text-xs" x-text="lab.test_name"></span>
                                                <span class="text-[10px] font-medium px-2 py-0.5 rounded border"
                                                      :class="lab.status === 'Normal' ? 'bg-teal-50 text-teal-800 border-teal-200' : 'bg-amber-50 text-amber-800 border-amber-200'"
                                                      x-text="lab.status"></span>
                                            </div>
                                            <p class="text-xs font-mono text-slate-700 mt-1" x-text="lab.result"></p>
                                            <p class="text-[10px] text-slate-400 mt-0.5">Dokter Perujuk: <span x-text="lab.doctor"></span> &bull; Tgl: <span x-text="lab.date"></span></p>
                                        </div>
                                        <div class="flex items-center gap-2 shrink-0">
                                            <button @click="alert('Hasil Lab Lengkap: ' + lab.test_name + '\n' + lab.result)" class="px-2.5 py-1 bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-medium rounded shadow-2xs">
                                                Lihat Hasil
                                            </button>
                                        </div>
                                    </div>
                                </template>
                                <div x-show="!activePatient.lab_results || activePatient.lab_results.length === 0" class="text-center py-6 text-slate-400 text-xs">
                                    Belum ada data pemeriksaan lab untuk pasien ini.
                                </div>
                            </div>
                        </div>

                        <!-- TAB 4: TINDAKAN KHUSUS -->
                        <div x-show="activeTab === 'tindakan'" class="bg-white rounded-lg p-5 border border-slate-200 space-y-4">
                            <div class="border-b border-slate-200 pb-2.5">
                                <h3 class="font-bold text-slate-900 text-sm">Riwayat Tindakan & Prosedur Medis</h3>
                            </div>
                            <div class="space-y-2">
                                <template x-for="(proc, pIdx) in activePatient.procedures" :key="pIdx">
                                    <div class="p-3 rounded-lg border border-slate-200 bg-slate-50 flex items-center justify-between">
                                        <div>
                                            <div class="font-bold text-slate-900 text-xs" x-text="proc.title"></div>
                                            <p class="text-[11px] text-slate-500 mt-0.5">
                                                Poli: <span class="font-semibold text-slate-700" x-text="proc.poli"></span> &bull; 
                                                Dokter: <span class="font-semibold text-slate-700" x-text="proc.doctor"></span> &bull; 
                                                Tgl: <span x-text="proc.date"></span>
                                            </p>
                                        </div>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-teal-50 text-teal-800 border border-teal-200" x-text="proc.status"></span>
                                    </div>
                                </template>
                                <div x-show="!activePatient.procedures || activePatient.procedures.length === 0" class="text-center py-6 text-slate-400 text-xs">
                                    Belum ada riwayat tindakan khusus untuk pasien ini.
                                </div>
                            </div>
                        </div>

                        <!-- TAB 5: RESEP / OBAT -->
                        <div x-show="activeTab === 'resep'" class="bg-white rounded-lg p-5 border border-slate-200 space-y-4">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-slate-200 pb-2.5 gap-2">
                                <div>
                                    <h3 class="font-bold text-slate-900 text-sm">Riwayat Resep & Terapi Obat Pasien</h3>
                                    <p class="text-[11px] text-slate-500 mt-0.5">Daftar terapi obat yang diresepkan dokter dan petunjuk pemakaian farmasi.</p>
                                </div>
                                <span class="text-[10px] font-mono font-medium text-teal-800 bg-teal-50 border border-teal-200 px-2 py-0.5 rounded self-start sm:self-auto">
                                    Unit Farmasi LPSK
                                </span>
                            </div>
                            <div class="space-y-3">
                                <template x-for="(v, vIdx) in activePatient.visits" :key="'rx-' + vIdx">
                                    <div x-show="v.prescriptions && v.prescriptions.length > 0" class="p-3.5 rounded-lg border border-slate-200 bg-slate-50 space-y-2.5">
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-2 border-b border-slate-200 gap-1">
                                            <div>
                                                <span class="font-bold text-xs text-slate-900" x-text="v.poli"></span>
                                                <span class="text-[11px] text-slate-500" x-text="' &bull; Tanggal: ' + v.date + ' (' + v.time + ')'"></span>
                                            </div>
                                            <span class="text-[11px] text-slate-700 font-medium" x-text="'Dokter: ' + v.doctor"></span>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                                            <template x-for="(rx, rIdx) in v.prescriptions" :key="rIdx">
                                                <div class="p-2.5 bg-white rounded border border-slate-200 space-y-1">
                                                    <div class="flex items-center justify-between">
                                                        <span class="font-semibold text-xs text-slate-900 truncate" x-text="rx.name"></span>
                                                        <span class="text-[10px] font-mono font-medium px-1.5 py-0.5 bg-teal-50 text-teal-800 border border-teal-200 rounded" x-text="rx.qty"></span>
                                                    </div>
                                                    <p class="text-[11px] text-teal-800 font-medium" x-text="rx.dosage"></p>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        @if($isStaff)
        <!-- ========================================================================= -->
        <!-- MODAL: TAMBAH REKAM MEDIS BARU (Khusus Tenaga Medis / Admin) -->
        <!-- ========================================================================= -->
        <div x-show="showTambahModal" 
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 flex items-center justify-center p-3 sm:p-4 print:hidden"
             style="display: none;">
            
            <div @click.away="showTambahModal = false"
                 class="relative bg-white rounded-lg shadow-xl border border-slate-200 w-full max-w-3xl max-h-[90vh] overflow-y-auto">
                
                <!-- Modal Header -->
                <div class="sticky top-0 z-20 bg-white px-5 py-3.5 border-b border-slate-200 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Tambah Lembar Rekam Medis Pasien</h3>
                        <p class="text-[11px] text-slate-500 mt-0.5">Isi formulir anamnesa, pemeriksaan fisik, diagnosa ICD-10, dan resep obat.</p>
                    </div>
                    <button @click="showTambahModal = false" class="p-1 text-slate-400 hover:text-slate-600 rounded transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Modal Body Form -->
                <form @submit.prevent="saveRekamMedis" class="p-5 space-y-4">
                    
                    <!-- Section 1: Pemilihan Pasien -->
                    <div class="bg-slate-50 p-3.5 rounded-lg border border-slate-200">
                        <div class="flex items-center justify-between mb-2.5">
                            <label class="text-[10px] font-bold text-slate-700 uppercase tracking-wider">Target Pasien</label>
                            <div class="flex items-center gap-4 text-xs">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" value="existing" x-model="newRecord.mode" class="text-teal-700 focus:ring-teal-700">
                                    <span class="ml-1.5 text-slate-700 font-medium">Pasien Terdaftar</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" value="new" x-model="newRecord.mode" class="text-teal-700 focus:ring-teal-700">
                                    <span class="ml-1.5 text-slate-700 font-medium">Pasien Baru</span>
                                </label>
                            </div>
                        </div>

                        <!-- If Existing Patient -->
                        <div x-show="newRecord.mode === 'existing'">
                            <select x-model="newRecord.patient_id" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:ring-1 focus:ring-teal-700 focus:border-teal-700 bg-white">
                                <template x-for="p in patients" :key="p.id">
                                    <option :value="p.id" x-text="p.name + ' (' + p.id + ') - Gol. ' + p.blood + ' - ' + p.gender + ' (' + p.age + ' thn)'"></option>
                                </template>
                            </select>
                        </div>

                        <!-- If New Patient Form -->
                        <div x-show="newRecord.mode === 'new'" class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 pt-2 border-t border-slate-200 mt-2">
                            <div class="sm:col-span-2">
                                <label class="block text-[11px] font-medium text-slate-700 mb-1">Nama Lengkap Pasien *</label>
                                <input type="text" x-model="newRecord.new_name" placeholder="Contoh: Hendra Gunawan" class="w-full rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-teal-700 focus:border-teal-700">
                            </div>
                            <div>
                                <label class="block text-[11px] font-medium text-slate-700 mb-1">NIK (KTP)</label>
                                <input type="text" x-model="newRecord.new_nik" placeholder="16 digit NIK" class="w-full rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-teal-700 focus:border-teal-700">
                            </div>
                            <div>
                                <label class="block text-[11px] font-medium text-slate-700 mb-1">Jenis Kelamin</label>
                                <select x-model="newRecord.new_gender" class="w-full rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-teal-700 focus:border-teal-700 bg-white">
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-medium text-slate-700 mb-1">Usia (Tahun)</label>
                                <input type="number" x-model="newRecord.new_age" placeholder="Contoh: 30" class="w-full rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-teal-700 focus:border-teal-700">
                            </div>
                            <div>
                                <label class="block text-[11px] font-medium text-slate-700 mb-1">Golongan Darah</label>
                                <select x-model="newRecord.new_blood" class="w-full rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-teal-700 focus:border-teal-700 bg-white">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                    <option value="-">-</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Poli & Dokter Pemeriksa -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider mb-1">Poli / Layanan</label>
                            <select x-model="newRecord.poli" @change="updateDoctorByPoli()" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:ring-1 focus:ring-teal-700 focus:border-teal-700 bg-white">
                                <option value="Poli Umum">Poli Umum</option>
                                <option value="Poli Gigi">Poli Gigi</option>
                                <option value="Poli Anak">Poli Anak</option>
                                <option value="Poli THT">Poli THT</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider mb-1">Dokter Pemeriksa</label>
                            <select x-model="newRecord.doctor" @change="updateDoctorSip()" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:ring-1 focus:ring-teal-700 focus:border-teal-700 bg-white">
                                <template x-for="doc in doctorsList" :key="doc.name">
                                    <option :value="doc.name" x-text="doc.name + ' (' + doc.poli + ')'"></option>
                                </template>
                            </select>
                        </div>
                    </div>

                    <!-- Section 3: Anamnesa & Keluhan -->
                    <div>
                        <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider mb-1">Anamnesa & Keluhan Utama Pasien *</label>
                        <textarea x-model="newRecord.anamnesa" rows="3" required placeholder="Jelaskan keluhan utama pasien, durasi gejala, riwayat penyakit..." class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:ring-1 focus:ring-teal-700 focus:border-teal-700"></textarea>
                    </div>

                    <!-- Section 4: Pemeriksaan Fisik & TTV -->
                    <div class="bg-slate-50 p-3.5 rounded-lg border border-slate-200">
                        <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider mb-2">Tanda-tanda Vital (TTV)</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-2">
                            <div>
                                <label class="block text-[10px] text-slate-500 mb-0.5">TD (mmHg)</label>
                                <input type="text" x-model="newRecord.bp" placeholder="120/80" class="w-full rounded border border-slate-300 px-2 py-1 text-xs text-center font-bold">
                            </div>
                            <div>
                                <label class="block text-[10px] text-slate-500 mb-0.5">Suhu (°C)</label>
                                <input type="text" x-model="newRecord.temp" placeholder="36.5" class="w-full rounded border border-slate-300 px-2 py-1 text-xs text-center font-bold">
                            </div>
                            <div>
                                <label class="block text-[10px] text-slate-500 mb-0.5">Nadi (x/mnt)</label>
                                <input type="text" x-model="newRecord.hr" placeholder="80" class="w-full rounded border border-slate-300 px-2 py-1 text-xs text-center font-bold">
                            </div>
                            <div>
                                <label class="block text-[10px] text-slate-500 mb-0.5">Resp (x/mnt)</label>
                                <input type="text" x-model="newRecord.rr" placeholder="20" class="w-full rounded border border-slate-300 px-2 py-1 text-xs text-center font-bold">
                            </div>
                            <div>
                                <label class="block text-[10px] text-slate-500 mb-0.5">BB (kg)</label>
                                <input type="text" x-model="newRecord.weight" placeholder="65" class="w-full rounded border border-slate-300 px-2 py-1 text-xs text-center font-bold">
                            </div>
                            <div>
                                <label class="block text-[10px] text-slate-500 mb-0.5">TB (cm)</label>
                                <input type="text" x-model="newRecord.height" placeholder="168" class="w-full rounded border border-slate-300 px-2 py-1 text-xs text-center font-bold">
                            </div>
                        </div>
                    </div>

                    <!-- Section 5: Diagnosa ICD-10 -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider mb-1">Kode ICD-10</label>
                            <input type="text" x-model="newRecord.diagnosis_code" placeholder="Misal: J06.9" class="w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-mono uppercase focus:ring-1 focus:ring-teal-700 focus:border-teal-700">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Diagnosa Medis *</label>
                            <input type="text" x-model="newRecord.diagnosis_name" required placeholder="Contoh: Acute upper respiratory infection, unspecified" class="w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs focus:ring-1 focus:ring-teal-700 focus:border-teal-700">
                        </div>
                    </div>

                    <!-- Section 6: Resep Obat & Terapi Dinamis -->
                    <div class="bg-slate-50 p-3.5 rounded-lg border border-slate-200">
                        <div class="flex items-center justify-between mb-2.5">
                            <label class="text-[10px] font-bold text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                Resep Obat & Terapi
                            </label>
                            <button type="button" @click="addPrescriptionItem()" class="text-xs font-medium text-teal-800 bg-white hover:bg-slate-50 border border-slate-300 px-2.5 py-1 rounded shadow-2xs transition-colors flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                Tambah Baris Obat
                            </button>
                        </div>
                        <div class="space-y-2">
                            <template x-for="(item, idx) in newRecord.prescriptions" :key="idx">
                                <div class="flex items-center gap-2 bg-white p-2 rounded border border-slate-200">
                                    <span class="w-5 h-5 rounded bg-slate-100 text-slate-600 font-mono font-bold flex items-center justify-center text-[10px] shrink-0" x-text="idx + 1"></span>
                                    <input type="text" x-model="item.name" placeholder="Nama Obat (mis: Paracetamol 500mg)" class="flex-1 rounded border border-slate-300 px-2.5 py-1 text-xs">
                                    <input type="text" x-model="item.dosage" placeholder="Aturan Pakai (mis: 3x1 sesudah makan)" class="flex-1 rounded border border-slate-300 px-2.5 py-1 text-xs">
                                    <input type="text" x-model="item.qty" placeholder="Jumlah (10 tab)" class="w-24 rounded border border-slate-300 px-2 py-1 text-xs text-center font-mono">
                                    <button type="button" @click="removePrescriptionItem(idx)" class="text-slate-400 hover:text-rose-600 p-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Section 7: Tindakan Medis & Catatan Dokter -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider mb-1">Tindakan Medis / Prosedur</label>
                            <input type="text" x-model="newRecord.actions" placeholder="Misal: Pembersihan Luka, Nebulisasi, dsb." class="w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs focus:ring-1 focus:ring-teal-700 focus:border-teal-700">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider mb-1">Instruksi & Edukasi Dokter</label>
                            <input type="text" x-model="newRecord.notes" placeholder="Misal: Kontrol ulang dalam 3 hari bila demam berlanjut" class="w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs focus:ring-1 focus:ring-teal-700 focus:border-teal-700">
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="pt-3 border-t border-slate-200 flex items-center justify-end gap-2">
                        <button type="button" @click="showTambahModal = false" class="px-4 py-2 rounded-lg border border-slate-300 text-xs font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white text-xs font-semibold rounded-lg shadow-2xs transition-colors">
                            Simpan Rekam Medis
                        </button>
                    </div>

                </form>
            </div>
        </div>
        @endif

        <!-- ========================================================================= -->
        <!-- MODAL & DEDICATED PRINT VIEW: CETAK RIWAYAT MEDIS -->
        <!-- ========================================================================= -->
        <div x-show="showCetakModal" 
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/70 flex items-center justify-center p-3 sm:p-4 print:p-0 print:bg-white print:static print:overflow-visible"
             style="display: none;">
            
            <div @click.away="showCetakModal = false"
                 class="relative bg-white rounded-lg shadow-xl border border-slate-200 w-full max-w-4xl max-h-[95vh] overflow-y-auto print:max-h-none print:shadow-none print:border-0 print:rounded-none print:w-full print:max-w-none">
                
                <!-- Action Bar (Hidden when printing) -->
                <div class="sticky top-0 z-20 bg-slate-900 text-white px-5 py-3 flex items-center justify-between print:hidden rounded-t-lg border-b border-slate-800">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded bg-slate-800 text-teal-400 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-xs text-white">Pratinjau Dokumen Rekam Medis</h4>
                            <p class="text-[10px] text-slate-400">Siap dicetak atau diekspor ke PDF resmi klinik LPSK.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button @click="executePrint()" class="px-3 py-1.5 bg-teal-700 hover:bg-teal-600 text-white text-xs font-semibold rounded shadow-2xs flex items-center gap-1.5 cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            <span>Cetak Sekarang (Print / PDF)</span>
                        </button>
                        <button @click="showCetakModal = false" class="p-1.5 text-slate-400 hover:text-white rounded hover:bg-slate-800 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>

                <!-- DOKUMEN CETAK RESMI (A4 PRINTABLE LAYOUT) -->
                <div id="printable-medical-record" class="p-8 sm:p-12 text-gray-900 bg-white space-y-6">
                    
                    <!-- KOP SURAT KLINIK -->
                    <div class="border-b-4 border-double border-gray-900 pb-4 text-center relative">
                        <div class="flex items-center justify-center gap-4 mb-2">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/e/ea/Logo_Garuda_Pancasila_Emas.svg" alt="Garuda" class="w-14 h-14 object-contain">
                            <div>
                                <h1 class="text-xl font-extrabold tracking-wider uppercase text-gray-900 leading-tight">LEMBAGA PERLINDUNGAN SAKSI DAN KORBAN</h1>
                                <h2 class="text-lg font-bold text-emerald-800 tracking-wide">KLINIK PRATAMA SATU SEHAT LPSK</h2>
                                <p class="text-xs text-gray-600 mt-0.5">Jl. Raya Mabes Hankam No. 8, Cipayung, Jakarta Timur, DKI Jakarta 13880</p>
                                <p class="text-[11px] text-gray-500 font-mono">Telp: (021) 2968-1234 &bull; Email: klinik@lpsk.go.id &bull; Izin Operasional: 440/012/KPP/2022</p>
                            </div>
                        </div>
                    </div>

                    <!-- TITLE OF DOCUMENT -->
                    <div class="text-center my-4">
                        <h3 class="text-base font-extrabold uppercase tracking-wider underline underline-offset-4">
                            <span x-show="printMode === 'all'">RINGKASAN REKAM MEDIS RAWAT JALAN (RESUME MEDIS)</span>
                            <span x-show="printMode === 'single'">LEMBAR PEMERIKSAAN RAWAT JALAN</span>
                        </h3>
                        <p class="text-xs text-gray-500 font-mono mt-1">Dokumen Resmi Pelayanan Kesehatan Elektronik (RME)</p>
                    </div>

                    <!-- IDENTITAS PASIEN -->
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-300 text-xs">
                        <div class="font-bold text-gray-900 uppercase tracking-wider border-b border-gray-200 pb-1.5 mb-2.5">
                            Identitas Pasien
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-y-2 gap-x-4">
                            <div>
                                <span class="text-gray-500 block text-[11px]">No. Rekam Medis:</span>
                                <span class="font-bold font-mono text-gray-900 text-sm" x-text="activePatient.id"></span>
                            </div>
                            <div>
                                <span class="text-gray-500 block text-[11px]">Nama Pasien:</span>
                                <span class="font-bold text-gray-900" x-text="activePatient.name"></span>
                            </div>
                            <div>
                                <span class="text-gray-500 block text-[11px]">NIK:</span>
                                <span class="font-mono text-gray-800" x-text="activePatient.nik"></span>
                            </div>
                            <div>
                                <span class="text-gray-500 block text-[11px]">Jenis Kelamin / Usia:</span>
                                <span class="font-semibold text-gray-900" x-text="activePatient.gender + ' / ' + activePatient.age + ' Thn'"></span>
                            </div>
                            <div>
                                <span class="text-gray-500 block text-[11px]">Golongan Darah:</span>
                                <span class="font-bold text-red-700" x-text="activePatient.blood"></span>
                            </div>
                            <div>
                                <span class="text-gray-500 block text-[11px]">Jaminan / Asuransi:</span>
                                <span class="font-semibold text-gray-800" x-text="activePatient.insurance"></span>
                            </div>
                            <div class="sm:col-span-2">
                                <span class="text-gray-500 block text-[11px]">Alamat:</span>
                                <span class="text-gray-800 truncate block" x-text="activePatient.address"></span>
                            </div>
                            <div class="sm:col-span-4 pt-1 border-t border-gray-200">
                                <span class="text-gray-500">Riwayat Alergi: </span>
                                <span class="font-bold text-red-700" x-text="activePatient.allergies || 'Tidak ada'"></span>
                            </div>
                        </div>
                    </div>

                    <!-- TABEL / RINCIAN KUNJUNGAN -->
                    <div class="space-y-6">
                        <template x-for="(v, vIdx) in (printMode === 'single' && selectedVisitForPrint ? [selectedVisitForPrint] : activePatient.visits)" :key="v.id || vIdx">
                            <div class="border border-gray-300 rounded-xl p-4 text-xs space-y-3 bg-white">
                                <div class="flex justify-between items-center bg-gray-100 p-2.5 rounded-lg font-bold border border-gray-200">
                                    <div>
                                        <span class="text-emerald-900 font-extrabold uppercase" x-text="v.poli"></span> &bull; 
                                        <span class="text-gray-800 font-medium" x-text="v.doctor"></span> 
                                        <span class="text-gray-500 font-mono text-[10px]" x-text="'(' + (v.doctor_sip || 'SIP Terlampir') + ')'"></span>
                                    </div>
                                    <div class="text-right text-gray-700 font-mono">
                                        <span x-text="v.date"></span> &bull; <span x-text="v.time"></span>
                                    </div>
                                </div>

                                <!-- Keluhan & TTV -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div class="p-2.5 bg-gray-50 rounded-lg border border-gray-200">
                                        <span class="font-bold text-gray-700 uppercase tracking-wider block text-[10px] mb-1">Anamnesa & Keluhan:</span>
                                        <p class="text-gray-800 text-[11px] leading-relaxed" x-text="v.anamnesa"></p>
                                    </div>
                                    <div class="p-2.5 bg-gray-50 rounded-lg border border-gray-200">
                                        <span class="font-bold text-gray-700 uppercase tracking-wider block text-[10px] mb-1">Tanda-tanda Vital (TTV):</span>
                                        <div class="grid grid-cols-3 gap-1.5 text-[11px]">
                                            <div>TD: <b x-text="v.vitals.bp"></b></div>
                                            <div>Suhu: <b x-text="v.vitals.temp"></b></div>
                                            <div>Nadi: <b x-text="v.vitals.hr"></b></div>
                                            <div>Resp: <b x-text="v.vitals.rr"></b></div>
                                            <div>BB: <b x-text="v.vitals.weight || '-'"></b></div>
                                            <div>TB: <b x-text="v.vitals.height || '-'"></b></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Diagnosa -->
                                <div class="p-2.5 bg-amber-50/50 rounded-lg border border-amber-200 text-xs">
                                    <span class="font-bold text-amber-900 uppercase tracking-wider block text-[10px] mb-0.5">Diagnosa ICD-10:</span>
                                    <span class="font-mono font-bold text-gray-900 bg-amber-100 px-1.5 py-0.5 rounded text-[11px]" x-text="v.diagnosis_code"></span>
                                    <span class="font-semibold text-gray-900 ml-1" x-text="v.diagnosis_name"></span>
                                </div>

                                <!-- Resep Obat -->
                                <div class="p-2.5 bg-emerald-50/40 rounded-lg border border-emerald-200">
                                    <span class="font-bold text-emerald-900 uppercase tracking-wider block text-[10px] mb-1">Terapi & Resep Obat (R/):</span>
                                    <table class="w-full text-left text-[11px] divide-y divide-emerald-200">
                                        <thead>
                                            <tr class="text-gray-500">
                                                <th class="py-1">No</th>
                                                <th class="py-1">Nama Obat</th>
                                                <th class="py-1">Dosis / Aturan Pakai</th>
                                                <th class="py-1 text-right">Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            <template x-for="(rx, rIdx) in v.prescriptions" :key="rIdx">
                                                <tr>
                                                    <td class="py-1 font-bold text-emerald-800" x-text="rIdx + 1 + '.'"></td>
                                                    <td class="py-1 font-semibold text-gray-900" x-text="rx.name"></td>
                                                    <td class="py-1 text-gray-600" x-text="rx.dosage"></td>
                                                    <td class="py-1 text-right font-mono font-bold text-gray-800" x-text="rx.qty"></td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Tindakan & Instruksi -->
                                <div x-show="v.actions || v.notes" class="text-[11px] text-gray-700 bg-gray-50 p-2.5 rounded-lg border border-gray-200">
                                    <div x-show="v.actions"><span class="font-bold">Tindakan:</span> <span x-text="v.actions"></span></div>
                                    <div x-show="v.notes" class="mt-0.5"><span class="font-bold">Instruksi:</span> <span x-text="v.notes"></span></div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- FOOTER & TANDA TANGAN -->
                    <div class="pt-6 border-t border-gray-300 grid grid-cols-2 text-xs">
                        <div>
                            <p class="text-gray-500">Catatan:</p>
                            <ul class="list-disc list-inside text-[11px] text-gray-500 space-y-0.5 mt-1">
                                <li>Dokumen ini sah dan dicetak otomatis dari Sistem e-Klinik LPSK.</li>
                                <li>Kerahasiaan rekam medis dilindungi undang-undang kesehatan.</li>
                            </ul>
                        </div>
                        <div class="text-center">
                            <p class="text-gray-600">Jakarta, <span x-text="new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })"></span></p>
                            <p class="font-bold text-gray-900 mt-1">Dokter Penanggung Jawab Pelayanan,</p>
                            <div class="h-16 flex items-center justify-center">
                                <span class="font-serif italic text-gray-400 text-sm">( Tanda Tangan Elektronik / Valid )</span>
                            </div>
                            <p class="font-bold text-gray-900 underline" x-text="selectedVisitForPrint ? selectedVisitForPrint.doctor : (activePatient.visits[0] ? activePatient.visits[0].doctor : 'dr. Rina Kusuma')"></p>
                            <p class="text-[10px] text-gray-500 font-mono" x-text="selectedVisitForPrint ? selectedVisitForPrint.doctor_sip : (activePatient.visits[0] ? activePatient.visits[0].doctor_sip : 'SIP: 446.1/092/DINKES/2021')"></p>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>

    <!-- Print Specific CSS Style for Zero Layout Distortion -->
    <style>
        @media print {
            body {
                background: white !important;
                color: black !important;
            }
            nav, .btn-primary, .btn-secondary, button {
                display: none !important;
            }
            #printable-medical-record {
                padding: 0 !important;
                margin: 0 !important;
                width: 100% !important;
            }
        }
    </style>
</x-app-layout>
