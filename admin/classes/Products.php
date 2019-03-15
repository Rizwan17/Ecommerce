<?php 
session_start();
/**
 * ALTER TABLE products ADD product_qty INT(11) NOT NULL AFTER `product_price`;
 	UPDATE `products` SET product_qty = 1000 WHERE 1;

	CREATE TABLE `products` (
 `product_id` int(100) NOT NULL AUTO_INCREMENT,
 `product_cat` int(11) NOT NULL,
 `product_brand` int(100) NOT NULL,
 `product_title` varchar(255) NOT NULL,
 `product_price` int(100) NOT NULL,
 `product_qty` int(11) NOT NULL,
 `product_desc` text NOT NULL,
 `product_image` text NOT NULL,
 `product_keywords` text NOT NULL,
  CONSTRAINT fk_product_cat FOREIGN KEY fk_product_cat (product_cat) REFERENCES categories(cat_id),
    CONSTRAINT fk_product_brand FOREIGN KEY fk_product_brand (product_brand) REFERENCES brands(brand_id),
 PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
 	
 */
class Products
{
	
	private $con;

	function __construct()
	{
		include_once("Database.php");
		$db = new Database();
		$this->con = $db->connect();
	}

	public function getProducts(){
		$q = $this->con->query("SELECT p.product_id, p.product_title, p.product_price,p.product_qty, p.product_desc, p.product_image, p.product_keywords, c.cat_title, c.cat_id, b.brand_id, b.brand_title FROM products p JOIN categories c ON c.cat_id = p.product_cat JOIN brands b ON b.brand_id = p.product_brand");
		
		$products = [];
		if ($q->num_rows > 0) {
			while($row = $q->fetch_assoc()){
				$products[] = $row;
			}
			//return ['status'=> 202, 'message'=> $ar];
			$_DATA['products'] = $products;
		}

		$categories = [];
		$q = $this->con->query("SELECT * FROM categories");
		if ($q->num_rows > 0) {
			while($row = $q->fetch_assoc()){
				$categories[] = $row;
			}
			//return ['status'=> 202, 'message'=> $ar];
			$_DATA['categories'] = $categories;
		}

		$brands = [];
		$q = $this->con->query("SELECT * FROM brands");
		if ($q->num_rows > 0) {
			while($row = $q->fetch_assoc()){
				$brands[] = $row;
			}
			//return ['status'=> 202, 'message'=> $ar];
			$_DATA['brands'] = $brands;
		}


		return ['status'=> 202, 'message'=> $_DATA];
	}

	public function addProduct($product_name,
								$brand_id,
								$category_id,
								$product_desc,
								$product_qty,
								$product_price,
								$product_keywords,
								$file){


		$fileName = $file['name'];
		$fileNameAr= explode(".", $fileName);
		$extension = end($fileNameAr);
		$ext = strtolower($extension);

		if ($ext == "jpg" || $ext == "jpeg" || $ext == "png") {
			
			//print_r($file['size']);

			if ($file['size'] > (1024 * 2)) {
				
				$uniqueImageName = time()."_".$file['name'];
				if (move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/KhanStore/product_images/".$uniqueImageName)) {
					
					$q = $this->con->query("INSERT INTO `products`(`product_cat`, `product_brand`, `product_title`, `product_qty`, `product_price`, `product_desc`, `product_image`, `product_keywords`) VALUES ('$category_id', '$brand_id', '$product_name', '$product_qty', '$product_price', '$product_desc', '$uniqueImageName', '$product_keywords')");

					if ($q) {
						return ['status'=> 202, 'message'=> 'Product Added Successfully..!'];
					}else{
						return ['status'=> 303, 'message'=> 'Failed to run query'];
					}

				}else{
					return ['status'=> 303, 'message'=> 'Failed to upload image'];
				}

			}else{
				return ['status'=> 303, 'message'=> 'Large Image ,Max Size allowed 2MB'];
			}

		}else{
			return ['status'=> 303, 'message'=> 'Invalid Image Format [Valid Formats : jpg, jpeg, png]'];
		}

	}


