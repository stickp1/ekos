
$("#graph").sparkline([ <?= $question['a1'] ? $question['a1'] : '0' ?>, <?= $question['a2'] ? $question['a2'] : '0'?>, <?= $question['a3'] ? $question['a3'] : '0' ?>, <?= $question['a4'] ? $question['a4'] : '0' ?>, <?= $question['a5'] ? $question['a5'] : '0' ?> ], { 
        type: 'bar',
        width: "97%",
        height: "125px",
        barWidth: "20",
        barSpacing: "17",
        colorMap: [
          <?=  $question['correct'] == 1 ? "'green'"  :  ($answer == 1 ? "'red'" : "'#999'") ?>, 
          <?=  $question['correct'] == 2 ? "'green'"  :  ($answer == 2 ? "'red'" : "'#999'") ?>, 
          <?=  $question['correct'] == 3 ? "'green'"  :  ($answer == 3 ? "'red'" : "'#999'") ?>, 
          <?=  $question['correct'] == 4 ? "'green'"  :  ($answer == 4 ? "'red'" : "'#999'") ?>, 
          <?=  $question['correct'] == 5 ? "'green'"  :  ($answer == 5 ? "'red'" : "'#999'") ?>

          ] });

$("#graph").fadeIn();