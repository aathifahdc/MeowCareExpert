CREATE DATABASE IF NOT EXISTS meowcare;
USE meowcare;

-- ===========================================
-- TABLE: DISEASE
-- ===========================================
CREATE TABLE disease (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(10),
    name VARCHAR(200),
    description TEXT
);

TRUNCATE TABLE disease;

INSERT INTO disease (code, name, description) VALUES
('P1', 'Flu Kucing (Feline URI)', 'Infeksi saluran pernapasan atas yang umum pada kucing.'),
('P2', 'Calicivirus', 'Infeksi virus yang menyebabkan sariawan, flu, dan demam.'),
('P3', 'Panleukopenia (Feline Distemper)', 'Virus mematikan yang menyerang sistem imun.'),
('P4', 'Feline Leukemia Virus (FeLV)', 'Virus yang melemahkan kekebalan tubuh.'),
('P5', 'Feline Immunodeficiency Virus (FIV)', 'Virus yang menyebabkan penurunan daya tahan tubuh.'),
('P6', 'Scabies (Kudis Kucing)', 'Infeksi tungau pada kulit.'),
('P7', 'Tungau Telinga (Ear Mites)', 'Parasit telinga yang menyebabkan gatal hebat.'),
('P8', 'Cacingan', 'Infeksi cacing pada pencernaan.'),
('P9', 'Diabetes Mellitus', 'Gangguan metabolisme gula darah.'),
('P10', 'Hipertiroidisme', 'Tiroid terlalu aktif menyebabkan penurunan berat badan.'),
('P11', 'FLUTD', 'Masalah saluran kemih bagian bawah.'),
('P12', 'FIP', 'Penyakit fatal akibat mutasi virus corona kucing.'),
('P13', 'Pneumonia', 'Radang paru-paru yang menyebabkan gangguan napas.'),
('P14', 'Feline Herpesvirus (FHV)', 'Virus flu kucing parah.'),
('P15', 'Ringworm', 'Infeksi jamur kulit menular pada kucing.'),
('P16', 'Gingivitis', 'Radang gusi yang menyebabkan nyeri mulut.');

-- ===========================================
-- TABLE: SYMPTOM
-- ===========================================
CREATE TABLE symptom (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(10),
    name VARCHAR(200)
);

TRUNCATE TABLE symptom;

INSERT INTO symptom (code, name) VALUES
('G001','Air liur berlebihan'),
('G002','Bau mulut'),
('G003','Bau tidak sedap dari telinga'),
('G004','Batuk'),
('G005','Bersin'),
('G006','Bulu kusam'),
('G007','Darah dalam urin'),
('G008','Dehidrasi'),
('G009','Demam'),
('G010','Demam tidak kunjung sembuh'),
('G011','Gatal parah'),
('G012','Gusi merah dan bengkak'),
('G013','Gusi pucat'),
('G014','Hidung berair'),
('G015','Hiperaktif'),
('G016','Infeksi berulang'),
('G017','Infeksi gusi'),
('G018','Keluar cairan dari mata'),
('G019','Kesulitan bernapas'),
('G020','Kesulitan buang air kecil'),
('G021','Kesulitan makan'),
('G022','Kerontokan bulu'),
('G023','Kerontokan bulu berbentuk lingkaran'),
('G024','Kotoran hitam di telinga'),
('G025','Kulit bersisik'),
('G026','Kulit kemerahan'),
('G027','Lesi merah'),
('G028','Lesu'),
('G029','Luka akibat garukan'),
('G030','Luka sulit sembuh'),
('G031','Mata berair'),
('G032','Mata merah dan bengkak'),
('G033','Menjilat area genital berlebihan'),
('G034','Muntah'),
('G035','Nafsu makan meningkat'),
('G036','Nafsu makan menurun'),
('G037','Perut membesar'),
('G038','Perut membuncit'),
('G039','Penurunan berat badan'),
('G040','Sariawan'),
('G041','Sering buang air kecil'),
('G042','Sering ke kotak pasir'),
('G043','Sering menggaruk telinga'),
('G044','Sering mengucek mata'),
('G045','Sering minum');

-- ===========================================
-- TABLE: RULE BASE
-- ===========================================
CREATE TABLE rule_base (
    id INT AUTO_INCREMENT PRIMARY KEY,
    disease_id INT,
    FOREIGN KEY (disease_id) REFERENCES disease(id)
);

