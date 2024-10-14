
<?php
/**
 * Plugin Name: Tutor LMS Enhanced
 * Description: Enhanced features for Tutor LMS.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com
 */

defined( 'ABSPATH' ) || exit;

define( 'TUTOR_FILE', __FILE__ );

/**
 * Load tutor text domain for translation
 */
add_action(
    'init',
    function () {
        load_plugin_textdomain( 'tutor', false, basename( dirname( __FILE__ ) ) . '/languages' );
    }
);

if ( ! function_exists( 'tutor' ) ) {
    /**
     * Tutor helper function.
     *
     * @since 1.0.0
     *
     * @return object
     */
    function tutor() {
        if ( isset( $GLOBALS['tutor_plugin_info'] ) ) {
            return $GLOBALS['tutor_plugin_info'];
        }

        $path    = plugin_dir_path( TUTOR_FILE );
        $has_pro = defined( 'TUTOR_PRO_VERSION' );

        // Prepare the basepath.
        $home_url  = get_home_url();
        $parsed    = parse_url( $home_url );
        $base_path = ( is_array( $parsed ) && isset( $parsed['path'] ) ) ? $parsed['path'] : '/';
        $base_path = rtrim( $base_path, '/' ) . '/';
        // Get current URL.
        $current_url = trailingslashit( $home_url ) . substr( $_SERVER['REQUEST_URI'], strlen( $base_path ) );//phpcs:ignore

        $info = array(
            'path'                   => $path,
            'url'                    => plugin_dir_url( TUTOR_FILE ),
            'icon_dir'               => plugin_dir_url( TUTOR_FILE ) . 'assets/images/images-v2/icons/',
            'v2_img_dir'             => plugin_dir_url( TUTOR_FILE ) . 'assets/images/images-v2/',
            'basename'               => plugin_basename( TUTOR_FILE ),
            'basepath'               => $base_path,
            'version'                => TUTOR_VERSION,
            'nonce_action'           => 'tutor_nonce_action',
            'nonce'                  => '_tutor_nonce',
            'course_post_type'       => apply_filters( 'tutor_course_post_type', 'courses' ),
            'lesson_post_type'       => apply_filters( 'tutor_lesson_post_type', 'lesson' ),
            'instructor_role'        => apply_filters( 'tutor_instructor_role', 'tutor_instructor' ),
            'instructor_role_name'   => apply_filters( 'tutor_instructor_role_name', __( 'Tutor Instructor', 'tutor' ) ),
            'template_path'          => apply_filters( 'tutor_template_path', 'tutor/' ),
            'has_pro'                => apply_filters( 'tutor_has_pro', $has_pro ),
            // @since v2.0.6.
            'topics_post_type'       => apply_filters( 'tutor_topics_post_type', 'topics' ),
            'announcement_post_type' => apply_filters( 'tutor_announcement_post_type', 'tutor_announcements' ),
            'assignment_post_type'   => apply_filters( 'tutor_assignment_post_type', 'tutor_assignments' ),
            'enrollment_post_type'   => apply_filters( 'tutor_enrollment_post_type', 'tutor_enrolled' ),
            'quiz_post_type'         => apply_filters( 'tutor_quiz_post_type', 'tutor_quiz' ),
            'zoom_post_type'         => apply_filters( 'tutor_zoom_meeting_post_type', 'tutor_zoom_meeting' ),
            'meet_post_type'         => apply_filters( 'tutor_google_meeting_post_type', 'tutor-google-meet' ),
        );

        $GLOBALS['tutor_plugin_info'] = (object) $info;
        return $GLOBALS['tutor_plugin_info'];
    }
}

class TutorPlugin {
    /**
     * Save course price
     *
     * @param int $post_id
     */
    public function save_course_price( $post_id ) {
        if ( isset( $_POST['tutor_course_price'] ) ) {
            update_post_meta( $post_id, '_tutor_course_price', sanitize_text_field( $_POST['tutor_course_price'] ) );
        }
    }

    /**
     * Add My Certifications menu item
     */
    public function add_my_certifications_menu() {
        add_menu_page(
            __( 'My Certifications', 'tutor' ),
            __( 'My Certifications', 'tutor' ),
            'read',
            'my-certifications',
            array( $this, 'display_my_certifications' ),
            'dashicons-awards',
            6
        );
    }

    /**
     * Display My Certifications page
     */
    public function display_my_certifications() {
        echo '<h1>' . __( 'My Certifications', 'tutor' ) . '</h1>';
    }
}

$tutor_plugin = new TutorPlugin();
add_action( 'save_post', array( $tutor_plugin, 'save_course_price' ) );
add_action( 'admin_menu', array( $tutor_plugin, 'add_my_certifications_menu' ) );
