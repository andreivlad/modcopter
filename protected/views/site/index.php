<div id="processing-generate" class="processing">
    Generating 3D model please wait...
    <img src="<?php echo $this->getAssetsUrl();?>/img/ajax-loader.gif" alt="Processing"/>
</div>
<?php
$this->widget('xupload.XUpload', array(
    'url' => Yii::app()->createUrl("site/upload"),
    'model' => $model,
    'attribute' => 'file',
    'multiple' => true,
));
?>

<div id="processing-dialog" title="Starting processing" style="display: none">
    <p>Image uploading is done. Starting 3D model generation.</p>
    <p>The process can take several minutes depending on the model.</p>
    <p>The download will start automatically when the model is complete.</p>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        mod.init.initModelGeneration();
    });

</script>