TRUNCATE TABLE rule_base;

INSERT INTO rule_base (disease_id) VALUES
(1),(2),(3),(4),(5),(6),(7),(8),(9),(10),(11),(12),(13),(14),(15),(16);

-- ===========================================
-- TABLE: RULE CONDITION
-- ===========================================
CREATE TABLE rule_condition (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rule_id INT,
    symptom_id INT,
    FOREIGN KEY (rule_id) REFERENCES rule_base(id),
    FOREIGN KEY (symptom_id) REFERENCES symptom(id)
);

TRUNCATE TABLE rule_condition;

-- ===========================================
-- AUTO-GENERATED RULES (MEDICAL)
-- ===========================================

-- P1 Flu Kucing
INSERT INTO rule_condition (rule_id, symptom_id) VALUES
(1,5),(1,14),(1,31),(1,18),(1,9),(1,28),(1,44);

-- P2 Calicivirus
INSERT INTO rule_condition (rule_id, symptom_id) VALUES
(2,5),(2,14),(2,31),(2,40),(2,9),(2,36),(2,28);

-- P3 Panleukopenia
INSERT INTO rule_condition (rule_id, symptom_id) VALUES
(3,34),(3,2),(3,8),(3,9),(3,36),(3,28),(3,39);

-- P4 FeLV
INSERT INTO rule_condition (rule_id, symptom_id) VALUES
(4,13),(4,16),(4,39),(4,28),(4,30),(4,36);

-- P5 FIV
INSERT INTO rule_condition (rule_id, symptom_id) VALUES
(5,16),(5,17),(5,36),(5,28),(5,39),(5,30);

-- P6 Scabies
INSERT INTO rule_condition (rule_id, symptom_id) VALUES
(6,11),(6,26),(6,29),(6,27),(6,22);

-- P7 Ear Mites
INSERT INTO rule_condition (rule_id, symptom_id) VALUES
(7,43),(7,24),(7,3);

-- P8 Cacingan
INSERT INTO rule_condition (rule_id, symptom_id) VALUES
(8,38),(8,37),(8,36),(8,39),(8,28);

-- P9 Diabetes
INSERT INTO rule_condition (rule_id, symptom_id) VALUES
(9,45),(9,41),(9,35),(9,39),(9,28);

-- P10 Hipertiroidisme
INSERT INTO rule_condition (rule_id, symptom_id) VALUES
(10,35),(10,39),(10,4),(10,28);

-- P11 FLUTD
INSERT INTO rule_condition (rule_id, symptom_id) VALUES
(11,20),(11,7),(11,33),(11,42),(11,41);

-- P12 FIP
INSERT INTO rule_condition (rule_id, symptom_id) VALUES
(12,37),(12,10),(12,28),(12,36),(12,32);

-- P13 Pneumonia
INSERT INTO rule_condition (rule_id, symptom_id) VALUES
(13,19),(13,4),(13,9),(13,14),(13,28);

-- P14 FHV
INSERT INTO rule_condition (rule_id, symptom_id) VALUES
(14,5),(14,14),(14,31),(14,32),(14,18),(14,36);

-- P15 Ringworm
INSERT INTO rule_condition (rule_id, symptom_id) VALUES
(15,23),(15,25),(15,27),(15,22);

-- P16 Gingivitis
INSERT INTO rule_condition (rule_id, symptom_id) VALUES
(16,12),(16,2),(16,21),(16,1),(16,36);

-- ===========================================
-- TABLE: VETERINARIAN
-- ===========================================
CREATE TABLE veterinarian (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    clinic_name VARCHAR(200),
    location VARCHAR(200),
    phone VARCHAR(20),
    whatsapp VARCHAR(20),
    hours VARCHAR(100),
    specialization VARCHAR(200),
    rating DECIMAL(2,1),
    reviews_count INT
);

