<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Magento - PHP Integration">
    <meta name="author" content="MariaHoots">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Alegreya%7CWork+Sans" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="main.css">
    <title>Magento REST API integration</title>
  </head>

  <body>
    <main class="container">
      <h1>Add Products to Magento</h1>
      <p>Form to add simple products to the store. You can add multiple products by altering the desired information after successfully transmitting a product, or add new information by resetting the form.</p>
      <form id="addProducts">
        <div class="form-group">
          <label for="productName">Name:</label>
          <input type="text" class="form-control" id="productName" name="productName" placeholder="Product Title" required>
          <small id="productNameHelp" class="form-text text-muted">Product title to display in store</small>
        </div>
        <div class="form-group">
          <label for="sku">SKU:</label>
          <input type="text" class="form-control" id="sku" name="sku" placeholder="Product SKU" required>
          <small id="skuHelp" class="form-text text-muted">Unique Stock Keeping Unit</small>
        </div>
        <div class="form-group">
          <label for="short_description">Short description:</label>
          <input type="text" class="form-control" id="short_description" name="short_description" placeholder="Short description for the product" required>
        </div>
        <div class="form-group">
          <label for="description">Full product description:</label>
          <textarea class="form-control" id="description" name="description" placeholder="Full description for the product" required></textarea>
        </div>
        <div class="form-group">
          <label for="price">Price:</label>
          <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Product price" required>
          <small id="priceHelp" class="form-text text-muted">Enter price for product, only numbers and dots</small>
        </div>
        <div class="form-group">
          <label for="weight">Weight:</label>
          <input type="number" step="0.01" class="form-control" id="weight" name="weight" placeholder="Product weight" required>
          <small id="weigthHelp" class="form-text text-muted">Enter weight for product, only numbers and dots</small>
        </div>
        <div class="form-group">
          <label for="visibility">Visibility</label>
          <select class="form-control" id="visibility" name="visibility">
            <option value="1">Not Visible Individually</option>
            <option value="2">Catalog</option>
            <option value="4">Catalog, Search</option>
          </select>
        </div>
        <div class="form-group">
          <label for="categories">Categories</label>
          <select class="form-control" id="categories" name="categories[]" required multiple>
            <?php
            foreach ($categories as $key => $val) {
              echo '<option value="'.$key.'">'.$val.'</option>';
            }
            ?>
          </select>
        </div>

        <div class="form-group">
          <label for="image">Upload product image:</label>
          <input type="file" name="image" id="image" required>
          <small id="imageHelp" class="form-text text-muted">Requirements: gif, jpg, jpeg or png; filesize smaller than 2MB and image width or height smaller than 1200px. The filename of the image will be used in the store.</small>
        </div>
        <div id="imgPrevContainer" style="display:none;">
          <p>This image will be uploaded:</p>
          <img id="imgPreview" alt="image preview" height="150" src="#" />
        </div>

        <div id="alertDiv"></div>

        <button type="reset" id="resetForm" class="btn btn-outline-danger">Empty form</button>
        <button type="submit" class="btn btn-primary">Submit <img id="loadingCircle" alt="loading, please wait" src="loading.gif" style="display:none;" /></button>
      </form>
    </main><!-- /.container -->

  <!-- Bootstrap -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  <script src="script.js"></script>
</body>
</html>
