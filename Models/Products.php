<?php

namespace Models;

use \Core\Model;
use PDO;

class Products extends Model
{

	public function getAvailableOptions($filters=[]) {
		$groups = [];
		$ids = [];

		$where = $this->buildWhere($filters);

		$sql = "SELECT id, options FROM products WHERE ".implode(' AND ', $where);

		$sql = $this->db->prepare($sql);
		$this->bindWhere($filters, $sql);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			foreach ($sql->fetchAll(\PDO::FETCH_ASSOC) as $product) {
				$ops = explode(',', $product['options']);
				$ids[] = $product['id'];
				foreach ($ops as $op) {
					if (!in_array($op, $groups)) {
						$groups[] = $op;
					}
				}
			}
		}
		$options = $this->getAvailableValuesFromOptions($groups, $ids);

		return $options;
	}

	public function getSaleCount($filters=[])
	{
		$array = [];

		$where = $this-> buildWhere($filters);
		$where[] = 'sale = "1"';

		$sql = "SELECT COUNT(*) AS c
			FROM
			products
			WHERE ".implode(' AND ', $where);

		$sql = $this->db->prepare($sql);

		$this->bindWhere($filters, $sql);

		$sql->execute();

		if ($sql->rowCount() > 0) {
			$sql = $sql->fetch(\PDO::FETCH_ASSOC);
			return $sql['c'];
		} else {
			return '0';
		}

		return $array;
	}

	public function getList($offset = 0, $limit = 3, $filters=[])
	{
		$array = [];

		$where = $this-> buildWhere($filters);

		$sql = "SELECT *,
			(SELECT brands.name FROM brands WHERE brands.id = products.id_brand) AS brand_name,
			(SELECT categories.name FROM categories WHERE categories.id = products.id_category) AS category_name
			FROM
			products
			WHERE ".implode(' AND ', $where)."
			LIMIT $offset, $limit";

		$sql = $this->db->prepare($sql);

		$this->bindWhere($filters, $sql);

		$sql->execute();

		if ($sql->rowCount() > 0) {
			$array = $sql->fetchAll(PDO::FETCH_ASSOC);

			foreach ($array as $key => $item) {
				$array[$key]['images'] = $this->getImageByProduct($item['id']);
			}
		}

		return $array;
	}

	public function getImageByProduct($id) {
		$array = [];

		$sql = "SELECT url FROM products_images WHERE id_product = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();
		if ($sql->rowCount() > 0) {
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $array;
	}

	public function getTotal($filters=[]) {

		$where = $this-> buildWhere($filters);

		$sql = "SELECT
			COUNT(*) AS total
			FROM products WHERE ".implode(' AND ', $where);
		$sql = $this->db->prepare($sql);

		$this->bindWhere($filters, $sql);

		$sql->execute();
		if ($sql->rowCount() > 0) {
			$sql = $sql->fetch(\PDO::FETCH_ASSOC);
		}
		return $sql['total'];
	}

	public function getListOfStars($filters = []) {
		$array = [];

		$where = $this->buildWhere($filters);

		$sql = "SELECT rating, COUNT(id)AS c FROM products WHERE ".implode(' AND ', $where)." GROUP BY rating";
		$sql = $this->db->prepare($sql);

		$this->bindWhere($filters, $sql);

		$sql->execute();

		if ($sql->rowCount() > 0) {
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $array;
	}

	public function getListOfBrands($filters=[]) {
		$array = [];

		$where = $this->buildWhere($filters);

		$sql = "SELECT id_brand, COUNT(id)AS c FROM products WHERE ".implode(' AND ', $where)." GROUP BY id_brand";
		$sql = $this->db->prepare($sql);

		$this->bindWhere($filters, $sql);

		$sql->execute();

		if ($sql->rowCount() > 0) {
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $array;
	}

	public function getMaxPrice($filters=[]) {

		$where = $this->buildWhere($filters);

		$sql = "SELECT price FROM products WHERE ".implode(' AND ', $where)." ORDER BY price DESC LIMIT 1";
		$sql = $this->db->prepare($sql);

		$this->bindWhere($filters, $sql);

		$sql->execute();

		if ($sql->rowCount() > 0) {
			$sql = $sql->fetch(\PDO::FETCH_ASSOC);
			return $sql['price'];
		} else {
			return '0';
		}
	}

	private function buildWhere($filters) {
		$where = ['1=1'];
		if (!empty($filters['category'])) {
			$where[] = 'id_category=:id_category';
		}
		return $where;
	}

	private function bindWhere($filters, &$sql) {
		if (!empty($filters['category'])) {
			$sql->bindValue(':id_category', $filters['category']);
		}
	}

	private function getAvailableValuesFromOptions($groups, $ids) {
		$array = [];
		$options = new Options();
		foreach ($groups as $op) {
			$array[$op] = [
				'name' => $options->getName($op),
				'options' => []
			];
		}

		$sql = "SELECT
			id,
			p_value,
			id_option,
			COUNT(id_option) AS c
			FROM products_options
			WHERE id_option IN ('".implode("','", $groups)."') AND
			id_product IN ('".implode("','", $ids)."')
			GROUP BY p_value, id_option, id
			ORDER BY id_option
		";
		$sql = $this->db->query($sql);
		if ($sql->rowCount() > 0) {
			foreach ($sql->fetchAll() as $ops) {
				$array[$ops['id_option']]['options'][] = [
					'id' => $ops['id'],
					'id_option' => $ops['id_option'],
					'value' => $ops['p_value'],
					'count' => $ops['c']
				];
			}
		}

		return $array;
	}
}