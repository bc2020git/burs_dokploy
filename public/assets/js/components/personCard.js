document.addEventListener("DOMContentLoaded", function() {
    const member = {
        bursiyerStatusu: "Aktif Bursiyer" // Bu değer dinamik olarak değiştirilebilir
    };

    const bursiyerStatusuHTML = member.bursiyerStatusu === "Red Bursiyer"
        ? `<div class="burs-durumu"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                <circle cx="9" cy="9" r="7" fill="#A9A9A9" stroke="#FFFFFF" stroke-width="2"/>
            </svg> `
        : member.bursiyerStatusu === "Aktif Bursiyer"
        ? `<div class="burs-durumu"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                <circle cx="9" cy="9" r="7" fill="#00875A" stroke="#FFFFFF" stroke-width="2"/>
            </svg> Aktif Bursiyer`
        : `<div class="burs-durumu"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                <circle cx="9" cy="9" r="7" fill="#FFA500" stroke="#FFFFFF" stroke-width="2"/>
            </svg> Aday Bursiyer`;

    document.getElementById('bursDurumu').innerHTML = bursiyerStatusuHTML;
});
