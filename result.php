<div class="panel panel-default">
  <div class="panel-body">
    <ul class="nav nav-tabs">
      <li role="presentation"><a href="index.php">Questions</a></li>
      <li role="presentation" class="active"><a href="#">Results</a></li>
    </ul>
    <h1>Users results</h1>
    <table class="table table-hover">
      <thead>
        <tr>
          <td>#</td>
          <td>Username</td>
          <td>Question number</td>
          <td>Answer</td>
          <td>Tries</td>
        </tr>
      </thead>
      <tbody>
        <?php
        $answers = $db->answers();
        $counter = $db->counter();
        $uanswers = $db->uanswers();
        $i = 1;
        foreach($uanswers as $answer) {
          $correct_answer = $answers[$answer['qid']-1]['qanswer'];
          $classes = '';
          if($correct_answer == $answer['uanswer']) $classes = 'success';
         /* <td><?=substr_count($counter[$i-1]['qcounter'], $answer['uid'])?></td> khate 35*/
        ?>
        <tr class="<?=$classes?>">
          <td><?=$i?></td>
          <td><?=$answer['uid']?></td>
          <td><?=$answer['qid']?></td>
          <td><?=$answer['uanswer']?></td>
          <td><?=substr_count($counter[$answer['qid']-1]['qcounter'], $answer['uid'])?></td>
          
        </tr>
        <?php
          $i++;
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
