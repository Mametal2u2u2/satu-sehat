<x-app-layout>
    <div x-data="{ 
        init() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('modal') === 'tambah' || urlParams.get('modal') === 'tambah-rm') {
                this.showTambahModal = true;
            }
            if (urlParams.get('modal') === 'cetak') {
                this.showCetakModal = true;
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
    x-on:open-modal.window="if ($event.detail.name === 'tambah-rm' || $event.detail.name === 'tambah') showTambahModal = true; if ($event.detail.name === 'cetak') showCetakModal = true;"
    >

        <!-- Toast Notification -->
        <div x-show="toast.show" 
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-2 scale-95"
             class="fixed top-5 right-5 z-[9999] max-w-md bg-white border border-emerald-200 shadow-xl rounded-2xl p-4 flex items-center gap-3 text-sm text-gray-800"
             style="display: none;">
            <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div class="flex-1">
                <p class="font-bold text-gray-900">Sukses</p>
                <p class="text-xs text-gray-600 mt-0.5" x-text="toast.message"></p>
            </div>
            <button @click="toast.show = false" class="text-gray-400 hover:text-gray-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Top Header & Action Buttons -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 print:hidden">
            <div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Data Rekam Medis</h2>
                </div>
                <p class="text-gray-500 text-sm mt-1">Kelola riwayat kesehatan pasien, anamnesa, diagnosa ICD-10, dan resep obat klinik.</p>
            </div>
            <div class="flex items-center gap-3">
                <button @click="openCetak('all', null)" class="btn-secondary py-2.5 px-4 text-sm font-semibold flex items-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak Riwayat
                </button>
                <button @click="openTambahModal()" class="btn-primary py-2.5 px-5 text-sm font-semibold shadow-md shadow-emerald-600/20 hover:shadow-lg transition-all">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Tambah Rekam Medis
                </button>
            </div>
        </div>

        <!-- Main Layout Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 print:hidden">
            
            <!-- Sidebar Filter / Patient List -->
            <div class="lg:col-span-1 space-y-4">
                <!-- Search Box -->
                <div class="relative w-full">
                    <input type="text" 
                           x-model="searchQuery" 
                           placeholder="Cari ID Pasien, NIK, atau Nama..." 
                           class="w-full pl-10 pr-4 py-2.5 rounded-2xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 text-sm shadow-sm transition-all bg-white">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>

                <!-- Patient Card List -->
                <div class="card p-0 overflow-hidden bg-white shadow-sm border border-gray-150 rounded-2xl">
                    <div class="p-3.5 border-b border-gray-100 bg-gray-50/70 flex justify-between items-center">
                        <h3 class="font-bold text-gray-900 text-xs uppercase tracking-wider">Daftar Pasien (<span x-text="filteredPatients.length"></span>)</h3>
                        <span class="text-[10px] text-emerald-600 font-semibold bg-emerald-50 px-2 py-0.5 rounded-full">Klinik LPSK</span>
                    </div>
                    <div class="divide-y divide-gray-100 max-h-[580px] overflow-y-auto">
                        <template x-for="p in filteredPatients" :key="p.id">
                            <div @click="activePatientId = p.id" 
                                 class="p-4 cursor-pointer transition-all flex items-start gap-3 select-none"
                                 :class="activePatientId === p.id ? 'bg-emerald-50/60 border-l-4 border-emerald-600 shadow-inner' : 'hover:bg-gray-50 border-l-4 border-transparent'">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr text-white flex items-center justify-center font-bold text-xs shadow-sm flex-shrink-0"
                                     :class="p.avatar_color">
                                    <span x-text="p.initials"></span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <div class="font-bold text-sm text-gray-900 truncate" x-text="p.name"></div>
                                        <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-gray-100 text-gray-600" x-text="p.blood ? 'Gol. ' + p.blood : ''"></span>
                                    </div>
                                    <div class="text-xs font-mono text-emerald-700 font-medium mt-0.5" x-text="p.id"></div>
                                    <div class="text-[11px] text-gray-400 mt-1.5 flex items-center">
                                        <svg class="w-3.5 h-3.5 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span x-text="p.last_visit"></span>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <div x-show="filteredPatients.length === 0" class="p-8 text-center text-gray-400 text-xs">
                            Tidak ada data pasien yang sesuai pencarian.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Detail Area -->
            <div class="lg:col-span-3">
                <div class="card p-0 overflow-hidden mb-6 bg-white shadow-sm border border-gray-150 rounded-3xl">
                    <!-- Header Card Detail (Active Patient Profile) -->
                    <div class="p-6 sm:p-8 border-b border-gray-100 flex flex-col sm:flex-row gap-6 justify-between items-start sm:items-center bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-700 text-white shadow-md relative overflow-hidden">
                        <!-- Background Pattern Deco -->
                        <div class="absolute -right-8 -bottom-8 w-40 h-40 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                        <div class="absolute left-1/2 -top-12 w-32 h-32 bg-emerald-400/20 rounded-full blur-xl pointer-events-none"></div>

                        <div class="flex items-center gap-4 relative z-10">
                            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center text-2xl font-black backdrop-blur-md border border-white/30 shadow-inner">
                                <span x-text="activePatient.initials"></span>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h2 class="text-2xl font-bold tracking-tight" x-text="activePatient.name"></h2>
                                    <span class="bg-white/20 text-white text-[11px] font-bold px-2 py-0.5 rounded-full border border-white/30" x-text="activePatient.insurance"></span>
                                </div>
                                <div class="flex flex-wrap items-center gap-3 text-xs text-emerald-100 mt-1.5">
                                    <span class="font-mono bg-black/25 px-2 py-0.5 rounded font-semibold tracking-wide text-white" x-text="activePatient.id"></span>
                                    <span x-text="activePatient.gender + ', ' + activePatient.age + ' Tahun'"></span>
                                    <span class="bg-white/15 px-2 py-0.5 rounded" x-text="'Gol. Darah: ' + activePatient.blood"></span>
                                    <span x-show="activePatient.allergies && activePatient.allergies !== 'Tidak ada'" class="bg-red-500/80 text-white px-2 py-0.5 rounded font-medium text-[11px]" x-text="'Alergi: ' + activePatient.allergies"></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 relative z-10 w-full sm:w-auto justify-end">
                            <button @click="openTambahModal(activePatient.id)" class="bg-white text-emerald-700 hover:bg-emerald-50 transition-all px-4 py-2 rounded-xl text-xs font-bold shadow-md flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                Rekam Medis Baru
                            </button>
                            <button @click="openCetak('all', null)" class="bg-white/20 hover:bg-white/30 transition-colors backdrop-blur-md px-3.5 py-2 rounded-xl text-xs font-semibold flex items-center gap-1.5 border border-white/30 text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                Cetak Resume
                            </button>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div class="border-b border-gray-100 px-6 sm:px-8 bg-white">
                        <nav class="-mb-px flex space-x-6 overflow-x-auto text-sm">
                            <button @click="activeTab = 'kunjungan'" 
                                    :class="activeTab === 'kunjungan' ? 'border-emerald-600 text-emerald-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium'"
                                    class="whitespace-nowrap py-3.5 px-1 border-b-2 transition-all flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                Riwayat Kunjungan (<span x-text="activePatient.visits.length"></span>)
                            </button>
                            <button @click="activeTab = 'demografi'" 
                                    :class="activeTab === 'demografi' ? 'border-emerald-600 text-emerald-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium'"
                                    class="whitespace-nowrap py-3.5 px-1 border-b-2 transition-all flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Data Demografi
                            </button>
                            <button @click="activeTab = 'lab'" 
                                    :class="activeTab === 'lab' ? 'border-emerald-600 text-emerald-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium'"
                                    class="whitespace-nowrap py-3.5 px-1 border-b-2 transition-all flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                Hasil Lab (<span x-text="activePatient.lab_results ? activePatient.lab_results.length : 0"></span>)
                            </button>
                            <button @click="activeTab = 'tindakan'" 
                                    :class="activeTab === 'tindakan' ? 'border-emerald-600 text-emerald-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium'"
                                    class="whitespace-nowrap py-3.5 px-1 border-b-2 transition-all flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                Tindakan Khusus (<span x-text="activePatient.procedures ? activePatient.procedures.length : 0"></span>)
                            </button>
                        </nav>
                    </div>

                    <!-- Content Area -->
                    <div class="p-6 sm:p-8 bg-gray-50/40">
                        
                        <!-- TAB 1: RIWAYAT KUNJUNGAN -->
                        <div x-show="activeTab === 'kunjungan'" class="space-y-6">
                            <template x-for="(visit, idx) in activePatient.visits" :key="visit.id || idx">
                                <div class="relative pl-8 sm:pl-32 py-4 group">
                                    <!-- Date Badge Left Column -->
                                    <div class="hidden sm:block absolute left-0 top-4 text-sm font-bold text-gray-900 w-24 text-right">
                                        <span x-text="visit.date_display"></span>
                                        <br>
                                        <span class="text-xs font-normal text-gray-500" x-text="visit.date_sub || visit.date"></span>
                                    </div>
                                    
                                    <!-- Timeline Dot and Line -->
                                    <div class="absolute left-0 sm:left-28 top-6 w-4 h-4 rounded-full border-4 border-white shadow-sm z-10"
                                         :class="idx === 0 ? 'bg-emerald-600 ring-4 ring-emerald-100' : 'bg-gray-400'"></div>
                                    <div class="absolute left-2 sm:left-[119px] top-10 bottom-[-1.5rem] w-0.5 bg-gray-200 group-last:hidden"></div>
                                    
                                    <!-- Card Content -->
                                    <div class="card p-5 sm:p-6 bg-white border border-gray-150 shadow-sm rounded-2xl ml-0 sm:ml-4 hover:shadow-md transition-all">
                                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2 mb-4 pb-3 border-b border-gray-100">
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <h4 class="font-bold text-lg text-gray-900" x-text="visit.poli"></h4>
                                                    <span class="text-xs font-mono px-2 py-0.5 rounded bg-gray-100 text-gray-600" x-text="visit.id"></span>
                                                </div>
                                                <p class="text-xs text-gray-500 mt-0.5">
                                                    Ditangani oleh <span class="font-semibold text-gray-800" x-text="visit.doctor"></span> &bull; <span class="text-gray-400" x-text="visit.time"></span>
                                                </p>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="badge badge-green" x-text="visit.status"></span>
                                                <button @click="openCetak('single', visit)" class="p-1.5 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors title='Cetak Lembar Kunjungan'">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <div class="space-y-4 text-sm">
                                            <!-- Anamnesa & Vitals Grid -->
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div class="bg-gray-50/80 rounded-xl p-3.5 border border-gray-100">
                                                    <div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                                                        Anamnesa & Keluhan Utama
                                                    </div>
                                                    <p class="text-gray-800 leading-relaxed text-xs sm:text-sm" x-text="visit.anamnesa"></p>
                                                </div>

                                                <div class="bg-gray-50/80 rounded-xl p-3.5 border border-gray-100">
                                                    <div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                                        Tanda-tanda Vital (TTV)
                                                    </div>
                                                    <div class="grid grid-cols-3 gap-2 text-xs">
                                                        <div class="bg-white p-2 rounded-lg border border-gray-100">
                                                            <span class="text-gray-400 block text-[10px]">Tekanan Darah</span>
                                                            <span class="font-bold text-gray-800" x-text="visit.vitals.bp"></span>
                                                        </div>
                                                        <div class="bg-white p-2 rounded-lg border border-gray-100">
                                                            <span class="text-gray-400 block text-[10px]">Suhu Tubuh</span>
                                                            <span class="font-bold text-gray-800" x-text="visit.vitals.temp"></span>
                                                        </div>
                                                        <div class="bg-white p-2 rounded-lg border border-gray-100">
                                                            <span class="text-gray-400 block text-[10px]">Denyut Nadi</span>
                                                            <span class="font-bold text-gray-800" x-text="visit.vitals.hr"></span>
                                                        </div>
                                                        <div class="bg-white p-2 rounded-lg border border-gray-100">
                                                            <span class="text-gray-400 block text-[10px]">Respirasi</span>
                                                            <span class="font-bold text-gray-800" x-text="visit.vitals.rr"></span>
                                                        </div>
                                                        <div class="bg-white p-2 rounded-lg border border-gray-100">
                                                            <span class="text-gray-400 block text-[10px]">Berat Badan</span>
                                                            <span class="font-bold text-gray-800" x-text="visit.vitals.weight || '-'"></span>
                                                        </div>
                                                        <div class="bg-white p-2 rounded-lg border border-gray-100">
                                                            <span class="text-gray-400 block text-[10px]">Tinggi Badan</span>
                                                            <span class="font-bold text-gray-800" x-text="visit.vitals.height || '-'"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Diagnosis Box -->
                                            <div class="bg-amber-50/60 rounded-xl p-3.5 border border-amber-200/70">
                                                <div class="text-xs font-bold text-amber-800 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                                                    <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                    Diagnosa ICD-10
                                                </div>
                                                <p class="text-sm font-semibold text-gray-900">
                                                    <span class="font-mono bg-amber-200/70 text-amber-900 px-2 py-0.5 rounded mr-1.5 text-xs" x-text="visit.diagnosis_code"></span>
                                                    <span x-text="visit.diagnosis_name"></span>
                                                </p>
                                            </div>
                                            
                                            <!-- Prescription & Medication Box -->
                                            <div class="bg-emerald-50/50 rounded-xl p-3.5 border border-emerald-200/70">
                                                <div class="text-xs font-bold text-emerald-800 uppercase tracking-wider mb-2 flex items-center justify-between">
                                                    <span class="flex items-center gap-1.5">
                                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                                        Resep Obat & Terapi
                                                    </span>
                                                    <span class="text-[10px] text-emerald-700 font-semibold bg-emerald-100/60 px-2 py-0.5 rounded">R/ Farmasi</span>
                                                </div>
                                                <div class="space-y-1.5">
                                                    <template x-for="(rx, rIdx) in visit.prescriptions" :key="rIdx">
                                                        <div class="flex items-start justify-between bg-white p-2.5 rounded-lg border border-emerald-100 text-xs">
                                                            <div class="flex items-center gap-2">
                                                                <span class="w-5 h-5 rounded bg-emerald-100 text-emerald-700 font-bold flex items-center justify-center text-[10px]" x-text="rIdx + 1"></span>
                                                                <div>
                                                                    <div class="font-bold text-gray-900" x-text="rx.name"></div>
                                                                    <div class="text-gray-500 text-[11px]" x-text="rx.dosage"></div>
                                                                </div>
                                                            </div>
                                                            <span class="font-mono text-emerald-800 bg-emerald-50 px-2 py-1 rounded font-semibold text-[11px]" x-text="rx.qty"></span>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>

                                            <!-- Notes & Actions -->
                                            <div x-show="visit.notes || visit.actions" class="text-xs text-gray-600 bg-gray-50 p-3 rounded-xl border border-gray-100">
                                                <div x-show="visit.actions" class="mb-1">
                                                    <span class="font-bold text-gray-700">Tindakan Medis: </span>
                                                    <span x-text="visit.actions"></span>
                                                </div>
                                                <div x-show="visit.notes">
                                                    <span class="font-bold text-gray-700">Instruksi & Catatan Dokter: </span>
                                                    <span x-text="visit.notes"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <div x-show="activePatient.visits.length === 0" class="text-center py-12 bg-white rounded-2xl border border-dashed border-gray-200">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <p class="text-sm font-semibold text-gray-700">Belum ada riwayat kunjungan.</p>
                                <p class="text-xs text-gray-400 mt-1">Klik tombol di bawah untuk menambahkan rekam medis pertama pasien ini.</p>
                                <button @click="openTambahModal(activePatient.id)" class="btn-primary mt-4 py-2 px-4 text-xs">
                                    Tambah Rekam Medis
                                </button>
                            </div>
                        </div>

                        <!-- TAB 2: DATA DEMOGRAFI -->
                        <div x-show="activeTab === 'demografi'" class="bg-white rounded-2xl p-6 border border-gray-150 shadow-sm space-y-6">
                            <h3 class="font-bold text-gray-900 text-base border-b border-gray-100 pb-3">Informasi Demografi & Rekam Pasien</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                                <div>
                                    <span class="text-xs text-gray-400 font-medium block">Nomor Rekam Medis (No. RM)</span>
                                    <span class="font-bold font-mono text-emerald-700 text-base" x-text="activePatient.id"></span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-400 font-medium block">Nomor Induk Kependudukan (NIK)</span>
                                    <span class="font-bold text-gray-800 font-mono" x-text="activePatient.nik"></span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-400 font-medium block">Nama Lengkap</span>
                                    <span class="font-semibold text-gray-800" x-text="activePatient.name"></span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-400 font-medium block">Jenis Kelamin & Usia</span>
                                    <span class="font-semibold text-gray-800" x-text="activePatient.gender + ', ' + activePatient.age + ' Tahun'"></span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-400 font-medium block">Tanggal Lahir</span>
                                    <span class="font-semibold text-gray-800" x-text="activePatient.dob"></span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-400 font-medium block">Golongan Darah</span>
                                    <span class="font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded" x-text="activePatient.blood"></span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-400 font-medium block">Nomor Telepon / WhatsApp</span>
                                    <span class="font-semibold text-gray-800" x-text="activePatient.phone"></span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-400 font-medium block">Pekerjaan</span>
                                    <span class="font-semibold text-gray-800" x-text="activePatient.demographics ? activePatient.demographics.occupation : '-'"></span>
                                </div>
                                <div class="md:col-span-2">
                                    <span class="text-xs text-gray-400 font-medium block">Alamat Domisili</span>
                                    <span class="font-semibold text-gray-800" x-text="activePatient.address"></span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-400 font-medium block">Kontak Darurat</span>
                                    <span class="font-semibold text-gray-800" x-text="activePatient.demographics ? activePatient.demographics.emergency_contact : '-'"></span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-400 font-medium block">Status Jaminan / Asuransi</span>
                                    <span class="font-semibold text-emerald-700" x-text="activePatient.insurance"></span>
                                </div>
                                <div class="md:col-span-2 bg-red-50 p-4 rounded-xl border border-red-100">
                                    <span class="text-xs text-red-700 font-bold uppercase tracking-wider block mb-1">Riwayat Alergi Obat / Makanan</span>
                                    <span class="font-semibold text-red-900" x-text="activePatient.allergies || 'Tidak ada riwayat alergi yang dilaporkan.'"></span>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 3: HASIL LAB -->
                        <div x-show="activeTab === 'lab'" class="space-y-4">
                            <div class="bg-white rounded-2xl p-6 border border-gray-150 shadow-sm">
                                <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-100">
                                    <h3 class="font-bold text-gray-900 text-base">Riwayat Pemeriksaan Laboratorium</h3>
                                    <span class="text-xs text-gray-500">Laboratorium Klinik Pratama Satu Sehat LPSK</span>
                                </div>
                                <div class="space-y-3">
                                    <template x-for="(lab, lIdx) in activePatient.lab_results" :key="lIdx">
                                        <div class="p-4 rounded-xl border border-gray-150 bg-gray-50/60 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <span class="font-bold text-gray-900 text-sm" x-text="lab.test_name"></span>
                                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full"
                                                          :class="lab.status === 'Normal' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-800'"
                                                          x-text="lab.status"></span>
                                                </div>
                                                <p class="text-xs font-mono text-gray-700 mt-1" x-text="lab.result"></p>
                                                <p class="text-[11px] text-gray-400 mt-1">Dokter Perujuk: <span x-text="lab.doctor"></span> &bull; Tanggal: <span x-text="lab.date"></span></p>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <button @click="alert('Hasil Lab Lengkap: ' + lab.test_name + '\n' + lab.result)" class="btn-secondary py-1.5 px-3 text-xs">
                                                    Lihat Hasil
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                    <div x-show="!activePatient.lab_results || activePatient.lab_results.length === 0" class="text-center py-8 text-gray-400 text-xs">
                                        Belum ada data pemeriksaan lab untuk pasien ini.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 4: TINDAKAN KHUSUS -->
                        <div x-show="activeTab === 'tindakan'" class="space-y-4">
                            <div class="bg-white rounded-2xl p-6 border border-gray-150 shadow-sm">
                                <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-100">
                                    <h3 class="font-bold text-gray-900 text-base">Riwayat Tindakan & Prosedur Medis</h3>
                                </div>
                                <div class="space-y-3">
                                    <template x-for="(proc, pIdx) in activePatient.procedures" :key="pIdx">
                                        <div class="p-4 rounded-xl border border-gray-150 bg-gray-50/60 flex items-center justify-between">
                                            <div>
                                                <div class="font-bold text-gray-900 text-sm" x-text="proc.title"></div>
                                                <p class="text-xs text-gray-500 mt-0.5">
                                                    Poli: <span class="font-semibold text-gray-700" x-text="proc.poli"></span> &bull; 
                                                    Dokter: <span class="font-semibold text-gray-700" x-text="proc.doctor"></span> &bull; 
                                                    Tgl: <span x-text="proc.date"></span>
                                                </p>
                                            </div>
                                            <span class="badge badge-green text-xs" x-text="proc.status"></span>
                                        </div>
                                    </template>
                                    <div x-show="!activePatient.procedures || activePatient.procedures.length === 0" class="text-center py-8 text-gray-400 text-xs">
                                        Belum ada riwayat tindakan khusus untuk pasien ini.
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- MODAL: TAMBAH REKAM MEDIS BARU -->
        <!-- ========================================================================= -->
        <div x-show="showTambahModal" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 sm:p-6 print:hidden"
             style="display: none;">
            
            <div @click.away="showTambahModal = false"
                 class="relative bg-white rounded-3xl shadow-2xl border border-gray-150 w-full max-w-3xl max-h-[90vh] overflow-y-auto">
                
                <!-- Modal Header -->
                <div class="sticky top-0 z-20 bg-white/95 backdrop-blur px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Tambah Rekam Medis Pasien</h3>
                            <p class="text-xs text-gray-500">Isi formulir anamnesa, pemeriksaan fisik, diagnosa, dan resep obat.</p>
                        </div>
                    </div>
                    <button @click="showTambahModal = false" class="p-2 text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Modal Body Form -->
                <form @submit.prevent="saveRekamMedis" class="p-6 space-y-6">
                    
                    <!-- Section 1: Pemilihan Pasien -->
                    <div class="bg-gray-50/70 p-4 rounded-2xl border border-gray-200">
                        <div class="flex items-center justify-between mb-3">
                            <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Target Pasien</label>
                            <div class="flex items-center gap-4 text-xs font-semibold">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" value="existing" x-model="newRecord.mode" class="text-emerald-600 focus:ring-emerald-500">
                                    <span class="ml-1.5 text-gray-700">Pasien Terdaftar</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" value="new" x-model="newRecord.mode" class="text-emerald-600 focus:ring-emerald-500">
                                    <span class="ml-1.5 text-gray-700">Pasien Baru</span>
                                </label>
                            </div>
                        </div>

                        <!-- If Existing Patient -->
                        <div x-show="newRecord.mode === 'existing'">
                            <select x-model="newRecord.patient_id" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500 bg-white">
                                <template x-for="p in patients" :key="p.id">
                                    <option :value="p.id" x-text="p.name + ' (' + p.id + ') - Gol. ' + p.blood + ' - ' + p.gender + ' (' + p.age + ' thn)'"></option>
                                </template>
                            </select>
                        </div>

                        <!-- If New Patient Form -->
                        <div x-show="newRecord.mode === 'new'" class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-medium text-gray-700 mb-1">Nama Lengkap Pasien *</label>
                                <input type="text" x-model="newRecord.new_name" placeholder="Contoh: Hendra Gunawan" class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">NIK (KTP)</label>
                                <input type="text" x-model="newRecord.new_nik" placeholder="16 digit NIK" class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                                <select x-model="newRecord.new_gender" class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500">
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Usia (Tahun)</label>
                                <input type="number" x-model="newRecord.new_age" placeholder="Contoh: 30" class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Golongan Darah</label>
                                <select x-model="newRecord.new_blood" class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500">
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
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Poli / Layanan</label>
                            <select x-model="newRecord.poli" @change="updateDoctorByPoli()" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500 bg-white">
                                <option value="Poli Umum">Poli Umum</option>
                                <option value="Poli Gigi">Poli Gigi</option>
                                <option value="Poli Anak">Poli Anak</option>
                                <option value="Poli THT">Poli THT</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Dokter Pemeriksa</label>
                            <select x-model="newRecord.doctor" @change="updateDoctorSip()" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500 bg-white">
                                <template x-for="doc in doctorsList" :key="doc.name">
                                    <option :value="doc.name" x-text="doc.name + ' (' + doc.poli + ')'"></option>
                                </template>
                            </select>
                        </div>
                    </div>

                    <!-- Section 3: Anamnesa & Keluhan -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Anamnesa & Keluhan Utama Pasien *</label>
                        <textarea x-model="newRecord.anamnesa" rows="3" required placeholder="Jelaskan keluhan utama pasien, durasi gejala, riwayat penyakit penyerta..." class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500"></textarea>
                    </div>

                    <!-- Section 4: Pemeriksaan Fisik & TTV -->
                    <div class="bg-gray-50/70 p-4 rounded-2xl border border-gray-200">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-3">Tanda-tanda Vital (TTV)</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">
                            <div>
                                <label class="block text-[11px] text-gray-500 mb-1">Tekanan Darah</label>
                                <input type="text" x-model="newRecord.bp" placeholder="120/80" class="w-full rounded-lg border border-gray-300 px-2.5 py-1.5 text-xs text-center font-bold">
                            </div>
                            <div>
                                <label class="block text-[11px] text-gray-500 mb-1">Suhu (°C)</label>
                                <input type="text" x-model="newRecord.temp" placeholder="36.5" class="w-full rounded-lg border border-gray-300 px-2.5 py-1.5 text-xs text-center font-bold">
                            </div>
                            <div>
                                <label class="block text-[11px] text-gray-500 mb-1">Nadi (x/mnt)</label>
                                <input type="text" x-model="newRecord.hr" placeholder="80" class="w-full rounded-lg border border-gray-300 px-2.5 py-1.5 text-xs text-center font-bold">
                            </div>
                            <div>
                                <label class="block text-[11px] text-gray-500 mb-1">Resp (x/mnt)</label>
                                <input type="text" x-model="newRecord.rr" placeholder="20" class="w-full rounded-lg border border-gray-300 px-2.5 py-1.5 text-xs text-center font-bold">
                            </div>
                            <div>
                                <label class="block text-[11px] text-gray-500 mb-1">Berat (kg)</label>
                                <input type="text" x-model="newRecord.weight" placeholder="65" class="w-full rounded-lg border border-gray-300 px-2.5 py-1.5 text-xs text-center font-bold">
                            </div>
                            <div>
                                <label class="block text-[11px] text-gray-500 mb-1">Tinggi (cm)</label>
                                <input type="text" x-model="newRecord.height" placeholder="168" class="w-full rounded-lg border border-gray-300 px-2.5 py-1.5 text-xs text-center font-bold">
                            </div>
                        </div>
                    </div>

                    <!-- Section 5: Diagnosa ICD-10 -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Kode ICD-10</label>
                            <input type="text" x-model="newRecord.diagnosis_code" placeholder="Contoh: J06.9 / K29.7" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm font-mono uppercase focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Deskripsi Diagnosa Medis *</label>
                            <input type="text" x-model="newRecord.diagnosis_name" required placeholder="Contoh: Acute upper respiratory infection, unspecified" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500">
                        </div>
                    </div>

                    <!-- Section 6: Resep Obat & Terapi Dinamis -->
                    <div class="bg-emerald-50/40 p-4 rounded-2xl border border-emerald-200">
                        <div class="flex items-center justify-between mb-3">
                            <label class="text-xs font-bold text-emerald-900 uppercase tracking-wider flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                Resep Obat & Terapi
                            </label>
                            <button type="button" @click="addPrescriptionItem()" class="text-xs font-bold text-emerald-700 bg-white hover:bg-emerald-50 border border-emerald-300 px-3 py-1 rounded-lg transition-colors flex items-center gap-1 shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                Tambah Baris Obat
                            </button>
                        </div>
                        <div class="space-y-2.5">
                            <template x-for="(item, idx) in newRecord.prescriptions" :key="idx">
                                <div class="flex items-center gap-2 bg-white p-2 rounded-xl border border-emerald-100 shadow-sm">
                                    <span class="w-6 h-6 rounded bg-emerald-100 text-emerald-700 font-bold flex items-center justify-center text-xs flex-shrink-0" x-text="idx + 1"></span>
                                    <input type="text" x-model="item.name" placeholder="Nama Obat (mis: Paracetamol 500mg)" class="flex-1 rounded-lg border border-gray-200 px-3 py-1.5 text-xs">
                                    <input type="text" x-model="item.dosage" placeholder="Aturan Pakai (mis: 3x1 sesudah makan)" class="flex-1 rounded-lg border border-gray-200 px-3 py-1.5 text-xs">
                                    <input type="text" x-model="item.qty" placeholder="Jumlah (10 tab)" class="w-24 rounded-lg border border-gray-200 px-3 py-1.5 text-xs text-center">
                                    <button type="button" @click="removePrescriptionItem(idx)" class="text-gray-400 hover:text-red-600 p-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Section 7: Tindakan Medis & Catatan Dokter -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Tindakan Medis / Prosedur</label>
                            <input type="text" x-model="newRecord.actions" placeholder="Misal: Pembersihan Luka, Nebulisasi, Restorasi Gigi" class="w-full rounded-xl border border-gray-300 px-3.5 py-2 text-sm focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Instruksi & Edukasi Dokter</label>
                            <input type="text" x-model="newRecord.notes" placeholder="Misal: Istirahat tirah baring 3 hari, kontrol ulang jika demam" class="w-full rounded-xl border border-gray-300 px-3.5 py-2 text-sm focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500">
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                        <button type="button" @click="showTambahModal = false" class="px-5 py-2.5 rounded-xl border border-gray-300 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="btn-primary py-2.5 px-6 text-sm font-bold shadow-md">
                            Simpan Rekam Medis
                        </button>
                    </div>

                </form>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- MODAL & DEDICATED PRINT VIEW: CETAK RIWAYAT MEDIS -->
        <!-- ========================================================================= -->
        <div x-show="showCetakModal" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 sm:p-6 print:p-0 print:bg-white print:static print:overflow-visible"
             style="display: none;">
            
            <div @click.away="showCetakModal = false"
                 class="relative bg-white rounded-3xl shadow-2xl border border-gray-150 w-full max-w-4xl max-h-[95vh] overflow-y-auto print:max-h-none print:shadow-none print:border-0 print:rounded-none print:w-full print:max-w-none">
                
                <!-- Action Bar (Hidden when printing) -->
                <div class="sticky top-0 z-20 bg-gray-900 text-white px-6 py-4 flex items-center justify-between print:hidden rounded-t-3xl">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm">Pratinjau Dokumen Rekam Medis</h4>
                            <p class="text-xs text-gray-400">Siap dicetak atau diekspor ke PDF resmi klinik.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button @click="executePrint()" class="btn-primary py-2 px-4 text-xs font-bold shadow flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            Cetak Sekarang (Print / PDF)
                        </button>
                        <button @click="showCetakModal = false" class="p-2 text-gray-400 hover:text-white rounded-lg hover:bg-white/10 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
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
