<tr>
    <td><?php echo $viewData['singleController']['first_name'] . ' ' . $viewData['singleController']['last_name']; ?></td>
    <td><?php echo $viewData['singleController']['email']; ?></td>
    <td><?php echo $viewData['singleController']['phone']; ?></td>
    <td><?php echo $viewData['singleController']['organization']['name']; ?></td>
    <td><?php echo $viewData['Carbon']::createFromFormat('Y-m-d G:i:s', $viewData['singleController']['last_login'])->format('d/m/Y'); ?></td>
    <td>
        <?php if ($viewData['singleController']['verified']): ?>
            <i class="icon-data-check commonColor"></i>
        <?php else: ?>
            <i class="icon-data-check commonColor"></i>
        <?php endif; ?>
    </td>
      <td><?php echo $viewData['singleController']['country']['name']; ?></td>
    <td><?php echo $viewData['Carbon']::createFromFormat('Y-m-d G:i:s', $viewData['singleController']['created_at'])->format('d/m/Y'); ?></td>

</tr>