	public function editProductWithImage($pid,
										$product_name,
										$brand_id,
										$category_id,
										$product_desc,
										$product_qty,
										$product_price,
										$product_keywords,
										$file){


		$fileName = $file['name'];
		$fileNameAr= explode(".", $fileName);
		$extension = end($fileNameAr);
		$ext = strtolower($extension);

		if ($ext == "jpg" || $ext == "jpeg" || $ext == "png") {
			
			//print_r($file['size']);

			if ($file['size'] > (1024 * 2)) {
				
				$uniqueImageName = time()."_".$file['name'];
				if (move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/KhanStore/product_images/".$uniqueImageName)) {
					
					$q = $this->con->query("UPDATE `products` SET 
										`product_cat` = '$category_id', 
										`product_brand` = '$brand_id', 
										`product_title` = '$product_name', 
										`product_qty` = '$product_qty', 
										`product_price` = '$product_price', 
										`product_desc` = '$product_desc', 
										`product_image` = '$uniqueImageName', 
										`product_keywords` = '$product_keywords'
										WHERE product_id = '$pid'");

					if ($q) {
						return ['status'=> 202, 'message'=> 'Product Modified Successfully..!'];
					}else{
						return ['status'=> 303, 'message'=> 'Failed to run query'];
					}

				}else{
					return ['status'=> 303, 'message'=> 'Failed to upload image'];
				}

			}else{
				return ['status'=> 303, 'message'=> 'Large Image ,Max Size allowed 2MB'];
			}

		}else{
			return ['status'=> 303, 'message'=> 'Invalid Image Format [Valid Formats : jpg, jpeg, png]'];
		}

	}

	public function editProductWithoutImage($pid,
										$product_name,
										$brand_id,
										$category_id,
										$product_desc,
										$product_qty,
										$product_price,
										$product_keywords){

		if ($pid != null) {
			$q = $this->con->query("UPDATE `products` SET 
										`product_cat` = '$category_id', 
										`product_brand` = '$brand_id', 
										`product_title` = '$product_name', 
										`product_qty` = '$product_qty', 
										`product_price` = '$product_price', 
										`product_desc` = '$product_desc',
										`product_keywords` = '$product_keywords'
										WHERE product_id = '$pid'");

			if ($q) {
				return ['status'=> 202, 'message'=> 'Product updated Successfully'];
			}else{
				return ['status'=> 303, 'message'=> 'Failed to run query'];
			}
			
		}else{
			return ['status'=> 303, 'message'=> 'Invalid product id'];
		}
		
	}


	public function getBrands(){
		$q = $this->con->query("SELECT * FROM brands");
		$ar = [];
		if ($q->num_rows > 0) {
			while ($row = $q->fetch_assoc()) {
				$ar[] = $row;
			}
		}
		return ['status'=> 202, 'message'=> $ar];
	}

	public function addCategory($name){
		$q = $this->con->query("SELECT * FROM categories WHERE cat_title = '$name' LIMIT 1");
		if ($q->num_rows > 0) {
			return ['status'=> 303, 'message'=> 'Category already exists'];
		}else{
			$q = $this->con->query("INSERT INTO categories (cat_title) VALUES ('$name')");
			if ($q) {
				return ['status'=> 202, 'message'=> 'New Category added Successfully'];
			}else{
				return ['status'=> 303, 'message'=> 'Failed to run query'];
			}
		}
	}

	public function getCategories(){
		$q = $this->con->query("SELECT * FROM categories");
		$ar = [];
		if ($q->num_rows > 0) {
			while ($row = $q->fetch_assoc()) {
				$ar[] = $row;
			}
		}
		return ['status'=> 202, 'message'=> $ar];
	}

	public function deleteProduct($pid = null){
		if ($pid != null) {
			$q = $this->con->query("DELETE FROM products WHERE product_id = '$pid'");
			if ($q) {
				return ['status'=> 202, 'message'=> 'Product removed from stocks'];
			}else{
				return ['status'=> 202, 'message'=> 'Failed to run query'];
			}
			
		}else{
			return ['status'=> 303, 'message'=>'Invalid product id'];
		}

	}

	public function deleteCategory($cid = null){
		if ($cid != null) {
			$q = $this->con->query("DELETE FROM categories WHERE cat_id = '$cid'");
			if ($q) {
				return ['status'=> 202, 'message'=> 'Category removed'];
			}else{
				return ['status'=> 202, 'message'=> 'Failed to run query'];
			}
			
		}else{
			return ['status'=> 303, 'message'=>'Invalid cattegory id'];
		}

	}
	
	

	public function updateCategory($post = null){
		extract($post);
		if (!empty($cat_id) && !empty($e_cat_title)) {
			$q = $this->con->query("UPDATE categories SET cat_title = '$e_cat_title' WHERE cat_id = '$cat_id'");
			if ($q) {
				return ['status'=> 202, 'message'=> 'Category updated'];
			}else{
				return ['status'=> 202, 'message'=> 'Failed to run query'];
			}
			
		}else{
			return ['status'=> 303, 'message'=>'Invalid category id'];
		}

	}

	public function addBrand($name){
		$q = $this->con->query("SELECT * FROM brands WHERE brand_title = '$name' LIMIT 1");
		if ($q->num_rows > 0) {
			return ['status'=> 303, 'message'=> 'Brand already exists'];
		}else{
			$q = $this->con->query("INSERT INTO brands (brand_title) VALUES ('$name')");
			if ($q) {
				return ['status'=> 202, 'message'=> 'New Brand added Successfully'];
			}else{
				return ['status'=> 303, 'message'=> 'Failed to run query'];
			}
		}
	}

	public function deleteBrand($bid = null){
		if ($bid != null) {
			$q = $this->con->query("DELETE FROM brands WHERE brand_id = '$bid'");
			if ($q) {
				return ['status'=> 202, 'message'=> 'Brand removed'];
			}else{
				return ['status'=> 202, 'message'=> 'Failed to run query'];
			}
			
		}else{
			return ['status'=> 303, 'message'=>'Invalid brand id'];
		}

	}
	
	

	public function updateBrand($post = null){
		extract($post);
		if (!empty($brand_id) && !empty($e_brand_title)) {
			$q = $this->con->query("UPDATE brands SET brand_title = '$e_brand_title' WHERE brand_id = '$brand_id'");
			if ($q) {
				return ['status'=> 202, 'message'=> 'Brand updated'];
			}else{
				return ['status'=> 202, 'message'=> 'Failed to run query'];
			}
			
		}else{
			return ['status'=> 303, 'message'=>'Invalid brand id'];
		}

	}

	

}


if (isset($_POST['GET_PRODUCT'])) {
	if (isset($_SESSION['admin_id'])) {
		$p = new Products();
		echo json_encode($p->getProducts());
		exit();
	}
}


if (isset($_POST['add_product'])) {

	extract($_POST);
	if (!empty($product_name) 
	&& !empty($brand_id) 
	&& !empty($category_id)
	&& !empty($product_desc)
	&& !empty($product_qty)
	&& !empty($product_price)
	&& !empty($product_keywords)
	&& !empty($_FILES['product_image']['name'])) {
		

		$p = new Products();
		$result = $p->addProduct($product_name,
								$brand_id,
								$category_id,
								$product_desc,
								$product_qty,
								$product_price,
								$product_keywords,
								$_FILES['product_image']);
		
		header("Content-type: application/json");
		echo json_encode($result);
		http_response_code($result['status']);
		exit();


	}else{
		echo json_encode(['status'=> 303, 'message'=> 'Empty fields']);
		exit();
	}



	
}


if (isset($_POST['edit_product'])) {

	extract($_POST);
	if (!empty($pid)
	&& !empty($e_product_name) 
	&& !empty($e_brand_id) 
	&& !empty($e_category_id)
	&& !empty($e_product_desc)
	&& !empty($e_product_qty)
	&& !empty($e_product_price)
	&& !empty($e_product_keywords) ) {
		
		$p = new Products();

		if (isset($_FILES['e_product_image']['name']) 
			&& !empty($_FILES['e_product_image']['name'])) {
			$result = $p->editProductWithImage($pid,
								$e_product_name,
								$e_brand_id,
								$e_category_id,
								$e_product_desc,
								$e_product_qty,
								$e_product_price,
								$e_product_keywords,
								$_FILES['e_product_image']);
		}else{
			$result = $p->editProductWithoutImage($pid,
								$e_product_name,
								$e_brand_id,
								$e_category_id,
								$e_product_desc,
								$e_product_qty,
								$e_product_price,
								$e_product_keywords);
		}

		echo json_encode($result);
		exit();


	}else{
		echo json_encode(['status'=> 303, 'message'=> 'Empty fields']);
		exit();
	}



	
}

if (isset($_POST['GET_BRAND'])) {
	$p = new Products();
	echo json_encode($p->getBrands());
	exit();
	
}

if (isset($_POST['add_category'])) {
	if (isset($_SESSION['admin_id'])) {
		$cat_title = $_POST['cat_title'];
		if (!empty($cat_title)) {
			$p = new Products();
			echo json_encode($p->addCategory($cat_title));
		}else{
			echo json_encode(['status'=> 303, 'message'=> 'Empty fields']);
		}
	}else{
		echo json_encode(['status'=> 303, 'message'=> 'Session Error']);
	}
}

if (isset($_POST['GET_CATEGORIES'])) {
	$p = new Products();
	echo json_encode($p->getCategories());
	exit();
	
}

if (isset($_POST['DELETE_PRODUCT'])) {
	$p = new Products();
	if (isset($_SESSION['admin_id'])) {
		if(!empty($_POST['pid'])){
			$pid = $_POST['pid'];
			echo json_encode($p->deleteProduct($pid));
			exit();
		}else{
			echo json_encode(['status'=> 303, 'message'=> 'Invalid product id']);
			exit();
		}
	}else{
		echo json_encode(['status'=> 303, 'message'=> 'Invalid Session']);
	}


}


if (isset($_POST['DELETE_CATEGORY'])) {
	if (!empty($_POST['cid'])) {
		$p = new Products();
		echo json_encode($p->deleteCategory($_POST['cid']));
		exit();
	}else{
		echo json_encode(['status'=> 303, 'message'=> 'Invalid details']);
		exit();
	}
}

if (isset($_POST['edit_category'])) {
	if (!empty($_POST['cat_id'])) {
		$p = new Products();
		echo json_encode($p->updateCategory($_POST));
		exit();
	}else{
		echo json_encode(['status'=> 303, 'message'=> 'Invalid details']);
		exit();
	}
}

if (isset($_POST['add_brand'])) {
	if (isset($_SESSION['admin_id'])) {
		$brand_title = $_POST['brand_title'];
		if (!empty($brand_title)) {
			$p = new Products();
			echo json_encode($p->addBrand($brand_title));
		}else{
			echo json_encode(['status'=> 303, 'message'=> 'Empty fields']);
		}
	}else{
		echo json_encode(['status'=> 303, 'message'=> 'Session Error']);
	}
}

if (isset($_POST['DELETE_BRAND'])) {
	if (!empty($_POST['bid'])) {
		$p = new Products();
		echo json_encode($p->deleteBrand($_POST['bid']));
		exit();
	}else{
		echo json_encode(['status'=> 303, 'message'=> 'Invalid details']);
		exit();
	}
}

if (isset($_POST['edit_brand'])) {
	if (!empty($_POST['brand_id'])) {
		$p = new Products();
		echo json_encode($p->updateBrand($_POST));
		exit();
	}else{
		echo json_encode(['status'=> 303, 'message'=> 'Invalid details']);
		exit();
	}
}

?>