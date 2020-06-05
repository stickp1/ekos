
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
                        <label for="group_id">Por favor seleciona uma turma:</label>
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
</style>