<?php
$answers = $db->answers();
$counts = $db->counts();
$counter = $db->counter();
$uanswers = $db->uanswers();
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  if(@$_POST['refresh']) {
    $counter->delete();
    $uanswers->delete();
    header('Location: index.php');
    exit;
  }
  $anss = preg_split('/\r\n|[\r\n]/', @$_POST['answers']);
  $i = 1;
  $answers->delete();
  $counts->delete();
  foreach($anss as $ans) {
    $ans = explode(' ', $ans);
    if(!trim($ans[0])) continue;
    $qw = 'q'.$i;
    $answers->insert_update(
      array('qid' => $qw),
      array('qanswer' => $ans[0])
    );
    $counts->insert_update(
      array('qid' => $qw),
      array('qcounts' => $ans[1])
    );
    $i++;
  }
  header('Location: index.php');
  exit;
}
?>
<div class="panel panel-default">
  <div class="panel-body">
		<ul class="nav nav-tabs">
			<li role="presentation" class="active"><a href="#">Questions</a></li>
			<li role="presentation"><a href="index.php?res=t">Results</a></li>
		</ul>
    <h1>Manage questions</h1>
    <form method="post" action="index.php">
      <p>
        <textarea name="answers" class="form-control" rows="10"><?php
        $i = 1;
        foreach($answers as $ans) {
          echo $ans['qanswer'];
          echo ' ';
          echo $counts[$i-1]['qcounts'];
          echo "\r";
          $i++;
        }
        ?></textarea>
      </p>
      <input type="submit" value="save" class="btn btn-default">
      <input type="submit" name="refresh" value="refresh" class="btn btn-primary">
    </form>
  </div>
</div>
