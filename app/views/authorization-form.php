<?php echo  Form::open(['method' => 'POST','class'=>'form-horizontal', 'url'=> route('oauth.authorize.post',$params)]) ?>
<div class="form-group">
    <dl class="dl-horizontal">
        <dt>Client Name</dt>
        <dd><?php echo $client->getName() ?></dd>
    </dl>
</div>

<?php echo  Form::hidden('client_id', $params['client_id']) ?>
    <?php echo  Form::hidden('redirect_uri', $params['redirect_uri']) ?>
    <?php  echo  Form::hidden('response_type', $params['response_type']) ?>
    <?php  echo  Form::hidden('state', $params['state']) ?>
    <?php echo  Form::submit('Approve', ['name'=>'approve', 'value'=>1, 'class'=>'btn btn-success']) ?>
    <?php echo  Form::submit('Deny', ['name'=>'deny', 'value'=>1, 'class'=>'btn bg-danger']) ?>

<?php  Form::close() ?>
