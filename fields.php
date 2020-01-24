<?php
$answers = $db->answers();
$counts = $db->counts();
$counter = $db->counter();
$uanswers = $db->uanswers();
$c = [];
$i = 0;
$msg = '';
if(@$_SESSION['msg']) echo $_SESSION['msg'];
$_SESSION['msg'] = '';
foreach($answers as $ans) {
    $i++;
    $c['q'.$i] = 0;
    if(@isset($counter[$i-1]['qcounter'])) {
      $c['q'.$i] = substr_count($counter[$i-1]['qcounter'], $_SESSION['login']);
    } else {
      $counter->insert_update(
        array('qid' => 'q'.$i),
        array('qcounter' => '')
      );
    }
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(@$_POST['sendres']) {
        if (@!($_POST['q'.$i])) continue;
      $row = $db->uanswers()->where('qid', $i)->and('uid', $_SESSION['login']);
      $t = null;
      foreach($row as $r) {
        $t = $r['id'];
      }
            
      $uanswers->insert_update(
      array('id' => $t),
      array(
        'qid' => $i,
        'uid' => $_SESSION['login'],
        'uanswer' => @$_POST['q'.$i]
      ));
      continue;
    }
    if(@$_POST['q'.$i]) {
      if($c['q'.$i] >= $counts[$i-1]['qcounts']) {
        $msg .= '<div class="panel panel-danger"> You can\'t answer to question N.'.$i.' anymore! </div>';
        $_SESSION['msg'] = $msg;
        continue;
      }
      $counter->insert_update(
        array('qid' => 'q'.$i),
        array('qcounter' => $counter[$i-1]['qcounter'].$_SESSION['login'])
      );
      if($ans['qanswer'] == $_POST['q'.$i]) $msg .= '<div class="panel panel-danger"> Answer N.'.$i.' is correct :-) </div>';
      else $msg .= '<div class="panel panel-danger"> Answer N.'.$i.' is wrong :-( </div>';
      
      $_SESSION['msg'] = $msg;
    }
  }
  
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  header('Location: index.php');
  exit;
}
?>
<div class="panel panel-default">
  <div class="panel-body">
    <p><?=$_SESSION['login']?></p>
    <ul class="nav nav-tabs">
      <li role="presentation" class="active"><a href="#">Questions</a></li>
      <li role="presentation"><a href="index.php?res=t">your Solution</a></li>
    </ul>
    <h1>Answer the questions</h1>
    <form method="post" action="index.php">
      <?php
      $i = 0;
      foreach($answers as $ans) {
      $i++;
      ?>
      <p>
        <label>Question N.<?=$i?></label>
        <input type="text" name="q<?=$i?>" class="form-control" cols="30" rows="10" placeholder="Question N.<?=$i?>">
        <p class="help-block">Chances: <?=$c['q'.$i]?>/<?=$counts[$i-1]['qcounts']?> </p>
      </p>
      <?php
      }
      ?>
      <input type="submit" value="check" class="btn btn-default">    
      <input type="submit" name="sendres" value="send solution" class="btn btn-primary">    
    </form>
  </div>
</div>
