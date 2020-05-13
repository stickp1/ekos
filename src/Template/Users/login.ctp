<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?> 
    <section id="about" class='text-center' style='background-color:#152355'></section>
    <section class='text-center' style='border-top: 1px solid grey; border-bottom: 1px solid grey'>
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-md-offset-4">
                <h2>Login</h2>
                
                <?= $this->Form->create('Form', [ 'url' => ['controller' => 'users', 'action' => 'login'], 'id' => 'login_form']) ?>
                
                <fieldset>
                    <?php if(@$_GET['e'] == 1): ?>
                    <div class="alert alert-danger" role="alert"> Utilizador ou password incorretos. </div>
                    <?php endif; ?>
                <div class="form-group">
                    <div class="label" style='float:left'>Email</div>
                    <input type="text" class="form-control" placeholder="Inserir email" name='email' required/>
                </div>
                
                <div class="form-group">
                     <div class="label" style='float:left'>Password</div>
                    <input type="password" class="form-control" placeholder="Inserir password" name='password' required/>
                    <p style='font-size:14px; margin-top:5px; text-align: right'><a href='<?= $url ?>/users/reset'>Esqueceste a password?</a></p>
                </div>

                <div align="center">
                     <button class="btn btn-black" type='submit'>ENTRAR</button>
                </div>

                </fieldset>

                <?= $this->Form->end() ?>

                <br>
                <p style='font-size: 18px; margin-bottom: 0'>Ainda não tens conta?</p>
                
                <div align="center" style='margin-bottom:30px'>
                     <button type="button" class="btn btn-black" id='register_button'>CRIAR REGISTO</button>
                </div>

            </div>
        </div>
    </div>
    </section>