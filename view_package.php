<?php
$packages = $conn->query("SELECT * FROM `packages` WHERE md5(id) = '{$_GET['id']}' ");
if ($packages->num_rows > 0) {
    foreach ($packages->fetch_assoc() as $k => $v) {
        $$k = stripslashes($v);
    }
}
?>

<!-- Header with black overlay -->
<header class="bg-dark py-5 position-relative" id="main-header">
    <div class="overlay"></div>
    <div class="container px-4 px-lg-5 my-5 position-relative">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder"><?php echo $title ?></h1>
            <p class="lead fw-normal text-white-50 mb-0">Our Exclusive Event Packages!</p>
        </div>
    </div>
</header>

<!-- Package Content -->
<section class="py-5" id="packages-section">
    <div class="container px-4 px-lg-5">
        <div class="text-center mb-5">
            <p class="lead fw-normal text-muted"><?php echo $description ?></p>
        </div>

        <div class="row gx-4 gx-lg-5 justify-content-center">
            <?php
            // Gather available images
            $images = [];
            if (!empty($photo1)) $images[] = $photo1;
            if (!empty($photo2)) $images[] = $photo2;
            if (!empty($photo3)) $images[] = $photo3;

            foreach ($images as $img):
            ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="position-relative overflow-hidden" style="height: 250px;">
                        <img class="card-img-top w-100 h-100 object-fit-cover"
                            src="<?php echo validate_image($img) ?>"
                            alt="Package Image">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Packages Section-->
<!-- Featured Products Section -->
<section class="py-1" id="products-section">
    <div class="container px-4 px-lg-5">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bolder">Featured Products</h2>
            <p class="lead fw-normal text-muted">Top picks from our products just for you.</p>
        </div>
        <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-lg-3 justify-content-center">
            <?php
            $products = $conn->query("SELECT * FROM `products` WHERE status = 1 AND `id` IN (SELECT product_id FROM `inventory`) AND package_id = '$id' ORDER BY rand() LIMIT 8");
            while($row = $products->fetch_assoc()):
                foreach ($row as $k => $v) {
                    $row[$k] = trim(stripslashes($v));
                }

                // Handle product image
                $upload_path = base_app . '/uploads/product_' . $row['id'];
                $img = 'uploads/default.jpg';
                if (is_dir($upload_path)) {
                    $fileO = scandir($upload_path);
                    if (isset($fileO[2])) {
                        $img = 'uploads/product_' . $row['id'] . '/' . $fileO[2];
                    }
                }

                // Get price from inventory
                $inventory = $conn->query("SELECT * FROM inventory WHERE product_id = " . $row['id']);
                $inv = [];
                while ($ir = $inventory->fetch_assoc()) {
                    $inv[] = number_format($ir['price']);
                }

                // Use lowest price as display (if multiple)
                $price_display = !empty($inv) ? min($inv) : '0.00';
            ?>
                <div class="col mb-5">
                    <div class="card package-item h-100 shadow-sm border-light">
                        <!-- Product image -->
                        <div class="position-relative overflow-hidden" style="height: 250px;">
                            <img class="card-img-top w-100 h-100 object-fit-cover"
                                src="<?php echo validate_image($img) ?>"
                                alt="<?php echo $row['title'] ?>" />
                        </div>

                        <!-- Product details -->
                        <div class="card-body p-2">
                            <div class="text-center">
                                <h5 class="fw-bolder mb-2 text-dark"><?php echo $row['title'] ?></h5>
                                <p class="text-muted">₱<?php echo $price_display ?></p>
                            </div>
                        </div>

                        <!-- Product actions -->
                        <div class="card-footer pb-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center">
                                <a class="btn btn-primary btn-lg rounded-pill px-4"
                                    href=".?p=view_product&id=<?php echo md5($row['id']) ?>">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>


<style>
    #main-header {
        background: url('<?php echo isset($photo1) && !empty($photo1) ? validate_image($photo1) : "uploads/default.jpg" ?>') center center/cover no-repeat;
        position: relative;
        min-height: 300px;
    }

    #main-header .overlay {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background: rgba(0, 0, 0, 0.6);
        z-index: 0;
    }

    #main-header .container {
        z-index: 1;
        position: relative;
    }

    .object-fit-cover {
        object-fit: cover;
    }

    .package-item {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid #ddd; /* Soft border for the card */
    }

    .package-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .object-fit-cover {
        object-fit: cover;
    }

    .card-img-top {
        transition: transform 0.5s ease;
    }

    .package-item:hover .card-img-top {
        transform: scale(1.05);
    }

    /* Add custom styles for better readability */
    .card-body p {
        font-size: 14px;
    }

    #packages-section h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #333;
    }

    #packages-section p {
        font-size: 1.1rem;
        font-weight: 400;
        color: #777;
    }
</style>
