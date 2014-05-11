<h3><?php echo $viewData['header']; ?></h3>    
<table class="table table-condensed table-bordered">
    <thead>
        <tr>
            <th><?php echo $viewData['heading'][0]; ?></th>
            <th><?php echo $viewData['heading'][1]; ?></th>
            <th><?php echo $viewData['heading'][2]; ?></th>
            <th><?php echo $viewData['heading'][3]; ?></th>
        </tr>
    </thead>
    <tbody>
        <?php echo $viewData['tableBody']; ?>
    </tbody>
</table>