INSERT INTO veterinarian (name, clinic_name, location, phone, whatsapp, hours, specialization, rating, reviews_count) VALUES
('Dr. Siti Rahayu', 'Klinik Hewan Pet Care', 'Jakarta Selatan', '081234567890', '081234567890', '08:00 - 20:00', 'Umum & Bedah', 4.8, 125),
('Dr. Bambang Sutrisno', 'Animal Hospital Plus', 'Jakarta Pusat', '082198765432', '082198765432', '09:00 - 19:00', 'Dermatologi & Parasit', 4.9, 89),
('Dr. Ani Wijaya', 'Klinik Kesehatan Hewan', 'Jakarta Utara', '081123456789', '081123456789', '08:00 - 18:00', 'Vaksinasi & Pencegahan', 4.7, 156),
('Dr. Hendra Kusuma', 'Emergency Vet Center', 'Jakarta Selatan', '082345678901', '082345678901', '24 Jam', 'Darurat & ICU', 5.0, 203),
('Dr. Linda Sofiana', 'Grooming & Health Care', 'Jakarta Timur', '081456789012', '081456789012', '08:30 - 17:30', 'Perawatan & Nutrisi', 4.6, 94),
('Dr. Muhammad Rizki', 'Paws Wellness Center', 'Jakarta Barat', '081567890123', '081567890123', '08:00 - 21:00', 'Umum & Ortopedi', 4.8, 112);

-- ===========================================
-- TABLE: SYMPTOM GUIDE
-- ===========================================
CREATE TABLE symptom_guide (
    id INT AUTO_INCREMENT PRIMARY KEY,
    symptom_id INT,
    description TEXT,
    how_to_identify TEXT,
    when_to_see_vet TEXT,
    prevention TEXT,
    FOREIGN KEY (symptom_id) REFERENCES symptom(id) ON DELETE CASCADE
);

