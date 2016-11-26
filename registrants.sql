use gc200310426;

CREATE TABLE registrants (
firstName VARCHAR(50) NOT NULL,
lastName VARCHAR(50) NOT NULL,
company_name VARCHAR(50) NOT NULL,
product_id INT(20) NOT NULL,
email VARCHAR(75) NOT NULL);

DESC registrants;

SELECT * FROM registrants;