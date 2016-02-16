<table class="table table-condensed table-striped table-hover table-responsive">
    <tr>
        <th></th>
        <th><?php echo \Lang::get('media::media.detailedPageView.file_name'); ?></th>
        <th><?php echo \Lang::get('media::media.detailedPageView.modified_at'); ?></th>
        <th><?php echo \Lang::get('media::media.detailedPageView.size'); ?></th>
    </tr>
    <tbody>
        <?php echo $view_data['single_media_view']; ?>
    </tbody>
</table>