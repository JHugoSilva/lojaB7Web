<?php
namespace Controllers;

use \Core\Controller;
use Models\Categories;
use Models\Products;

class CategoriesController extends Controller {

	public function index() {
		header("Location:".BASE_URL);
		exit;
	}

	public function enter($id) {
		$dados = [];

		$categories = new Categories();
		$products = new Products();
		$dados['category_name'] = $categories->getCategoryName($id);

		if (!empty($dados['category_name'])) {
			$currentPage = 1;
			$offset = 0;
			$limit = 3;

			if (!empty($_GET['p'])) {
				$currentPage = $_GET['p'];
			}

			$offset = ($currentPage * $limit) - $limit;
			$filters = ['category' => $id];
			$dados['category_filter'] = $categories->getCategoryTree($id);
			$dados['list'] = $products->getList($offset, $limit, $filters);
			$dados['totalItems'] = $products->getTotal($filters);
			$dados['numberOfPages'] = ceil($dados['totalItems'] / $limit);
			$dados['currentPage'] = $currentPage;
			$dados['id_category'] = $id;
			$dados['categories'] = $categories->getList();
			$this->loadTemplate('categories', $dados);
		} else {
			header("Location:".BASE_URL);
			exit;
		}
	}

}