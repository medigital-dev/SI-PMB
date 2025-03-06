<?php if (isset($script)): ?>
    <?php foreach ($script as $val): ?>
        <script src="<?= $val; ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>
</body>

</html>