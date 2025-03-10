<?php if (isset($script)): ?>
    <?php foreach ($script as $val): ?>
        <script src="<?= $val; ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

<script>
    $(document).ready(function() {
        $('#btnSimpanTautan').on('click', async function() {
            const title = $('#titleTautan');
            const url = $('#urlTautan');

            if (!title.val().trim() || !url.val().trim()) {
                if (!title.val().trim()) title.addClass('is-invalid');
                else title.removeClass('is-invalid');
                if (!url.val().trim()) url.addClass('is-invalid');
                else url.removeClass('is-invalid');
                toast('Lengkapi form.', 'error');
                return;
            }
            $('.is-invalid').removeClass('is-invalid');

            toggleButton($(this), 'Menyimpan...');
            const res = await fetchData({
                url: '/api/tautan.php',
                data: {
                    title: title.val(),
                    url: url.val()
                },
                method: 'POST'
            }).catch(err => {
                toggleButton($(this), 'Simpan');
                toast(err.responseJSON.message, 'error');
                return false;
            });
            if (!res) return;
            toast(res.message, 'success', '', 5000);
            title.val('');
            url.val('');
            $('#modalTambahTauran').modal('hide');
            toggleButton($(this), 'Simpan');
        });
    })
</script>
</body>

</html>