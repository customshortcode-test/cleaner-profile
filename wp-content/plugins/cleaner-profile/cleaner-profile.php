<?php

/* 
Plugin Name: Cleaner Profile
Version 1.0
Description: Outputs a cleaner profile block.
Author: Jumar Juaton
Author URI: https://wordpress.org/
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: cleanerprofiles
*/

/**
 * Shortcode: [cleaner_profile]
 *
 * Description:
 * Outputs a responsive Tailwind CSS-styled HTML table displaying cleaner profile data
 * pulled from a semicolon-delimited CSV file. Each row includes:
 * - Name
 * - Photo (URL, shown as a circular avatar)
 * - Star rating (numeric, out of 5)
 * - Availability (e.g., “Weekdays: 9am–5pm”)
 * - A short bio or description
 *
 * Features:
 * - Automatic detection and formatting of image URLs
 * - Underscores in column headers are converted to title case
 * - Clean Tailwind UI layout
 *
 * Example usage:
 * [cleaner_profile file="/wp-content/uploads/data.csv"]
 *
 * @param array $atts Shortcode attributes: 'file' (required)
 * @return string Rendered HTML table of cleaner profiles
 */

function cleaner_profile_display_tailwind_csv_table_with_images($atts) {
    $atts = shortcode_atts([
        'file' => '',
        'rows_per_page' => 10,
    ], $atts);

    if (empty($atts['file'])) return '<p>No CSV file specified.</p>';

    $rows = [];

    // Load CSV data
    if (filter_var($atts['file'], FILTER_VALIDATE_URL)) {
        $response = wp_remote_get($atts['file']);
        if (is_wp_error($response)) return '<p>Failed to fetch CSV file.</p>';
        $lines = explode("\n", wp_remote_retrieve_body($response));
    } else {
        $filepath = ABSPATH . ltrim($atts['file'], '/'); // Fix in case path starts with /
        if (!file_exists($filepath)) return '<p>CSV file not found.</p>';
        $lines = file($filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }

    foreach ($lines as $line) {
        $rows[] = str_getcsv($line, ';');
    }

    if (empty($rows) || count($rows) < 2) return '<p>CSV file is empty or has no data.</p>';

    $headers = $rows[0];
    $data_rows = array_slice($rows, 1);

    $page = isset($_GET['cp_page']) ? max(1, intval($_GET['cp_page'])) : 1;
    $per_page = intval($atts['rows_per_page']);
    $total_items = count($data_rows) + 1;
    $total_pages = ceil($total_items / $per_page);
    $start = ($page - 1) * $per_page;
    $paginated_rows = array_slice($data_rows, $start, $per_page);

    ob_start();
    ?>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <?php foreach ($headers as $index => $header): ?>
                        <?php if ($index === 0) continue; ?>
                        <th class="px-6 py-3"><?php echo esc_html(ucwords(str_replace('_', ' ', $header))); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($paginated_rows as $row): ?>
                    <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                        <?php for ($i = 1; $i < count($row); $i++): ?>
                            <td class="px-6 py-4">
                                <?php
                                $cell = trim($row[$i]);
                                if (filter_var($cell, FILTER_VALIDATE_URL)) {
                                    echo '<img src="' . esc_url($cell) . '" class="w-10 h-10 rounded-full" />';
                                } else {
                                    echo esc_html($cell);
                                }
                                ?>
                            </td>
                        <?php endfor; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
    $current_url = esc_url_raw(add_query_arg(null, null)); // Get current full URL
    $base_url = remove_query_arg('cp_page', $current_url); // Only remove cp_page
                        
    // Pagination summary
    if ($total_items > 0) {
        $from = $start + 1;
        $to = min($start + $per_page, $total_items);
    } else {
        $from = 0;
        $to = 0;
    }

    $current_url = esc_url_raw(add_query_arg(null, null)); // Get full URL
    $base_url = remove_query_arg('cp_page', $current_url); // Remove cp_page param only

    echo '<nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4">';
    echo '<span class="text-sm font-normal text-gray-500 mb-4 md:mb-0 block w-full md:inline md:w-auto">';
    echo 'Showing <span class="font-semibold text-gray-500">' . esc_html($from) . '-' . esc_html($to) . '</span> of ';
    echo '<span class="font-semibold text-gray-500">' . esc_html($total_items) . '</span>';
    echo '</span>';

    echo '<ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8 list-none">';

    // Previous
    if ($page > 1) {
        echo '<li><a href="' . esc_url(add_query_arg('cp_page', $page - 1, $base_url)) . '" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700">Previous</a></li>';
    }

    for ($i = 1; $i <= $total_pages; $i++) {
        $active = ($i == $page);
        $classes = $active
            ? 'text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700'
            : 'leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700';
        echo '<li><a href="' . esc_url(add_query_arg('cp_page', $i, $base_url)) . '" class="flex items-center justify-center px-3 h-8 ' . $classes . '">' . $i . '</a></li>';
    }

    // Next
    if ($page < $total_pages) {
        echo '<li><a href="' . esc_url(add_query_arg('cp_page', $page + 1, $base_url)) . '" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700">Next</a></li>';
    }

    echo '</ul>';
    echo '</nav>';

    // ✅ FIXED: Return the buffered output instead of echoing it at the top of the page
    return ob_get_clean();
}
add_shortcode('cleaner_profile', 'cleaner_profile_display_tailwind_csv_table_with_images');

/*
* Description:
 * This code adds a custom admin menu page to the WordPress dashboard where admins can
 * input cleaner profile information (Photo URL, Name, Rating, Availability, Bio).
 * Submitted data is validated and saved to a CSV file located at `/wp-content/uploads/data.csv`.
 *
 * Key Features:
 * - Adds a "Cleaner Profiles" menu item in the WP Admin.
 * - Validates and sanitizes form inputs.
 * - Generates a UUID for each entry.
 * - Saves each cleaner's profile as a new row in the CSV file.
 * - Displays success or error messages after form submission.
 */
function cleaner_profiles_csv_admin_menu() {
    add_menu_page(
        'Cleaner Profiles CSV',
        'Cleaner Profiles',
        'manage_options',
        'cleaner-profiles-csv',
        'cleaner_profiles_csv_page',
        'dashicons-groups',
        30
    );
}
add_action('admin_menu', 'cleaner_profiles_csv_admin_menu');

function cleaner_profiles_csv_page() {
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && check_admin_referer('add_cleaner_profile_csv')) {
        $photo = trim($_POST['photo']);
        $name = trim($_POST['name']);
        $rating = trim($_POST['rating']);
        $availability = trim($_POST['availability']);
        $bio = trim($_POST['bio']);

        // Validation
        if (empty($photo) || !filter_var($photo, FILTER_VALIDATE_URL)) {
            $errors[] = 'Please enter a valid Photo URL.';
        }

        if (empty($name)) {
            $errors[] = 'Name is required.';
        }

        if ($rating === '' || !is_numeric($rating) || $rating < 0 || $rating > 5) {
            $errors[] = 'Please enter a valid rating between 0 and 5.';
        }

        if (empty($availability)) {
            $errors[] = 'Availability is required.';
        }

        if (empty($bio)) {
            $errors[] = 'Bio is required.';
        }

        // If no errors, save to CSV
        if (empty($errors)) {
            $uuid = wp_generate_uuid4();
            $row = [
                $uuid,
                esc_url_raw($photo),
                sanitize_text_field($name),
                floatval($rating),
                sanitize_text_field($availability),
                sanitize_textarea_field($bio)
            ];

            $csv_path = WP_CONTENT_DIR . '/uploads/data.csv';
            if (!file_exists($csv_path)) {
                file_put_contents($csv_path, ""); // create file
            }

            $handle = fopen($csv_path, 'a');
            fputcsv($handle, $row, ';');
            fclose($handle);

            echo '<div class="notice notice-success is-dismissible"><p>Cleaner profile added successfully.</p></div>';

            // Clear form fields after successful save
            $photo = $name = $rating = $availability = $bio = '';
        } else {
            echo '<div class="notice notice-error"><ul>';
            foreach ($errors as $error) {
                echo '<li>' . esc_html($error) . '</li>';
            }
            echo '</ul></div>';
        }
    }

    // If not set from previous post, define empty
    $photo = isset($photo) ? esc_attr($photo) : '';
    $name = isset($name) ? esc_attr($name) : '';
    $rating = isset($rating) ? esc_attr($rating) : '';
    $availability = isset($availability) ? esc_attr($availability) : '';
    $bio = isset($bio) ? esc_textarea($bio) : '';
?>

    <div class="wrap">
        <h1>Add Cleaner Profile to CSV</h1>
        <form method="post">
            <?php wp_nonce_field('add_cleaner_profile_csv'); ?>

            <table class="form-table">
                <tr>
                    <th scope="row"><label for="photo">Photo URL</label></th>
                    <td><input name="photo" type="text" class="regular-text" required value="<?php echo $photo; ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="name">Name</label></th>
                    <td><input name="name" type="text" class="regular-text" required value="<?php echo $name; ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="rating">Rating (1–5)</label></th>
                    <td><input name="rating" type="number" step="0.01" min="1" max="5" class="small-text" required value="<?php echo $rating; ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="availability">Availability</label></th>
                    <td><input name="availability" type="text" class="regular-text" required value="<?php echo $availability; ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="bio">Bio</label></th>
                    <td><textarea name="bio" rows="4" cols="50" required><?php echo $bio; ?></textarea></td>
                </tr>
            </table>

            <?php submit_button('Add Cleaner'); ?>
        </form>
    </div>

    <?php
}
