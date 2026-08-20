 function toggleAllCheckboxes(master) {
   const checkboxes = document.querySelectorAll("#documentList .checkbox");
   checkboxes.forEach((checkbox) => (checkbox.checked = master.checked));
 }

 function approveDocument(button) {
   const row = button.closest("tr");
   const statusCell = row.querySelector(".status");

   statusCell.classList.remove("reject");
   statusCell.classList.add("checked");
   statusCell.innerHTML = 'Onaylandı<span class="checkmark">✅</span>';

   disableButtons(row, "approve");
belgedurumdegis(button,1)
 }


 function rejectDocument(button) {
   const row = button.closest("tr");
   const statusCell = row.querySelector(".status");

   statusCell.classList.remove("checked");
   statusCell.classList.add("reject");
   statusCell.innerHTML = 'Reddedildi <span class="crossmark">❌</span>';

   disableButtons(row, "reject");
     belgedurumdegis(button,2)

 }
 function islemIcinDiziGonder(islemid) {
  const selectedUserIds = [];
  const checkboxes = document.querySelectorAll('input[name="doccheckbox"]:checked');
  var tc = $('#tc_no').val();
  var period = $('#termControlSelect option:selected').val();


  checkboxes.forEach(checkbox => {
      const userId = checkbox.getAttribute('data-docname');
      if (userId) {
          selectedUserIds.push(userId);
      }
  });
  const surname = $('#surname').val();
  const name = $('#name').val();
  const islemId = islemid;

  if (islemId === 3) {
    // İndirme işlemi için
    $.ajax({
        url: '/Belge-Toplu-Islem',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            userIds: selectedUserIds,
            islemId: islemId,
            tc: tc,
            period: period
        },
        xhrFields: {
            responseType: 'blob'
        },
        success: function(response) {
            // Eğer JSON hata yanıtı gelirse
            if (response.type === 'application/json') {
                const reader = new FileReader();
                reader.onload = function() {
                    const error = JSON.parse(this.result);
                    alert(error.error || 'Bir hata oluştu');
                };
                reader.readAsText(response);
                return;
            }

            // Zip dosyası gelirse
            const blob = new Blob([response], { type: 'application/zip' });
            const link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = `${tc}_${name}_${surname}_belgeler.zip`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        },
        error: function(xhr, status, error) {
            try {
                const response = JSON.parse(xhr.responseText);
                alert(response.error || 'Bir hata oluştu');
            } catch (e) {
                alert('Dosya indirme işlemi başarısız oldu');
            }
            console.error("AJAX Hatası:", status, error);
        }
    });
} else {
      // Diğer işlemler için
      $.ajax({
          url: '/Belge-Toplu-Islem',
          method: 'POST',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: {
              userIds: selectedUserIds,
              islemId: islemId,
              tc: tc,
              period: period
          },
          success: function(response) {
              console.log('Veriler gönderildi:', response);
              location.reload();
          },
          error: function(xhr, status, error) {
              console.error("AJAX Hatası:", status, error);
              alert('İşlem sırasında bir hata oluştu!');
          }
      });
  }
}

 $('#adayTopluKabulBtn').click(function(e) {
     e.preventDefault();
     islemIcinDiziGonder(1);
     approveSelected();

 });
 $('#adayTopluRedBtn').click(function(e) {
     e.preventDefault();

     islemIcinDiziGonder(2);
     rejectSelected();
 });
 function belgedurumdegis(a,durum){
     var docname = a.getAttribute('data-docname');
     var tc = $('#tc_no').val();
     var period = $('#termControlSelect option:selected').val();

     $.ajax({
         url: `/panel/belge-durum-degis/${docname}/${tc}/${period}/${durum}`, // Güncelleme URL'si
         type: 'get', // POST methodu
         headers: {
             'Content-Type': 'application/json',
             'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token eklenmesi
         },
         data: JSON.stringify({

         }),
         success: function(response) {
             console.log(response);
             iziToast.success({
                title: 'İşlem Başarılı',
                message: 'Belge durumu başarıyla güncellendi',
            });
             // İşlem başarılı olduğunda modalı kapat
             $('#updateInterviewModal').modal('hide');
         },
         error: function(xhr, status, error) {
             console.error('Error:', error);
         }
     });
 }
 function disableButtons(row, action) {
   const approveButton = row.querySelector(
     'button[onclick="approveDocument(this)"]'
   );
   const rejectButton = row.querySelector(
     'button[onclick="rejectDocument(this)"]'
   );

   if (action === "approve") {
     approveButton.disabled = true;
     rejectButton.disabled = false;
   } else if (action === "reject") {
     approveButton.disabled = false;
     rejectButton.disabled = true;
   }
 }

 function approveSelected() {
   const checkboxes = document.querySelectorAll(
     "#documentList .checkbox:checked"
   );
   checkboxes.forEach((checkbox) => {
     const row = checkbox.closest("tr");
     approveDocument(
       row.querySelector('button[onclick="approveDocument(this)"]')
     );
   });
 }

 function rejectSelected() {
   const checkboxes = document.querySelectorAll(
     "#documentList .checkbox:checked"
   );
   checkboxes.forEach((checkbox) => {
     const row = checkbox.closest("tr");
     rejectDocument(row.querySelector('button[onclick="rejectDocument(this)"]'));
   });
 }



