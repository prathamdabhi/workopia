<?php if (isset($error)) : ?>
    <?php foreach ($error as $error) : ?>
        <div class="message bg-red-100 my-3">
            <?= $error ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>