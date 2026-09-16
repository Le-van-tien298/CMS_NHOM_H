<?php

function cms_nhom_h_create_tables()
{
    global $wpdb;

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $charset_collate = $wpdb->get_charset_collate();
    $prefix = $wpdb->prefix;

    // Bảng danh mục
    $sql_categories = "CREATE TABLE {$prefix}fashion_categories (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NOT NULL,
        description TEXT NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

        PRIMARY KEY (id),
        UNIQUE KEY slug (slug)
    ) $charset_collate;";

    // Bảng sản phẩm
    $sql_products = "CREATE TABLE {$prefix}fashion_products (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        category_id BIGINT UNSIGNED NOT NULL,
        name VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NOT NULL,
        description TEXT NULL,
        price DECIMAL(12,2) NOT NULL DEFAULT 0,
        image_url TEXT NULL,
        status VARCHAR(20) NOT NULL DEFAULT 'active',
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

        PRIMARY KEY (id),
        KEY category_id (category_id),
        UNIQUE KEY slug (slug)
    ) $charset_collate;";

    // Bảng size, màu sắc và tồn kho
    $sql_variants = "CREATE TABLE {$prefix}fashion_product_variants (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        product_id BIGINT UNSIGNED NOT NULL,
        size VARCHAR(20) NOT NULL,
        color VARCHAR(50) NOT NULL,
        price DECIMAL(12,2) NOT NULL DEFAULT 0,
        stock INT NOT NULL DEFAULT 0,
        sku VARCHAR(100) NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

        PRIMARY KEY (id),
        KEY product_id (product_id),
        UNIQUE KEY sku (sku)
    ) $charset_collate;";

    // Bảng đơn hàng
    $sql_orders = "CREATE TABLE {$prefix}fashion_orders (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        user_id BIGINT UNSIGNED NULL,
        customer_name VARCHAR(255) NOT NULL,
        customer_phone VARCHAR(20) NOT NULL,
        customer_address TEXT NOT NULL,
        total_amount DECIMAL(12,2) NOT NULL DEFAULT 0,
        status VARCHAR(30) NOT NULL DEFAULT 'pending',
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

        PRIMARY KEY (id),
        KEY user_id (user_id)
    ) $charset_collate;";

    // Bảng chi tiết đơn hàng
    $sql_order_items = "CREATE TABLE {$prefix}fashion_order_items (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        order_id BIGINT UNSIGNED NOT NULL,
        variant_id BIGINT UNSIGNED NOT NULL,
        product_name VARCHAR(255) NOT NULL,
        size VARCHAR(20) NULL,
        color VARCHAR(50) NULL,
        quantity INT NOT NULL DEFAULT 1,
        price DECIMAL(12,2) NOT NULL DEFAULT 0,
        subtotal DECIMAL(12,2) NOT NULL DEFAULT 0,

        PRIMARY KEY (id),
        KEY order_id (order_id),
        KEY variant_id (variant_id)
    ) $charset_collate;";

    dbDelta($sql_categories);
    dbDelta($sql_products);
    dbDelta($sql_variants);
    dbDelta($sql_orders);
    dbDelta($sql_order_items);
}