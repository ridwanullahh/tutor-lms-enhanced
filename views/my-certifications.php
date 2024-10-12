
<?php
/**
 * My Certifications
 *
 * @package Tutor\Certificate
 * @subpackage Tutor\MyCertifications
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$user_id = get_current_user_id();
$certificates = get_user_meta( $user_id, 'certificates', true );

if ( ! empty( $certificates ) ) {
    echo '<h2>' . esc_html__( 'My Certifications', 'tutor' ) . '</h2>';
    echo '<ul>';
    foreach ( $certificates as $course_id => $certificate_url ) {
        $course_title = get_the_title( $course_id );
        echo '<li>';
        echo '<a href="' . esc_url( $certificate_url ) . '" download>' . esc_html( $course_title ) . '</a>';
        echo '</li>';
    }
    echo '</ul>';
} else {
    echo '<p>' . esc_html__( 'No certifications available.', 'tutor' ) . '</p>';
}
?>
