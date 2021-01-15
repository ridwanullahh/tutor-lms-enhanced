<?php
if ( ! defined( 'ABSPATH' ) )
exit;
/**
 * Template for displaying Announcements
 *
 * @since v.1.7.9
 *
 * @author Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.7.9
 */
$per_page           = 10;
$paged              = isset( $_GET['paged'] ) ? $_GET['paged'] : 1;

$order_filter       = isset($_GET['order']) ? $_GET['order'] : 'DESC';
$search_filter      = isset($_GET['search']) ? $_GET['search'] : '';
//announcement's parent
$course_id          = isset($_GET['course-id']) ? $_GET['course-id'] : ''; 
$date_filter        = isset($_GET['date']) ? $_GET['date'] : ''; 

$year               = date('Y', strtotime($date_filter));
$month              = date('m', strtotime($date_filter));
$day                = date('d', strtotime($date_filter));

$args = array(
    'post_type'         => 'tutor_announcements',
    'post_status'       => 'publish',
    's'                 => sanitize_text_field($search_filter),
    'post_parent'       => sanitize_text_field($course_id),
    'posts_per_page'    => sanitize_text_field($per_page),
    'paged'             => sanitize_text_field($paged),
    'orderBy'           => 'ID',
    'order'             => sanitize_text_field($order_filter),

);
if(!empty($date_filter)){
    $args['date_query'] = array(
        array(
            'year'      => $year,
            'month'     => $month,
            'day'       => $day
        )
    );
}
$the_query = new WP_Query($args);

//get courses
$courses = tutils()->get_courses();

?>

<div class="tutor-dashboard-announcement-sorting-wrap">

    <div class="tutor-dashboard-announcement-form-group">
        <label for="">
            <?php _e('Courses', 'tutor'); ?>
        </label>
        <div class="tutor-dashboard-announcement-form-control">

            <select class="tutor-report-category tutor-announcement-course-sorting">
                <?php if(empty($course_id)):?>
                        <option value="">Select course</option>
                <?php endif;?>
                <?php if($courses):?>
                <?php foreach($courses as $course):?>

                    <option value="<?= esc_attr($course->ID)?>" <?php selected($course_id,$course->ID,'selected')?>>
                        <?= $course->post_title;?>
                    </option>
                <?php endforeach;?>
                <?php else:?>
                <option value="">No course found</option>
                <?php endif;?>
            </select>
        </div>
    </div>

    <div class="tutor-dashboard-announcement-form-group">
        <label><?php _e('Sort By', 'tutor'); ?></label>
        <div class="tutor-dashboard-announcement-form-control">
            <select class="tutor-announcement-order-sorting">
                <option <?php selected( $order_filter, 'ASC' ); ?>>ASC</option>
                <option <?php selected( $order_filter, 'DESC' ); ?>>DESC</option>
            </select>
        </div>
    </div>

    <div class="tutor-dashboard-announcement-form-group">
        <label><?php _e('Date', 'tutor'); ?></label>
        <div class="date-range-input tutor-dashboard-announcement-form-control">
            <input type="text" class="tutor-announcement-date-sorting" id="tutor-announcement-datepicker" value="<?php echo $date_filter; ?>" autocomplete="off"/>
            <i class="tutor-icon-calendar"></i>
        </div>
    </div>
</div>

<div class="tutor-announcement-table-wrap">
    <div class="tutor-list-header tutor-announcements-header">
        <div class="heading">
            <h3><?php _e('Announcements', 'tutor'); ?></h3>
        </div>
        <button type="button" class="tutor-btn bordered-btn tutor-announcement-add-new">
            <?php esc_html_e('Add new','tutor');?>
        </button>
    </div>
   
        <table class="tutor-dashboard-info-table tutor-dashboard-assignment-table">
            <thead>
                <tr>
                    <th style="width:20%"><?php _e('Date', 'tutor'); ?></th>
                    <th style="text-align:left"><?php _e('Announcements', 'tutor'); ?></th>

                </tr>
            </thead>
            <tbody>
                    <?php if($the_query->have_posts()):?>
                    <?php foreach($the_query->posts as $post):?>
                    <?php
                        $course = get_post($post->post_parent);
                        $dateObj = date_create($post->post_date);
                        $date_format = date_format($dateObj,'F j, Y, g:i a');
                    ?>
                        <tr>
                            <td class="tutor-announcement-date"><?= esc_html($date_format);?></td>
                            <td class="tutor-announcement-content-wrap">
                                <div class="tutor-announcement-content">
                                    <span>
                                        <?= esc_html($post->post_title);?>
                                    </span>
                                    <p>
                                        <?= $course? $course->post_title : '';?>
                                    </p>
                                </div>
                                <div class="tutor-announcement-buttons">
                                    <button type="button" announcement-title="<?= $post->post_title;?>" announcement-summary="<?= $post->post_content;?>" course-id="<?= $post->post_parent;?>" announcement-id="<?= $post->ID;?>" class="tutor-btn bordered-btn tutor-announcement-edit">
                                        <?php esc_html_e('Edit','tutor');?>
                                    </button>
                                    <button type="button" class="tutor-btn bordered-btn tutor-announcement-delete" announcement-id="<?= $post->ID;?>">
                                        <?php esc_html_e('Delete','tutor');?>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    <?php else:?>
                    <tr>
                        <td>
                            <?= esc_html_e('Announcements not found','tutor');?>
                        </td>
                    </tr>
                    <?php endif;?>
            </tbody>
        </table>
  
</div>

<!--pagination-->
<div class="tutor-pagination">
    <?php
        $big = 999999999; // need an unlikely integer
        
        echo paginate_links( array(
            'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format'    => '?paged=%#%',
            'current'   => $paged,
            'total'     => $the_query->max_num_pages
        ) );
    ?>
</div>
<!--pagination end-->

<?php
    include 'announcements/create.php';
    include 'announcements/update.php';
?>
