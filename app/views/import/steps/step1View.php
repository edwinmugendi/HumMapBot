<div  id="idStepView" data-step="1" class="row">
    <div class="col-md-12 commonMarginLeft10">
        <h4 class="commonFontWeightBold"><?php echo \Lang::get('common.importView.select_csv'); ?></h4>
        <input id="idImportFile" type="file" class="btn btn-primary">
        <p class="commonMarginTop5"><a href="<?php echo asset('import/csv/' . \Str::title(\Str::snake($view_data['package'] . '_' . $view_data['controller']) . '.csv')); ?>" target="_blank"><?php echo \Lang::get('common.importView.download_sample_file'); ?> <i class="glyphicon glyphicon-download"></i></a></p>
    </div>
</div>


