<?php
$width = \Config::get($view_data['package'] . '::media.thumbnailWidth');
$height = \Config::get($view_data['package'] . '::media.thumbnailHeight');
?>
<div id="mediaUpload" class="col-md-12">
    <h4 class="commonTextTransformUpper"><?php echo $view_data['media']['heading']; ?></h4>   

    <?php foreach ($view_data['media']['list'] as $key => $singleItem): ?>
        <p><?php echo ($key + 1) . '. ' . $singleItem ?></p>
    <?php endforeach; ?>
    <?php
    $disabled = $view_data['disableFields'] ? 'disabled=disabled' : '';
    ?>
    <input id="mediaController" type="hidden" value="<?php echo $view_data['mediaController'] ?>" <?php echo $disabled; ?> />
    <input id="mediaType" type="hidden" value="<?php echo $view_data['media']['type']; ?>" <?php echo $disabled; ?> />
    <?php if (array_key_exists('icons', $view_data['media'])): ?>
        <div id="mediaIcons" class="commonFontWeightBold commonColor commonTextAlignCenter commonClearBoth">
            <?php foreach ($view_data['media']['icons'] as $singleIcon): ?>
                <div class=" commonFloatLeft text-center" style="width: <?php echo $width . 'px' ?>;">
                    <div><?php echo $singleIcon['name'] ?></div>
                    <div class=""><i class="icon-data-<?php echo $singleIcon['icon'] ?> icon-data-2x commonTextAlignCenter"></i></div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <ul id="mediaPreviewContainer" class="files commonClearBoth"></ul>
    <span id="mediaButton" class="commonBorderRadius" style="width: <?php echo $width . 'px' ?>; height: <?php echo (int) $height + 34 . 'px' ?>">
        <span id="addMedia" class="commonFontWeightBold"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.mediaView.addMedia', array('type' => \Str::lower(\Lang::choice($view_data['package'] . '::' . $view_data['controller'] . '.type.' . $view_data['media']['type'], 1)))) ?></span><br/>
        <?php if (is_int($view_data['media']['count']) || ctype_digit($view_data['media']['count'])): ?>
            <span class="commonFontWeightBold"><span id="mediaRemaining" class="commonColorRed"><?php echo $view_data['media']['count'] ?></span> <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.mediaView.remainingMedia', array('type' => \Str::lower(\Lang::choice($view_data['package'] . '::' . $view_data['controller'] . '.type.' . $view_data['media']['type'], 1)))) ?></span><br/>
        <?php endif; ?>
        <span class="icon-data-camera icon-data-3x commonColor"></span>
        <input type="file" name="media" multiple <?php echo $disabled; ?> accept="<?php echo $view_data['media']['accept'] ?>"/>
    </span>
</div>

<?php //S# The template to display files available for download   ?>
<script id="templateDownload" type="text/dust">
    <li class="uploadedMediaPreview templateDownload fade commonFloatLeft" style="width: <?php echo $width . 'px' ?>; height: <?php echo ($height + 34) . 'px' ?>">
    {?error}
    <p class="commonColorRed commonFontWeightBold"><i class="icon-data-warning-sign"></i>{error}</p>
    {:else}
    <div>
    <div class="commonBorderColor commonBorderRadius">
    <i class="delete icon-data-delete icon-data-2x commonColorRed" title="<?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.mediaView.deleteMedia', array('type' => \Str::lower(\Lang::choice($view_data['package'] . '::' . $view_data['controller'] . '.type.' . $view_data['media']['type'], 1)))) ?>" data-url="{delete_url}" data-media-type="{media_type}" data-media-controller="{media_controller}" data-media-name="{media_name}" data-media-id="{media_id}"></i>
    <div class="preview">
    {?thumbnail_url}
    <img src="{thumbnail_url}"/>
    {/thumbnail_url}
    </div>
    </div>
    <?php if ($view_data['media']['describe']): ?>
        <input type="text" class="describeMedia form-control" placeholder="<?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.mediaView.describeMedia', array('type' => \Str::lower(\Lang::choice($view_data['package'] . '::' . $view_data['controller'] . '.type.' . $view_data['media']['type'], 1)))) ?>" data-media-id="{media_id}" data-media-type="{media_type}" value="{media_description}"  <?php echo $disabled; ?> />
    <?php endif; ?>            
    </div>
    </li>
    {/error}
</script>
<?php //E# The template to display files available for download   ?>

<?php //S# The template to display files available for upload  ?>
<script id="templateUpload" type="text/dust">
    <li class="mediaPreview templateUpload commonFloatLeft commonBorderColor commonBorderRadius" style="width: <?php echo $width . 'px' ?>; height: <?php echo $height . 'px' ?>">
    <span class="cancel icon-data-trash commonColorRed"></span>
    {?error}
    <p class="commonColorRed commonFontWeightBold"><i class="icon-data-warning-sign commonColorRed"></i>{error}</p>
    {:else}
    <span class="preview"><span class="fade"></span></span>
    <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
    <div class="bar" style="width:0%;">
    </div>
    </div>
    {/error}
    </li>
</script>
<?php //E# The template to display files available for upload  ?>
