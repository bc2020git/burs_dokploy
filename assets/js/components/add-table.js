
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('addSiblingForm');
    const tableBody = document.querySelector('table tbody');
    let siblingCount = 0;

    form.addEventListener('submit', function (event) {
        event.preventDefault(); 

        const name = document.getElementById('kardesAdi').value.trim();
        const surname = document.getElementById('kardesSoyadi').value.trim();
        const age = document.getElementById('kardesYasi').value.trim();
        const education = document.getElementById('kardesOgrenimDurumu').value;
        const maritalStatus = document.getElementById('kardesMedeniDurumu').value;
        const job = document.getElementById('kardesMeslegi').value.trim();


        const row = document.createElement('tr');

        siblingCount++;
        row.innerHTML = `
    <td>${siblingCount}</td>
    <td>${name}</td>
    <td>${surname}</td>
    <td>${age}</td>
    <td>${education}</td>
    <td>${maritalStatus}</td>
    <td>${job}</td>
    <td>
        <button class="btn edit-member-info-btn" type="button"
         class="btn btn-primary mb-3" data-bs-toggle="modal"
         data-bs-target="#kardesDuzenleModal"><svg
         xmlns="http://www.w3.org/2000/svg" width="24"
         height="24" viewBox="0 0 24 24" fill="none">
         <path
        d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3V13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89H21V21.89H3V19.89Z"
         fill="#4069E5" />
         </svg></button>
         <button class="btn" data-bs-toggle="modal"
         data-bs-target="#kardesDeleteConfirmModal">
        <svg xmlns="http://www.w3.org/2000/svg" width="20"
         height="20" viewBox="0 0 20 20" fill="none">
        <path
         d="M14.1641 5.00008H18.3307V6.66675H16.6641V17.5001C16.6641 17.9603 16.291 18.3334 15.8307 18.3334H4.16406C3.70383 18.3334 3.33073 17.9603 3.33073 17.5001V6.66675H1.66406V5.00008H5.83073V2.50008C5.83073 2.03985 6.20383 1.66675 6.66406 1.66675H13.3307C13.791 1.66675 14.1641 2.03985 14.1641 2.50008V5.00008ZM7.4974 9.16675V14.1667H9.16406V9.16675H7.4974ZM10.8307 9.16675V14.1667H12.4974V9.16675H10.8307ZM7.4974 3.33341V5.00008H12.4974V3.33341H7.4974Z"
        fill="#F03000" />
        </svg></button>
     </td>
`;
        tableBody.appendChild(row);

        form.reset();
        const modal = bootstrap.Modal.getInstance(document.getElementById('kardesEkleModal'));
        modal.hide();
    });

    tableBody.addEventListener('click', function (event) {
        if (event.target.classList.contains('delete-button')) {
            const row = event.target.closest('tr');
            row.remove();
        }
    });
});

