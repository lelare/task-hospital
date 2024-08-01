CREATE DATABASE task_hospital;
USE task_hospital;

CREATE TABLE patient (
    _id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    pn VARCHAR(11) DEFAULT NULL,
    first VARCHAR(15) DEFAULT NULL,
    last VARCHAR(25) DEFAULT NULL,
    dob DATE DEFAULT NULL,
    PRIMARY KEY (_id)
);

CREATE TABLE insurance (
    _id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    patient_id INT(10) UNSIGNED NOT NULL,
    iname VARCHAR(40) DEFAULT NULL,
    from_date DATE DEFAULT NULL,
    to_date DATE DEFAULT NULL,
    PRIMARY KEY (_id),
    FOREIGN KEY (patient_id) REFERENCES patient(_id)
);

INSERT INTO patient (pn, first, last, dob) VALUES
('pn01', 'John', 'Doe', '1982-07-14'),
('pn02', 'Jane', 'Smith', '2005-04-10'),
('pn03', 'Billie', 'Palmer', '1997-11-05'),
('pn04', 'Olivia', 'Miller', '1999-03-02'),
('pn05', 'Sarah', 'Logan', '1989-01-25');

INSERT INTO insurance (patient_id, iname, from_date, to_date) VALUES
(1, 'SwissCare', '2022-01-01', '2023-12-31'),
(1, 'Ergo', '2023-01-01', '2024-12-31'),
(2, 'InsuranceCo', '2023-03-15', '2023-11-15'),
(2, 'AON', '2023-11-16', NULL),
(3, 'AON', '2020-05-02', '2022-02-13'),
(3, 'Ergo', '2022-03-05', '2024-01-06'),
(4, 'SwissCare', '2019-01-01', '2019-11-30'),
(4, 'InsuranceCo', '2019-11-28', '2024-11-28'),
(5, 'Ergo', '2024-02-02', '2024-03-02'),
(5, 'SwissCare', '2024-03-03', '2024-12-31');