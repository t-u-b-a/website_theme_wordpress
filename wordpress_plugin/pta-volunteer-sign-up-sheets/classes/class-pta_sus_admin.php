<?php
/**
* Admin pages
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if (!class_exists('PTA_SUS_Options')) include_once(dirname(__FILE__).'/class-pta_sus_options.php');


class PTA_SUS_Admin {

	private $admin_settings_slug = 'pta-sus-settings';
	public $options_page;
	private $member_directory_active;
	public $data;
	public $main_options;

	public function __construct() {
		global $plugin_page;
		$this->page_url = admin_url("admin.php?page=$plugin_page");
		$this->data = new PTA_SUS_Data();

		add_action('admin_enqueue_scripts', array($this, 'add_scripts_to_admin'));
		$this->options_page = new PTA_SUS_Options();

		$this->main_options = get_option( 'pta_volunteer_sus_main_options' );

		add_menu_page(__('Sign-up Sheets', 'pta_volunteer_sus'), __('Sign-up Sheets', 'pta_volunteer_sus'), 'manage_signup_sheets', $this->admin_settings_slug.'_sheets', array($this, 'admin_sheet_page'));
		add_submenu_page($this->admin_settings_slug.'_sheets', __('Sign-up Sheets', 'pta_volunteer_sus'), __('All Sheets', 'pta_volunteer_sus'), 'manage_signup_sheets', $this->admin_settings_slug.'_sheets', array($this, 'admin_sheet_page'));
		$sheet_page_suffix = add_submenu_page($this->admin_settings_slug.'_sheets', __('Add New Sheet', 'pta_volunteer_sus'), __('Add New', 'pta_volunteer_sus'), 'manage_signup_sheets', $this->admin_settings_slug.'_modify_sheet', array($this, 'admin_modify_sheet_page'));
		add_submenu_page($this->admin_settings_slug.'_sheets', __('Email Volunteers', 'pta_volunteer_sus'), __('Email Volunteers', 'pta_volunteer_sus'), 'manage_signup_sheets', $this->admin_settings_slug.'_email', array($this, 'email_volunteers_page'));
		add_submenu_page($this->admin_settings_slug.'_sheets', __('Settings', 'pta_volunteer_sus'), __('Settings', 'pta_volunteer_sus'), 'manage_signup_sheets', $this->admin_settings_slug.'_settings', array($this->options_page, 'admin_options'));
		add_submenu_page($this->admin_settings_slug.'_sheets', __('CRON Functions', 'pta_volunteer_sus'), __('CRON Functions', 'pta_volunteer_sus'), 'manage_signup_sheets', $this->admin_settings_slug.'_cron', array($this, 'admin_reminders_page'));
		add_submenu_page($this->admin_settings_slug.'_sheets', __('Add Ons', 'pta_volunteer_sus'), __('Add Ons', 'pta_volunteer_sus'), 'manage_signup_sheets', $this->admin_settings_slug.'_addons', array($this, 'admin_addons_page'));

		if (is_plugin_active( 'pta-member-directory/pta-member-directory.php' )) {
			$this->member_directory_active = true;
		} else {
			$this->member_directory_active = false;
		}

		add_action('admin_print_scripts-' . $sheet_page_suffix, array($this, 'add_sheet_admin_scripts') );       
	}

	/**
	 * Enqueue plugin's admin scripts
	 */
	public function add_scripts_to_admin() {
		wp_enqueue_style( 'pta-admin-style', plugins_url( '../assets/css/pta-admin-style.css', __FILE__ ) );
	}

	public function add_sheet_admin_scripts() {
		wp_enqueue_script( 'jquery-plugin', plugins_url( '../assets/js/jquery.plugin.min.js' , __FILE__ ), array( 'jquery' ) );
		wp_enqueue_script( 'jquery-datepick', plugins_url( '../assets/js/jquery.datepick.js' , __FILE__ ), array( 'jquery' ), '5.0.0' );
		wp_enqueue_script( 'jquery-ui-timepicker', plugins_url( '../assets/js/jquery.ui.timepicker.js' , __FILE__ ), array( 'jquery', 'jquery-ui-core', 'jquery-ui-position' ) );
		wp_enqueue_script( 'pta-sus-backend', plugins_url( '../assets/js/backend.js' , __FILE__ ), array( 'jquery' ) );
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_style( 'pta-jquery.datepick', plugins_url( '../assets/css/jquery.datepick.css', __FILE__ ) );
		wp_enqueue_style( 'pta-jquery.ui.timepicker', plugins_url( '../assets/css/jquery.ui.timepicker.css', __FILE__ ) );
		wp_enqueue_style( 'pta-jquery-ui-1.10.0.custom', plugins_url( '../assets/css/jquery-ui-1.10.0.custom.min.css', __FILE__ ) );
		$translation_array = array('default_text' => __('Item you are bringing', 'pta_volunteer_sus') );
		wp_localize_script('pta-sus-backend', 'PTA_Backend_js', $translation_array);
	}


	public function admin_reminders_page() {
		$messages = '';
		$cleared_message = '';
		if ( $last = get_option( 'pta_sus_last_reminders' ) ) {
			$messages .= '<hr/>';
			$messages .= '<h4>' . __('Last reminders sent:', 'pta_volunteer_sus'). '</h4>';
			$messages .= '<p>' . sprintf(__('Date: %s', 'pta_volunteer_sus'), date_i18n(get_option('date_format'), $last['time'])) . '<br/>';
			$messages .= sprintf(__('Time: %s', 'pta_volunteer_sus'), date_i18n(get_option("time_format"), $last['time'])) . '<br/>';        
			$messages .= sprintf( _n( '1 reminder sent', '%d reminders sent', $last['num'], 'pta_volunteer_sus'), $last['num'] ) . '</p>';
			$messages .= '<h4>' . __('Last reminder check:', 'pta_volunteer_sus'). '</h4>';
			$messages .= '<p>' . sprintf(__('Date: %s', 'pta_volunteer_sus'), date_i18n(get_option('date_format'), $last['last'])) . '<br/>';
			$messages .= sprintf(__('Time: %s', 'pta_volunteer_sus'), date_i18n(get_option("time_format"), $last['last'])) . '<br/>';
			$messages .= '<hr/>';

		}
		if (isset($_GET['action']) && 'reminders' == $_GET['action']) {
			check_admin_referer( 'pta-sus-reminders', '_sus_nonce');
			if(!class_exists('PTA_SUS_Emails')) {
				include_once(dirname(__FILE__).'/class-pta_sus_emails.php');
			}
			$emails = new PTA_SUS_Emails();
			$num = $emails->send_reminders();
			$results = sprintf( _n( '1 reminder sent', '%d reminders sent', $num, 'pta_volunteer_sus'), $num );
			$messages .= '<div class="updated">'.$results.'</div>';
		}
		if (isset($_GET['action']) && 'clear_signups' == $_GET['action'] ) {
			check_admin_referer( 'pta-sus-clear-signups', '_sus_nonce');
			$num = $this->data->delete_expired_signups();
			$results = sprintf( _n( '1 signup cleared', '%d signups cleared', $num, 'pta_volunteer_sus'), $num );
			$cleared_message = '<div class="updated">'.$results.'</div>';
		}
		$reminders_link = add_query_arg(array('action' => 'reminders'));
		$nonced_reminders_link = wp_nonce_url( $reminders_link, 'pta-sus-reminders', '_sus_nonce');
		$clear_signups_link = add_query_arg(array('action' => 'clear_signups'));
		$nonced_clear_signups_link = wp_nonce_url( $clear_signups_link, 'pta-sus-clear-signups', '_sus_nonce');
		echo '<div class="wrap pta_sus">';
		echo '<h2>'.__('CRON Functions', 'pta_volunteer_sus').'</h2>';
		echo '<h3>'.__('Volunteer Reminders', 'pta_volunteer_sus').'</h3>';
		echo '<p>'.__("The system automatically checks if it needs to send reminders hourly via a CRON function. If you are testing, or don't want to wait for the next CRON job to be triggered, you can trigger the reminders function with the button below.", "pta_volunteer_sus") . '</p>';
		echo $messages;
		echo '<p><a href="'.esc_url($nonced_reminders_link).'" class="button-primary">'.__('Send Reminders', 'pta_volunteer_sus').'</a></p>';
		echo '<hr/>';
		echo '<h3>'.__('Clear Expired Signups', 'pta_volunteer_sus').'</h3>';
		echo '<p>'.__("If you have disabled the automatic clearing of expired signups, you can use this to clear ALL expired signups from ALL sheets. NOTE: THIS ACTION CAN NOT BE UNDONE!", "pta_volunteer_sus") . '</p>';
		echo '<p><a href="'.esc_url($nonced_clear_signups_link).'" class="button-secondary">'.__('Clear Expired Signups', 'pta_volunteer_sus').'</a></p>';
		echo $cleared_message;
		echo '</div>';
	}

	/**
	 * Admin Page: Sheets
	 */
	function admin_sheet_page() {
		if (!current_user_can('manage_options') && !current_user_can('manage_signup_sheets'))  {
			wp_die( __( 'You do not have sufficient permissions to access this page.', 'pta_volunteer_sus' ) );
		}

		// SECURITY CHECK
		// Checks nonces for ALL actions
		if (isset($_GET['action'])) {
			check_admin_referer( $_GET['action'], '_sus_nonce');
		}
		// Remove signup record
		if (isset($_GET['action']) && $_GET['action'] == 'clear') {
			if (($result = $this->data->delete_signup($_GET['signup_id'])) === false) {
				echo '<div class="error"><p>'.sprintf( __('Error clearing spot (ID # %s)', 'pta_volunteer_sus'), esc_attr($_GET['signup_id']) ).'</p></div>';
			} else {
				if ($result > 0) echo '<div class="updated"><p>'.__('Spot has been cleared.', 'pta_volunteer_sus').'</p></div>';
			}
		}

		// Set Actons
		$trash = (!empty($_GET['action']) && $_GET['action'] == 'trash');
		$untrash = (!empty($_GET['action']) && $_GET['action'] == 'untrash');
		$delete = (!empty($_GET['action']) && $_GET['action'] == 'delete');
		$copy = (!empty($_GET['action']) && $_GET['action'] == 'copy');
		$view_signups = (!empty($_GET['action']) && $_GET['action'] == 'view_signups');
		$toggle_visibility = (!empty($_GET['action']) && $_GET['action'] == 'toggle_visibility');
		$edit = (!$trash && !$untrash && !$delete && !$copy && !$toggle_visibility && !empty($_GET['sheet_id']));

		$export_all_url = add_query_arg(array('pta-action' => 'export_all', 'sheet_id' => false), $this->page_url);
		$nonced_export_all_url = wp_nonce_url($export_all_url, 'pta-export');

		echo '<div class="wrap pta_sus">';
		echo ($edit || $view_signups) ? '<h2>'.__('Sheet Details', 'pta_volunteer_sus').'</h2>' : '<h2>'.__('Sign-up Sheets ', 'pta_volunteer_sus').'
			<a href="?page='.$this->admin_settings_slug.'_modify_sheet" class="add-new-h2">'.__('Add New', 'pta_volunteer_sus').'</a>
			<a href="'.esc_url($nonced_export_all_url).'" class="button-primary">'.__('Export ALL Data as CSV', 'pta_volunteer_sus').'</a>
			</h2>
			';

		$sheet_id = isset($_GET['sheet_id']) ? intval($_GET['sheet_id']) : 0;

		if ($untrash) {
			if (($result = $this->data->update_sheet(array('sheet_trash'=>0), $sheet_id)) === false) {
				echo '<div class="error"><p>'.__('Error restoring sheet.', 'pta_volunteer_sus').'</p></div>';
			} elseif ($result > 0) {
				echo '<div class="updated"><p>'.__('Sheet has been restored.', 'pta_volunteer_sus').'</p></div>';
			}
		} elseif ($trash) {
			if (($result = $this->data->update_sheet(array('sheet_trash'=>true), $sheet_id)) === false) {
				echo '<div class="error"><p>'.__('Error moving sheet to trash.', 'pta_volunteer_sus').'</p></div>';
			} elseif ($result > 0) {
				echo '<div class="updated"><p>'.__('Sheet has been moved to trash.', 'pta_volunteer_sus').'</p></div>';
			}
		} elseif ($delete) {
			if (($result = $this->data->delete_sheet($sheet_id)) === false) {
				echo '<div class="error"><p>'.__('Error permanently deleting sheet.', 'pta_volunteer_sus').'</p></div>';
			} elseif ($result > 0) {
				echo '<div class="updated"><p>'.__('Sheet has been permanently deleted.', 'pta_volunteer_sus').'</p></div>';
			}
		} elseif ($copy) {
			if (($new_id = $this->data->copy_sheet($sheet_id)) === false) {
				echo '<div class="error"><p>'.__('Error copying sheet.', 'pta_volunteer_sus').'</p></div>';
			} else {
				echo '<div class="updated"><p>'.__('Sheet has been copied to new sheet ID #', 'pta_volunteer_sus').$new_id.' (<a href="?page='.$this->admin_settings_slug.'_modify_sheet&amp;action=edit_sheet&amp;sheet_id='.$new_id.'">'.__('Edit', 'pta_volunteer_sus').'</a>).</p></div>';
			}
		} elseif ($toggle_visibility) {
			if ($toggled = $this->data->toggle_visibility($sheet_id) === false) {
				echo '<div class="error"><p>'.__('Error toggling sheet visibility.', 'pta_volunteer_sus').'</p></div>';
			}
		} elseif ($edit || $view_signups) {

			// View Single Sheet
			if (!($sheet = $this->data->get_sheet($sheet_id))) {
				echo '<p class="error">'.__('No sign-up sheet found.', 'pta_volunteer_sus').'</p>';
			} else {
				echo '
					<h2>'.esc_html($sheet->title).'</h2>
					<h4>'.__('Event Type: ', 'pta_volunteer_sus').esc_html($sheet->type).'</h4>                
					<h3>'.__('Signups', 'pta_volunteer_sus').'</h3>
					';

				// Tasks
				if (!($tasks = $this->data->get_tasks($sheet_id))) {
					echo '<p>'.__('No tasks were found.', 'pta_volunteer_sus').'</p>';
				} else {
					$all_task_dates = $this->data->get_all_task_dates((int)$sheet->id);
					echo '
						<table class="wp-list-table widefat" cellspacing="0">
						<thead>
						<tr>
						<th>'.__('Task/Item', 'pta_volunteer_sus').'</th>
						<th>'.__('Start Time', 'pta_volunteer_sus').'</th>
						<th>'.__('End Time', 'pta_volunteer_sus').'</th>
						<th>'.__('Name', 'pta_volunteer_sus').'</th>
						<th>'.__('E-mail', 'pta_volunteer_sus').'</th>
						<th>'.__('Phone', 'pta_volunteer_sus').'</th>
						<th>'.__('Item Details', 'pta_volunteer_sus').'</th>
						<th>'.__('Item Qty', 'pta_volunteer_sus').'</th>
						<th></th>
						</tr>
						</thead>
						<tbody>
						';
					foreach ($all_task_dates as $tdate) {
						// check if we want to show expired tasks and Skip any task whose date has already passed
						if ( !$this->main_options['show_expired_tasks']) {
							if ($tdate < date("Y-m-d") && "0000-00-00" != $tdate) continue;
						}

						if ("0000-00-00" == $tdate) {
							$show_date = false;
						} else {
							$show_date = mysql2date( get_option('date_format'), $tdate, $translate = true );
							echo '<tr><th colspan="8"><strong>'.$show_date.'</strong></th></tr>';
						}        
						foreach ($tasks as $task) {
							$task_dates = explode(',', $task->dates);
							if(!in_array($tdate, $task_dates)) continue;
							echo '<tr>';

							$i=1;
							$signups = $this->data->get_signups($task->id, $tdate);
							foreach ($signups AS $signup) {
								$clear_url = '?page='.$this->admin_settings_slug.'_sheets&amp;sheet_id='.$_GET['sheet_id'].'&amp;signup_id='.$signup->id.'&amp;action=clear';
								$nonced_clear_url = wp_nonce_url( $clear_url, 'clear', '_sus_nonce' );
								echo '
									<tr>
									<td>'.(($i === 1) ? esc_html($task->title) : '' ).'</td>
									<td>'.(("" == $task->time_start) ? __("N/A", 'pta_volunteer_sus') : date_i18n(get_option("time_format"), strtotime($task->time_start)) ).'</td>
									<td>'.(("" == $task->time_end) ? __("N/A", 'pta_volunteer_sus') : date_i18n(get_option("time_format"), strtotime($task->time_end)) ).'</td>
									<td>#'.$i.': <em>'.esc_html($signup->lastname).' '.esc_html($signup->firstname).'</em>
									<td>'.esc_html($signup->email).'</td>
									<td>'.esc_html($signup->phone).'</td>
									<td>'.esc_html($signup->item).'</td>
									<td>'.(int)($signup->item_qty).'</td>
									<td><span class="delete"><a href="'. esc_url($nonced_clear_url) . '">'.__('Clear Spot', 'pta_volunteer_sus').'</a></span></td>
									</tr>
									';
								if ('YES' === $task->enable_quantities) {
									$i += $signup->item_qty;
								} else {
									$i++;
								} 
							}
							// Remaining empty spots
							for ($i=$i; $i<=$task->qty; $i++) {
								echo '
									<tr>
									<td>'.(($i === 1) ? esc_html($task->title) : '' ).'</td>
									<td>'.(("" == $task->time_start) ? __("N/A", 'pta_volunteer_sus') : date_i18n(get_option("time_format"), strtotime($task->time_start)) ).'</td>
									<td>'.(("" == $task->time_end) ? __("N/A", 'pta_volunteer_sus') : date_i18n(get_option("time_format"), strtotime($task->time_end)) ).'</td>
									<td colspan="5">#'.$i.': '.__('(empty)', 'pta_volunteer_sus').'</td>
									</tr>
									';
							}

							echo '</tr>';
						}

					}
					
					$export_url = add_query_arg(array('pta-action' => 'export', 'sheet_id' => $sheet_id), $this->page_url);
					$export_transposed_url = add_query_arg(array('pta-action' => 'export_transposed', 'sheet_id' => $sheet_id), $this->page_url);
					$nonced_export_url = wp_nonce_url($export_url, 'pta-export');
					$nonced_export_transposed_url = wp_nonce_url($export_transposed_url, 'pta-export');
					echo '
						</tbody>
						</table>
						<br />
						<a href="'.esc_url($nonced_export_url).'" class="button-primary">'.__('Export Sheet as CSV', 'pta_volunteer_sus').'</a>
						<a href="'.esc_url($nonced_export_transposed_url).'" class="button-primary">'.__('Export Sheet as transposed simplified CSV', 'pta_volunteer_sus').'</a>
						';
				}

			}
			echo '</div>';
			return;
		}

		//View All
		$show_trash = (isset($_GET['sheet_status']) && $_GET['sheet_status'] == 'trash') ? true : false;
		$show_all = !$show_trash;

		// List Table functions need to be inside of form
		echo'<form id="pta-sus-list-table-form" method="post">';

		// Get and prepare data
		$this->table = new PTA_SUS_List_Table();
		$this->table->set_show_trash($show_trash);
		$this->table->prepare_items();

		// Moved this below above 2 lines so counts update properly when doing bulk actions (bulk actions called inside of prepare_items function)
		echo '
			<ul class="subsubsub">
			<li class="all"><a href="admin.php?page='.$this->admin_settings_slug.'_sheets"'.(($show_all) ? ' class="current"' : '').'>'.__('All ', 'pta_volunteer_sus').'<span class="count">('.$this->data->get_sheet_count().')</span></a> |</li>
			<li class="trash"><a href="admin.php?page='.$this->admin_settings_slug.'_sheets&amp;sheet_status=trash"'.(($show_trash) ? ' class="current"' : '').'>'.__('Trash ', 'pta_volunteer_sus').'<span class="count">('.$this->data->get_sheet_count(true).')</span></a></li>
			</ul>
			';

		// Display List Table
		$this->table->display();

		echo '</form><!-- #sheet-filter -->';
		echo '</div><!-- .wrap -->';

	}

	/**
	 * Admin Page: Add a Sheet Page
	 */
	function admin_modify_sheet_page() {
		if (!current_user_can('manage_options') && !current_user_can('manage_signup_sheets'))  {
			wp_die( __( 'You do not have sufficient permissions to access this page.', 'pta_volunteer_sus' ) );
		}

		// Set mode vars
		$edit = (empty($_GET['sheet_id'])) ? false : true;
		$add = ($edit) ? false : true;
		$sheet_submitted = (isset($_POST['sheet_mode']) && $_POST['sheet_mode'] == 'submitted');
		$tasks_submitted = (isset($_POST['tasks_mode']) && $_POST['tasks_mode'] == 'submitted');
		$tasks_move = (isset($_POST['tasks_mode']) && $_POST['tasks_mode'] == 'move_tasks');
		$edit_tasks = (isset($_GET['action']) && 'edit_tasks' == $_GET['action']);
		$edit_sheet = (isset($_GET['action']) && 'edit_sheet' == $_GET['action']);
		$sheet_success = false;
		$tasks_success = false;
		$add_tasks = false;
		$moved = false;

		if ($tasks_move) {
			// Nonce check
			check_admin_referer( 'pta_sus_move_tasks', 'pta_sus_move_tasks_nonce' );
			$sheet_id = intval($_POST['sheet_id']);
			$new_sheet_id = intval($_POST['new_sheet_id']);
			$move_results = $this->data->move_tasks($sheet_id,$new_sheet_id);
			if($move_results > 0) {
				echo '<div class="updated"><strong>'.__('Tasks Successfully Moved!', 'pta_volunteer_sus').'</strong></div>';
				echo '<div class="error"><p><strong>'.__('For changes to show, and for new task dates to be updated, please adjust tasks as needed and hit save.', 'pta_volunteer_sus').'</strong></p></div>';
				$moved = true;
			}


		} elseif ($tasks_submitted) {
			// Tasks
			// Nonce check
			check_admin_referer( 'pta_sus_add_tasks', 'pta_sus_add_tasks_nonce' );

			$sheet_success = true;
			$tasks_success = false;
			$sheet_id = (int)$_POST['sheet_id'];
			$no_signups = absint($_POST['sheet_no_signups']);
			$tasks = $this->data->get_tasks($sheet_id);
			$tasks_to_delete = array();
			$tasks_to_update = array();
			$task_err = 0;
			$keys_to_process = array();
			$count = 0;
			$dates = array();
			$old_dates = $this->data->get_all_task_dates($sheet_id);

			do_action( 'pta_sus_admin_process_tasks_start', $sheet_id, $tasks, $old_dates );

			// Get keys for any task line items on screen when posted (even if empty)
			foreach ($_POST['task_title'] AS $key=>$value) {
				$keys_to_process[] = $key;
				$count++;
			}

			// Check if dates were entered for Single or Recurring Events
			if( "Single" == $_POST['sheet_type'] ) {
				if(empty($_POST['single_date'])) {
					$task_err++;
					echo '<div class="error"><p><strong>'.__('You must enter a date!', 'pta_volunteer_sus').'</strong></p></div>';
				} elseif (false === $this->data->check_date($_POST['single_date'])) {
					$task_err++;
					echo '<div class="error"><p><strong>'.__('Invalid date!', 'pta_volunteer_sus').'</strong></p></div>';
				} else {
					$dates[] = $_POST['single_date'];
				}
			} elseif ( "Recurring" == $_POST['sheet_type'] ) {
				if(empty($_POST['recurring_dates'])) {
					$task_err++;
					echo '<div class="error"><p><strong>'.__('You must enter at least two dates for a Recurring event!', 'pta_volunteer_sus').'</strong></p></div>';
				} else {
					$dates = $this->data->get_sanitized_dates($_POST['recurring_dates']);
					if (count($dates) < 2) {
						$task_err++;
						echo '<div class="error"><p><strong>'.__('Invalid dates!  Enter at least 2 valid dates.', 'pta_volunteer_sus').'</strong></p></div>';
					}
				}
			} elseif ( "Ongoing" == $_POST['sheet_type'] ) {
				$dates[] = "0000-00-00";
			}


			// created a posted_tasks array of fields we want to validate
			$posted_tasks = array();
			foreach ($keys_to_process as $index => $key) {
				$posted_tasks[] = array(
						'task_sheet_id'     => $_POST['sheet_id'],
						'task_title'        => $_POST['task_title'][$key],
						'task_dates'         => (isset($_POST['task_dates'][$key])) ? $_POST['task_dates'][$key] : '',
						'task_time_start'   => $_POST['task_time_start'][$key],
						'task_time_end'     => $_POST['task_time_end'][$key],
						'task_qty'          => $_POST['task_qty'][$key],
						'task_need_details' => isset($_POST['task_need_details'][$key]) ? "YES" : "NO",
						'task_allow_duplicates' => isset($_POST['task_allow_duplicates'][$key]) ? "YES" : "NO",
						'task_enable_quantities' => isset($_POST['task_enable_quantities'][$key]) ? "YES" : "NO",
						'task_details_text' => $_POST['task_details_text'][$key],
						'task_id'           => (isset($_POST['task_id'][$key]) && 0 != $_POST['task_id'][$key]) ? (int)$_POST['task_id'][$key] : -1,
						);
			}

			foreach ($posted_tasks as $task) {
				// Validate each posted task
				$results = $this->data->validate_post($task, 'task');
				if(!empty($results['errors'])) {
					$task_err++;
					echo '<div class="error"><p><strong>'.$results['message'].'</strong></p></div>';
				} elseif ("Multi-Day" == $_POST['sheet_type'] && -1 != $task['task_id']) {
					// If the date changed, check for signups on the old date
					$old_task = $this->data->get_task($task['task_id']);
					if ($old_task->dates !== $task['task_dates']) {
						// Date has changed - check if there were signups
						$signups = $this->data->get_signups($old_task->id, $old_task->dates);
						$signup_count = count($signups);
						if ($signup_count > 0) {
							$task_err++;
							$people = _n('person', 'people', $signup_count, 'pta_volunteer_sus');
							echo '<div class="error"><p><strong>'.sprintf(__('The task "%1$s" cannot be changed to a new date because it has %2$d %3$s signed up.  Please clear all spots first before changing this task date.', 'pta_volunteer_sus'), esc_html($old_task->title), (int)$signup_count, $people) .'</strong></p></div>';
						} else {
							$dates[] = $task['task_dates']; // build our array of valid dates
						}
					}
				}
			}


			if (0 === $task_err && !empty($dates) && !empty($old_dates) && "Multi-Day" != $_POST['sheet_type']) {
				// This works for Single & Recurring Event Types, but can be fooled by certain edits on Multi-Day Events
				// Compare the posted $dates with the $old_dates and figure out which task dates to add or remove
				// Skip multi-day events, since we took care of them above

				sort($dates);
				sort($old_dates);
				// sort them and then see if they are different
				if ($dates !== $old_dates) {
					// Adding new dates is fine, we just need to get an array of removed dates that we can use
					// to see if anybody signed up for those dates.  If so, we'll just create an error here that
					// will prevent continuing
					$signups = false;
					$removed_dates = array_diff($old_dates, $dates);
					// Since this only happens if we edit existing tasks/dates, and not for brand new sheet/tasks
					// we can just use the existing tasks from the database that we already put in $tasks
					if(!empty($removed_dates)) {
						foreach ($removed_dates as $removed_date) {
							foreach ($tasks as $task) {
								if(count($this->data->get_signups($task->id, $removed_date)) > 0) {
									$signups = true;
									break 2; // break out of both foreach loops
								}
							}
						}
						if($signups) {
							$task_err++;
							echo '<div class="error"><p><strong>'.__('You are trying to remove '._n('a date', 'dates', count($removed_dates), 'pta_volunteer_sus').' that people have already signed up for!<br/>
									Please clear those signups first if you wish to remove '._n('that date', 'those dates', count($removed_dates), 'pta_volunteer_sus'), 'pta_volunteer_sus').'</strong></p>';
							echo '<p>'.__('Please check '._n('this date', 'these dates', count($removed_dates), 'pta_volunteer_sus' ).' for existing signups:', 'pta_volunteer_sus').'<br/>'.esc_html(implode(', ', $removed_dates)).'</p></div>';
						}
					}
				}
			}


			if( 0 === $task_err ) {



				// Queue for removal: tasks where the fields were emptied out
				for ($i = 0; $i < $count; $i++) {
					if (empty($_POST['task_title'][$i])) {
						if (!empty($_POST['task_id'][$i])) {
							$tasks_to_delete[] = $_POST['task_id'][$i];
						}                            
						continue;
					} else {
						$tasks_to_update[] = (int)$_POST['task_id'][$i];
						if("Single" == $_POST['sheet_type'] || "Recurring" == $_POST['sheet_type'] || "Ongoing" == $_POST['sheet_type']) {
							$check_dates = $dates;
						} else {
							$check_dates = $this->data->get_sanitized_dates($_POST['task_dates'][$i]);
						}
						foreach ($check_dates as $key => $cdate) {
							$signup_count = count($this->data->get_signups((int)$_POST['task_id'][$i], $cdate));
							if ($signup_count > $_POST['task_qty'][$i]) {
								$task_err++;
								$people = _n('person', 'people', $signup_count, 'pta_volunteer_sus');
								if (!empty($task_err)) echo '<div class="error"><p><strong>';
								printf(__('The number of spots for task "%1$s" cannot be set below %2$d because it currently has %2$d %3$s signed up.  Please clear some spots first before updating this task.', 'pta_volunteer_sus'), esc_attr($_POST['task_title'][$i]), (int)$signup_count, $people);
								echo '</strong></p></div>';
							}
						}                        
					}
				}

				if( 0 === count($tasks_to_update) ) {
					$task_err++;
					echo '<div class="error"><p><strong>'.__('You must enter at least one task!', 'pta_volunteer_sus').'</strong></p></div>';
				}
				// Queue for removal: tasks that are no longer in the list
				foreach ($tasks AS $task) {
					if (!in_array($task->id, $_POST['task_id'])) {
						$tasks_to_delete[] = $task->id;
					}
				}

				foreach ($tasks_to_delete as $task_id) {
					$signup_count = count($this->data->get_signups($task_id));
					if ($signup_count > 0) {
						$task_err++;
						$task = $this->data->get_task($task_id);
						if (!empty($task_err)) echo '<div class="error"><p><strong>';
						$people = _n('person', 'people', $signup_count, 'pta_volunteer_sus');
						printf(__('The task "%1$s" cannot be removed because it has %2$d %3$s signed up.  Please clear all spots first before removing this task.', 'pta_volunteer_sus'), esc_html($task->title), (int)$signup_count, $people);
						echo '</strong></p></div>';
					}
				}

				if (empty($task_err)) {
					$i = 0;
					foreach ($keys_to_process AS $key) {                        
						if (!empty($_POST['task_title'][$key])) {
							foreach ($this->data->tables['task']['allowed_fields'] AS $field=>$nothing) {
								if ( 'need_details' == $field && !isset($_POST['task_'.$field][$key]) ) {
									$task_data['task_'.$field] = 'NO';
								}
								if ( 'allow_duplicates' == $field && !isset($_POST['task_'.$field][$key]) ) {
									$task_data['task_'.$field] = 'NO';
								}
								if ( 'enable_quantities' == $field && !isset($_POST['task_'.$field][$key]) ) {
									$task_data['task_'.$field] = 'NO';
								}
								if (isset($_POST['task_'.$field][$key])) {
									$task_data['task_'.$field] = $_POST['task_'.$field][$key];
									$task_data['task_position'] = $i;
								}
							}
							if ( "Single" == $_POST['sheet_type'] || "Ongoing" == $_POST['sheet_type'] ) {
								$task_data['task_dates'] = $dates[0];
							} elseif ( "Recurring" == $_POST['sheet_type'] ) {
								$task_data['task_dates'] = implode(",", $dates);
							} elseif ( "Multi-Day" == $_POST['sheet_type'] ) {
								$dates[] = $_POST['task_dates'][$key];
							}
							$task_data['task_sheet_id'] = $sheet_id;
							if (empty($_POST['task_id'][$key])) {
								if (($result = $this->data->add_task($task_data, $sheet_id, $no_signups)) === false) {
									$task_err++;
								}
							} else {
								if (($result = $this->data->update_task($task_data, $_POST['task_id'][$key], $no_signups)) === false) {
									$task_err++;
								}
							}
						}
						$i++;
					}

					if (!empty($task_err)) {
						echo '<div class="error"><p><strong>';
						printf(__('Error saving %d '. _n('task.', 'tasks.', $task_err, 'pta_volunteer_sus')), (int)$task_err, 'pta_volunteer_sus');
						echo '</strong></p></div>';
					} else {
						// Tasks updated successfully

						// Update sheet with first and last dates
						if ($sheet = $this->data->get_sheet((int)$_POST['sheet_id'])) {
							$sheet_fields = array();
							foreach($sheet AS $k=>$v) $sheet_fields['sheet_'.$k] = $v;
						}
						// Check if we need to update first and last dates for sheet
						$needs_update = false;
						sort($dates);
						if (!isset($sheet_fields['sheet_first_date']) || $sheet_fields['sheet_first_date'] != min($dates)) {
							$sheet_fields['sheet_first_date'] = min($dates);
							$needs_update = true;
						}
						if (!isset($sheet_fields['sheet_last_date']) || $sheet_fields['sheet_last_date'] != max($dates)) {
							$sheet_fields['sheet_last_date'] = max($dates);
							$needs_update = true;
						}
						if ($needs_update) {
							$result = $this->data->update_sheet($sheet_fields, (int)$_POST['sheet_id']);
							if(!$result) {
								$task_err++;
								echo '<div class="error"><p><strong>'.__('Error updating sheet.', 'pta_volunteer_sus').'</strong></p></div>';
							}
						}
						if(empty($task_err)) {
							$tasks_success = true;
							$sheet_fields['sheet_id'] = $_POST['sheet_id'];
						}
					}


					// Delete unused tasks
					foreach ($tasks_to_delete AS $task_id) {
						if ($this->data->delete_task($task_id) === false) {
							echo '<div class="error"><p><strong>'.__('Error removing a task.', 'pta_volunteer_sus').'</strong></p></div>';
						}
					}
				}
			}

			do_action( 'pta_sus_admin_process_tasks_end', $sheet_id );    

		} elseif($sheet_submitted) {
			// Nonce check
			check_admin_referer( 'pta_sus_add_sheet', 'pta_sus_add_sheet_nonce' );

			do_action( 'pta_sus_admin_process_sheet_start' );
			$sheet_err = 0;
			$sheet_success = false;
			// Validate the posted fields
			if ((isset($_POST['sheet_position']) && '' != $_POST['sheet_position'] ) && !empty($_POST['sheet_chair_name'])) {
				$sheet_err++;
				echo '<div class="error"><p><strong>'.__('Please select a Position OR manually enter Chair contact info. NOT Both!', 'pta_volunteer_sus').'</strong></p></div>';
			} elseif ( (!empty($_POST['sheet_chair_name']) && empty($_POST['sheet_chair_email'])) || (empty($_POST['sheet_chair_name']) && !empty($_POST['sheet_chair_email']))) {
				$sheet_err++;
				echo '<div class="error"><p><strong>'.__('Please enter Chair Name(s) AND Email(s)!', 'pta_volunteer_sus').'</strong></p></div>';
			} elseif ((isset($_POST['sheet_position']) && '' == $_POST['sheet_position']) && (empty($_POST['sheet_chair_name']) || empty($_POST['sheet_chair_email']))) {
				$sheet_err++;
				echo '<div class="error"><p><strong>'.__('Please either select a position or type in the chair contact info!', 'pta_volunteer_sus').'</strong></p></div>';
			} elseif (!isset($_POST['sheet_position']) && (empty($_POST['sheet_chair_email']) || empty($_POST['sheet_chair_name']))) {
				$sheet_err++;
				echo '<div class="error"><p><strong>'.__('Please enter Chair Name(s) and Email(s)!', 'pta_volunteer_sus').'</strong></p></div>';
			}
			$results = $this->data->validate_post($_POST, 'sheet');
			// Give extensions a chance to validate any custom fields
			$results = apply_filters( 'pta_sus_validate_sheet_post', $results );
			if(!empty($results['errors'])) {
				echo '<div class="error"><p><strong>'.wp_kses($results['message'], array('br' => array())).'</strong></p></div>';
			} elseif (!$sheet_err) {
				// Passed Validation
				$sheet_fields = $_POST;
				$duplicates = $this->data->check_duplicate_sheet( $sheet_fields['sheet_title'] );
				// Some extensions may want to allow duplicates
				$duplicates = apply_filters( 'pta_sus_check_duplicate_sheets', $duplicates, $sheet_fields );
				// Make sure our sheet_visible gets set correctly
				if (isset($sheet_fields['sheet_visible']) && '1' == $sheet_fields['sheet_visible']) {
					$sheet_fields['sheet_visible'] = true;
				} else {
					$sheet_fields['sheet_visible'] = false;
				}
				// Make sure our sheet_clear gets set correctly
				if (isset($sheet_fields['sheet_clear']) && '1' == $sheet_fields['sheet_clear']) {
					$sheet_fields['sheet_clear'] = true;
				} else {
					$sheet_fields['sheet_clear'] = false;
				}
				// Make sure our no_signups gets set correctly
				if (isset($sheet_fields['sheet_no_signups']) && '1' == $sheet_fields['sheet_no_signups']) {
					$sheet_fields['sheet_no_signups'] = true;
				} else {
					$sheet_fields['sheet_no_signups'] = false;
				}
				// Make sure our duplicate_times gets set correctly
				if (isset($sheet_fields['sheet_duplicate_times']) && '1' == $sheet_fields['sheet_duplicate_times']) {
					$sheet_fields['sheet_duplicate_times'] = true;
				} else {
					$sheet_fields['sheet_duplicate_times'] = false;
				}
				if ($duplicates && $add) {
					echo '<div class="error"><p><strong>'.__('A Sheet with the same name already exists!', 'pta_volunteer_sus').'</strong></p></div>';
					return;
				}
				// Add/Update Sheet
				if ($add) {
					$added = $this->data->add_sheet($sheet_fields);
					if(!$added) {
						$sheet_err++;
						echo '<div class="error"><p><strong>'.__('Error adding sheet.', 'pta_volunteer_sus').'</strong></p></div>';
						$sheet_fields['sheet_id'] = 0;
					} else {
						$sheet_fields['sheet_id'] = $this->data->wpdb->insert_id;
					}
				} else {
					$updated = $this->data->update_sheet($sheet_fields, (int)$_GET['sheet_id']);
					$sheet_fields['sheet_id'] = (int)$_GET['sheet_id'];
					if(false === $updated) {
						$sheet_err++;
						echo '<div class="error"><p><strong>'.__('Error updating sheet.', 'pta_volunteer_sus').'</strong></p></div>';
					}
				}

				do_action( 'pta_sus_admin_process_sheet_end', $add, $sheet_err, $sheet_fields['sheet_id'] );

				if (!$sheet_err) {
					// Sheet saved successfully, set flags to show tasks form
					$sheet_success = true;
					if($add) $add_tasks = true;                   
				}
			}
		}

		// Set field values for form
		$fields = array();
		// Check possible conditions
		// 
		// If a form was submitted, but no success yet, get fields from POST data
		if(($sheet_submitted && !$sheet_success) || ($tasks_submitted && !$tasks_success)) {
			$fields = $_POST;
		} elseif($edit_sheet || $edit_tasks || $add_tasks || $tasks_success || $moved) {
			// Clicked on an edit action link, but nothing posted yet - Get fields from DB instead
			// Or, Tasks successfully posted, in which case we want to show task form again (Heather)
			// So, grab the fields from the database also
			// Get the right sheet id
			if($sheet_success || $tasks_success) {
				$sheet_id = (int)$sheet_fields['sheet_id'];
			} elseif ($moved) {
				$sheet_id = $new_sheet_id;
			} else {
				$sheet_id = (int)$_GET['sheet_id'];
			}
			$fields = $this->get_fields((int)$sheet_id);
		} 

		// Figure out which form to display
		if (!$tasks_success && ($edit_tasks || $tasks_submitted || $add_tasks || $moved)) {
			echo '<div class="wrap pta_sus"><h2>'.( $edit_tasks || $moved ? __('Edit', 'pta_volunteer_sus') : __('ADD', 'pta_volunteer_sus')) . ' '.__('Tasks', 'pta_volunteer_sus').'</h2>';
			$this->display_tasks_form($fields);
			echo '</div>';
		} elseif (!$sheet_success && ($add || $edit_sheet)) {
			echo '<div class="wrap pta_sus"><h2>'.(($add) ? __('ADD', 'pta_volunteer_sus') :  __('Edit', 'pta_volunteer_sus')).' '.__('Sign-up Sheet', 'pta_volunteer_sus').'</h2>';
			$this->display_sheet_form($fields, $edit_sheet);
			if($edit_sheet) {
				$edit_tasks_url = add_query_arg(array("action"=>"edit_tasks", "sheet_id"=>$_GET['sheet_id']),$this->page_url);
				echo '<a href="'.esc_url($edit_tasks_url).'" class="button-secondary">'.__('Edit Tasks', 'pta_volunteer_sus').'</a>';
			} else {
				echo'<p><strong>'.__('Dates and Tasks are added on the next page', 'pta_volunteer_sus').'</strong></p>';
			}
			echo '</div>';
		} elseif ($tasks_success) {
			echo '<div class="wrap pta_sus"><h2>'.($edit_tasks ? __('Edit', 'pta_volunteer_sus') : __('ADD', 'pta_volunteer_sus')) . ' '.__('Tasks', 'pta_volunteer_sus').'</h2>
				<div class="updated"><strong>'.__('Tasks Successfully Updated!', 'pta_volunteer_sus').'</strong></div>';
			$this->display_tasks_form($fields);
			echo '</div>';
		} elseif ($sheet_success && $edit_sheet) {
			echo '<div class="wrap pta_sus"><h2>'.__('Edit Sheet', 'pta_volunteer_sus').'</h2>
				<div class="updated"><strong>'.__('Sheet Updated!', 'pta_volunteer_sus').'</strong></div>';
			$edit_tasks_url = add_query_arg(array("action"=>"edit_tasks", "sheet_id"=>$_GET['sheet_id']),$this->page_url);
			echo '<a href="'.esc_url($edit_tasks_url).'" class="button-secondary">'.__('Edit Tasks', 'pta_volunteer_sus').'</a>
				</div>';
		}
	}

	private function get_fields($id='') {
		if('' == $id) return false;
		if ($sheet = $this->data->get_sheet($id)) {
			$sheet_fields = array();
			foreach($sheet AS $k=>$v) $sheet_fields['sheet_'.$k] = $v;
		}
		$task_fields = array();
		$dates = $this->data->get_all_task_dates($id);
		if ($tasks = $this->data->get_tasks($id)) {
			foreach ($tasks AS $task) {
				$task_fields['task_id'][] = $task->id;
				$task_fields['task_title'][] = $task->title;
				$task_fields['task_dates'][] = $task->dates;
				$task_fields['task_qty'][] = $task->qty;
				$task_fields['task_time_start'][] = $task->time_start;
				$task_fields['task_time_end'][] = $task->time_end;
				$task_fields['task_need_details'][] = $task->need_details;
				$task_fields['task_details_text'][] = $task->details_text;
				$task_fields['task_allow_duplicates'][] = $task->allow_duplicates;                
				$task_fields['task_enable_quantities'][] = $task->enable_quantities;
			}
		}

		$fields = array_merge((array)$sheet_fields, (array)$task_fields);
		if ( 'Single' == $sheet_fields['sheet_type'] ) {
			$fields['single_date'] = (false === $dates) ? '' : $dates[0];
		} elseif ( 'Recurring' == $sheet_fields['sheet_type'] ) {
			$fields['recurring_dates'] = (false === $dates) ? '' : implode(",", $dates);
		}
		return apply_filters( 'pta_sus_admin_get_fields', $fields, $id );
	} // Get Fields

	private function display_sheet_form($f=array(), $edit=false) {
		// Allow other plugins to add/modify other sheet types
		$sheet_types = apply_filters( 'pta_sus_sheet_form_sheet_types', 
				array(
					'Single' => __('Single', 'pta_volunteer_sus'), 
					'Recurring' => __('Recurring', 'pta_volunteer_sus'), 
					'Multi-Day' => __('Multi-Day', 'pta_volunteer_sus'), 
					'Ongoing' => __('Ongoing', 'pta_volunteer_sus')
				     ));
		// default for visible will be checked
		if ((isset($f['sheet_visible']) && 1 == $f['sheet_visible']) || !isset($f['sheet_visible'])) {
			$visible_checked = 'checked="checked"';
		} else {
			// it's set, but == 0
			$visible_checked = '';
		}
		// default for clear will be checked
		if ((isset($f['sheet_clear']) && 1 == $f['sheet_clear']) || !isset($f['sheet_clear'])) {
			$clear_checked = 'checked="checked"';
		} else {
			// it's set, but == 0
			$clear_checked = '';
		}

		if (isset($f['sheet_no_signups']) && 1 == $f['sheet_no_signups']) {
			$no_signups_checked = 'checked="checked"';
		} else {
			// it's set, but == 0
			$no_signups_checked = '';
		}

		if (isset($f['sheet_duplicate_times']) && 1 == $f['sheet_duplicate_times']) {
			$duplicate_times_checked = 'checked="checked"';
		} else {
			// it's set, but == 0
			$duplicate_times_checked = '';
		}

		$options = array();
		$options[] = "<option value=''>".__('Select Event Type', 'pta_volunteer_sus')."</option>";
		foreach ($sheet_types as $type => $display) {
			$selected = '';
			if ( isset($f['sheet_type']) && $type == $f['sheet_type'] ) {
				$selected = "selected='selected'"; 
			}
			$options[] = "<option value='{$type}' $selected >{$display}</option>";
		}
		echo '
			<form name="add_sheet" id="pta-sus-modify-sheet" method="post" action="">
			<p>
			<label for="sheet_title"><strong>'.__('Title:', 'pta_volunteer_sus').'</strong></label>
			<input type="text" id="sheet_title" name="sheet_title" value="'.((isset($f['sheet_title']) ? stripslashes(esc_attr($f['sheet_title'])) : '')).'" size="60">
			<em>'.__('Title of event, program or function', 'pta_volunteer_sus').'</em>
			</p>';
		// Allow other plugins to add fields to the form
		do_action( 'pta_sus_sheet_form_after_title', $f, $edit );
		if($edit) {
			echo '<p><strong>'.__('Event Type:', 'pta_volunteer_sus').' </strong>'.$f['sheet_type'].'</p>
				<input type="hidden" name="sheet_type" value="'.$f['sheet_type'].'" />';
		} else {
			echo '<p>
				<label for="sheet_type"><strong>'.__('Event Type:', 'pta_volunteer_sus').'</strong></label>
				<select id="sheet_type" name="sheet_type">
				'.implode("\n", $options).'
				</select>
				</p>';
		}
		// Allow other plugins to add fields to the form
		do_action( 'pta_sus_sheet_form_after_event_type', $f, $edit );

		echo '
			<p>
			<label for="sheet_no_signups">'.__('No Signup Event?', 'pta_volunteer_sus').'&nbsp;</label>
			<input type="checkbox" id="sheet_no_signups" name="sheet_no_signups" value="1" '.$no_signups_checked.'/>
			<em>&nbsp;'.__('Check this for an event where no sign-ups are needed (display only). You can still enter tasks, which could be used to show a schedule, but you can not enter quantities and there will be no signup links.', 'pta_volunteer_sus').'</em>
			</p>';

		echo '  
			<p>    
			<label for="sheet_reminder1_days">'.__('1st Reminder # of days:', 'pta_volunteer_sus').'</label>
			<input type="text" id="sheet_reminder1_days" name="sheet_reminder1_days" value="'.((isset($f['sheet_reminder1_days']) ? esc_attr($f['sheet_reminder1_days']) : '')).'" size="5" >
			<em>'.__('# of days before the event date to send the first reminder. Leave blank (or 0) for no automatic reminders', 'pta_volunteer_sus').'</em>
			</p>
			<p>    
			<label for="sheet_reminder2_days">'.__('2nd Reminder # of days:', 'pta_volunteer_sus').'</label>
			<input type="text" id="sheet_reminder2_days" name="sheet_reminder2_days" value="'.((isset($f['sheet_reminder2_days']) ? esc_attr($f['sheet_reminder2_days']) : '')).'" size="5" >
			<em>'.__('# of days before the event date to send the second reminder. Leave blank (or 0) for no second reminder', 'pta_volunteer_sus').'</em>
			</p>';

		echo '
			<p>
			<label for="sheet_clear">'.__('Show Clear links for signups?', 'pta_volunteer_sus').'&nbsp;</label>
			<input type="checkbox" id="sheet_clear" name="sheet_clear" value="1" '.$clear_checked.'/>
			<em>&nbsp;'.__('<strong>Uncheck</strong> if you want to <strong>HIDE</strong> the clear link in the user\'s signup list. Administrators and Sign-Up Sheet Managers can still clear volunteers from signups in the admin dashboard.', 'pta_volunteer_sus').'</em>
			</p>
			<p>    
			<label for="sheet_clear_days">'.__('# of days to allow clear:', 'pta_volunteer_sus').'</label>
			<input type="text" id="sheet_clear_days" name="sheet_clear_days" value="'.((isset($f['sheet_clear_days']) ? esc_attr($f['sheet_clear_days']) : '')).'" size="5" >
			<em>'.__('If the above option is checked, enter the MINIMUM # of days before the signup event/item date during which volunteers can clear their signups. Leave blank (or 0) to allow them to clear themselves at any time.', 'pta_volunteer_sus').'</em>
			</p>';

		echo '
			<p>
			<label for="sheet_visible">'.__('Visible to Public?', 'pta_volunteer_sus').'&nbsp;</label>
			<input type="checkbox" id="sheet_visible" name="sheet_visible" value="1" '.$visible_checked.'/>
			<em>&nbsp;'.__('<strong>Uncheck</strong> if you want to <strong>hide</strong> this sheet from the public. Administrators and Sign-Up Sheet Managers can still see hidden sheets.', 'pta_volunteer_sus').'</em>
			</p>';

		echo '
			<p>
			<label for="sheet_duplicate_times">'.__('Allow Duplicate Signup Times?', 'pta_volunteer_sus').'&nbsp;</label>
			<input type="checkbox" id="sheet_duplicate_times" name="sheet_duplicate_times" value="1" '.$duplicate_times_checked.'/>
			<em>&nbsp;'.__('Check this to allow a volunteer to signup for more than one task (in this sheet) with overlapping time ranges.', 'pta_volunteer_sus').'</em>
			</p>';

		// Allow other plugins to add fields to the form
		do_action( 'pta_sus_sheet_form_after_visible', $f, $edit );
		echo '
			<hr />
			<h3>'.__('Contact Info:', 'pta_volunteer_sus').'</h3>';

		if( $this->member_directory_active ) {
			$taxonomies = array('member_category');
			$positions = get_terms( $taxonomies );
			$options = array();
			$options[] = "<option value=''>".__('Select Position', 'pta_volunteer_sus')."</option>";
			foreach ($positions as $position) {
				$selected = '';
				if ( isset($f['sheet_position']) && $position->slug == $f['sheet_position'] ) {
					$selected = "selected='selected'"; 
				}
				$options[] = "<option value='{$position->slug}' $selected >{$position->name}</option>";
			}
			echo '<p>'.__('Select a program, committee, or position, to use the contact form:', 'pta_volunteer_sus').'</p>
				<label for="sheet_position">'.__('Position:', 'pta_volunteer_sus').'</label>
				<select id="sheet_position" name="sheet_position">
				'.implode("\n", $options).'
				</select>
				<p>'.__('<strong><em>OR</em></strong>, manually enter chair names and contact emails below.', 'pta_volunteer_sus').'</p>';
		}

		echo '
			<p>
			<label for="sheet_chair_name">'.__('Chair Name(s):', 'pta_volunteer_sus').'</label>
									      <input type="text" id="sheet_chair_name" name="sheet_chair_name" value="'.((isset($f['sheet_chair_name']) ? esc_attr($f['sheet_chair_name']) : '')).'" size="80">
															<em>'.__('Separate multiple names with commas', 'pta_volunteer_sus').'</em>
																				  </p>
																				      <p>
																					 <label for="sheet_chair_email">'.__('Chair Email(s):', 'pta_volunteer_sus').'</label>
																												 <input type="text" id="sheet_chair_email" name="sheet_chair_email" value="'.((isset($f['sheet_chair_email']) ? esc_attr($f['sheet_chair_email']) : '')).'" size="80">
																																		  <em>'.__('Separate multiple emails with commas', 'pta_volunteer_sus').'</em>
																																							    </p>';
		// Allow other plugins to add fields to the form
		do_action( 'pta_sus_sheet_form_after_contact_info', $f, $edit );
		$content = isset($f['sheet_details']) ? wp_kses_post($f['sheet_details']) : '';
		$editor_id = "sheet_details";
		$settings = array( 'wpautop' => false, 'textarea_rows' => 10 );
		echo '
			<hr />
			<p>
			<label for="sheet_details"><h3>'.__('Program/Event Details (optional):', 'pta_volunteer_sus').'</h3></label>
												  </p>';
		wp_editor( $content, $editor_id, $settings );
		// Allow other plugins to add fields to the form
		do_action( 'pta_sus_sheet_form_after_sheet_details', $f, $edit );
		// Security Nonce
		wp_nonce_field('pta_sus_add_sheet','pta_sus_add_sheet_nonce');
		echo '
			<p class="submit">
			<input type="hidden" name="sheet_mode" value="submitted" />
			<input type="submit" name="Submit" class="button-primary" value="'.__("Save Sheet", "pta_volunteer_sus").'" /><br/><br/>
			</p>
			</form>
			';
	} // Display Sheet Form

	private function display_tasks_form($f=array()) {
		$count = (isset($f['task_title'])) ? count($f['task_title']) : 3;
		$no_signups = absint($f['sheet_no_signups']);
		do_action( 'pta_sus_tasks_form_start', $f, $count );
		if ($count < 3) $count = 3;
		echo '<form name="add_tasks" id="pta-sus-modify-tasks" method="post" action="'.$this->page_url.'">';
		if ( "Single" == $f['sheet_type'] ) {
			echo '<h2>'.__('Select the date for ', 'pta_volunteer_sus'). stripslashes(esc_attr($f['sheet_title'])) . '</h2>
				<p>    
				<label for="single_date"><strong>Date:</strong></label>
				<input type="text" class="singlePicker" id="single_date" name="single_date" value="'.((isset($f['single_date']) ? esc_attr($f['single_date']) : '')).'" size="12" >
				<em>'.__('Select a date for the event.  All tasks will then be assigned to this date.', 'pta_volunteer_sus').'</em>
				</p>
				';
		} elseif ( "Recurring" == $f['sheet_type']) {
			echo '<h2>'.__('Select ALL the dates for ', 'pta_volunteer_sus'). stripslashes(esc_attr($f['sheet_title'])) . '</h2>
				<p>    
				<label for="recurring_dates"><strong>Dates:</strong></label>
				<input type="text" id="multi999Picker" name="recurring_dates" value="'.((isset($f['recurring_dates']) ? esc_attr($f['recurring_dates']) : '')).'" size="40" >
				<em>'.__('Select all the dates for the event. Copies of the tasks will be created for each date.', 'pta_volunteer_sus').'</em>
				</p>
				';
		}
		echo'
			<h2>'.__('Tasks for ', 'pta_volunteer_sus'). stripslashes(esc_attr($f['sheet_title'])) . '</h2>
			<h3>'.__('Tasks/Items', 'pta_volunteer_sus').'</h3>
			<p><em>'.__('Enter tasks or items below. Drag and drop to change sort order. Times are optional. If you need details for an item or task (such as what dish they are bringing for a lunch) check the Details Needed box.<br/>
					Click on (+) to add additional tasks, or (-) to remove a task.  At least one task/item must be entered.  If # needed is left blank, the value will be set to 1.', 'pta_volunteer_sus').'</em></p>
			<ul class="tasks">
			';
		for ($i = 0; $i < $count; $i++) {
			do_action( 'pta_sus_tasks_form_task_loop_start', $f, $i );
			echo '
				<li id="task-'.$i.'">
				'.__('Task/Item:', 'pta_volunteer_sus').' <input type="text" name="task_title['.$i.']" id="task_title['.$i.']" value="'.((isset($f['task_title'][$i]) ? esc_attr($f['task_title'][$i]) : '')).'" size="20">&nbsp;&nbsp;&nbsp;';
			if ( "Multi-Day" == $f['sheet_type'] ) {
				echo __('Date:','pta_volunteer_sus').' <input type="text" class="singlePicker" name="task_dates['.$i.']" id="singlePicker['.$i.']" value="'.((isset($f['task_dates'][$i]) ? esc_attr($f['task_dates'][$i]) : '')).'" size="10">&nbsp;&nbsp;&nbsp;';
			}
			if(!$no_signups) {
				echo __('# Needed:','pta_volunteer_sus').' <input type="text" name="task_qty['.$i.']" id="task_qty['.$i.']" value="'.((isset($f['task_qty'][$i]) ? (int)$f['task_qty'][$i] : '')).'" size="3">';
			}
			echo
				'&nbsp;&nbsp;&nbsp;'.__('Start Time:', 'pta_volunteer_sus').' <input type="text" class="timepicker" id="timepicker_start['.$i.']" name="task_time_start['.$i.']" value="'.((isset($f['task_time_start'][$i]) ? esc_attr($f['task_time_start'][$i]) : '')).'" size="10">
				&nbsp;&nbsp;&nbsp;'.__('End Time:', 'pta_volunteer_sus').' <input type="text" class="timepicker" id="timepicker_end['.$i.']" name="task_time_end['.$i.']" value="'.((isset($f['task_time_end'][$i]) ? esc_attr($f['task_time_end'][$i]) : '')).'" size="10">';

			if(!$no_signups) {
				echo '&nbsp;&nbsp;&nbsp;'.__('Allow Duplicates? ', 'pta_volunteer_sus');
				if (!isset($f['task_allow_duplicates'][$i])) {
					$f['task_allow_duplicates'][$i] = "NO";
				}
				echo '<input type="checkbox" name="task_allow_duplicates['.$i.']" id="task_allow_duplicates['.$i.']" value="YES" ';
				if (isset($f['task_allow_duplicates'][$i]) &&  $f['task_allow_duplicates'][$i] === "YES") {
					echo 'checked="checked" ';
				}
				echo '>
				&nbsp;&nbsp;&nbsp;'.__('Enable Quantities? ', 'pta_volunteer_sus');
				if (!isset($f['task_enable_quantities'][$i])) {
					$f['task_enable_quantities'][$i] = "NO";
				}
				echo '<input type="checkbox" name="task_enable_quantities['.$i.']" id="task_enable_quantities['.$i.']" value="YES" ';
				if (isset($f['task_enable_quantities'][$i]) &&  $f['task_enable_quantities'][$i] === "YES") {
					echo 'checked="checked" ';
				}
				echo '>
				&nbsp;&nbsp;&nbsp;'.__('Details Needed? ', 'pta_volunteer_sus');
				if (!isset($f['task_need_details'][$i])) {
					$f['task_need_details'][$i] = "NO";
				}
				echo '<input type="checkbox" class="details_checkbox" name="task_need_details['.$i.']" id="task_need_details['.$i.']" value="YES" ';
				if (isset($f['task_need_details'][$i]) &&  $f['task_need_details'][$i] === "YES") {
					echo 'checked="checked" ';
				}
				echo '>';
				// Details label - added in version 1.6
				echo '<span class="pta_toggle"><br />'.__('Details text:','pta_volunteer_sus').' <input type="text" class="details_text" name="task_details_text['.$i.']" id="task_details_text['.$i.']" value="'.((isset($f['task_details_text'][$i]) ? esc_attr($f['task_details_text'][$i]) : __("Item you are bringing", "pta_volunteer_sus" ) )).'" size="25"></span>';
			}

			echo '&nbsp;&nbsp;<input type="hidden" name="task_id['.$i.']" id="task_id['.$i.']" value="'.((isset($f['task_id'][$i]) ? (int)$f['task_id'][$i] : '')).'">
				<a href="#" class="add-task-after">(+)</a>
				<a href="#" class="remove-task">(-)</a>
				</li>
				';
			do_action( 'pta_sus_tasks_form_task_loop_end', $f, $i );
		}
		do_action( 'pta_sus_tasks_form_after_tasks', $f );
		echo '
			</ul>';
		wp_nonce_field('pta_sus_add_tasks','pta_sus_add_tasks_nonce');
		echo '
			<hr />
			<p class="submit">
			<input type="hidden" name="sheet_id" value="'.(int)$f["sheet_id"].'" />
			<input type="hidden" name="sheet_title" value="'.$f["sheet_title"].'" />
			<input type="hidden" name="sheet_type" value="'.$f["sheet_type"].'" />
			<input type="hidden" name="sheet_no_signups" value="'.(int)$f["sheet_no_signups"].'" />
			<input type="hidden" name="tasks_mode" value="submitted" />
			<input type="submit" name="Submit" class="button-primary" value="'.__("Save", "pta_volunteer_sus").'" />
			</p>
			</form>';

		// tasks move	
		$rows = $this->data->get_sheets(false, false, true);
		if (count($rows)>1) {
			echo '<h2>'.__('Move tasks ', 'pta_volunteer_sus'). '</h2>';
			echo '<form name="move_tasks" id="pta-sus-move-tasks" method="post" action="'.$this->page_url.'">';
			wp_nonce_field('pta_sus_move_tasks','pta_sus_move_tasks_nonce');
			echo '<input type="hidden" name="sheet_id" value="'.(int)$f["sheet_id"].'" />
			<input type="hidden" name="tasks_mode" value="move_tasks" />
			<label for="new_sheet_id">'.__('Move all tasks of this sheet to sheet', 'pta_volunteer_sus').'</label>
			<select id="new_sheet_id" name="new_sheet_id">';

			foreach ($rows as $row) {
				if ($row->id == $f["sheet_id"]) continue;
				echo '<option value='.$row->id.'>'.$row->title.'</option>';
			}
			echo '
			</select>
			<input type="submit" name="Submit" class="button-primary" value="'.__("Move", "pta_volunteer_sus").'" />
			</form>';
		}
		
	} // Display Tasks Form

	public function email_volunteers_page() {
		$messages = ''; // messages passed to the html form
		// check if form submitted, and send emails, if needed
		if(isset($_POST['email_volunteers_mode']) && 'submitted' === $_POST['email_volunteers_mode']) {
			check_admin_referer( 'pta_sus_email_volunteers', 'pta_sus_email_volunteers_nonce' );
			$messages = $this->send_volunteer_emails();
		}

		include('admin-email-volunteers-html.php');
	}

	public function admin_addons_page() {
		include('admin-addons-html.php');
	}

	public function send_volunteer_emails() {
		$messages = '';
		$errors = 0;
		// Get all needed info, or set error messages
		if(isset($_POST['sheet_select']) && is_numeric($_POST['sheet_select'])) {
			$sheet_id = absint($_POST['sheet_select']);
		} else {
			$errors++;
			$messages .= '<div class="error"><p><strong>'.__('Invalid sheet selection', 'pta_volunteer_sus').'</strong></p></div>';
		}
		if(isset($_POST['from_name']) && '' !== $_POST['from_name']) {
			$from_name = sanitize_text_field($_POST['from_name']);
		} else {
			$errors++;
			$messages .= '<div class="error"><p><strong>'.__('Please enter a From Name', 'pta_volunteer_sus').'</strong></p></div>';
		}
		if(isset($_POST['reply_to']) && is_email($_POST['reply_to']) && '' !== $_POST['reply_to']) {
			$reply_to = sanitize_text_field($_POST['reply_to']);
		} else {
			$errors++;
			$messages .= '<div class="error"><p><strong>'.__('Please enter a valid reply to email, or leave blank for none.', 'pta_volunteer_sus').'</strong></p></div>';
		}
		if(isset($_POST['subject']) && '' !== sanitize_text_field($_POST['subject'])) {
			$subject = sanitize_text_field($_POST['subject']);
		} else {
			$errors++;
			$messages .= '<div class="error"><p><strong>'.__('Please enter a subject', 'pta_volunteer_sus').'</strong></p></div>';
		}
		if(isset($_POST['message']) && '' !== wp_kses_post(trim($_POST['message']))) {
			$message = wp_kses_post($_POST['message']);
		} else {
			$errors++;
			$messages .= '<div class="error"><p><strong>'.__('Please enter a message', 'pta_volunteer_sus').'</strong></p></div>';
		}
		$individually = (isset($_POST['individually']) && 1 == absint($_POST['individually']));

		if(0 == $errors) {
			// No errors, get volunteer emails
			$emails = $this->data->get_volunteer_emails($sheet_id);
			if(empty($emails)) {
				$messages .= '<div class="error"><p><strong>'.__('No signups found for that sheet', 'pta_volunteer_sus').'</strong></p></div>';
			} else {
				// Send some emails!
				$user_email = isset($_POST['user_email']) ? sanitize_text_field($_POST['user_email']) : get_option('admin_email');
				$headers = array();
				$headers[]  = "From: " . $from_name . " <" . $user_email . ">";
				$headers[]  = "Reply-To: " . $reply_to;
				$headers[]  = "Content-Type: text/plain; charset=utf-8";
				$headers[]  = "Content-Transfer-Encoding: 8bit";

				$sent_to = array();
				if($individually) {
					$emails[] = $user_email;
					$sent = true;
					foreach ($emails as $email) {
						// make sure it's a valid email before sending
						if(is_email($email)) {
							$result = wp_mail($email, $subject, $message, $headers);
							if(false === $result) {
								$sent = false;
							} else {
								$sent_to[] = $email;
							}
						}
					}
				} else {
					$sent_to[] = $user_email;
					// put all volunteer emails in BCC fields
					foreach ($emails as $cc) {
						if(is_email($cc)) {
							$headers[] = 'Bcc: ' . $cc;
							$sent_to[] = $cc;
						}
					}
					// send to the sender, with BCC to all volunteers
					$sent = wp_mail($user_email, $subject, $message, $headers);
				}

				if($sent) {
					$count = count($sent_to);
					$emails = implode(', ', $sent_to);
					$messages .= '<div class="updated"><strong>'.sprintf(__('%s Emails Sent!', 'pta_volunteer_sus'), $count).'</strong></div>';
					$messages .= '<div class="updated">'.sprintf(__('Emails sent to: %s', 'pta_volunteer_sus'), esc_html($emails)).'</div>';
				} else {
					$messages .= '<div class="error"><p><strong>'.__('The WordPress Mail function reported a problem sending one or more emails.', 'pta_volunteer_sus').'</strong></p></div>';
				}
			}
		}

		return $messages;
	}

} // End of Class
/* EOF */
