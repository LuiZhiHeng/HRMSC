    CREATE DATABASE hrmsc;

-- Data Type for Reference
    CREATE TABLE status_type (
        statusTypeId TINYINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        statusName VARCHAR(255) NOT NULL
    );

        INSERT INTO status_type VALUES
            (NULL, 'Approved'),
            (NULL, 'Rejected'),
            (NULL, 'Pending'),

            (NULL, 'Cancelled'),
            (NULL, 'Prepared'),
            (NULL, 'Taken');

    CREATE TABLE state_type (
        stateTypeId TINYINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        stateName VARCHAR(255) NOT NULL
    );

        INSERT INTO state_type VALUES
            (NULL, "Johor"),
            (NULL, "Kedah"),
            (NULL, "Kelantan"),
            (NULL, "Malacca"),
            (NULL, "Negeri Sembilan"),
            (NULL, "Pahang"),
            (NULL, "Penang"),
            (NULL, "Perak"),
            (NULL, "Perlis"),
            (NULL, "Sabah"),
            (NULL, "Sarawak"),
            (NULL, "Selangor"),
            (NULL, "Terengganu");

    CREATE TABLE allowance_type (
        allowanceTypeId TINYINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        allowanceName VARCHAR(255) NOT NULL
    );

        INSERT INTO allowance_type VALUES
            (NULL, "Transportation"),
            (NULL, "Medical"),
            (NULL, "Car");

    CREATE TABLE claim_type (
        claimTypeId TINYINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        claimName VARCHAR(255) NOT NULL
    );

        INSERT INTO claim_type VALUES
            (NULL, "Other"),
            (NULL, "Transportation");

    CREATE TABLE leave_type (
        leaveTypeId TINYINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        leaveName VARCHAR(255) NOT NULL
    );

        INSERT INTO leave_type VALUES
            (NULL, "Sick"),
            (NULL, "Annual"),
            (NULL, "Matternity");

    CREATE TABLE payroll_item_type (
        payrollItemTypeId TINYINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        payrollItemTypeName VARCHAR(255) NOT NULL
    );

    CREATE TABLE overtime_day_type (
        dayTypeId TINYINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        dayTypeName VARCHAR(255) NOT NULL
    );

-- Data Table
    CREATE TABLE holiday (
        holidayId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        holidayDate date NOT NULL,
        holidayName VARCHAR(255) NOT NULL
    );

    CREATE TABLE leave_item (
        leaveItemId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        leaveTypeId TINYINT,
        minWorkedYear TINYINT NOT NULL,
        day TINYINT NOT NULL,
        leaveItemStartFrom date NOT NULL,

        FOREIGN KEY (leaveTypeId) REFERENCES leave_type(leaveTypeId)
    );

        INSERT INTO leave_item VALUES
            (NULL, 1, 5, 22, "1955-01-01"),
            (NULL, 1, 2, 18, "1995-01-01"),
            (NULL, 1, 0, 8, "1995-01-01"),
            (NULL, 2, 5, 16, "1955-01-01"),
            (NULL, 2, 2, 12, "1955-01-01"),
            (NULL, 2, 0, 8, "1955-01-01"),
            (NULL, 3, 0, 60, "1995-01-01");
            

    CREATE TABLE payroll_item (
        payrollItemId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        payrollItemTypeId TINYINT,
        minSalary INT,
        minAge TINYINT,
        percentEmployee DECIMAL(10,4),
        percentEmployer DECIMAL(10,4),
        payrollItemStartFrom date NOT NULL
    );

    CREATE TABLE overtime_payrate (
        overtimePayrateId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        dayTypeId TINYINT,
        minWorkedHour DECIMAL(10,2),
        payrate DECIMAL(5,2),
        overtimePayrateStartFrom date NOT NULL,
        
        FOREIGN KEY (dayTypeId) REFERENCES overtime_day_type(dayTypeId)
    );

-- Recruitment Data
    CREATE TABLE recruitment (
        recruitmentId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        position VARCHAR(255) NOT NULL,
        positionDetail VARCHAR(255),
        requirement VARCHAR(255),
        salary INT NOT NULL,
        peopleLimit INT NOT NULL,
        workDay INT NOT NULL,
        startJobTime time NOT NULL,
        endJobTime time NOT NULL
    );

    CREATE TABLE allowance (
        allowanceId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        recruitmentId INT,
        allowanceTypeId TINYINT,
        allowanceAmount DECIMAL(10,2) NOT NULL,

        FOREIGN KEY (recruitmentId) REFERENCES recruitment(recruitmentId),
        FOREIGN KEY (allowanceTypeId) REFERENCES allowance_type(allowanceTypeId)
    );

