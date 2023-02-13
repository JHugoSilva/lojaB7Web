CREATE TABLE categories(
    id INT AUTO_INCREMENT PRIMARY KEY,
    sub INT,
    name VARCHAR(200)NOT NULL
);

CREATE TABLE brands(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200)NOT NULL
);

CREATE TABLE products(
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_category INT NOT NULL,
    id_brand INT NOT NULL,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    stock INT NOT NULL,
    price FLOAT(10,2) NOT NULL,
    price_from FLOAT(10,2) NOT NULL,
    rating FLOAT(10,2) NOT NULL,
    featured TINYINT(1) NOT NULL,
    sale TINYINT(1)NOT NULL,
    bestseller TINYINT(1)NOT NULL,
    new_product TINYINT(1)NOT NULL,
    options VARCHAR(200)
);

CREATE TABLE options(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL
);

CREATE TABLE products_options(
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_product INT NOT NULL,
    id_option INT NOT NULL,
    p_value VARCHAR(200) NOT NULL
);

CREATE TABLE products_images(
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_product INT NOT NULL,
    url VARCHAR(200) NOT NULL
);

CREATE TABLE rates(
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_product INT NOT NULL,
    id_user INT NOT NULL,
    date_rated DATETIME NOT NULL,
    points INT NOT NULL,
    comment TEXT
);

CREATE TABLE users(
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(200) NOT NULL,
    password VARCHAR(255)NOT NULL
);

CREATE TABLE pages(
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    body TEXT NOT NULL
);

CREATE TABLE purchases(
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_coupon INT NOT NULL,
    total_amount FLOAT(10,2) NOT NULL,
    payment_type INT,
    payment_status INT NOT NULL
);

CREATE TABLE coupons(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    coupon_type INT NOT NULL,
    coupon_value FLOAT(10,2) NOT NULL
);

CREATE TABLE purchases_products(
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_purchase INT NOT NULL,
    id_product INT NOT NULL,
    quantity INT NOT NULL
);

CREATE TABLE purchase_transactions(
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_purchase INT NOT NULL,
    amount FLOAT(10,2) NOT NULL,
    transaction_code INT NOT NULL
);
