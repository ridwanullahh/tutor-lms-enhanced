<?php

/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

if ( tutor_utils()->get_option( 'enable_profile_completion' ) ) {
	$profile_completion = tutor_utils()->user_profile_completion();
	$is_instructor      = tutor_utils()->is_instructor(null, true);
	$total_count        = count( $profile_completion );
	$incomplete_count   = count(
		array_filter(
			$profile_completion,
			function( $data ) {
				return ! $data['is_set'];
			}
		)
	);
	$complete_count     = $total_count - $incomplete_count;

	if ( $is_instructor ) {
		if ( isset($total_count) && isset($incomplete_count) && $incomplete_count <= $total_count ) {
			?>
			<div class="tutor-profile-completion tutor-card tutor-px-32 tutor-py-24 tutor-mb-40">
				<div class="tutor-row tutor-gx-0">
					<div class="tutor-col-lg-7 <?php echo tutor_utils()->is_instructor() ? 'tutor-profile-completion-content-admin' : ''; ?>">
						<div class="tutor-fs-5 tutor-fw-medium tutor-color-black">
							<?php esc_html_e( 'Complete Your Profile', 'tutor' ); ?>
						</div>

						<div class="tutor-row tutor-align-items-center tutor-mt-12">
							<div class="tutor-col">
								<div class="tutor-row tutor-gx-1">
									<?php for ( $i = 1; $i <= $total_count; $i++ ) : ?>
										<div class="tutor-col">
											<div class="tutor-progress-bar" style="--tutor-progress-value: <?php echo $i > $complete_count ? 0 : 100; ?>%; height: 8px;"><div class="tutor-progress-value" area-hidden="true"></div></div>
										</div>
									<?php endfor; ?>
								</div>
							</div>

							<div class="tutor-col-auto">
								<span class="tutor-round-box tutor-my-n20">
									<i class="tutor-icon-trophy" area-hidden="true"></i>
								</span>
							</div>
						</div>

						<div class="tutor-fs-6 tutor-mt-20">
							<?php
								$profile_complete_text = __("Please complete profile", "tutor");
								if($complete_count > ( $total_count / 2 ) && $complete_count < $total_count) {
									$profile_complete_text = __("You are almost done", "tutor");
								} else if($complete_count === $total_count) {
									$profile_complete_text = __("Thanks for completing your profile", "tutor");
								}
								$profile_complete_status = $profile_complete_text;
							?>

							<span class="tutor-color-muted"><?php echo $profile_complete_status ?>:</span>
							<span><?php echo $complete_count . '/' . $total_count; ?></span>
						</div>
					</div>

					<div class="tutor-col-lg-1 tutor-text-center tutor-my-24 tutor-my-lg-n24">
						<div class="tutor-vr tutor-d-none tutor-d-lg-inline-flex"></div>
						<div class="tutor-hr tutor-d-flex tutor-d-lg-none"></div>
					</div>

					<div class="tutor-col-lg-4 tutor-d-flex tutor-flex-column tutor-justify-center">
						<?php
						$i = 0;
						foreach ( $profile_completion as $key => $data ) {
							$is_set = $data['is_set']; // Whether the step is done or not
							?>
								<div class="tutor-d-flex tutor-align-items-center<?php echo $i < (count($profile_completion) - 1) ? ' tutor-mb-8' : ''; ?>">
									<?php if ( $is_set ) : ?>
										<span class="tutor-icon-circle-mark-line tutor-color-success tutor-mr-8"></span>
									<?php else : ?>
										<span class="tutor-icon-circle-times-line tutor-color-warning tutor-mr-8"></span>
									<?php endif; ?>

									<span class="<?php echo $is_set ? 'tutor-color-secondary' : 'tutor-color-muted'; ?>">
										<?php echo $data['label_html']; ?>
									</span>
								</div>
								<?php
								$i++;
						}
						?>
					</div>
				</div>
			</div>
			<?php
		}
	} else {
		if ( ! $profile_completion['_tutor_profile_photo']['is_set'] ) {
			$alert_message = sprintf(
				'<div class="tutor-alert tutor-primary tutor-mb-20">
					<div class="tutor-alert-text">
						<span class="tutor-alert-icon tutor-fs-4 tutor-icon-circle-info tutor-mr-12"></span>
						<span>
							%s
						</span>
					</div>
					<div class="alert-btn-group">
						<a href="%s" class="tutor-btn tutor-btn-sm">Click Here</a>
					</div>
				</div>',
				$profile_completion['_tutor_profile_photo']['label_html'],
				tutor_utils()->tutor_dashboard_url( 'settings' )
			);

			echo $alert_message;
		}
	}
}
?>

