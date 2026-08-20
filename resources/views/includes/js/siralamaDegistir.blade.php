<script>
    $(document).ready(function() {
        var el = document.getElementById('rankTable').getElementsByTagName('tbody')[0];
        var sortable = new Sortable(el, {
            onUpdate: function (event) {
                var items = event.to.children;
                var sira = [];
                var tabloadi = '<?php echo $tabloadi; ?>';
                for (var i = 0; i < items.length; i++) {
                    sira.push(items[i].getAttribute('data-id'));
                }
                $.ajax({
                    method: 'POST',
                    url: '/siralamayi-guncelle',
                    data: {
                        sira: sira,
                        tabloadi:tabloadi,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        iziToast.success({
                            title: 'Başarılı',
                            message: 'Sıralama İşlemi Başarılı',
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Hata:', error);
                    }
                });
            }
        });
    });
</script>
