<?php echo \Form::open(array('action' => \Router::get('yolp_sample_search', compact('lat', 'lon', 'z')), 'method' => 'get')); ?>
<?php echo \Form::input('query', \Input::get('query', ''), array('size' => 40)); ?>
<?php echo \Form::submit(null, '検索'); ?>

<a href="<?php echo \Router::get('yolp_sample_search', array('lat' => $lat, 'lon' => $lon, 'z' => $z + 1)); ?><?php echo \Input::get('query') ? '?query='.rawurlencode(\Input::get('query')) : ''; ?>">拡大</a>
<a href="<?php echo \Router::get('yolp_sample_search', array('lat' => $lat, 'lon' => $lon, 'z' => $z - 1)); ?><?php echo \Input::get('query') ? '?query='.rawurlencode(\Input::get('query')) : ''; ?>">縮小</a>
<br>
<input type="image" src="data:image/png;base64,<?php echo base64_encode($image->body()); ?>" style="float:left; margin-right: 56px">
<?php echo \Form::close(); ?>

<?php if (isset($response['Feature'])): ?>
<?php //\Debug::dump($response); ?>
<ol>
<?php foreach($response['Feature'] as $feature): ?>
  <li><?php echo \Html::anchor(\Router::get('yolp_sample_view', array('gid' => $feature['Gid'])), $feature['Name']); ?></li>
<?php endforeach; ?>
</ol>
<?php endif; ?>
