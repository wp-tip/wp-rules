<?php
namespace WP_Rules\ThirdParty\Plugins\ContactForm7;

/**
 * Class Plugin
 *
 * @package WP_Rules\ThirdParty\Plugins\CotactForm7
 */
class Plugin {

	/**
	 * Status of this plugin activation.
	 *
	 * @return bool
	 */
	public static function is_allowed(): bool {
		return wpbr_has_constant( 'WPCF7_PLUGIN' );
	}

	/**
	 * Register this list of classes.
	 *
	 * @return string[]
	 */
	public static function register(): array {
		return [
			'trigger_before_send_email' => '\WP_Rules\ThirdParty\Plugins\ContactForm7\Triggers\BeforeSendEmail',
			'trigger_submit_form'       => '\WP_Rules\ThirdParty\Plugins\ContactForm7\Triggers\FormSubmitted',

			'action_stop_submission'    => '\WP_Rules\ThirdParty\Plugins\ContactForm7\Actions\StopSubmission',
			'action_skip_mail'          => '\WP_Rules\ThirdParty\Plugins\ContactForm7\Actions\SkipMail',
		];
	}

}
