
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

<<<<<<< HEAD

if ( ! class_exists( 'Tutor' ) ) {
class Tutor {
    public function save_course_price( $post_id ) {
	/**
	 * Tutor helper function.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	    /**
	     * Tutor helper function.
	     *
	     * @since 1.0.0
	     *
	     * @return object
	     */
	    public function tutor() {
	        if ( isset( $GLOBALS['tutor_plugin_info'] ) ) {
			return $GLOBALS['tutor_plugin_info'];
		}
=======
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
>>>>>>> a857512d1ca6a0b40bfbb6badc593cfe7154abcd

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

<<<<<<< HEAD
		$GLOBALS['tutor_plugin_info'] = (object) $info;
		return $GLOBALS['tutor_plugin_info'];
	}

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

	add_action( 'save_post', array( $this, 'save_course_price' ) );

	function add_my_certifications_menu() {
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

	function display_my_certifications() {
		include 'views/my-certifications.php';
	}

	add_action( 'admin_menu', array( $this, 'add_my_certifications_menu' ) );
=======
        $GLOBALS['tutor_plugin_info'] = (object) $info;
        return $GLOBALS['tutor_plugin_info'];
    }
>>>>>>> a857512d1ca6a0b40bfbb6badc593cfe7154abcd
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

<<<<<<< HEAD
    /**
     * Tutor helper function.
     *
     * @since 1.0.0
     *
     * @return object
     */
    public function tutor() {
        if ( isset( $GLOBALS['tutor_plugin_info'] ) ) {
			return $GLOBALS['tutor_plugin_info'];
		}
		
		// Rest of the code...
	}


if ( ! function_exists( 'tutils' ) ) {
	/**
	 * Alis of tutor_utils()
	 *
	 * @since 1.3.4
	 *
	 * @return \TUTOR\Utils
	 */
	function tutils() {
		return tutor_utils();
	}
}

/**
 * Do some task during activation
 *
 * @since 1.5.2
 *
 * @since 2.6.2
 *
 * Uninstall hook registered
 */
register_activation_hook( TUTOR_FILE, array( '\TUTOR\Tutor', 'tutor_activate' ) );
register_deactivation_hook( TUTOR_FILE, array( '\TUTOR\Tutor', 'tutor_deactivation' ) );
register_uninstall_hook( TUTOR_FILE, array( '\TUTOR\Tutor', 'tutor_uninstall' ) );

if ( ! function_exists( 'tutor_lms' ) ) {
	/**
	 * Run main instance of the Tutor
	 *
	 * @since 1.2.0
	 *
	 * @return null|\TUTOR\Tutor
	 */
	function tutor_lms() {
		return \TUTOR\Tutor::instance();
	}
}

if ( ! function_exists( 'str_contains' ) ) {
	/**
	 * String helper for str contains
	 *
	 * @since 1.0.0
	 *
	 * @param string $haystack haystack.
	 * @param string $needle needle.
	 *
	 * @return bool
	 */
	function str_contains( string $haystack, string $needle ) {
		return empty( $needle ) || strpos( $haystack, $needle ) !== false;
	}
}

$GLOBALS['tutor'] = tutor_lms();
=======
$tutor_plugin = new TutorPlugin();
add_action( 'save_post', array( $tutor_plugin, 'save_course_price' ) );
add_action( 'admin_menu', array( $tutor_plugin, 'add_my_certifications_menu' ) );
>>>>>>> a857512d1ca6a0b40bfbb6badc593cfe7154abcd
