<div class="panel panel-default">
  <div class="panel-body">
    <p><?=$_SESSION['login']?></p>
    <ul class="nav nav-tabs">
      <li role="presentation"><a href="index.php">Questions</a></li>
      <li role="presentation" class="active"><a href="#">your Solution</a></li>
    </ul>
    <br>
    <table class="table table-hover">
      <thead>
        <tr>
          <td>Question number</td>
          <td>Answer</td>
          <td>Tries</td>
        </tr>
      </thead>
      <tbody>
        <?php
        $answers = $db->answers();
        $counter = $db->counter();
        $uanswers = $db->uanswers()->where('uid', $_SESSION['login']);
        $i = 1;
        foreach($uanswers as $answer) {
          $correct_answer = $answers[$answer['qid']-1]['qanswer'];
          $classes = '';
        ?>
        <tr class="<?=$classes?>">
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
