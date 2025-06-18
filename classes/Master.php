<?php
require_once('../config.php');
class Master extends DBConnection
{
	private $settings;
	public function __construct()
	{
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	function capture_err()
	{
		if (!$this->conn->error)
			return false;
		else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function save_category()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'description'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if (isset($_POST['description'])) {
			if (!empty($data)) $data .= ",";
			$data .= " `description`='" . addslashes(htmlentities($description)) . "' ";
		}
		$check = $this->conn->query("SELECT * FROM `categories` where `category` = '{$category}' " . (!empty($id) ? " and id != {$id} " : "") . " ")->num_rows;
		if ($this->capture_err())
			return $this->capture_err();
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Category already exist.";
			return json_encode($resp);
			exit;
		}
		if (empty($id)) {
			$sql = "INSERT INTO `categories` set {$data} ";
			$save = $this->conn->query($sql);
		} else {
			$sql = "UPDATE `categories` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if ($save) {
			$resp['status'] = 'success';
			if (empty($id))
				$this->settings->set_flashdata('success', "New Category successfully saved.");
			else
				$this->settings->set_flashdata('success', "Category successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_category()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `categories` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Category successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_sub_category()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'description'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if (isset($_POST['description'])) {
			if (!empty($data)) $data .= ",";
			$data .= " `description`='" . addslashes(htmlentities($description)) . "' ";
		}
		$check = $this->conn->query("SELECT * FROM `sub_categories` where `sub_category` = '{$sub_category}' " . (!empty($id) ? " and id != {$id} " : "") . " ")->num_rows;
		if ($this->capture_err())
			return $this->capture_err();
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Sub Category already exist.";
			return json_encode($resp);
			exit;
		}
		if (empty($id)) {
			$sql = "INSERT INTO `sub_categories` set {$data} ";
			$save = $this->conn->query($sql);
		} else {
			$sql = "UPDATE `sub_categories` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if ($save) {
			$resp['status'] = 'success';
			if (empty($id))
				$this->settings->set_flashdata('success', "New Sub Category successfully saved.");
			else
				$this->settings->set_flashdata('success', "Sub Category successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_sub_category()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `sub_categories` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Sub Category successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	function delete_packages_img()
	{
		extract($_POST);
		if (is_file($path)) {
			if (unlink($path)) {
				$resp['status'] = 'success';
			} else {
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete ' . $path;
			}
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown ' . $path . ' path';
		}
		return json_encode($resp);
	}
	function save_packages()
	{
		// Initialize response
		$resp = array('status' => 'failed');

		// Prepare basic data
		$id = $_POST['id'] ?? 0;
		$title = $this->conn->real_escape_string($_POST['title'] ?? '');
		$description = $this->conn->real_escape_string($_POST['description'] ?? '');

		// Create upload directory based on package ID (or temp for new packages)
		$upload_dir = "uploads/packages/" . ($id ?: 'temp') . "/";
		if (!is_dir(base_app . $upload_dir)) {
			mkdir(base_app . $upload_dir, 0777, true);
		}

		// Process photo uploads
		$photo_data = array();
		for ($i = 1; $i <= 3; $i++) {
			$photo_field = "photo$i";
			$existing_field = "existing_photo$i";

			// Handle file upload
			if (!empty($_FILES[$photo_field]['tmp_name'])) {
				$file_name = $_FILES[$photo_field]['name'];
				$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
				$new_file_name = "photo{$i}_" . time() . ".{$file_ext}";
				$file_path = $upload_dir . $new_file_name;

				if (move_uploaded_file($_FILES[$photo_field]['tmp_name'], base_app . $file_path)) {
					$photo_data[$photo_field] = $file_path;
				}
			}
			// Keep existing photo if no new upload
			elseif (!empty($_POST[$existing_field])) {
				$photo_data[$photo_field] = $_POST[$existing_field];
			}
		}

		// Check for duplicate title
		$check = $this->conn->query("SELECT id FROM `packages` WHERE `title` = '{$title}'" .
			($id ? " AND id != {$id}" : ""))->num_rows;
		if ($check > 0) {
			$resp['msg'] = "Package with this title already exists.";
			return json_encode($resp);
		}

		// Build SQL query
		if ($id) {
			// Update existing package
			$set = array(
				"title = '{$title}'",
				"description = '{$description}'"
			);

			foreach ($photo_data as $field => $value) {
				$set[] = "{$field} = '{$value}'";
			}

			$sql = "UPDATE `packages` SET " . implode(", ", $set) . " WHERE id = {$id}";
		} else {
			// Create new package
			$columns = array('title', 'description', 'date_created');
			$values = array(
				"'{$title}'",
				"'{$description}'",
				"'" . date('Y-m-d') . "'"
			);

			foreach ($photo_data as $field => $value) {
				$columns[] = $field;
				$values[] = "'{$value}'";
			}

			$sql = "INSERT INTO `packages` (" . implode(", ", $columns) . ") 
                VALUES (" . implode(", ", $values) . ")";
		}

		// Execute query
		$save = $this->conn->query($sql);

		if ($save) {
			$resp['status'] = 'success';

			// For new packages, rename temp directory to actual ID
			if (!$id) {
				$new_id = $this->conn->insert_id;
				$temp_dir = "uploads/packages/temp/";
				$new_dir = "uploads/packages/{$new_id}/";

				if (is_dir(base_app . $temp_dir)) {
					rename(base_app . $temp_dir, base_app . $new_dir);

					// Update photo paths in database with new directory
					foreach ($photo_data as $field => $value) {
						$new_path = str_replace('/temp/', "/{$new_id}/", $value);
						$this->conn->query("UPDATE `packages` SET {$field} = '{$new_path}' WHERE id = {$new_id}");
					}
				}
			}
		} else {
			$resp['msg'] = $this->conn->error;
			$resp['sql'] = $sql; // For debugging
		}

		return json_encode($resp);
	}

	function delete_package_photo()
	{
		// Initialize response
		$resp = array('status' => 'failed', 'msg' => '');

		// Get the path from POST data
		$path = $_POST['path'] ?? '';

		if (empty($path)) {
			$resp['msg'] = 'No file path provided';
			return json_encode($resp);
		}

		// Construct full file path
		$full_path = base_app . $path;

		// Verify the file exists and is within the uploads directory
		if (file_exists($full_path) && strpos($full_path, base_app . 'uploads/') === 0) {
			if (unlink($full_path)) {
				$resp['status'] = 'success';
				$resp['msg'] = 'Photo deleted successfully';

				// Optional: Update database to remove the photo reference
				$photo_field = '';
				if (strpos($path, 'photo1') !== false) $photo_field = 'photo1';
				elseif (strpos($path, 'photo2') !== false) $photo_field = 'photo2';
				elseif (strpos($path, 'photo3') !== false) $photo_field = 'photo3';

				if (!empty($photo_field)) {
					// Get package ID from path
					$path_parts = explode('/', $path);
					$package_id = $path_parts[2] ?? 0;

					if (is_numeric($package_id) && $package_id > 0) {
						$this->conn->query("UPDATE packages SET {$photo_field} = '' WHERE id = {$package_id}");
					}
				}
			} else {
				$resp['msg'] = 'Failed to delete file (permission error)';
			}
		} else {
			$resp['msg'] = 'File does not exist or invalid path';
		}

		return json_encode($resp);
	}
	function delete_package()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `packages` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Packages successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_product()
	{
		foreach ($_POST as $k => $v) {
			$_POST[$k] = addslashes($v);
		}
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'description'))) {
				if (!empty($data)) $data .= ",";
				$v = addslashes($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if (isset($_POST['description'])) {
			if (!empty($data)) $data .= ",";
			$data .= " `description`='" . addslashes(htmlentities($description)) . "' ";
		}
		$check = $this->conn->query("SELECT * FROM `products` where `title` = '{$title}' " . (!empty($id) ? " and id != {$id} " : "") . " ")->num_rows;
		if ($this->capture_err())
			return $this->capture_err();
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Book already exist.";
			return json_encode($resp);
			exit;
		}
		if (empty($id)) {
			$sql = "INSERT INTO `products` set {$data} ";
			$save = $this->conn->query($sql);
			$id = $this->conn->insert_id;
		} else {
			$sql = "UPDATE `products` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if ($save) {
			$upload_path = "uploads/product_" . $id;
			if (!is_dir(base_app . $upload_path))
				mkdir(base_app . $upload_path);
			if (isset($_FILES['img']) && count($_FILES['img']['tmp_name']) > 0) {
				foreach ($_FILES['img']['tmp_name'] as $k => $v) {
					if (!empty($_FILES['img']['tmp_name'][$k])) {
						move_uploaded_file($_FILES['img']['tmp_name'][$k], base_app . $upload_path . '/' . $_FILES['img']['name'][$k]);
					}
				}
			}
			$resp['status'] = 'success';
			if (empty($id))
				$this->settings->set_flashdata('success', "New Book successfully saved.");
			else
				$this->settings->set_flashdata('success', "Book successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_product()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `products` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Product successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function delete_img()
	{
		extract($_POST);
		if (is_file($path)) {
			if (unlink($path)) {
				$resp['status'] = 'success';
			} else {
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete ' . $path;
			}
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown ' . $path . ' path';
		}
		return json_encode($resp);
	}
	function save_inventory()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `inventory` where `product_id` = '{$product_id}' and `type_name` = '{$type_name}' " . (!empty($id) ? " and id != {$id} " : "") . " ")->num_rows;
		if ($this->capture_err())
			return $this->capture_err();
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Menu Pricing Already Exist.";
			return json_encode($resp);
			exit;
		}
		if (empty($id)) {
			$sql = "INSERT INTO `inventory` set {$data} ";
			$save = $this->conn->query($sql);
		} else {
			$sql = "UPDATE `inventory` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if ($save) {
			$resp['status'] = 'success';
			if (empty($id))
				$this->settings->set_flashdata('success', "New Menu Pricing successfully saved.");
			else
				$this->settings->set_flashdata('success', "Menu Pricing successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_inventory()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `inventory` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Menu Pricing successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function register()
	{
		extract($_POST);
		$data = "";
		$_POST['password'] = md5($_POST['password']);
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `clients` where `email` = '{$email}' " . (!empty($id) ? " and id != {$id} " : "") . " ")->num_rows;
		if ($this->capture_err())
			return $this->capture_err();
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Email already taken.";
			return json_encode($resp);
			exit;
		}
		if (empty($id)) {
			$sql = "INSERT INTO `clients` set {$data} ";
			$save = $this->conn->query($sql);
			$id = $this->conn->insert_id;
		} else {
			$sql = "UPDATE `clients` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if ($save) {
			$resp['status'] = 'success';
			if (empty($id))
				$this->settings->set_flashdata('success', "Account successfully created.");
			else
				$this->settings->set_flashdata('success', "Account successfully updated.");
			foreach ($_POST as $k => $v) {
				$this->settings->set_userdata($k, $v);
			}
			$this->settings->set_userdata('id', $id);
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}

	function add_to_cart()
	{
		extract($_POST);
		$data = " client_id = '" . $this->settings->userdata('id') . "' ";
		$_POST['price'] = str_replace(",", "", $_POST['price']);
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `cart` where `inventory_id` = '{$inventory_id}' and client_id = " . $this->settings->userdata('id'))->num_rows;
		if ($this->capture_err())
			return $this->capture_err();
		if ($check > 0) {
			$sql = "UPDATE `cart` set quantity = quantity + {$quantity} where `inventory_id` = '{$inventory_id}' and client_id = " . $this->settings->userdata('id');
		} else {
			$sql = "INSERT INTO `cart` set {$data} ";
		}

		$save = $this->conn->query($sql);
		if ($this->capture_err())
			return $this->capture_err();
		if ($save) {
			$resp['status'] = 'success';
			$resp['cart_count'] = $this->conn->query("SELECT SUM(quantity) as items from `cart` where client_id =" . $this->settings->userdata('id'))->fetch_assoc()['items'];
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function update_cart_qty()
	{
		extract($_POST);

		$save = $this->conn->query("UPDATE `cart` set quantity = '{$quantity}' where id = '{$id}'");
		if ($this->capture_err())
			return $this->capture_err();
		if ($save) {
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function empty_cart()
	{
		$delete = $this->conn->query("DELETE FROM `cart` where client_id = " . $this->settings->userdata('id'));
		if ($this->capture_err())
			return $this->capture_err();
		if ($delete) {
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_cart()
	{
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM `cart` where id = '{$id}'");
		if ($this->capture_err())
			return $this->capture_err();
		if ($delete) {
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_order()
	{
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM `orders` where id = '{$id}'");
		$delete2 = $this->conn->query("DELETE FROM `order_list` where order_id = '{$id}'");
		$delete3 = $this->conn->query("DELETE FROM `sales` where order_id = '{$id}'");
		if ($this->capture_err())
			return $this->capture_err();
		if ($delete) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Order successfully deleted");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function place_order()
	{
		extract($_POST);
		$client_id = $this->settings->userdata('id');

		$data = " client_id = '{$client_id}' ";
		$data .= " ,event = '{$event}' ";
		$data .= " ,venue = '{$venue}' ";
		$data .= " ,amount = '{$amount}' ";
		$data .= " ,event_date = '{$event_date}' ";
		$order_sql = "INSERT INTO `orders` set $data";
		$save_order = $this->conn->query($order_sql);
		if ($this->capture_err())
			return $this->capture_err();
		if ($save_order) {
			$order_id = $this->conn->insert_id;
			$data = '';
			$cart = $this->conn->query("SELECT c.*,p.title,i.price,i.id as pid from `cart` c inner join `inventory` i on i.id=c.inventory_id inner join products p on p.id = i.product_id where c.client_id ='{$client_id}' ");
			while ($row = $cart->fetch_assoc()):
				if (!empty($data)) $data .= ", ";
				$total = $row['price'] * $row['quantity'];
				$data .= "('{$order_id}','{$row['pid']}','{$row['quantity']}','{$row['price']}', $total)";
			endwhile;
			$list_sql = "INSERT INTO `order_list` (order_id,inventory_id,quantity,price,total) VALUES {$data} ";
			$save_olist = $this->conn->query($list_sql);
			if ($this->capture_err())
				return $this->capture_err();
			if ($save_olist) {
				$empty_cart = $this->conn->query("DELETE FROM `cart` where client_id = '{$client_id}'");
				$data = " order_id = '{$order_id}'";
				$data .= " ,total_amount = '{$amount}'";
				$save_sales = $this->conn->query("INSERT INTO `sales` set $data");
				if ($this->capture_err())
					return $this->capture_err();
				$resp['status'] = 'success';
			} else {
				$resp['status'] = 'failed';
				$resp['err_sql'] = $save_olist;
			}
		} else {
			$resp['status'] = 'failed';
			$resp['err_sql'] = $save_order;
		}
		return json_encode($resp);
	}
	function update_order_status()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$update = $this->conn->query("UPDATE `orders` set $data where id = '{$id}' ");
		if ($update) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata("success", " Order status successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function pay_order()
	{
		extract($_POST);
		$update = $this->conn->query("UPDATE `orders` set `paid` = '1' where id = '{$id}' ");
		if ($update) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata("success", " Order payment status successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function update_account()
	{
		extract($_POST);
		$data = "";
		if (!empty($password)) {
			$_POST['password'] = md5($password);
			if (md5($cpassword) != $this->settings->userdata('password')) {
				$resp['status'] = 'failed';
				$resp['msg'] = "Current Password is Incorrect";
				return json_encode($resp);
				exit;
			}
		}
		$check = $this->conn->query("SELECT * FROM `clients`  where `email`='{$email}' and `id` != $id ")->num_rows;
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Email already taken.";
			return json_encode($resp);
			exit;
		}
		foreach ($_POST as $k => $v) {
			if ($k == 'cpassword' || ($k == 'password' && empty($v)))
				continue;
			if (!empty($data)) $data .= ",";
			$data .= " `{$k}`='{$v}' ";
		}
		$save = $this->conn->query("UPDATE `clients` set $data where id = $id ");
		if ($save) {
			foreach ($_POST as $k => $v) {
				if ($k != 'cpassword')
					$this->settings->set_userdata($k, $v);
			}

			$this->settings->set_userdata('id', $this->conn->insert_id);
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_category':
		echo $Master->save_category();
		break;
	case 'delete_category':
		echo $Master->delete_category();
		break;
	case 'save_sub_category':
		echo $Master->save_sub_category();
		break;
	case 'delete_sub_category':
		echo $Master->delete_sub_category();
		break;
	case 'save_product':
		echo $Master->save_product();
		break;
	case 'delete_product':
		echo $Master->delete_product();
		break;

	case 'save_packages':
		echo $Master->save_packages();
		break;

	case 'delete_package_photo':
		echo $Master->delete_package_photo();
		break;

	case 'delete_package':
		echo $Master->delete_package();
		break;

	case 'save_inventory':
		echo $Master->save_inventory();
		break;
	case 'delete_inventory':
		echo $Master->delete_inventory();
		break;
	case 'register':
		echo $Master->register();
		break;
	case 'add_to_cart':
		echo $Master->add_to_cart();
		break;
	case 'update_cart_qty':
		echo $Master->update_cart_qty();
		break;
	case 'delete_cart':
		echo $Master->delete_cart();
		break;
	case 'empty_cart':
		echo $Master->empty_cart();
		break;
	case 'delete_img':
		echo $Master->delete_img();
		break;
	case 'place_order':
		echo $Master->place_order();
		break;
	case 'update_order_status':
		echo $Master->update_order_status();
		break;
	case 'pay_order':
		echo $Master->pay_order();
		break;
	case 'update_account':
		echo $Master->update_account();
		break;
	case 'delete_order':
		echo $Master->delete_order();
		break;
	default:
		// echo $sysset->index();
		break;
}
