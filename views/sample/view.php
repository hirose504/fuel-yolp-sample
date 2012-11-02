<img src="data:image/png;base64,<?php echo base64_encode($image->body()); ?>">

<?php if (isset($response['Feature'])): ?>
<?php $feature = \Arr::flatten_assoc($response['Feature']); ?>
<dl>
<?php foreach($feature as $name => $value): ?>
  <dt><?php echo $name; ?></dt>
  <dd><?php var_dump($value); ?></dd>
<?php endforeach; ?>
</dl>
<?php endif; ?>
