const nufusIlSelect = document.getElementById('nufusIl');
const nufusIlceSelect = document.getElementById('nufusIlce');
const genderSelect = document.getElementById('cinsiyet');
const maritalStatusSelect = document.getElementById('medeniHal');
const okulIlSelect = document.getElementById('okulIl');
const kaldigiIlSelect = document.getElementById('kaldigiIl');
const kaldigiIlceSelect = document.getElementById('kaldigiIlce');
const barinmaTuruSelect = document.getElementById('barinmaTuru');
const anneninIlSelect = document.getElementById('anneninIl');
const babaninIlSelect = document.getElementById('babaninIl');
const anneninIlceSelect = document.getElementById('anneninIlce');
const babaninIlceSelect = document.getElementById('babaninIlce');

const nufusIls = {
    "Ankara": ["Çankaya", "Keçiören", "Mamak"],
    "İstanbul": ["Kadıköy", "Beşiktaş", "Şişli"],
    "İzmir": ["Bornova", "Konak", "Karşıyaka"]
};

const genders = ["Erkek", "Kadın", "Diğer"];
const maritalStatuses = ["Bekar", "Evli", "Dul", "Boşanmış"];

const barinmaTurleri = ["Ev", "Yurt", "Apart", "Misafirhane"];


function populateOptions(selectElement, optionsArray, defaultOptionText) {
    selectElement.innerHTML = `<option selected disabled>${defaultOptionText}</option>`;
    optionsArray.forEach(optionValue => {
        const option = document.createElement('option');
        option.value = optionValue;
        option.textContent = optionValue;
        selectElement.appendChild(option);
    });
}

function populateNufusIls() {
    populateOptions(nufusIlSelect, Object.keys(nufusIls), 'İl Seçiniz...');
}

function populateNufusIlces(nufusIl) {
    if (nufusIls[nufusIl]) {
        populateOptions(nufusIlceSelect, nufusIls[nufusIl], 'İlçe Seçiniz...');
    }
}

nufusIlSelect.addEventListener('change', (e) => {
    populateNufusIlces(e.target.value);
});

window.addEventListener('DOMContentLoaded', (event) => {
    populateNufusIls();
    populateOptions(genderSelect, genders, 'Cinsiyet Seçiniz...');
    populateOptions(maritalStatusSelect, maritalStatuses, 'Medeni Hal Seçiniz...');
});

function populateNufusIls() {
    for (let nufusIl in nufusIls) {
        const option = document.createElement('option');
        option.value = nufusIl;
        option.textContent = nufusIl;
        okulIlSelect.appendChild(option);
    }
}

window.addEventListener('DOMContentLoaded', (event) => {
    populateNufusIls();
});

function populateSelectOptions(selectElement, options) {
    options.forEach(optionValue => {
        const option = document.createElement('option');
        option.value = optionValue;
        option.textContent = optionValue;
        selectElement.appendChild(option);
    });
}

function populateNufusIls() {
    populateSelectOptions(kaldigiIlSelect, Object.keys(nufusIls));
}

function populateNufusIlces(selectedIl) {
    kaldigiIlceSelect.innerHTML = '<option selected disabled>Seçiniz...</option>'; 
    if (nufusIls[selectedIl]) {
        populateSelectOptions(kaldigiIlceSelect, nufusIls[selectedIl]);
    }
}

kaldigiIlSelect.addEventListener('change', (e) => {
    populateNufusIlces(e.target.value);
});

window.addEventListener('DOMContentLoaded', (event) => {
    populateNufusIls();
    populateSelectOptions(barinmaTuruSelect, barinmaTurleri);
});

function populateSelectOptions(selectElement, options) {
    options.forEach(optionValue => {
        const option = document.createElement('option');
        option.value = optionValue;
        option.textContent = optionValue;
        selectElement.appendChild(option);
    });
}

function populateNufusIls() {
    const ilNames = Object.keys(nufusIls);
    populateSelectOptions(anneninIlSelect, ilNames);
    populateSelectOptions(babaninIlSelect, ilNames);
}

function populateNufusIlces(selectElement, selectedIl) {
    selectElement.innerHTML = '<option selected disabled>Seçiniz...</option>';
    if (nufusIls[selectedIl]) {
        populateSelectOptions(selectElement, nufusIls[selectedIl]);
    }
}

anneninIlSelect.addEventListener('change', (e) => {
    populateNufusIlces(anneninIlceSelect, e.target.value);
});

babaninIlSelect.addEventListener('change', (e) => {
    populateNufusIlces(babaninIlceSelect, e.target.value);
});

window.addEventListener('DOMContentLoaded', (event) => {
    populateNufusIls();
});