<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * from `packages` where id = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = stripslashes($v);
            // Fix photo paths for display
            if (in_array($k, ['photo1', 'photo2', 'photo3']) && !empty($v)) {
                $$k = base_url . $v;
            }
        }
    }
}
?>
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title"><?php echo isset($id) ? "Update " : "Create New " ?> Package</h3>
    </div>
    <div class="card-body">
        <form action="" id="product-form">
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">

            <div class="form-group">
                <label for="title" class="control-label">Package Title</label>
                <textarea name="title" id="" cols="30" rows="2" class="form-control form no-resize"><?php echo isset($title) ? $title : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="description" class="control-label">Description</label>
                <textarea name="description" id="" cols="30" rows="2" class="form-control form no-resize summernote"><?php echo isset($description) ? $description : ''; ?></textarea>
            </div>

            <!-- Photo Upload Fields -->
            <?php for ($i = 1; $i <= 3; $i++):
                $photo_field = "photo$i";
                $existing_field = "existing_$photo_field";
            ?>
                <div class="form-group">
                    <label for="<?php echo $photo_field ?>" class="control-label">Photo <?php echo $i ?></label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input rounded-circle" id="<?php echo $photo_field ?>" name="<?php echo $photo_field ?>" accept="image/*">
                        <label class="custom-file-label" for="<?php echo $photo_field ?>">Choose file</label>
                    </div>
                    <?php if (isset($$photo_field) && !empty($$photo_field)): ?>
                        <div class="mt-2 d-flex align-items-center img-container" data-field="<?php echo $photo_field ?>">
                            <img src="<?php echo $$photo_field ?>" width="150px" height="100px" style="object-fit:cover;" class="img-thumbnail">
                            <button type="button" class="btn btn-sm btn-danger ml-2 remove-photo"
                                data-path="<?php echo str_replace(base_url, '', $$photo_field) ?>">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                            <input type="hidden" name="<?php echo $existing_field ?>" value="<?php echo str_replace(base_url, '', $$photo_field) ?>">
                        </div>
                    <?php endif; ?>
                </div>
            <?php endfor; ?>

        </form>
    </div>
    <div class="card-footer">
        <button class="btn btn-flat btn-primary" form="product-form">Save</button>
        <a class="btn btn-flat btn-default" href="?page=packages">Cancel</a>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Update file input labels
        $('input[type="file"]').change(function(e) {
            var fileName = e.target.files[0].name;
            $(this).next('.custom-file-label').html(fileName);
        });

        // Handle photo removal
        $(document).on('click', '.remove-photo', function() {
            var _this = $(this);
            var path = _this.data('path');
            var container = _this.closest('.img-container');
            var field = container.data('field');

            // Confirm deletion
            if (confirm("Are you sure you want to delete this photo?")) {
                start_loader();
                $.ajax({
                    url: _base_url_ + 'classes/Master.php?f=delete_package_photo',
                    method: 'POST',
                    data: {
                        path: path
                    },
                    dataType: 'json',
                    error: function(err) {
                        console.log(err);
                        alert_toast("An error occurred", 'error');
                        end_loader();
                    },
                    success: function(resp) {
                        if (resp.status == 'success') {
                            // Remove the image container
                            container.remove();
                            // Clear the file input if exists
                            $('input[name="' + field + '"]').val('');
                            // Clear the existing photo hidden field
                            $('input[name="existing_' + field + '"]').val('');
                            alert_toast("Photo successfully deleted", 'success');
                        } else {
                            alert_toast(resp.msg || "An error occurred", 'error');
                        }
                        end_loader();
                    }
                });
            }
        });

        // Form submission
        $('#product-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this);
            $('.err-msg').remove();
            start_loader();

            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_packages",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: function(err) {
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        location.href = "./?page=packages/index";
                    } else if (resp.status == 'failed' && !!resp.msg) {
                        var el = $('<div>');
                        el.addClass("alert alert-danger err-msg").text(resp.msg);
                        _this.prepend(el);
                        el.show('slow');
                        $("html, body").animate({
                            scrollTop: _this.closest('.card').offset().top
                        }, "fast");
                        end_loader();
                    } else {
                        alert_toast("An error occurred", 'error');
                        end_loader();
                        console.log(resp);
                    }
                }
            });
        });

        $('.summernote').summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ol', 'ul', 'paragraph', 'height']],
                ['table', ['table']],
                ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>