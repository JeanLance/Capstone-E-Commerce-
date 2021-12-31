<div class="modal-wrapper">
    <div class="modal">
        <span id="close-modal">X</span>
        <h2><?= $action == 'Edit' ? 'Edit Product - ID ' . $id : 'Add Product';?></h2>
        <?= form_open('products/product' . $action, 'id="edit-add-form"')?>
<?php       if ($action == 'Edit') { ?>
                <input type="text" name="id" value="<?= $id?>" hidden>
<?php       } ?>
            <!-- Name Field -->
            <div class="form-field-wrapper">
                <label for="name-field">Name:</label>
                <span><input id="name-field" type="text" name="name" value="<?= isset($name) ? $name : NULL ;?>" required></span>
            </div>
            <!-- Description Field -->
            <div class="form-field-wrapper">
                <label for="description-fi">Description:</label>
                <span><textarea id="description-field" name="description" required><?= isset($description) ? $description : NULL ;?></textarea></span>
            </div>
            <!-- Categories Field -->
            <div class="form-field-wrapper">
                <label>Categories:</label>
                <span>
                    <select class="c-select" name="category" required>
<?php           foreach($categories as $category) { ?>
                        <option data-id="<?= $category['id']?>" value="<?= $category['category'] ?>"><?= $category['category'] ?></option>
<?php           } ?>
                    </select>
                </span>
            </div>
            <!-- Add New Category Field -->
            <div class="form-field-wrapper">
                <label for="">Or Add New Category:</label>
                <span>
                    <input id="add-category-field" class="field-btn hover-shadow" type="button" value="Create" required>
                </span>
            </div>
            <!-- Price Field -->
            <div class="form-field-wrapper">
                <label for="">Price($):</label>
                <span>
                    <input id="price-field" type="text" name="price" min="0" placeholder="00.00" value="<?= isset($price) ? $price : NULL ;?>" required><p></p>
                </span>
            </div>
            <div class="form-field-wrapper">
                <label for="">Stock Quantity:</label>
                <span>
                    <input id="stock-field" type="number" name="stock" min="0" placeholder="0" value="<?= isset($stock) ? $stock : NULL ;?>" required><p></p>
                </span>
            </div>
            <!-- Upload Image Field -->
            <div class="form-field-wrapper">
                <label for="">Images:</label>
                <span>
                    <input id="upload-btn" class="field-btn hover-shadow" type="button" name="upload_btn" value="Upload" required>
                </span>
            </div>
            <!-- Uploaded Image Section -->
            <div class="form-field-wrapper">
                <label></label>
                <span>
                    <ul class="sortable-list" id="img-list">
                        <!-- Dynamically Created -->
                    </ul>
                </span>
            </div>
            <!-- Action Buttons Field -->
            <div class="form-field-wrapper">
                <label></label>
                <span id="form-action-btns">
                    <input id="form-action-cancel" class="hover-shadow" type="button" name="cancel" value="Cancel">
                    <input id="form-action-preview" class="hover-shadow" type="submit" name="submit" value="Preview">
                    <input id="form-action-update" class="hover-shadow" type="submit" name="submit" value="<?= $action == "Edit" ? "Update" : "Add" ?>">
                </span>
            </div>
        </form>
        <?= form_open('dashboard/uploadImagePartial', 'id="upload-img" enctype="multipart/form-data"')?>
            <input id="upload-img-field" type="file" name="file" accept="image/*" hidden>
        </form>
    </div>
</div>