<?php
namespace WP_Rules\Conditions\Backend;

use WP_Rules\Core\Admin\Condition\AbstractCondition;

/**
 * Class CurrentAdminScreen
 *
 * @package WP_Rules\Conditions
 */
class CurrentAdminScreen extends AbstractCondition {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'current-admin-screen',
			'name'        => __( 'Current Admin Screen', 'rules' ),
			'description' => __( 'Check in which admin screen the user is.', 'rules' ),
			'group'       => __( 'Backend', 'rules' ),
		];
	}

	/**
	 * Return condition options fields array.
	 *
	 * @return array Admin fields.
	 */
	protected function admin_fields() {
		return [
			[
				'type'    => 'select',
				'label'   => __( 'Choose Admin Screen', 'rules' ),
				'name'    => 'screen_id',
				'options' => $this->get_admin_screens_list(),
			],
		];
	}

	/**
	 * Get list of admin screens.
	 *
	 * @return array
	 */
	private function get_admin_screens_list() {
		return [
			'dashboard'              => __( 'Main Dashboard', 'rules' ),
			'update-core'            => __( 'Wordpress Updates', 'rules' ),

			'edit-post'              => __( 'Posts', 'rules' ),
			'post'                   => __( 'Add/Edit Post', 'rules' ),
			'edit-category'          => __( 'Categories', 'rules' ),
			'edit-post_tag'          => __( 'Tags', 'rules' ),

			'upload'                 => __( 'Media Library', 'rules' ),
			'attachment'             => __( 'Edit Media Attachment', 'rules' ),

			'edit-page'              => __( 'Pages', 'rules' ),
			'page'                   => __( 'Add/Edit Page', 'rules' ),

			'edit-comments'          => __( 'Comments', 'rules' ),
			'comment'                => __( 'Edit Comment', 'rules' ),

			'themes'                 => __( 'Themes', 'rules' ),
			'theme-install'          => __( 'Add Theme', 'rules' ),
			'themes-network'         => __( 'Network Themes', 'rules' ),
			'site-themes-network'    => __( 'Edit Site: Themes', 'rules' ),

			'widgets'                => __( 'Widgets', 'rules' ),

			'nav-menus'              => __( 'Menus', 'rules' ),

			'theme-editor'           => __( 'Theme Editor', 'rules' ),

			'plugins'                => __( 'Plugins', 'rules' ),
			'plugins-network'        => __( 'Network Plugins', 'rules' ),
			'plugin-install'         => __( 'Plugin Install', 'rules' ),
			'plugin-install-network' => __( 'Network Plugin Install', 'rules' ),
			'plugin-editor'          => __( 'Plugin Editor', 'rules' ),

			'users'                  => __( 'Users', 'rules' ),
			'users-network'          => __( 'Network Users', 'rules' ),
			'site-users-network'     => __( 'Network Site Users', 'rules' ),
			'user'                   => __( 'Add User', 'rules' ),
			'user-edit'              => __( 'Edit User', 'rules' ),
			'profile'                => __( 'Edit Profile', 'rules' ),

			'tools'                  => __( 'Tools', 'rules' ),
			'import'                 => __( 'Import', 'rules' ),
			'export'                 => __( 'Export', 'rules' ),
			'site-health'            => __( 'Site Health', 'rules' ),
			'export-personal-data'   => __( 'Export Personal Data', 'rules' ),
			'erase-personal-data'    => __( 'Erase Personal Data', 'rules' ),

			'options-general'        => __( 'General Settings', 'rules' ),
			'options-writing'        => __( 'Writing Settings', 'rules' ),
			'options-reading'        => __( 'Reading Settings', 'rules' ),
			'options-discussion'     => __( 'Discussion Settings', 'rules' ),
			'options-media'          => __( 'Media Settings', 'rules' ),
			'options-permalink'      => __( 'Permalink Settings', 'rules' ),
			'options-privacy'        => __( 'Privacy Settings', 'rules' ),

			'sites-network'          => __( 'Network sites', 'rules' ),
		];
	}

	/**
	 * Evaluate current condition.
	 *
	 * @param array $condition_options Condition Options array.
	 * @param array $trigger_hook_args Current rule trigger hook arguments.
	 *
	 * @return bool If it passes or not.
	 */
	protected function evaluate( $condition_options, $trigger_hook_args ) {
		if ( ! function_exists( 'get_current_screen' ) ) {
			return false;
		}

		return get_current_screen()->id === $condition_options['screen_id'];
	}
}
