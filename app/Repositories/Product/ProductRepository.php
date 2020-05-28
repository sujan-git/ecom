<?php

namespace App\Repositories\Product;

interface ProductRepository{
	public function getAll();

    public function getById($id);

    public function create(array $attributes);

    public function update( array $attributes,$id);

    public function delete($data,$id);
}
?>
