<?php

/**
 * Plugin Name: User Manager
 * Description: Plugin quản lý người dùng
 * Version: 1.0
 * Author: Pro
 */

add_action('admin_menu', 'um_add_admin_menu');

function um_add_admin_menu()
{
    add_menu_page(
        'User Manager',
        'User Manager',
        'manage_options',
        'user-manager',
        'um_render_page',
        'dashicons-admin-users'
    );
}

function um_render_page()
{
    // =========================
    // 1. XỬ LÝ THÊM USER
    // =========================

    if (isset($_POST['create_user'])) {

        $username = sanitize_user($_POST['username']);
        $email = sanitize_email($_POST['email']);
        $password = $_POST['password'];
        $role = sanitize_text_field($_POST['role']);

        $user_id = wp_insert_user([
            'user_login' => $username,
            'user_pass' => $password,
            'user_email' => $email,
            'role' => $role,
        ]);

        if (is_wp_error($user_id)) {

            echo '<div class="notice notice-error">';
            echo '<p>' . esc_html($user_id->get_error_message()) . '</p>';
            echo '</div>';

        } else {

            echo '<div class="notice notice-success">';
            echo '<p>Thêm user thành công!</p>';
            echo '</div>';
        }
    }


    // =========================
    // 2. LẤY DANH SÁCH USER
    // =========================

    $users = get_users();

    ?>

    <div class="wrap">

        <h1>User Manager</h1>

        <!-- =========================
             USER LIST
        ========================== -->

        <h2>Danh sách User</h2>

        <table class="widefat">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
            </thead>

            <tbody>

                    <?php foreach ($users as $user): ?>

                    <tr>

                        <td>
                                    <?php echo esc_html($user->ID); ?>
                        </td>

                        <td>
                                    <?php echo esc_html($user->user_login); ?>
                        </td>

                        <td>
                                    <?php echo esc_html($user->user_email); ?>
                        </td>

                        <td>
                                    <?php echo esc_html(
                                        implode(', ', $user->roles)
                                    ); ?>
                        </td>

                    </tr>

                    <?php endforeach; ?>

            </tbody>

        </table>


        <!-- =========================
             CREATE USER
        ========================== -->

        <h2>Thêm User</h2>

        <form method="post">

            <p>
                <label>
                    Username
                </label>

                <br>

                <input type="text" name="username" required>
            </p>


            <p>
                <label>
                    Email
                </label>

                <br>

                <input type="email" name="email" required>
            </p>


            <p>
                <label>
                    Password
                </label>

                <br>

                <input type="password" name="password" required>
            </p>


            <p>
                <label>
                    Role
                </label>

                <br>

                <select name="role">

                    <option value="subscriber">
                        Subscriber
                    </option>

                    <option value="author">
                        Author
                    </option>

                    <option value="editor">
                        Editor
                    </option>

                </select>
            </p>


            <p>
                <button type="submit" name="create_user" class="button button-primary">
                    Thêm User
                </button>
            </p>

        </form>

    </div>

    <?php
}

