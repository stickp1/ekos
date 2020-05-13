<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?> 
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Admin</b>EKOS</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <h4 style='text-align: center'>Iniciar Sessão</h4>

    <form method="post">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name='email'>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name='password'>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <p style='font-size:10pt; margin-top:5px; text-align: right'><a href='<?= $url ?>/users/reset'>Recuperar password</a></p>
      </div>
      <div class="row">

        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->