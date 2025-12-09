CREATE DATABASE IF NOT EXISTS meowcare;
USE meowcare;

-- ----------------------------------
-- TABLE: disease (Penyakit)
-- ----------------------------------
CREATE TABLE disease (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(10),
    name VARCHAR(200),
    description TEXT
);

INSERT INTO disease (code, name, description) VALUES
('P01', 'Feline Panleukopenia (FPV)', 'Infeksi virus yang menyerang sistem imun dan pencernaan kucing. Ditandai muntah, diare, demam, lesu.'),
('P02', 'Feline Upper Respiratory Infection (Flu Kucing)', 'Infeksi saluran pernapasan atas pada kucing. Gejala berupa bersin, mata berair, hidung berair.'),
('P03', 'Feline Ear Mite (Kutu Telinga)', 'Infestasi parasit pada telinga kucing. Ditandai telinga gatal dan bau tidak sedap.'),
('P04', 'Feline Dermatitis (Jamur/Kulit Radang)', 'Infeksi atau iritasi kulit. Gejalanya kulit kemerahan, kerontokan bulu, luka seperti jamur.'),
('P05', 'Feline Worm Infection (Cacingan)', 'Infeksi cacing pada pencernaan kucing. Terlihat dengan perut buncit dan diare.'),
('P06', 'Feline Diarrhea (Diare Umum)', 'Gangguan pencernaan ringan. Gejala diare dan tidak nafsu makan.');

-- ----------------------------------
-- TABLE: symptom (Gejala)
-- ----------------------------------
CREATE TABLE symptom (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(10),
    name VARCHAR(200)
);

INSERT INTO symptom (code, name) VALUES
('G01', 'Demam'),
('G02', 'Diare'),
('G03', 'Muntah'),
('G04', 'Tidak Nafsu Makan'),
('G05', 'Lesu'),
('G06', 'Mata Berair'),
('G07', 'Hidung Berair'),
('G08', 'Bersin'),
('G09', 'Telinga Gatal'),
('G10', 'Telinga Berbau'),
('G11', 'Kulit Kemerahan'),
('G12', 'Kerontokan Bulu'),
('G13', 'Kotoran Berwarna Hijau'),
('G14', 'Perut Buncit'),
('G15', 'Luka Berjamur');

-- ----------------------------------
-- TABLE: rule_base (Aturan)
-- ----------------------------------
CREATE TABLE rule_base (
    id INT AUTO_INCREMENT PRIMARY KEY,
    disease_id INT,
    FOREIGN KEY (disease_id) REFERENCES disease(id)
);

INSERT INTO rule_base (disease_id) VALUES
(1), -- FPV
(2), -- Flu Kucing
(3), -- Ear Mite
(4), -- Dermatitis
(5), -- Cacingan
(6); -- Diare Umum

-- ----------------------------------
-- TABLE: rule_condition (Gejala dalam rule)
-- ----------------------------------
CREATE TABLE rule_condition (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rule_id INT,
    symptom_id INT,
    FOREIGN KEY (rule_id) REFERENCES rule_base(id),
    FOREIGN KEY (symptom_id) REFERENCES symptom(id)
);

-- RULE R1 - FPV
INSERT INTO rule_condition (rule_id, symptom_id) VALUES
(1, 3),  -- muntah
(1, 2),  -- diare
(1, 1),  -- demam
(1, 5);  -- lesu

-- RULE R2 - Flu Kucing
INSERT INTO rule_condition (rule_id, symptom_id) VALUES
(2, 8), -- bersin
(2, 6), -- mata berair
(2, 7); -- hidung berair

-- RULE R3 - Kutu Telinga
INSERT INTO rule_condition (rule_id, symptom_id) VALUES
(3, 9),  -- telinga gatal
(3, 10); -- telinga berbau

-- RULE R4 - Dermatitis
INSERT INTO rule_condition (rule_id, symptom_id) VALUES
(4, 11), -- kulit kemerahan
(4, 12), -- kerontokan bulu
(4, 15); -- luka berjamur

-- RULE R5 - Cacingan
INSERT INTO rule_condition (rule_id, symptom_id) VALUES
(5, 14), -- perut buncit
(5, 2);  -- diare

-- RULE R6 - Diare Umum
INSERT INTO rule_condition (rule_id, symptom_id) VALUES
(6, 2), -- diare
(6, 4); -- tidak nafsu makan

-- ----------------------------------
-- TABLE: history (Riwayat Diagnosa)
-- ----------------------------------
CREATE TABLE history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    symptoms TEXT,
    result TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
