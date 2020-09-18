
<section id="services" class="text-center">
    <div class="container">
        <div class="row" style='position:relative'>
            <div class="reserved-background"></div>
            <div class="col-md-10 col-md-offset-1">
                <form method='post'><br>
                    <h2>Confirmar Inscrição</h2>
                    <p><?= $course['name']?></p>
                    <p><b><?= $course['price'] ?> €</b></p><br>
                    <div class="select" id="main-group">
                        <label for="<?= 'course_'.$course['id'].'_group_id'?>">Por favor seleciona uma turma:</label>
                        <select class="form-control" name="<?= 'course_'.$course['id'].'_group_id'?>" id="<?= 'course_'.$value['id'].'_group_id'?>">
                          <?php foreach ($groups as $key=>$group): ?>
                              <option value=<?=$group['id']?> >
                                  <?=$group['name']?>
                              </option>
                          <?php endforeach; ?>
                        </select>
                        <?php if ($course['name'] == "Curso Anual"): ?>
                            <button class="btn" type="button" data-toggle="collapse" data-target="#annual-groups" aria-expanded="false" aria-controls="annual-groups"><span style="font-size:0.8em;">mais opções...</span>
                            </button>
                        <?php endif; ?>
                    </div>
                    <div id="annual-groups" class="panel panel-info collapse">
                        <div class="panel-body">
                            <p>Seleciona uma turma para cada um dos módulos:</p>
                            <?php foreach($annual_courses as $key => $value): ?>
                                <?php if ($value['id'] != $course['id']) : ?>
                                    <div class="select">
                                        <label for="group_id"><?= $value['name']?></label>
                                        <select class="form-control" name="<?= 'course_'.$value['id'].'_group_id'?>" id="<?= 'course_'.$value['id'].'_group_id'?>">
                                            <?php foreach ($value['groups'] as $key=>$group): ?>
                                                <option value=<?=$group['id']?> >
                                                    <?=$group['name']?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div> 
                    </div>
                    <div class="agreeTerms">
                        <input type="checkbox" required>Declaro que li e aceito os termos e condições de formação descritos no Regulamento da Atividade Formativa da EKOS.
                    </div>
                    <div style="margin-top:15px;">
                    <a href='/regulamento.pdf' target="_blank">    <i class="fa fa-download"></i> Regulamento </a>
                    </div>                          
                    <input type='hidden' name='payment_type' value='2' />
                    <button class='btn btn-black' type='submit' >INSCREVER</button>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
#services{
  padding-top: 150px;
  padding-bottom: 30px;
}
#main_container{
  background-color: #f5f5f5;
}
.select{
  width: 70%;
  margin: auto;
  margin-top: 40px;
}
.select label{
  float: left;
  margin-bottom: 0;
}
.select .form-control{
  height: auto;
  background-color: #f5f5f5;
}
.select button{
  font-size: 1.1em;
  position: absolute;
  right: 0;
  float: right;
  margin-top: 15px;
  background-color: #f5f5f5;
  border: 2px solid #152335;
}
#main-group{
  margin-bottom: 100px;
  position: relative;
}
#annual-groups{
  width: 70%;
  margin: auto;
  padding-top: 20px;
  padding-bottom: 20px;
  border: 2px solid #152335;
}
#annual-groups .select{
  width: 90%;
}
#annual-groups .select .form-control{
  background-color: white;
}
.btn-black{
  margin-top: 50px;
}
input[type='checkbox']{
        -webkit-appearance: none;
        width: 30px;
        height: 30px;
        outline: none;
        border: 2px solid gray;
        margin-left: 3px
}
input[type='checkbox']:before{
        content: '';
        display: block;
        width: 50%;
        height: 50%;
        margin: 25% auto;
}
input[type="checkbox"]:checked:before{
        background: #FEB000;
}
input[type='checkbox']:checked{
    border: 2px solid #152335;
}
input[type='checkbox']:disabled{
    border: 2px solid grey;
    background: grey!important;
}
.agreeTerms{
    padding-top: 45px;
    position:relative;
    display: flex;
    flex-direction: row;
    align-content: space-between;
    align-items: baseline;
    height:90%;
    font-size:12pt;
    margin-left:50px;
    text-align: left;
}
.agreeTerms input[type='checkbox']{
    width:20px; 
    height:20px; 
    position:relative; 
    top:5px;
    margin-right: 5px;
    flex-shrink:0;
}
</style>

<script>
  $('#main-group select').change(function(){
    option = $('#main-group select option:selected').text().trim();
    console.log(option);
    $('#annual-groups select option').filter(function() {
      console.log($(this).text().trim() == option);
      return $(this).text().trim() == option;
    }).prop('selected', true);
  });

</script>