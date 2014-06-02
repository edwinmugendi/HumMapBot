<?php if ($viewData['logged']): ?>
        <p id="notification" class="text text-info commonTextAlignCenter"></p>
<?php endif; ?>
<?php if (!empty($viewData['topBarPartial'])): ?>
    <? echo$viewData['topBarPartial']; ?>
<?php endif; ?>
