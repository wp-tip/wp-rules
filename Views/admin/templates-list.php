<main class="rules-content">
	<header class="rules-content__header">
		<div class="rules-content__title">Workflow Templates</div>
		<div class="rules-content__search">
			<div class="rules-content__search_container">
				<input type="text" class="textbox" id="rules_template_search" placeholder="Search Templates">
			</div>
		</div>
	</header>

	<input type="hidden" id="rule_template_nonce" value="<?php echo esc_attr( $data['template_nonce'] ); ?>">

	<section class="rules-content__templates" id="rules-content__templates">
		<div class="rules-content__templates_item scratch">
			<a href="#">
				<div class="rules-content__templates_item_thumbnail_wrap">

				</div>
				<footer class="rules-content__templates_item_title">
					Start from scratch
				</footer>
			</a>
		</div>

		<?php foreach ( $data['templates'] as $wpbr_template_id => $wpbr_template ) { ?>
		<div class="rules-content__templates_item" data-template_id="<?php echo esc_attr( $wpbr_template_id ); ?>">
			<a href="#">
				<div class="rules-content__templates_item_thumbnail_wrap">
					<div class="rules-content__templates_item_thumbnail" data-bg="<?php echo esc_url( $wpbr_template['thumbnail'] ); ?>"></div>
				</div>
				<footer class="rules-content__templates_item_title">
					<?php echo esc_html( $wpbr_template['name'] ); ?>
				</footer>
			</a>
		</div>
		<?php } ?>
	</section>

	<section class="rules-content__settings" id="rules-content__settings">
		<div class="rules-settings__template_details">
			<div class="rules-settings__template_thumbnail">
				<img src="" id="rules-settings__template_thumbnail_img" alt="" title="" />
			</div>
			<h3 class="rules-settings__template_title" id="rules-settings__template_title"></h3>
		</div>
		<form class="rules-settings__fields" id="rules-settings__fields">

		</form>
	</section>

	<footer class="rules-footer" id="rules-footer">
		<a href="#" class="button button-primary" id="rules_template_save"><?php esc_html_e( 'Save Rule', 'rules' ); ?></a>
	</footer>
</main>
