<!DOCTYPE html>
<html>
<head>
	<title>This is Product Page</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<h1 class="text-center mt-5">Add Product</h1>
		<br>
		<br>
		<br>
		<div class="row">
			<div class="product col-md-8  offset-md-2">
			<form action="<?php echo base_url()?>index.php/ProductController/addProduct" method="post">
				<div class="form-input">
					<label for="name">Name</label>
					<input class="form-control" type="text" name="name" id="name" placeholder="Enter Name of the Product">
				</div>
				<div class="form-input">
					<label for="price">Price</label>
					<input class="form-control" type="text" name="price" id="price" placeholder="Enter Name of the Product">
				</div>

				<div class="form-input mt-2 text-right">
					<input class="btn btn-success" type="submit" name="submit" value="Save">
				</div>
			</form>
		</div>
		</div>
		
	</div>
	


	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>