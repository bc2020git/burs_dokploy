<link rel="stylesheet" href="<?=url('/')?>/resources/css/iziToast.min.css">
<script src="<?=url('/')?>/resources/js/iziToast.min.js" type="text/javascript"></script>
<script>
    @if(Session::has('error'))
    iziToast.error({
        title: 'Hata',
        message: '{{ Session::get('error') }}',
    });
    @endif
    @if(Session::has('success'))
    iziToast.success({
        title: 'İşlem Başarılı',
        message: '{{ Session::get('success') }}',
    });
    @endif
</script>
