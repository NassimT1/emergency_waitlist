CREATE TABLE patient (
    code VARCHAR(5),
    firstName VARCHAR(20),
    lastName VARCHAR(20),
    severity INT(1),
    arrivalTime VARCHAR(20),
    PRIMARY KEY (code, lastName)
);
