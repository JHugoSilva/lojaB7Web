<?php
namespace Controllers;

use \Core\Controller;
use Models\Categories;
use Models\Filters;
use Models\Products;

class HomeController extends Controller {

	public function index() {
		$dados = [];

		$currentPage = 1;
		$offset = 0;
		$limit = 3;

		if (!empty($_GET['p'])) {
			$currentPage = $_GET['p'];
		}

		$offset = ($currentPage * $limit) - $limit;

		$products = new Products();
		$categories = new Categories();
		$f = new Filters();
		$filters = [];

		$dados['list'] = $products->getList($offset, $limit);
		$dados['totalItems'] = $products->getTotal();
		$dados['numberOfPages'] = ceil($dados['totalItems'] / $limit);
		$dados['currentPage'] = $currentPage;
		$dados['categories'] = $categories->getList();
		$dados['filters'] = $f->getFilters($filters);
		$this->loadTemplate('home', $dados);
	}

}