<div class="tutor-fs-5 tutor-fw-medium tutor-color-black tutor-capitalize-text tutor-mb-24 tutor-dashboard-title"><?php _e( 'Dashboard', 'tutor' ); ?></div>
<div class="tutor-dashboard-content-inner">
	<?php
	$enrolled_course   = tutor_utils()->get_enrolled_courses_by_user();
	$completed_courses = tutor_utils()->get_completed_courses_ids_by_user();
	$total_students    = tutor_utils()->get_total_students_by_instructor( get_current_user_id() );
	$my_courses        = tutor_utils()->get_courses_by_instructor( get_current_user_id(), 'publish' );
	$earning_sum       = tutor_utils()->get_earning_sum();

	$enrolled_course_count                          = $enrolled_course ? $enrolled_course->post_count : 0;
	$completed_course_count                         = count( $completed_courses );
	$active_course_count                            = $enrolled_course_count - $completed_course_count;
	$active_course_count < 0 ? $active_course_count = 0 : 0;

	$status_translations = array(
		'publish' => __( 'Published', 'tutor' ),
		'pending' => __( 'Pending', 'tutor' ),
		'trash'   => __( 'Trash', 'tutor' ),
	);

	?>
	<div class="tutor-row tutor-gx-lg-4">
		<div class="tutor-col-lg-6 tutor-col-xl-4 tutor-mb-16 tutor-mb-lg-32">
			<div class="tutor-card tutor-d-flex tutor-flex-lg-column tutor-align-items-center tutor-text-lg-center tutor-px-12 tutor-px-lg-24 tutor-py-8 tutor-py-lg-32">
				<span class="tutor-round-box tutor-mr-12 tutor-mr-lg-0 tutor-mb-lg-12">
					<i class="tutor-icon-book-open" area-hidden="true"></i>
				</span>
				<div class="tutor-fs-3 tutor-fw-bold tutor-d-none tutor-d-lg-block"><?php echo esc_html( $enrolled_course_count ); ?></div>
				<div class="tutor-fs-7 tutor-color-secondary"><?php esc_html_e( 'Enrolled Courses', 'tutor' ); ?></div>
				<div class="tutor-fs-4 tutor-fw-bold tutor-d-block tutor-d-lg-none tutor-ml-auto"><?php echo esc_html( $enrolled_course_count ); ?></div>
			</div>
		</div>

		<div class="tutor-col-lg-6 tutor-col-xl-4 tutor-mb-16 tutor-mb-lg-32">
			<div class="tutor-card tutor-d-flex tutor-flex-lg-column tutor-align-items-center tutor-text-lg-center tutor-px-12 tutor-px-lg-24 tutor-py-8 tutor-py-lg-32">
				<span class="tutor-round-box tutor-mr-12 tutor-mr-lg-0 tutor-mb-lg-12">
					<i class="tutor-icon-mortarboard-o" area-hidden="true"></i>
				</span>
				<div class="tutor-fs-3 tutor-fw-bold tutor-d-none tutor-d-lg-block"><?php echo esc_html( $active_course_count ); ?></div>
				<div class="tutor-fs-7 tutor-color-secondary"><?php esc_html_e( 'Active Courses', 'tutor' ); ?></div>
				<div class="tutor-fs-4 tutor-fw-bold tutor-d-block tutor-d-lg-none tutor-ml-auto"><?php echo esc_html( $active_course_count ); ?></div>
			</div>
		</div>

		<div class="tutor-col-lg-6 tutor-col-xl-4 tutor-mb-16 tutor-mb-lg-32">
			<div class="tutor-card tutor-d-flex tutor-flex-lg-column tutor-align-items-center tutor-text-lg-center tutor-px-12 tutor-px-lg-24 tutor-py-8 tutor-py-lg-32">
				<span class="tutor-round-box tutor-mr-12 tutor-mr-lg-0 tutor-mb-lg-12">
					<i class="tutor-icon-trophy" area-hidden="true"></i>
				</span>
				<div class="tutor-fs-3 tutor-fw-bold tutor-d-none tutor-d-lg-block"><?php echo esc_html( $completed_course_count ); ?></div>
				<div class="tutor-fs-7 tutor-color-secondary"><?php esc_html_e( 'Completed Courses', 'tutor' ); ?></div>
				<div class="tutor-fs-4 tutor-fw-bold tutor-d-block tutor-d-lg-none tutor-ml-auto"><?php echo esc_html( $completed_course_count ); ?></div>
			</div>
		</div>

		<?php
		if ( current_user_can( tutor()->instructor_role ) ) :
			?>
			<div class="tutor-col-lg-6 tutor-col-xl-4 tutor-mb-16 tutor-mb-lg-32">
				<div class="tutor-card tutor-d-flex tutor-flex-lg-column tutor-align-items-center tutor-text-lg-center tutor-px-12 tutor-px-lg-24 tutor-py-8 tutor-py-lg-32">
					<span class="tutor-round-box tutor-mr-12 tutor-mr-lg-0 tutor-mb-lg-12">
						<i class="tutor-icon-user-graduate" area-hidden="true"></i>
					</span>
					<div class="tutor-fs-3 tutor-fw-bold tutor-d-none tutor-d-lg-block"><?php echo esc_html( $total_students ); ?></div>
					<div class="tutor-fs-7 tutor-color-secondary"><?php esc_html_e( 'Total Students', 'tutor' ); ?></div>
					<div class="tutor-fs-4 tutor-fw-bold tutor-d-block tutor-d-lg-none tutor-ml-auto"><?php echo esc_html( $total_students ); ?></div>
				</div>
			</div>

			<div class="tutor-col-lg-6 tutor-col-xl-4 tutor-mb-16 tutor-mb-lg-32">
				<div class="tutor-card tutor-d-flex tutor-flex-lg-column tutor-align-items-center tutor-text-lg-center tutor-px-12 tutor-px-lg-24 tutor-py-8 tutor-py-lg-32">
					<span class="tutor-round-box tutor-mr-12 tutor-mr-lg-0 tutor-mb-lg-12">
						<i class="tutor-icon-box-open" area-hidden="true"></i>
					</span>
					<div class="tutor-fs-3 tutor-fw-bold tutor-d-none tutor-d-lg-block"><?php echo esc_html( count( $my_courses ) ); ?></div>
					<div class="tutor-fs-7 tutor-color-secondary"><?php esc_html_e( 'Total Courses', 'tutor' ); ?></div>
					<div class="tutor-fs-4 tutor-fw-bold tutor-d-block tutor-d-lg-none tutor-ml-auto"><?php echo esc_html( count( $my_courses ) ); ?></div>
				</div>
			</div>

			<div class="tutor-col-lg-6 tutor-col-xl-4 tutor-mb-16 tutor-mb-lg-32">
				<div class="tutor-card tutor-d-flex tutor-flex-lg-column tutor-align-items-center tutor-text-lg-center tutor-px-12 tutor-px-lg-24 tutor-py-8 tutor-py-lg-32">
					<span class="tutor-round-box tutor-mr-12 tutor-mr-lg-0 tutor-mb-lg-12">
						<i class="tutor-icon-coins" area-hidden="true"></i>
					</span>
					<div class="tutor-fs-3 tutor-fw-bold tutor-d-none tutor-d-lg-block"><?php echo tutor_utils()->tutor_price( $earning_sum->instructor_amount ); ?></div>
					<div class="tutor-fs-7 tutor-color-secondary"><?php esc_html_e( 'Total Earnings', 'tutor' ); ?></div>
					<div class="tutor-fs-4 tutor-fw-bold tutor-d-block tutor-d-lg-none tutor-ml-auto"><?php echo tutor_utils()->tutor_price( $earning_sum->instructor_amount ); ?></div>
				</div>
			</div>
			<?php
		endif;
		?>
	</div>