-- Employee Data
    CREATE TABLE employee (
        employeeId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        employeeName VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        pwd VARCHAR(255) NOT NULL,
        phone VARCHAR(255),
        birthday date,
        gender VARCHAR(16),
        
        address1 VARCHAR(255),
        address2 VARCHAR(255),
        address3 VARCHAR(255),
        stateTypeId TINYINT,
        postcode INT,
        city VARCHAR(255),

        epfAcc VARCHAR(255),
        socsoAcc VARCHAR(255),
        eisAcc VARCHAR(255),
        pcbAcc VARCHAR(255),

        startWorkDate date,
        endWorkDate date DEFAULT NULL,
        recruitmentId INT,

        FOREIGN KEY (stateTypeId) REFERENCES state_type(stateTypeId),
        FOREIGN KEY (recruitmentId) REFERENCES recruitment(recruitmentId)
    );

-- Admin Data
-- admin@admin.com admin
    CREATE TABLE admin (
        adminId TINYINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        adminEmail VARCHAR(255) NOT NULL,
        pwd VARCHAR(255) NOT NULL,
        adminLevel TINYINT NOT NULL
    );

    INSERT INTO admin VALUES (1, "admin@admin.com", "d033e22ae348aeb5660fc2140aec35850c4da997", 1);


-- Attendance
    CREATE TABLE attendance (
        attendanceId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        employeeId INT,
        attendanceDate date NOT NULL,
        punchInDateTime datetime,
        punchOutDateTime datetime,

        FOREIGN KEY (employeeId) REFERENCES employee(employeeId)
    );

    INSERT INTO attendance VALUES
        (NULL, 1, "2021-08-01", "2021-08-01 09:00:00", "2021-08-01 17:00:00"),
        (NULL, 1, "2021-08-07", "2021-08-07 09:00:00", "2021-08-07 17:00:00"),
        (NULL, 1, "2021-08-08", "2021-08-08 09:00:00", "2021-08-08 17:00:00"),
        (NULL, 1, "2021-08-14", "2021-08-14 09:00:00", "2021-08-14 17:00:00"),
        (NULL, 1, "2021-08-15", "2021-08-15 09:00:00", "2021-08-15 17:00:00"),
        (NULL, 1, "2021-08-21", "2021-08-21 09:00:00", "2021-08-21 17:00:00"),
        (NULL, 1, "2021-08-22", "2021-08-22 09:00:00", "2021-08-22 17:00:00"),
        (NULL, 1, "2021-08-28", "2021-08-28 09:00:00", "2021-08-28 17:00:00"),
        (NULL, 1, "2021-08-29", "2021-08-29 09:00:00", "2021-08-29 17:00:00");

-- Claim
    CREATE TABLE claim_request (
        claimId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        employeeId INT,
        claimTypeId TINYINT,
        claimDetail VARCHAR(255),
        claimAmount DECIMAL(10,2) NOT NULL,
        claimFileName VARCHAR(255) NOT NULL,
        applyClaimDateTime datetime NOT NULL,

        approveClaimDateTime datetime DEFAULT NULL,
        comment VARCHAR(255),
        claimStatus TINYINT,

        FOREIGN KEY (employeeId) REFERENCES employee(employeeId),
        FOREIGN KEY (claimTypeId) REFERENCES claim_type(claimTypeId),
        FOREIGN KEY (claimStatus) REFERENCES status_type(statusTypeId)
    );

-- Leave
    CREATE TABLE leave_request (
        leaveId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        employeeId INT,
        leaveTypeId TINYINT,
        leaveDetail VARCHAR(255),
        startLeaveDateTime datetime,
        endLeaveDateTime datetime,
        leaveFileName VARCHAR(255),
        applyLeaveDateTime datetime NOT NULL,

        approveLeaveDateTime datetime DEFAULT NULL,
        comment VARCHAR(255),
        leaveStatus TINYINT,

        FOREIGN KEY (employeeId)  REFERENCES employee(employeeId),
        FOREIGN KEY (leaveTypeId) REFERENCES leave_type(leaveTypeId),
        FOREIGN KEY (leaveStatus) REFERENCES status_type(statusTypeId)
    );

-- Payroll
    CREATE TABLE payroll (
        payrollId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        employeeId INT,
        month TINYINT NOT NULL,
        year INT NOT NULL,
        cheque VARCHAR(255) DEFAULT NULL,
        basicPay DECIMAL(10,2),
        deduction DECIMAL(10,2),
        netPay DECIMAL(10,2),

        FOREIGN KEY (employeeId) REFERENCES employee(employeeId)
    );

-- permission
    CREATE TABLE permission (
        permissionId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        permissionLevel TINYINT NOT NULL
    );

    INSERT INTO permission VALUES
        (NULL, "allowance", 1),
        (NULL, "claim_type", 1),
        (NULL, "holiday", 1),
        (NULL, "leave_type", 1),
        (NULL, "overtime_type", 1),
        (NULL, "payroll_type", 1),
        (NULL, "state", 1),
        (NULL, "status", 1);
        