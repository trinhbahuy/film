<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<div class="card">
				<header class="card-header">
					<a href="/film_hunter/users/login" class="float-right btn btn-outline-primary mt-1">Log in</a>
					<h4 class="card-title mt-2">Sign up</h4>
				</header>
				<article class="card-body">
				<?php if(isset($errorss)) foreach($errorss as $errors):?>
		            <?php foreach($errors as $error): ?>
		                <div class="<?php echo 'alert alert-danger'?>"> <?php echo $error; ?> </div>
		            <?php endforeach; ?>
		        <?php endforeach; ?>
				<?php echo $this->Flash->render() ?>
				<form action="/film_hunter/users/register" method="post">
					<div class="form-row">
						<div class="col form-group">
							<label>Name</label>
						  	<input type="text" class="form-control" placeholder=" " name="name">
						</div> 
						<div class="col form-group">
						  	<label>Age</label>
						  	<input type="text" class="form-control" placeholder=" " name="age">
						</div> 
						<!-- form-group end.// -->
					</div> 
					<!-- form-row end.// -->
					<div class="form-group">
						<label>Email address</label>
						<input type="email" class="form-control" placeholder="" name="email">
						<small class="form-text text-muted">We'll never share your email with anyone else.</small>
					</div> 
					<!-- form-group end.// -->
					<div class="form-group">
							<label class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="gender" value="1">
						  <span class="form-check-label"> Male </span>
						</label>
						<label class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="gender" value="0">
						  <span class="form-check-label"> Female</span>
						</label>
					</div> 
					<!-- form-group end.// -->
					<div class="form-group">
						<label>Password</label>
					    <input class="form-control" type="password" name="password">
					</div>
					<div class="form-group">
						<label>Confirm password</label>
					    <input class="form-control" type="password" name="re-password">
					</div> 
					<!-- form-group end.// -->  
				    <div class="form-group">
				        <button type="submit" class="btn btn-primary btn-block"> Register  </button>
				    </div>
				     <!-- form-group// -->                                           
				</form>
				</article> 
			</div> 
			<!-- card.// -->
		</div> 
		<!-- col.//-->
	</div> 
</div> 