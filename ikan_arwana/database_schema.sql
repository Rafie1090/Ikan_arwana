-- Pastikan menggunakan database yang benar
USE test;

-- 1. Users Table
CREATE TABLE IF NOT EXISTS users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(255) NOT NULL DEFAULT 'client',
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- 2. Password Reset Tokens Table
CREATE TABLE IF NOT EXISTS password_reset_tokens (
    email VARCHAR(255) PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL
);

-- 3. Sessions Table
CREATE TABLE IF NOT EXISTS sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX sessions_user_id_index (user_id),
    INDEX sessions_last_activity_index (last_activity)
);

-- 4. Products Table
CREATE TABLE IF NOT EXISTS products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    price DECIMAL(12, 2) NOT NULL,
    image VARCHAR(255) NULL,
    stock INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- 5. Kolams Table
CREATE TABLE IF NOT EXISTS kolams (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_kolam VARCHAR(255) NOT NULL,
    lokasi VARCHAR(255) NULL,
    deskripsi TEXT NULL,
    status ENUM('aktif', 'nonaktif') NOT NULL DEFAULT 'aktif',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- 6. Monitoring Air Table
CREATE TABLE IF NOT EXISTS monitoring_air (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kolam_id BIGINT UNSIGNED NOT NULL,
    suhu DOUBLE(8, 2) NOT NULL,
    ph DOUBLE(8, 2) NOT NULL,
    oksigen DOUBLE(8, 2) NOT NULL,
    kekeruhan DOUBLE(8, 2) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (kolam_id) REFERENCES kolams(id) ON DELETE CASCADE
);

-- 7. Jadwal Pakans Table
CREATE TABLE IF NOT EXISTS jadwal_pakans (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kolam_id BIGINT UNSIGNED NOT NULL,
    tanggal DATE NOT NULL DEFAULT (CURRENT_DATE),
    waktu VARCHAR(255) NOT NULL,
    sesi VARCHAR(255) NOT NULL,
    jumlah VARCHAR(255) NOT NULL,
    jenis_pakan VARCHAR(255) NOT NULL,
    status ENUM('Aktif', 'Nonaktif') NOT NULL DEFAULT 'Aktif',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (kolam_id) REFERENCES kolams(id) ON DELETE CASCADE
);

-- 8. Orders Table
CREATE TABLE IF NOT EXISTS orders (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    order_number VARCHAR(255) NOT NULL UNIQUE,
    customer_name VARCHAR(255) NOT NULL,
    customer_phone VARCHAR(255) NOT NULL,
    customer_address TEXT NOT NULL,
    notes TEXT NULL,
    subtotal DECIMAL(12, 2) NOT NULL,
    shipping_cost DECIMAL(12, 2) NOT NULL DEFAULT 0,
    total DECIMAL(12, 2) NOT NULL,
    payment_method ENUM('cod', 'transfer') NOT NULL DEFAULT 'cod',
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') NOT NULL DEFAULT 'pending',
    cancellation_note TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 9. Order Items Table
CREATE TABLE IF NOT EXISTS order_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NULL,
    product_name VARCHAR(255) NOT NULL,
    price DECIMAL(12, 2) NOT NULL,
    quantity INT NOT NULL,
    subtotal DECIMAL(12, 2) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
);
