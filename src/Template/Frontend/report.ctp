        <div class="modal fade" id="report">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h1 class="modal-title text-center">Erro/Sugestão</h1>
                    </div>
                    <div class="modal-body">
                        <?= $this->Form->create('Form', ['url' => ['controller' => 'frontend', 'action' => 'report'], 'id' => 'report-form']) ?>
                            <div id="textDiv">
                                <input type="hidden" class="form-control"name="report-url" value=<?php echo $this->request->here; ?>/>
                                <textarea class="form-control" id="report-message" name="report-message" rows="5" placeholder="Escreve aqui o erro/sugestão" required></textarea>
                                <textarea class="form-control" id="report-contact" name="report-contact" rows=1 placeholder="Contacto (opcional)"></textarea>
                            </div>
                            <div class="modal-footer row">
                                <div id="report-captcha" class="g-recaptcha col-xs-6" data-sitekey="6LcyRvoUAAAAAI5eHrrEudrAR1M08g_zGNOEcZls" style='margin-top:15px; display: none'>
                                </div>
                                <div class="col-xs-6 col-xs-offset-6">
                                    <button type="submit" class="btn btn-black">Submeter</button>
                                </div> 
                            </div>
                        <?= $this->Form->end() ?>
                    </div>
                    
                </div>
            </div>
        </div>