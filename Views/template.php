<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<title>Loja 2.0</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/jquery-ui.min.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/jquery-ui.structure.min.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/jquery-ui.theme.min.css" type="text/css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
	<nav class="navbar topnav">
		<div class="container">
			<ul class="nav navbar-nav">
				<li class="active"><a href="<?php echo BASE_URL; ?>"><?= $this->lang->get('HOME'); ?></a></li>
				<li><a href="<?php echo BASE_URL; ?>contact"><?= $this->lang->get('CONTACT'); ?></a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?= $this->lang->get('LANGUAGE'); ?>
						<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?= BASE_URL; ?>lang/set/en">English</a></li>
						<li><a href="<?= BASE_URL; ?>lang/set/pt-br">Português</a></li>
					</ul>
				</li>
				<li><a href="<?php echo BASE_URL; ?>login"><?= $this->lang->get('LOGIN'); ?></a></li>
			</ul>
		</div>
	</nav>
	<header>
		<div class="container">
			<div class="row">
				<div class="col-sm-2 logo">
					<a href="<?php echo BASE_URL; ?>"><img src="<?php echo BASE_URL; ?>assets/images/logo.png" /></a>
				</div>
				<div class="col-sm-7">
					<div class="head_help">(11) 9999-9999</div>
					<div class="head_email">contato@<span>loja2.com.br</span></div>

					<div class="search_area">
						<form method="GET">
							<input type="text" name="s" required placeholder="<?= $this->lang->get('SEARCHFORANITEM'); ?>" />
							<select name="category">
								<option value=""><?= $this->lang->get('ALLCATEGORIES'); ?></option>
							</select>
							<input type="submit" value="" />
						</form>
					</div>
				</div>
				<div class="col-sm-3">
					<a href="<?php echo BASE_URL; ?>cart">
						<div class="cartarea">
							<div class="carticon">
								<div class="cartqt">9</div>
							</div>
							<div class="carttotal">
								<?= $this->lang->get('CART'); ?>:<br />
								<span>R$ 999,99</span>
							</div>
						</div>
					</a>
				</div>
			</div>
		</div>
	</header>
	<div class="categoryarea">
		<nav class="navbar">
			<div class="container">
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?= $this->lang->get('SELECTCATEGORY'); ?>
							<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<?php foreach ($viewData['categories'] as $cat) : ?>
								<li>
									<a href="<?= BASE_URL . 'categories/enter/' . $cat['id']; ?>">
										<?= $cat['name']; ?>
									</a>
								</li>
								<?php
								if (count($cat['subs']) > 0) {
									$this->loadView('menu_subcategory', [
										'subs' => $cat['subs'],
										'level' => 1
									]);
								}
								?>
							<?php endforeach; ?>
						</ul>
					</li>
					<?php if (isset($viewData['category_filter'])) : ?>
						<?php foreach ($viewData['category_filter'] as $cf) : ?>
							<li>
								<a href="<?= BASE_URL; ?>categories/enter/<?= $cf['id']; ?>">
									<?= $cf['name']; ?>
								</a>
							</li>
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</div>
		</nav>
	</div>
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<aside>
						<h1><?= $this->lang->get('FILTER'); ?></h1>
						<div class="filterarea">
							<form method="GET">
								<div class="filter_box">
									<div class="filtertitle">
										<?= $this->lang->get('BRANDS'); ?>
									</div>
									<div class="filtercontent">
										<?php foreach ($viewData['filters']['brands'] as $bitem) : ?>
											<div class="filteritem">
												<label for="filter_brand_<?= $bitem['id']; ?>">
													<input type="checkbox" name="filter[brand][]" id="filter_brand_<?= $bitem['id']; ?>">
													<?= $bitem['name']; ?>
												</label>
												<span style="float:right;">(<?= $bitem['count']; ?>)</span>
											</div>
										<?php endforeach; ?>
									</div>
								</div>

								<div class="filter_box">
									<div class="filtertitle">
										<?= $this->lang->get('PRICE'); ?>
									</div>
									<div class="filtercontent">
										<p>
											<input type="text" id="amount" readonly style="border:0; color:#F6931F;font-weight:bold;">
										</p>
										<div id="slider-range"></div>
									</div>
								</div>

								<div class="filter_box">
									<div class="filtertitle">
										<?= $this->lang->get('RATING'); ?>
									</div>
									<div class="filtercontent">
										<div class="filteritem">
											<input type="checkbox" name="filter[star0][]" value="0" id="filter_star0">
											<label for="filter_star0">
												(<?= $this->lang->get('NO_STAR'); ?>)
											</label>
											<span style="float:right">(<?php echo $viewData['filters']['stars']['0']; ?>)</span>
										</div>
										<div class="filteritem">
											<label for="filter_star1">
												<input type="checkbox" name="filter[star1][]" value="1" id="filter_star1">
												<i class="fa-solid fa-star" style="color:#ffd43b;"></i>
											</label>
											<span style="float:right">(<?php echo $viewData['filters']['stars']['1']; ?>)</span>
										</div>
										<div class="filteritem">
											<label for="filter_star2">
												<input type="checkbox" name="filter[star2][]" value="2" id="filter_star2">
												<i class="fa-solid fa-star" style="color:#ffd43b;"></i>
												<i class="fa-solid fa-star" style="color:#ffd43b;"></i>
											</label>
											<span style="float:right">(<?php echo $viewData['filters']['stars']['2']; ?>)</span>
										</div>
										<div class="filteritem">
											<label for="filter_star3">
												<input type="checkbox" name="filter[star3][]" value="3" id="filter_star3">
												<i class="fa-solid fa-star" style="color:#ffd43b;"></i>
												<i class="fa-solid fa-star" style="color:#ffd43b;"></i>
												<i class="fa-solid fa-star" style="color:#ffd43b;"></i>
											</label>
											<span style="float:right">(<?php echo $viewData['filters']['stars']['3']; ?>)</span>
										</div>
										<div class="filteritem">
											<label for="filter_star4">
												<input type="checkbox" name="filter[star4][]" value="4" id="filter_star4">
												<i class="fa-solid fa-star" style="color:#ffd43b;"></i>
												<i class="fa-solid fa-star" style="color:#ffd43b;"></i>
												<i class="fa-solid fa-star" style="color:#ffd43b;"></i>
												<i class="fa-solid fa-star" style="color:#ffd43b;"></i>
											</label>
											<span style="float:right">(<?php echo $viewData['filters']['stars']['4']; ?>)</span>
										</div>
										<div class="filteritem">
											<label for="filter_star5">
												<input type="checkbox" name="filter[star5][]" value="5" id="filter_star5">
												<i class="fa-solid fa-star" style="color:#ffd43b;"></i>
												<i class="fa-solid fa-star" style="color:#ffd43b;"></i>
												<i class="fa-solid fa-star" style="color:#ffd43b;"></i>
												<i class="fa-solid fa-star" style="color:#ffd43b;"></i>
												<i class="fa-solid fa-star" style="color:#ffd43b;"></i>
											</label>
											<span style="float:right">(<?php echo $viewData['filters']['stars']['5']; ?>)</span>
										</div>
									</div>
								</div>

								<div class="filter_box">
									<div class="filtertitle">
										<?= $this->lang->get('SALE'); ?>
									</div>
									<div class="filtercontent">
										<div class="filteritem">
											<input type="checkbox" name="filter[sale]" id="filter_sale"><label for="filter_sale">&nbsp;Em promoção</label>
											<span style="float:right">(<?php echo $viewData['filters']['sale']; ?>)</span>
										</div>
									</div>
								</div>

								<div class="filter_box">
									<div class="filtertitle">
										<?= $this->lang->get('OPTIONS'); ?>
									</div>
									<div class="filtercontent">
										<?php foreach ($viewData['filters']['options'] as $option) : ?>
											<strong><?= $option['name']; ?></strong><br>
											<?php foreach ($option['options'] as $op) : ?>
												<div class="filteritem">
													<input type="checkbox" name="filter[options][]" id="filter_options_<?= $op['value']; ?>" value="<?= $op['value']; ?>">
													<label for="filter_options_<?= $op['value']; ?>">&nbsp;<?= $op['value']; ?></label>
													<span style="float:right">(<?php echo $op['count']; ?>)</span>
												</div>
											<?php endforeach; ?>
											<br>
										<?php endforeach; ?>
									</div>
								</div>
						</div>
						</form>
						<div class="widget">
							<h1><?= $this->lang->get('FEATUREDPRODUCTS'); ?></h1>
							<div class="widget_body">
								...
							</div>
						</div>
					</aside>
				</div>
				<div class="col-sm-9"><?php $this->loadViewInTemplate($viewName, $viewData); ?></div>
			</div>
		</div>
	</section>
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-sm-4">
					<div class="widget">
						<h1><?= $this->lang->get('FEATUREDPRODUCTS'); ?></h1>
						<div class="widget_body">
							...
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="widget">
						<h1><?= $this->lang->get('ONSALEPRODUCTS'); ?></h1>
						<div class="widget_body">
							...
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="widget">
						<h1><?= $this->lang->get('TOPRATEDPRODUCTS'); ?></h1>
						<div class="widget_body">
							...
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="subarea">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-8 col-sm-offset-2 no-padding">
						<form method="POST">
							<input class="subemail" name="email" placeholder="<?= $this->lang->get('SUBSCRIBETEXT'); ?>">
							<input type="submit" value="<?= $this->lang->get('SUBSCRIBEBUTTON'); ?>" />
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="links">
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<a href="<?php echo BASE_URL; ?>"><img width="150" src="<?php echo BASE_URL; ?>assets/images/logo.png" /></a><br /><br />
						<strong>Slogan da Loja Virtual</strong><br /><br />
						Endereço da Loja Virtual
					</div>
					<div class="col-sm-8 linkgroups">
						<div class="row">
							<div class="col-sm-4">
								<h3><?= $this->lang->get('CATEGORIES'); ?></h3>
								<ul>
									<li><a href="#">Categoria X</a></li>
									<li><a href="#">Categoria X</a></li>
									<li><a href="#">Categoria X</a></li>
									<li><a href="#">Categoria X</a></li>
									<li><a href="#">Categoria X</a></li>
									<li><a href="#">Categoria X</a></li>
								</ul>
							</div>
							<div class="col-sm-4">
								<h3><?= $this->lang->get('INFORMATION'); ?></h3>
								<ul>
									<li><a href="#">Menu 1</a></li>
									<li><a href="#">Menu 2</a></li>
									<li><a href="#">Menu 3</a></li>
									<li><a href="#">Menu 4</a></li>
									<li><a href="#">Menu 5</a></li>
									<li><a href="#">Menu 6</a></li>
								</ul>
							</div>
							<div class="col-sm-4">
								<h3><?= $this->lang->get('INFORMATION'); ?></h3>
								<ul>
									<li><a href="#">Menu 1</a></li>
									<li><a href="#">Menu 2</a></li>
									<li><a href="#">Menu 3</a></li>
									<li><a href="#">Menu 4</a></li>
									<li><a href="#">Menu 5</a></li>
									<li><a href="#">Menu 6</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="copyright">
			<div class="container">
				<div class="row">
					<div class="col-sm-6">© <span>Loja 2.0</span> - <?= $this->lang->get('ALLRIGHTRESERVED'); ?></div>
					<div class="col-sm-6">
						<div class="payments">
							<img src="<?php echo BASE_URL; ?>assets/images/visa.png" />
							<img src="<?php echo BASE_URL; ?>assets/images/visa.png" />
							<img src="<?php echo BASE_URL; ?>assets/images/visa.png" />
							<img src="<?php echo BASE_URL; ?>assets/images/visa.png" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/script.js"></script>
	<script type="text/javascript">
		var BASE_URL = "<?php echo BASE_URL; ?>";
		var maxslider = "<?php echo $viewData['filters']['maxslider']; ?>";
	</script>
</body>

</html>