INSERT INTO symptom_guide (symptom_id, description, how_to_identify, when_to_see_vet, prevention) VALUES
(1, 'Kucing mengeluarkan air liur berlebihan dari mulutnya', 'Mulut selalu basah|Ada air liur menetes|Bantal tempat tidur lembab', 'Jika berlangsung lebih dari beberapa jam atau ada tanda infeksi', 'Kesehatan gigi|Hindari benda asing|Vaksinasi'),
(2, 'Bau tidak sedap keluar dari mulut kucing', 'Bau menyengat saat kucing berbicara|Bau terus menerus|Gusi mungkin merah', 'Jika bau tidak hilang dalam seminggu', 'Kebersihan gigi|Makanan berkualitas|Perawatan rutin'),
(3, 'Bau tidak sedap keluar dari telinga kucing', 'Bau kuning/busuk dari telinga|Telinga merah dan bengkak|Ada discharge', 'Segera, karena menandakan infeksi', 'Pembersihan rutin|Hindari air di telinga'),
(4, 'Kucing sering batuk atau batuk terus-menerus', 'Suara batuk keras|Batuk disertai keluarnya cairan|Kucing terlihat tidak nyaman', 'Jika batuk persisten lebih dari 3-4 hari', 'Hindari asap|Ventilasi baik|Jaga kelembaban'),
(5, 'Kucing sering bersin-bersin', 'Bersin berulang-ulang|Suara bersin keras|Discharge dari hidung', 'Jika bersin persisten atau disertai gejala lain', 'Vaksinasi|Hindari alergen|Jaga kebersihan'),
(6, 'Bulu kucing terlihat kusam dan tidak mengkilap', 'Bulu terlihat dull|Tekstur bulu kasar|Bulu mudah rontok', 'Jika berkelanjutan lebih dari 1 minggu', 'Nutrisi seimbang|Grooming rutin'),
(7, 'Ada darah dalam urin kucing', 'Urin berwarna merah atau cokelat|Darah terlihat jelas di litter box', 'Segera, dapat menandakan infeksi atau batu ginjal', 'Air bersih melimpah|Diet seimbang'),
(8, 'Kucing menunjukkan tanda-tanda dehidrasi', 'Mulut dan gusi terasa kering|Kulit tidak elastis|Mata terlihat cekung', 'Segera, dehidrasi serius dapat mengancam', 'Air bersih selalu tersedia'),
(9, 'Suhu tubuh kucing meningkat di atas normal', 'Telinga dan hidung terasa panas|Kucing lebih lemas|Mata sayu', 'Jika demam berlangsung lebih dari 2-3 hari', 'Vaksinasi rutin|Menjaga kebersihan'),
(10, 'Demam yang tidak hilang meskipun sudah berlangsung lama', 'Suhu tubuh tetap tinggi lebih dari 1 minggu|Kucing sangat lemah', 'Sangat penting, perlu tes untuk diagnosis', 'Vaksinasi|Cegah infeksi'),
(11, 'Kucing mengalami gatal yang sangat parah pada kulit', 'Kucing sering menggaruk|Menggigit kulit|Kerontokan bulu', 'Jika gatal sangat mengganggu', 'Kebersihan kulit|Hindari alergen'),
(12, 'Gusi kucing berwarna merah dan bengkak', 'Gusi merah cerah atau gelap|Bengkak pada gusi|Kucing sulit makan', 'Jika gusi sangat bengkak atau ada nanah', 'Kebersihan gigi|Kontrol diet'),
(13, 'Warna gusi kucing pucat bukan merah muda', 'Gusi terlihat pucat atau putih|Tanda anemia', 'Sangat urgent, dapat menandakan penyakit serius', 'Nutrisi seimbang'),
(14, 'Cairan jernih atau berwarna keluar dari hidung', 'Hidung lembab dan basah|Discharge jernih atau berwarna', 'Jika berlangsung lebih dari 3-4 hari', 'Vaksinasi|Hindari alergen'),
(15, 'Kucing menjadi sangat aktif dan hiperaktif', 'Kucing sering bergerak cepat|Tidur lebih sedikit|Perilaku agresif', 'Jika perilaku sangat berubah', 'Vaksinasi|Hindari stress'),
(16, 'Kucing sering terkena infeksi berulang kali', 'Infeksi satu kesembuhan langsung kena infeksi lagi|Luka sulit sembuh', 'Penting untuk tes imunitas', 'Vaksinasi|Nutrisi baik'),
(17, 'Terjadi infeksi pada gusi kucing', 'Gusi merah dan bengkak|Ada nanah|Bau sangat tidak sedap', 'Segera, dapat berkembang menjadi serius', 'Kebersihan gigi'),
(18, 'Cairan keluar dari mata kucing', 'Mata berair dan basah|Bulu di sekitar mata lembab', 'Jika mata terus berair', 'Bersihkan mata rutin|Hindarkan debu'),
(19, 'Kucing mengalami kesulitan bernapas atau sesak', 'Napas cepat dan terengah-engah|Suara napas kasar', 'Sangat urgent, jangan menunggu', 'Hindari stres|Ventilasi baik'),
(20, 'Kucing kesulitan atau menyakitkan saat buang air kecil', 'Frekuensi BAK tinggi|Kucing mengeong saat BAK|Ada darah dalam urin', 'Segera, dapat obstruksi saluran kemih', 'Air bersih melimpah|Diet seimbang'),
(21, 'Kucing kesulitan makan atau tidak mau makan', 'Mulut dibuka dengan ragu-ragu|Makanan jatuh dari mulut', 'Jika berlangsung lebih dari 24 jam', 'Kesehatan gigi|Makanan berkualitas'),
(22, 'Kucing mengalami kerontokan bulu yang abnormal', 'Banyak bulu rontok saat digaruk|Patch botak di tubuh', 'Jika kerontokan sangat banyak', 'Grooming teratur|Nutrisi baik'),
(23, 'Kerontokan bulu berbentuk lingkaran (seperti jamur)', 'Patch bulat dengan tepi jelas|Kulit terlihat bersisik', 'Segera, menandakan infeksi jamur', 'Kebersihan|Jauhi kucing terinfeksi'),
(24, 'Kotoran hitam terlihat di dalam telinga kucing', 'Kotoran hitam seperti biji lada|Telinga berbau|Kucing sering menggaruk', 'Jika kotoran sangat banyak', 'Pembersihan rutin'),
(25, 'Kulit kucing terlihat bersisik atau berminyak', 'Kulit kasar dan bersisik|Tekstur tidak halus', 'Jika sangat parah atau menyebar luas', 'Kebersihan|Nutrisi seimbang'),
(26, 'Kulit kucing berwarna merah dan iritasi', 'Patch merah pada kulit|Kucing sering menggaruk', 'Jika semakin parah atau menyebar', 'Kebersihan|Hindari alergen'),
(27, 'Ada lesi atau luka merah pada kulit kucing', 'Luka berwarna merah|Luka terbuka atau bernanah', 'Jika luka semakin besar', 'Hindari trauma|Kebersihan'),
(28, 'Kucing terlihat lesu dan tidak aktif', 'Berbaring terus menerus|Pergerakan lambat|Tidur lebih banyak', 'Jika berlangsung lebih dari 1-2 hari', 'Istirahat cukup|Nutrisi baik'),
(29, 'Ada luka di kulit kucing akibat garukan berlebihan', 'Luka terbuka dari menggaruk|Kucing terus menggaruk', 'Jika luka terinfeksi', 'Kontrol gatal|Potong kuku'),
(30, 'Luka pada kulit kucing tidak kunjung sembuh', 'Luka terbuka bertahan lama|Tidak ada tanda penyembuhan', 'Segera, luka yang tidak sembuh dapat serius', 'Kebersihan luka|Nutrisi baik'),
(31, 'Mata kucing berair atau keluar air mata', 'Mata berair dan basah|Bulu di sekitar mata lembab', 'Jika mata terus berair', 'Bersihkan mata rutin'),
(32, 'Mata kucing merah dan bengkak', 'Mata terlihat merah cerah|Kelopak mata bengkak', 'Segera, dapat infeksi atau cedera mata', 'Hindari trauma|Vaksinasi'),
(33, 'Kucing sering menjilat area genital secara berlebihan', 'Menjilat area genital terus menerus|Area genital merah', 'Segera, dapat infeksi saluran kemih', 'Kebersihan|Hindari stress'),
(34, 'Kucing sering muntah atau mengeluarkan isi perut', 'Gerakan lambung yang terlihat|Cairan keluar dari mulut', 'Jika sering muntah lebih dari 2x sehari', 'Makan dalam porsi kecil|Jaga kebersihan'),
(35, 'Nafsu makan kucing meningkat drastis', 'Kucing selalu minta makan|Makan dalam porsi besar', 'Jika perilaku sangat berubah', 'Diet seimbang|Monitor porsi'),
(36, 'Kucing tidak mau atau jarang makan', 'Makanan tidak disentuh|Berat badan berkurang', 'Jika berlangsung lebih dari 24 jam', 'Nutrisi seimbang|Makanan berkualitas'),
(37, 'Perut kucing tampak membesar menonjol', 'Perut terlihat membesar|Area perut lembut', 'Jika perut membesar tiba-tiba', 'Nutrisi seimbang|Parasit prevention'),
(38, 'Perut kucing tampak membuncit dan tegang', 'Perut terlihat besar dan tegang|Kesulitan bergerak', 'Segera, untuk mencari tahu penyebabnya', 'Nutrisi seimbang|Parasit prevention'),
(39, 'Berat badan kucing menurun drastis', 'Kucing terlihat lebih kurus|Tulang belakang terlihat menonjol', 'Jika penurunan berat cepat', 'Nutrisi seimbang|Makanan berkualitas'),
(40, 'Kucing memiliki sariawan atau luka di mulut', 'Ada luka atau lepuhan di mulut|Kucing sulit makan', 'Segera, dapat tanda penyakit serius', 'Kebersihan gigi|Vaksinasi'),
(41, 'Kucing sering buang air kecil dari biasanya', 'Frekuensi BAK meningkat|Sering ke litter box', 'Jika frekuensi sangat meningkat', 'Air bersih|Diet seimbang'),
(42, 'Kucing sering pergi ke kotak pasir', 'Sering mengunjungi litter box|Perilaku sering berubah', 'Jika frekuensi sangat tinggi', 'Litter box bersih|Air bersih'),
(43, 'Kucing sering menggaruk telinganya', 'Sering menggaruk telinga|Telinga merah atau bengkak', 'Jika gatal terus-menerus', 'Bersihkan telinga berkala'),
(44, 'Kucing sering mengucek atau menggosok matanya', 'Sering menggosek mata dengan kaki depan|Mata gatal', 'Jika terus-menerus', 'Kebersihan mata|Hindari debu'),
(45, 'Kucing sering minum air dari biasanya', 'Sering ke mangkuk air|Minum dalam jumlah banyak', 'Jika minum sangat banyak', 'Air bersih selalu tersedia');

