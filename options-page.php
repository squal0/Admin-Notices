<div id="wp_admin_notice_admin_wrapper" class="wrap wp_admin_notice_admin_wrapper">
	<h2>Admin Notices</h2>
	<p>
		<?php _e('This plugin allows you to show a simple notice to alert different user roles.') ?>
	</p>

	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-3">

		<!-- main content -->
		<div id="post-body-content">

			<div class="meta-box-sortables ui-sortable">

			<div class="postbox">
				<h3><span><?php _e('Settings');?></span></h3>
				<div class="inside">
				<form method="post" action="options.php">

					<?php settings_fields('wp_admin_notice_settings') ?>
					<table class="form-table">

						<tr valign="top">
							<th scope="row"><?php _e('Status') ?></th>
							<td>
							<label for="wp_admin_notice_options_radio1">
								<input type="radio" id="wp_admin_notice_options_radio1" name="wp_admin_notice_options[status]"
								   value="1" <?php echo $opts['status'] ? 'checked="checked"' : ''; ?> /> <?php _e('Enable') ?>
							</label>
							<br/>
							<label for="wp_admin_notice_options_radio2">
								<input type="radio" id="wp_admin_notice_options_radio2" name="wp_admin_notice_options[status]"
								   value="0" <?php echo !$opts['status'] ? 'checked="checked"' : ''; ?> /> <?php _e('Disable') ?>
							</label>
							</td>
						</tr>
						
							
						 <tr>
							<th scope="row"><?php _e('User Role') ?></th>

								<td>
									<label for="wp_admin_notice_options_role">
									<select id="wp_admin_notice_options_role" name="wp_admin_notice_options[role]">
										<option value="administrator" <?php echo $opts['role']=='administrator' ? 'selected' : '';?>>Administrator</option>
										<option value="editor"   <?php echo $opts['role']=='editor' ? 'selected' : '';?>>Editor</option>
										<option value="contributor"   <?php echo $opts['role']=='contributor' ? 'selected' : '';?>>Contributor</option>
										<option value="author"   <?php echo $opts['role']=='author' ? 'selected' : '';?>>Author</option>
									</select>
								</label>
								<p><?php _e('Select the User role that can view the notifications') ?></p>
							</td>
						</tr>

						<tr>
								<th scope="row"><?php _e('Size') ?></th>
								<td>
									<input type="text" id="wp_admin_notice_options_notice" class="widefat"
									name="wp_admin_notice_options[font_size]"
									value="<?php echo esc_attr($opts['font_size']); ?>" />
									<p>
										<?php _e('Set font size of the notice,default font size is 12px.') ?>
									</p>
								</td>
											
						</tr>


						<tr>
							<th scope="row"><?php _e('Text Color') ?></th>
							<td>
							<label for="wp_admin_notice_options_text_color">
								<input type="text" id="wp_admin_notice_options_text_color" size="7"
								   name="wp_admin_notice_options[text_color]"
								   value="<?php echo esc_attr($opts['text_color']); ?>" />

								<div id="text_color_picker"></div> <!-- Used for old WP color picker WP < 3.5 -->
							</label>
							<p><?php _e('Set the text color for the notice,default color is #444') ?></p>
							</td>
						</tr>

						<tr>
							<th scope="row"><?php _e('Style') ?></th>
							<td>
								<label for="wp_admin_notice_options_style">
									<select id="wp_admin_notice_options_style" name="wp_admin_notice_options[style]">
										<option value="notice-success" <?php echo $opts['style']=='notice-success' ? 'selected' : '';?>>success</option>
										<option value="notice-error"   <?php echo $opts['style']=='notice-error' ? 'selected' : '';?>>error</option>
										<option value="notice-info"   <?php echo $opts['style']=='notice-info' ? 'selected' : '';?>>info</option>
										<option value="notice-warning"   <?php echo $opts['style']=='notice-warning' ? 'selected' : '';?>>warning</option>
									</select>
								</label>
								<p><?php _e('Select the display style for notice') ?></p>
							</td>
						</tr>
							
						<tr>
							<th scope="row"><?php _e('Start Date') ?></th>
							<td>
								<input type="date" id="wp_admin_notice_options_notice" class="widefat"
								   name="wp_admin_notice_options[start_date]"
								   value="<?php echo esc_attr($opts['start_date']); ?>" />
							<p>
								<?php _e('Example: mm/dd/yyyy.') ?>
							</p>
							</td>
						</tr>
						
						<tr>
							<th scope="row"><?php _e('End Date') ?></th>
							<td>
								<input type="date" id="wp_admin_notice_options_notice" class="widefat date1"
								   name="wp_admin_notice_options[end_date]"
								   value="<?php echo esc_attr($opts['end_date']); ?>" />
							<p>
								<?php _e('Example: mm/dd/yyyy.') ?>
							</p>
							</td>
						</tr>	
						
					</table>

					<div class="wrap">
						<h4><?php _e('Custom Notice') ?></h4>
						<textarea type="text" id="wp_admin_notice_options_notice" class="widefat date1"
							   name="wp_admin_notice_options[notice]"
							   value="<?php echo esc_attr($opts['notice']); ?>"  rows="3" required placeholder="Enter your custom message here..."></textarea>
					</div>

					<p class="submit">
						<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
					</p>

				</form>
				</div> <!-- .inside -->
			</div> <!-- .postbox -->

			</div> <!-- .meta-box-sortables .ui-sortable -->

		</div> <!-- post-body-content -->

		</div> <!-- #post-body .metabox-holder .columns-3 -->

		<br class="clear">
</div> <!-- #poststuff -->
	
<script type='text/javascript'>
	$('.date1').datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		dateFormat: "m/d/yy"
	});

</script>