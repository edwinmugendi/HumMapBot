<h3><?php echo $view_data['header']; ?></h3>    
<table class="table table-condensed table-bordered">
    <thead>
        <tr>
            <th><?php echo $view_data['heading'][0]; ?></th>
            <th><?php echo $view_data['heading'][1]; ?></th>
            <th><?php echo $view_data['heading'][2]; ?></th>
            <th><?php echo $view_data['heading'][3]; ?></th>
        </tr>
    </thead>
    <tbody>
        <?php echo $view_data['tableBody']; ?>
    </tbody>
</table>