-- ===========================================
-- TABLE: DISEASE DETAIL
-- ===========================================
CREATE TABLE disease_detail (
    id INT AUTO_INCREMENT PRIMARY KEY,
    disease_id INT,
    severity VARCHAR(50),
    is_contagious BOOLEAN,
    symptoms_summary TEXT,
    prevention TEXT,
    treatment TEXT,
    survival_rate VARCHAR(100),
    is_emergency BOOLEAN,
    FOREIGN KEY (disease_id) REFERENCES disease(id) ON DELETE CASCADE
);

INSERT INTO disease_detail (disease_id, severity, is_contagious, symptoms_summary, prevention, treatment, survival_rate, is_emergency) VALUES
(1, 'Sedang', 1, 'Bersin, mata berair, hidung berair', 'Vaksinasi FVRCP|Hindari stress|Hindari draft', 'Istirahat, makanan bergizi, obat simtomatik', '80-90%', 0),
(2, 'Sedang', 1, 'Sariawan, demam, sulit makan', 'Vaksinasi FVRCP|Jaga kebersihan mulut', 'Istirahat, makanan lembut, obat antivirus', '75-85%', 0),
(3, 'Sangat Tinggi', 1, 'Muntah, diare, demam, lesu', 'Vaksinasi FVRCP|Isolasi kucing sakit|Kebersihan ketat', 'Perawatan suportif, cairan IV, rawat inap', '40-60%', 1),
(4, 'Tinggi', 1, 'Demam, infeksi berulang, lesu', 'Vaksinasi FELV|Jauhi kucing terinfeksi', 'Perawatan suportif, obat simtomatik', '50-70%', 0),
(5, 'Tinggi', 1, 'Demam, infeksi berulang, lesu', 'Jauhi kucing terinfeksi|Hindari kontak darah', 'Perawatan suportif, obat untuk infeksi', '50-70%', 0),
(6, 'Sedang', 0, 'Gatal parah, kulit kemerahan, luka', 'Grooming rutin|Kebersihan lingkungan', 'Obat antiparasit topikal atau oral', '90-95%', 0),
(7, 'Rendah', 0, 'Telinga gatal, bau tidak sedap', 'Pembersihan telinga rutin|Hindari air', 'Pembersihan telinga, tetes antiparasit', '95%+', 0),
(8, 'Rendah', 0, 'Perut buncit, diare, tidak nafsu makan', 'Pemberian obat cacing berkala', 'Obat cacing, makanan bergizi', '85%+', 0),
(9, 'Sedang', 0, 'Nafsu makan meningkat, penurunan berat badan', 'Deteksi dini|Diet seimbang', 'Insulin injection, diet khusus', '60-80%', 0),
(10, 'Sedang', 0, 'Hiperaktif, penurunan berat badan', 'Tes hormon rutin|Pemeriksaan berkala', 'Obat thyroid, diet khusus', '70-85%', 0),
(11, 'Sedang', 0, 'Kesulitan buang air kecil, sering ke kotak pasir', 'Air bersih melimpah|Diet seimbang', 'Kateterisasi jika obstruksi, antibiotik', '70-80%', 1),
(12, 'Sangat Tinggi', 0, 'Demam tidak kunjung sembuh, perut membuncit', 'Isolasi dari kucing lain|Jaga kebersihan', 'Perawatan suportif, cairan IV', '20-40%', 1),
(13, 'Sedang', 0, 'Batuk, kesulitan bernapas, lesu', 'Hindari draft|Kebersihan ruangan', 'Istirahat, obat batuk, antibiotik', '70-85%', 0),
(14, 'Sedang', 1, 'Bersin, mata merah, batuk', 'Vaksinasi FVRCP|Hindari stress', 'Istirahat, obat antivirus, antibiotik', '75-85%', 0),
(15, 'Rendah', 1, 'Kerontokan bulu lingkaran, kulit bersisik', 'Grooming rutin|Jauhi kucing terinfeksi', 'Obat anti jamur topikal, oral jika perlu', '90%+', 0),
(16, 'Rendah', 0, 'Bau mulut, gusi merah bengkak, sulit makan', 'Kebersihan gigi rutin|Makanan berkualitas', 'Scaling gigi, antibiotik jika perlu', '90%+', 0);