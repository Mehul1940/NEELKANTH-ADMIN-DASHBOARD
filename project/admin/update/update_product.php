<?php require_once "/xampp/htdocs/Project/config/admincheck.php"; ?>
<?php require_once "/xampp/htdocs/Project/config/db.php"; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = intval($_POST['PRODUCT_ID']);
    $product_name = $conn->real_escape_string($_POST['PRODUCT_NAME']);
    $price = floatval($_POST['PRICE']);
    $category_id = intval($_POST['CATEGORY_ID']);
    $brand_id = intval($_POST['BRAND_ID']);
    $image_path =  $_POST['IMAGE_PREVIEW'];

    // Check if a new image is uploaded
    if (isset($_FILES['P_IMG']) && $_FILES['P_IMG']['error'] == 0) {
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/Project/imgs/product/";
        $filename = basename($_FILES['P_IMG']['name']);
        $target_file = $target_dir . $filename;
        $relative_path = "imgs/product/" . $filename; // Save relative path in DB
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate the file type
        $allowed_types = ["jpg", "jpeg", "png", "gif"];
        if (in_array($image_file_type, $allowed_types)) {
            if (move_uploaded_file($_FILES['P_IMG']['tmp_name'], $target_file)) {
                $image_path = $relative_path;
            } else {
                die("Error uploading image.");
            }
        } else {
            die("Invalid file type.");
        }
    }

    // Update the product record
    $query = "UPDATE product 
              SET PRODUCT_NAME = '$product_name', 
                  PRICE = $price, 
                  CATEGORY_ID = $category_id, 
                  BRAND_ID = $brand_id";
    if ($image_path) {
        $query .= ", P_IMG = '$image_path'";
    }
    $query .= " WHERE PRODUCT_ID = $product_id";

    if ($conn->query($query)) {
        header("Location: /Project/admin/module/product.php?success=Product updated successfully");
        exit();
    } else {
        die("Error updating product: " . $conn->error);
    }
}
?>
