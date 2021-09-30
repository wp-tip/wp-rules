<?php /*
<nav class="rules-navbar">
	<div class="rules-navbar__logo">
		WP Business Rules
	</div>
	<div class="rules-navbar__menu">
		<ul>
			<li class="active">
				<a href="#">Home</a>
			</li>
			<li>
				<a href="#">Templates</a>
			</li>
		</ul>
	</div>
</nav>
 */ ?>

<main class="rules-content">
	<header class="rules-content__header">
		<div class="rules-content__title">Workflow Templates</div>
		<div class="rules-content__search">
			<div class="rules-content__search_container">
				<input type="text" class="textbox" id="rules_template_search" placeholder="Search Templates">
			</div>
		</div>
	</header>

	<section class="rules-content__templates">
		<div class="rules-content__templates_item scratch">
			<a href="#">
				<div class="rules-content__templates_item_thumbnail_wrap">

				</div>
				<footer class="rules-content__templates_item_title">
					Start from scratch
				</footer>
			</a>
		</div>

		<?php foreach ( $data['templates'] as $template_id => $template ){ ?>
		<div class="rules-content__templates_item">
			<a href="#" data-template_id="<?php echo $template_id; ?>">
				<div class="rules-content__templates_item_thumbnail_wrap">
					<div class="rules-content__templates_item_thumbnail" style="background-image: url('<?php echo $template['thumbnail']; ?>');"></div>
				</div>
				<footer class="rules-content__templates_item_title">
					<?php echo $template['name']; ?>
				</footer>
			</a>
		</div>
		<?php } ?>

	</section>
</main>
