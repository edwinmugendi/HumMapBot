<tr>
    <td><?php echo $view_data['singleController']['first_name'] . ' ' . $view_data['singleController']['last_name']; ?></td>
    <td><?php echo $view_data['singleController']['email']; ?></td>
    <td><?php echo $view_data['singleController']['phone']; ?></td>
    <td><?php echo $view_data['singleController']['organization']['name']; ?></td>
    <td><?php echo $view_data['Carbon']::createFromFormat('Y-m-d G:i:s', $view_data['singleController']['last_login'])->format('d/m/Y'); ?></td>
    <td>
        <?php if ($view_data['singleController']['verified']): ?>
            <i class="icon-data-check commonColor"></i>
        <?php else: ?>
            <i class="icon-data-check commonColor"></i>
        <?php endif; ?>
    </td>
      <td><?php echo $view_data['singleController']['country']['name']; ?></td>
    <td><?php echo $view_data['Carbon']::createFromFormat('Y-m-d G:i:s', $view_data['singleController']['created_at'])->format('d/m/Y'); ?></td>

</tr>
