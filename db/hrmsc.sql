-- create db hrmsc
    CREATE DATABASE hrmsc;


-- status type
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


--  state type
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


-- allowance type
    CREATE TABLE allowance_type (
        allowanceTypeId TINYINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        allowanceName VARCHAR(255) NOT NULL
    );

        INSERT INTO allowance_type VALUES
            (NULL, "Transportation"),
            (NULL, "Medical"),
            (NULL, "Phone");


-- claim type
    CREATE TABLE claim_type (
        claimTypeId TINYINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        claimName VARCHAR(255) NOT NULL
    );

        INSERT INTO claim_type VALUES
            (NULL, "Other"),
            (NULL, "Transportation");


-- leave type
    CREATE TABLE leave_type (
        leaveTypeId TINYINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        leaveName VARCHAR(255) NOT NULL
    );

        INSERT INTO leave_type VALUES
            (NULL, "Sick"),
            (NULL, "Annual"),
            (NULL, "Matternity"),
            (NULL, "Personal");


-- payroll item type
    CREATE TABLE payroll_item_type (
        payrollItemTypeId TINYINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        payrollItemTypeName VARCHAR(255) NOT NULL
    );

        INSERT INTO payroll_item_type VALUES
            (NULL, 'EPF'),
            (NULL, 'SOCSO'),
            (NULL, 'EIS');


-- overtime day type
    CREATE TABLE overtime_day_type (
        dayTypeId TINYINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        dayTypeName VARCHAR(255) NOT NULL
    );

        INSERT INTO overtime_day_type VALUES
            (NULL, 'Normal Day'),
            (NULL, 'Rest Day'),
            (NULL, 'Public Holiday Day');


-- holiday
    CREATE TABLE holiday (
        holidayId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        holidayName VARCHAR(255) NOT NULL,
        holidayDate date NOT NULL
    );

        INSERT INTO holiday VALUES
            (NULL, 'Christmas Day', '2021-12-25'),
            (NULL, 'Malaysia Independence Day', '2021-09-16'),
            (NULL, 'Prophet Birthday', '2021-10-19'),
            (NULL, 'Malaysia Day', '2021-08-31'),
            (NULL, 'Christmas Day', '2022-12-25'),
            (NULL, 'Malaysia Independence Day', '2022-09-16'),
            (NULL, 'Malaysia Day', '2022-08-31');


-- leave item
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
            

-- payroll item
    CREATE TABLE payroll_item (
        payrollItemId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        payrollItemTypeId TINYINT,
        minSalary INT,
        minAge TINYINT,
        percentEmployee DECIMAL(10,4),
        percentEmployer DECIMAL(10,4),
        payrollItemStartFrom date NOT NULL
    );

        INSERT INTO payroll_item VALUES
            (NULL, 1, 0, 0, '0.1100', '0.1300', '1955-01-01'),
            (NULL, 2, 0, 60, '0.0125', '0.0000', '1955-01-01'),
            (NULL, 2, 0, 0, '0.0175', '0.0050', '1955-01-01'),
            (NULL, 3, 4000, 0, '7.9000', '7.9000', '1955-01-01'),
            (NULL, 3, 3000, 0, '5.9000', '5.9000', '1955-01-01'),
            (NULL, 3, 2000, 0, '3.9000', '3.9000', '1955-01-01'),
            (NULL, 3, 1000, 0, '1.9000', '1.9000', '1955-01-01'),
            (NULL, 3, 0, 0, '0.0000', '0.0000', '1955-01-01');


-- overtime payrate
    CREATE TABLE overtime_payrate (
        overtimePayrateId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        dayTypeId TINYINT,
        minWorkedHour DECIMAL(10,2),
        payrate DECIMAL(5,2),
        overtimePayrateStartFrom date NOT NULL,
        
        FOREIGN KEY (dayTypeId) REFERENCES overtime_day_type(dayTypeId)
    );

        INSERT INTO overtime_payrate VALUES
            (NULL, 1, '8.00', '1.50', '1955-01-01'),
            (NULL, 1, '0.00', '1.00', '1955-01-01'),
            (NULL, 2, '8.00', '2.00', '1955-01-01'),
            (NULL, 2, '4.00', '1.00', '1955-01-01'),
            (NULL, 2, '0.00', '0.50', '1955-01-01'),
            (NULL, 3, '8.00', '3.00', '1955-01-01'),
            (NULL, 3, '0.00', '2.00', '1955-01-01');


-- permission
    CREATE TABLE permission (
            permissionId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            permissionLevel TINYINT NOT NULL
        );

        INSERT INTO permission VALUES
            (NULL, "allowance", 1),
            (NULL, "claim_type", 1),
            (NULL, "holiday", 2),
            (NULL, "leave_type", 1),
            (NULL, "overtime_type", 1),
            (NULL, "payroll_type", 1),
            (NULL, "state", 1),
            (NULL, "status", 1);


-- Admin & Staff
    CREATE TABLE admin (
        adminId TINYINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        adminEmail VARCHAR(255) NOT NULL,
        pwd VARCHAR(255) NOT NULL,
        adminLevel TINYINT NOT NULL
    );

    INSERT INTO admin VALUES 
        (NULL, "admin@hrmsc.com", "d033e22ae348aeb5660fc2140aec35850c4da997", 1),
        (NULL, 'staff@hrmsc.com', '6ccb4b7c39a6e77f76ecfa935a855c6c46ad5611', 2);
    

-- Recruitment
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


-- Employee
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


-- Attendance
    CREATE TABLE attendance (
        attendanceId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        employeeId INT,
        attendanceDate date NOT NULL,
        punchInDateTime datetime,
        punchOutDateTime datetime,

        FOREIGN KEY (employeeId) REFERENCES employee(employeeId)
    );


-- Claim Request
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


-- Leave Request
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