</div>

<?php
/**
 * Active users in progress courses
 */
$placeholder_img     = tutor()->url . 'assets/images/placeholder.svg';
$courses_in_progress = tutor_utils()->get_active_courses_by_user( get_current_user_id() );
?>

<?php if ( tutor_utils()->is_instructor() ) : ?>
	<div class="tutor-frontend-dashboard-course-progress">
		<div class="tutor-fs-5 tutor-fw-medium tutor-color-black tutor-capitalize-text tutor-mb-24">
			<?php esc_html_e( 'In Progress Courses', 'tutor' ); ?>
		</div>
		<?php if ( $courses_in_progress && $courses_in_progress->have_posts() ) : ?>
			<?php
			while ( $courses_in_progress->have_posts() ) :
				$courses_in_progress->the_post();
				$tutor_course_img = get_tutor_course_thumbnail_src();
				$course_rating    = tutor_utils()->get_course_rating( get_the_ID() );
				$course_progress  = tutor_utils()->get_course_completed_percent( get_the_ID(), 0, true );
				$completed_number = 0 === (int) $course_progress['completed_count'] ? 1 : (int) $course_progress['completed_count'];
				?>
			<div class="tutor-course-progress-item tutor-card tutor-mb-20">
				<div class="tutor-row tutor-gx-0">
					<div class="tutor-col-lg-5">
						<div class="tutor-ratio tutor-ratio-3x2">
							<img class="tutor-card-image-left" src="<?php echo empty(esc_url($tutor_course_img)) ? $placeholder_img : esc_url($tutor_course_img) ?>" alt="<?php the_title(); ?>" loading="lazy">
						</div>
					</div>

					<div class="tutor-col-lg-7 tutor-align-self-center">
						<div class="tutor-card-body">
							<?php if ( $course_rating ) : ?>
								<div class="tutor-ratings tutor-mb-4">
									<?php tutor_utils()->star_rating_generator( $course_rating->rating_avg ); ?>
									<div class="tutor-ratings-count">
										<?php echo esc_html( number_format( $course_rating->rating_avg, 2 ) ); ?>
									</div>
								</div>
							<?php endif; ?>

							<div class="tutor-course-progress-item-title tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-12">
								<?php the_title(); ?>
							</div>

							<div class="tutor-d-flex tutor-fs-7 tutor-mb-32">
								<span class="tutor-color-muted tutor-mr-4"><?php esc_html_e( 'Completed Lessons:', 'tutor' ); ?></span>
								<span class="tutor-fw-medium tutor-color-black">
									<span>
										<?php echo esc_html( $course_progress['completed_count'] ); ?>
									</span>
									<?php esc_html_e( 'of', 'tutor' ); ?>
									<span>
										<?php echo esc_html( $course_progress['total_count'] ); ?>
									</span>
									<?php echo esc_html( _n( 'lesson', 'lessons', $completed_number, 'tutor' ) ); ?>
								</span>
							</div>

							<div class="tutor-row tutor-align-items-center">
								<div class="tutor-col">
									<div class="tutor-progress-bar tutor-mr-16" style="--tutor-progress-value:<?php echo esc_attr( $course_progress['completed_percent'] ); ?>%"><span class="tutor-progress-value" area-hidden="true"></span></div>
								</div>

								<div class="tutor-col-auto">
									<span class="progress-percentage tutor-fs-7 tutor-color-muted">
										<span class="tutor-fw-medium tutor-color-black ">
											<?php echo esc_html( $course_progress['completed_percent'] . '%' ); ?>
										</span><?php esc_html_e( 'Complete', 'tutor' ); ?>
									</span>
								</div>
							</div>
						</div>
					</div>
					<a class="tutor-stretched-link" href="<?php the_permalink(); ?>"></a>
				</div>
			</div>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		<?php else : ?>
			<?php tutor_utils()->tutor_empty_state( tutor_utils()->not_found_text() ); ?>
		<?php endif; ?>
	</div>
