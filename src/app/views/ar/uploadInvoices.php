<!DOCTYPE html>
<html>
<head>
	<title>Upload invoices</title>
	<link rel="shortcut icon" type="image/png" href="src/app/views/images/logo2.jpg"/>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="https://www.fontstatic.com/f=sky-bold" />
	<style type="text/css">
		* { font-family: 'sky-bold';
			direction: rtl; };
		body {
			background-color: #f3f3f3;
		}
		#content {
			background-color: white;
			width: 80%;
			margin-left: 10%;
			margin-right: 10%;
			margin-top: 10%;
			padding: 5%;
			border-left: 5px solid black;
		}
	</style>
</head>
<body>
	<div id="content">
	<?php if (isset($error)): ?>
		<div class="alert alert-danger" role="alert">
		 	<?php echo $error; ?>
		</div>
	<?php endif; ?>
	<?php if (isset($suc)): ?>
		<div class="alert alert-success" role="alert">
		 	<?php echo $suc; ?>
		</div>
	<?php endif ?>
		<form method="post" action="postUploadedInvoices" enctype="multipart/form-data">
		  <div class="form-row">
		    <div class="form-group col-md-6">
		      <label style="float: right;" for="inputEmail4">الإيميل</label>
		      <input type="email" name="email" value="<? echo $user->email; ?>" class="form-control" id="inputEmail4">
		    </div>
		    <div class="form-group col-md-2">
		      <label style="float: right;" for="inputFirstname">اللقب</label>
		      <input type="text" name="firstname" class="form-control" value="<? echo $user->firstname; ?>" id="inputFirstname">
		    </div><div class="form-group col-md-2">
		      <label style="float: right;" for="inputLastname">الإسم</label>
		      <input type="text" name="lastname" class="form-control" value="<? echo $user->lastname; ?>" id="inputLastname">
		    </div>
		  </div>
		  <div class="form-group">
		    <label style="float: right;" for="inputAddress">العنوان</label>
		    <input type="text" name="address" class="form-control" id="inputAddress" value="<? echo $user->address; ?>">
		  </div>
		  <div class="form-group">
		    <label style="float: right;" for="inputAddress">رقم الهاتف</label>
		    <input type="text" name="phone" class="form-control" id="inputAddress" value="<? echo $user->phone; ?>">
		  </div>
		  <div class="form-group">
		    	<label style="float: right;" class="text-black" for="Address">الخطط</label>                    
                  <select style="float: right;" name="plan">
                  	<? if($user->plan == 1): ?>
                    	<option value="1" selected="selected">500da</option>
                    	<option value="2">900da</option>
                    	<option value="3">1300da</option>
                    <? elseif($user->plan == 2): ?>
                    	<option value="1">500da</option>
                    	<option value="2" selected="selected">900da</option>
                    	<option value="3">1300da</option>
                    <? else: ?>
                    	<option value="1">500da</option>
                    	<option value="2">900da</option>
                    	<option value="3" selected="selected">1300da</option>
                    <? endif; ?>
                  </select>
		  </div>
		  <br/>
		  <br/>
		  <p  style="float: right; color: red;">قم بتحميل 3 صور مختلفة مختلفة للفاتورة. (الصور المقبولة: .jpg ، .jpeg ، .png) وصورة واحدة لبطاقة الهوية</p>
		  <br/>
		  <div style="float: right;" class="form-row">
			    <div class="form-group col-md-5">
			      <label id="image1" for="inputFirstname">الصورة 1 للفاتورة</label>
			      <div class="custom-file">
					    <input name="image1" onchange="imageName(this, 'image1')" type="file" class="custom-file-input" id="validatedCustomFile" required>
					    <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
					    <div class="invalid-feedback">Example invalid custom file feedback</div>
					</div>
			    </div>
			    <br/>
			    <div class="form-group col-md-5">
			      <label id="image2" for="inputLastname">الصورة 2 للفاتورة</label>
			      <div class="custom-file">
				    <input name="image2" onchange="imageName(this, 'image2')" type="file" class="custom-file-input" id="validatedCustomFile" required>
				    <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
				    <div class="invalid-feedback">Example invalid custom file feedback</div>
				  </div>
			    </div>
			    <br/>
			    <div class="form-group col-md-5">
			      <label id="image3" for="inputLastname">الصورة 3 للفاتورة</label>
			      <div class="custom-file">
				    <input name="image3" onchange="imageName(this, 'image3')" type="file" class="custom-file-input" id="validatedCustomFile" required>
				    <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
				    <div class="invalid-feedback">Example invalid custom file feedback</div>
				  </div>
			    </div>
			    <br/>
			    <div class="form-group col-md-5">
			      <label id="image4" for="inputLastname">صورة لبطافة الهوية</label>
			      <div class="custom-file">
				    <input name="id" type="file" onchange="imageName(this, 'image4')" class="custom-file-input" id="validatedCustomFile" required>
				    <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
				    <div class="invalid-feedback">Example invalid custom file feedback</div>
				  </div>
			    </div>
		  </div>
		  <div class="form-group">
		    <label style="float: right;" for="inputAddress2">المبلغ المُرسل (DA)</label>
		    <input type="number" name="money" class="form-control" id="inputAddress2">
		  </div>
		  <div class="form-group">
		    <label style="float: right;" for="inputAddress2">كلمة السر</label>
		    <input type="password" name="password" placeholder="أدخل كلمة السر" class="form-control" id="inputAddress2">
		  </div>
		  <br/>
		  <button type="submit" class="btn btn-primary">إراسل</button>
		</form>
	</div>
</body>
<script type="text/javascript">
	function imageName(fileInput, label) {
		var filename = fileInput.files[0].name;
		document.getElementById(label).innerHTML = filename;
	}
</script>
</html>
