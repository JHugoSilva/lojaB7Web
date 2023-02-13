<?php
namespace Controllers;

use \Core\Controller;
use \Models\Exemplo;

class LangController extends Controller {

	public function index() { }

	public function set($lang) {
		$_SESSION['lang'] = $lang;
		header("Location:".BASE_URL);
	}
}