<?php endif; ?>

<?php
$instructor_course = tutor_utils()->get_courses_for_instructors( get_current_user_id() );

if ( count( $instructor_course ) ) {
	$course_badges = array(
		'publish' => 'success',
		'pending' => 'warning',
		'trash'   => 'danger',
	);

	?>
		<div class="popular-courses-heading-dashboard tutor-d-flex tutor-justify-between tutor-mb-24 tutor-mt-md-40 tutor-mt-0">
			<span class="tutor-fs-5 tutor-fw-medium tutor-color-black"><?php esc_html_e( 'My Courses', 'tutor' ); ?></span>
			<a class="tutor-btn tutor-btn-ghost" href="<?php echo esc_url( tutor_utils()->tutor_dashboard_url( 'my-courses' ) ); ?>">
				<?php esc_html_e( 'View All', 'tutor' ); ?>
			</a>
		</div>
		
		<div class="tutor-dashboard-content-inner">
			<table class="tutor-ui-table tutor-ui-table-responsive table-popular-courses">
				<thead>
					<tr>
						<th>
							<span class="tutor-fs-7 tutor-color-secondary">
								<?php esc_html_e( 'Course Name', 'tutor' ); ?>
							</span>
						</th>
						<th class="tutor-table-rows-sorting">
							<div class="tutor-d-inline-flex tutor-align-items-center tutor-color-secondary">
								<span class="tutor-fs-7"><?php esc_html_e( 'Enrolled', 'tutor' ); ?></span>
								<span class="tutor-icon-ordering-a-z a-to-z-sort-icon"></span>
							</div>
						</th>
						<th class="tutor-table-rows-sorting">
							<div class="tutor-d-inline-flex tutor-align-items-center tutor-color-secondary">
								<span class="tutor-fs-7"><?php esc_html_e( 'Rating', 'tutor' ); ?></span>
								<span class="tutor-icon-ordering-a-z a-to-z-sort-icon"></span>
							</div>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php if ( is_array( $instructor_course ) && count( $instructor_course ) ) : ?>
						<?php
						foreach ( $instructor_course as $course ) :
							$enrolled      = tutor_utils()->count_enrolled_users_by_course( $course->ID );
							$course_status = isset( $status_translations[ $course->post_status ] ) ? $status_translations[ $course->post_status ] : __( $course->post_status, 'tutor' );
							$course_rating = tutor_utils()->get_course_rating( $course->ID );
							$course_badge  = isset( $course_badges[ $course->post_status ] ) ? $course_badges[ $course->post_status ] : 'dark';

							?>
							<tr>
								<td data-th="<?php esc_html_e( 'Course Name', 'tutor' ); ?>" class="column-fullwidth">
									<div class="td-course  tutor-fs-6 tutor-fw-medium  tutor-color-black">
										<a href="<?php echo esc_url( get_the_permalink( $course->ID ) ); ?>" target="_blank">
											<?php esc_html_e( $course->post_title ); ?>
										</a>
									</div>
								</td>
								<td data-th="<?php esc_html_e( 'Enrolled', 'tutor' ); ?>">
									<span class="tutor-fs-7 tutor-fw-medium tutor-color-black">
										<?php esc_html_e( $enrolled ); ?>
									</span>
								</td>
								<td data-th="<?php esc_html_e( 'Rating', 'tutor' ); ?>">
									<div class="td-tutor-rating tutor-fs-6 tutor-color-secondary">
										<?php tutor_utils()->star_rating_generator_v2( $course_rating->rating_avg, null, true ); ?>
									</div>
								</td>
							</tr>
							<?php endforeach; ?>
						<?php else : ?>
							<tr>
								<td colspan="100%" class="column-empty-state">
									<?php tutor_utils()->tutor_empty_state( tutor_utils()->not_found_text() ); ?>
								</td>
							</tr>
						<?php endif; ?>
				</tbody>
			</table>
		</div>
	<?php
}
?>
