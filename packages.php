<!-- Header with black overlay -->
<header class="bg-dark py-5 position-relative" id="main-header">
    <div class="overlay"></div>
    <div class="container px-4 px-lg-5 my-5 position-relative">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Our Exclusive Event Packages</h1>
            <p class="lead fw-normal text-white-50 mb-0">Choose from a variety of packages designed to make your event truly special.</p>
        </div>
    </div>
</header>

<section class="py-5" id="packages-section">
    <div class="container px-4 px-lg-5 mt-5">
       
        <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-lg-3 justify-content-center">
            <?php 
                $packages = $conn->query("SELECT * FROM `packages` ORDER BY rand() ");
                while($row = $packages->fetch_assoc()):
                    foreach($row as $k=> $v){
                        $row[$k] = trim(stripslashes($v));
                    }
                    // Use photo1 as the main image
                    $package_image = !empty($row['photo1']) ? $row['photo1'] : 'uploads/1628047500_catering.jpg';
            ?>
            <div class="col mb-5">
                <div class="card package-item h-100 shadow-sm border-light">
                    <!-- Package image-->
                    <div class="position-relative overflow-hidden" style="height: 250px;">
                        <img class="card-img-top w-100 h-100 object-fit-cover" 
                             src="<?php echo validate_image($package_image) ?>" 
                             alt="<?php echo $row['title'] ?>" />
                    </div>
                    
                    <!-- Package details-->
                    <div class="card-body p-2">
                        <div class="text-center">
                            <!-- Package name-->
                            <h5 class="fw-bolder mb-2 text-dark"><?php echo $row['title'] ?></h5>
                            <!-- Package description (shortened)-->
                            <p class="text-muted ">
                                <?php echo substr(strip_tags($row['description']), 0, 100) . '...' ?>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Package actions-->
                    <div class="card-footer pb-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center">
                            <a class="btn btn-primary btn-lg rounded-pill px-4" 
                               href=".?p=view_package&id=<?php echo md5($row['id']) ?>">
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

