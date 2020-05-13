<section id="about" class='text-center' style='background-color:#152355'></section>
    <section  class='text-center' style='border-top: 1px solid grey; border-bottom: 1px solid grey'>
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-md-offset-4">
                <h2>Recuperar Password</h2>
<?php if(@$char): ?>

<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create('Form', ['id' => 'register_form']) ?>
    <fieldset>
        <?php
            echo $this->Form->input('char', ['type' => 'hidden', 'value' => $char]);

        ?>

        <div class="form-group">
                    <input type="password" class="form-control" placeholder="Insere a nova password" name='password' id='password1' data-minlength="6" data-error="Mínimo de 6 caracteres." required />
                    <div class="help-block with-errors"></div>
                </div>

                 <div class="form-group">
                    <input type="password" class="form-control" placeholder="Confirma a nova password" id='password2' data-match="#password1" data-match-error="As passwords inseridas não são iguais." required />
                    <div class="help-block with-errors"></div>
                </div>
    </fieldset>
    <button class="btn btn-black" type='submit'>ENVIAR</button>
    <?= $this->Form->end() ?>
</div>

<?php else: ?>

<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create('Form') ?>
    <fieldset>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Inserir email de registo" name='email' required />
                </div>
    </fieldset>
    <button class="btn btn-black" type='submit'>ENVIAR</button>
    <?= $this->Form->end() ?>
</div>

<?php endif; ?>

        </div>
    </div>
</div>
</section>