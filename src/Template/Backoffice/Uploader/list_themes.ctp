<?php
        echo '<label>Tema</label>
                      <select class="form-control" id="themes-select">
                            <option style="display:none"> -- selecionar uma opção -- </option>';
         foreach ($themes as $key => $value){
                            echo "<option value='$key'>$value</option>" ; }

        echo "</select>";

?>

<script>
$("#themes-select").on('change', function(){
    $("#uploader").slideDown();
    $("#theme_id").val($("#themes-select").val());

    $("#results").fadeOut();
    $.get("<?= $this->Url->build(['action' => 'list-files']);?>/"+ $("#themes-select").val(),
   function(data){
     $("#results").html(data).fadeIn();
   });

 })
</script>