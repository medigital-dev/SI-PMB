<?php if (isset($script)): ?>
    <?php foreach ($script as $val): ?>
        <script src="<?= $val; ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

<script>
    $(document).ready(function() {})
</script>
</body>

</html>