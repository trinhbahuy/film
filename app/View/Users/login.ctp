<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <header class="card-header">
                    <a href="/film_hunter/users/register" class="float-right btn btn-outline-primary mt-1">Sign up</a>
                    <h4 class="card-title mt-2">Login</h4>
                </header>
                <article class="card-body">
                <?php echo $this->Flash->render('success_msg'); ?>
                <?php if(isset($errorss)) foreach($errorss as $errors):?>
                    <?php foreach($errors as $error): ?>
                        <div class="<?php echo 'alert alert-danger'?>"> <?php echo $error; ?> </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <?php echo $this->Flash->render('danger_msg'); ?>
                <form action="/film_hunter/users/login" method="post">
                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" name="data[User][email]" class="form-control" id="email" required autofocus>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="data[User][password]" class="form-control" id="password"
                                               placeholder="Password" required>
                        </div> 
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block"> Login</button>
                        </div>
                </form>
                </article> 
            </div> 
        </div> 
    </div> 
</div> 