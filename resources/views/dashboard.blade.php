<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Volt - Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --evolt-yellow: #DAE200;
            --evolt-green: #00C853;
            --evolt-text-green: #398300;
            --evolt-dark: #212529;
            --evolt-font: 'Poppins', sans-serif;
        }

        body {
            font-family: var(--evolt-font);
            background-color: #f8f9fa;
        }

        .navbar { padding-top: 1.5rem; padding-bottom: 1.5rem; }
        .navbar-brand { font-weight: 700; font-size: 1.5rem; }
        .nav-link { font-weight: 500; color: var(--evolt-dark); }
        .nav-link:hover { color: var(--evolt-green); }
        .profile-circle { width: 45px; height: 45px; background-color: var(--evolt-green); border-radius: 50%; cursor: pointer; }
        .hero-section { background-color: var(--evolt-yellow); padding: 5rem 0; position: relative; overflow: hidden; }
        .hero-section h1 { font-weight: 800; font-size: 3.0rem; color: #333; max-width: 500px; }
        .hero-section .highlight-text { color: var(--evolt-text-green); }
        .hero-image { position: relative; z-index: 2; }
        .search-form-container { margin-top: -80px; position: relative; z-index: 10; }
        .search-form-card { background-color: #fff; padding: 2.5rem; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .form-label { font-weight: 500; color: #495057; margin-bottom: 0.5rem; }

        /* --- STYLING FORM UNIVERSAL --- */
        .custom-select-trigger {
            height: 55px; border-radius: 10px; border: 1px solid #dee2e6;
            background-color: #fff; padding: 0 1rem; width: 100%;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            display: flex; align-items: center; justify-content: space-between;
            font-size: 1rem; color: #212529; cursor: pointer;
        }
        .custom-select-trigger:hover { border-color: #adb5bd; }
        .custom-select-wrapper.open .custom-select-trigger {
            border-color: var(--evolt-green);
            box-shadow: 0 0 0 0.2rem rgba(0, 200, 83, 0.25);
            outline: none;
        }
        .custom-select-trigger .trigger-icon { width: 20px; height: 20px; fill: #6c757d; }
        .custom-select-wrapper { position: relative; }
        .custom-options {
            position: absolute; top: 100%; left: 0; right: 0; background-color: #fff; border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1); margin-top: 8px; z-index: 100;
            opacity: 0; visibility: hidden; transform: translateY(-10px);
            transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.3s ease;
            max-height: 240px; overflow-y: auto;
        }
        .custom-select-wrapper.open .custom-options { opacity: 1; visibility: visible; transform: translateY(0); }
        .custom-option { padding: 12px 1rem; cursor: pointer; transition: background-color 0.2s ease; }
        .custom-option:hover { background-color: rgba(0, 200, 83, 0.1); }
        .custom-option.selected { font-weight: 600; color: var(--evolt-green); }
        .custom-option.disabled { color: #adb5bd; cursor: not-allowed; background-color: #f8f9fa; }
        
        /* --- STYLING KALENDER KUSTOM --- */
        .calendar-picker { padding: 1rem; }
        .calendar-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
        .calendar-nav { cursor: pointer; padding: 0.5rem; border-radius: 50%; }
        .calendar-nav:hover { background-color: #e9ecef; }
        .calendar-nav svg { width: 12px; height: 12px; }
        .calendar-title { font-weight: 600; }
        .calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 5px; text-align: center; }
        .calendar-grid > div { padding: 0.5rem 0; font-size: 0.9rem; }
        .day-name { font-weight: 600; color: #6c757d; }
        .day-number { cursor: pointer; border-radius: 50%; }
        .day-number:not(.disabled):hover { background-color: rgba(0, 200, 83, 0.1); }
        .day-number.selected { background-color: var(--evolt-green); color: white; }
        .day-number.disabled { color: #ced4da; cursor: not-allowed; }

        .original-input { display: none; }
        
        .btn-cari { background-color: var(--evolt-green); color: #fff; font-weight: 600; padding: 12px 30px; border-radius: 10px; border: none; transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease; box-shadow: 0 4px 15px rgba(0, 200, 83, 0.2); }
        .btn-cari:hover { background-color: #00a042; color: #fff; transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0, 200, 83, 0.3); }
        .company-section { padding: 10rem 0 5rem 0; }
        .company-logos img { max-height: 40px; /* Adjusted size for better visibility */ filter: grayscale(100%); opacity: 0.6; transition: all 0.3s ease; }
        .company-logos img:hover { filter: grayscale(0%); opacity: 1; }
        .footer { background-color: #1c1c1c; color: #a9a9a9; padding: 4rem 0 2rem 0; }
        .footer h5 { color: #fff; margin-bottom: 1rem; font-weight: 600; }
        .footer a { color: #a9a9a9; text-decoration: none; }
        .footer a:hover { color: #fff; }
        .footer .list-unstyled li { margin-bottom: 0.5rem; }
        .footer .social-icons a { display: inline-block; width: 30px; height: 30px; background-color: #333; border-radius: 50%; margin-right: 10px; }
        .footer .copyright { border-top: 1px solid #333; padding-top: 1.5rem; margin-top: 2rem; font-size: 0.9rem; }
    </style>
</head>
<body>

    <header>
        <nav class="navbar navbar-expand-lg bg-transparent">
            <div class="container">
                <a class="navbar-brand text-dark" href="#"><span style="color: var(--evolt-green);">E</span>-VOLT</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">About us</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Blog</a></li>
                    </ul>
                    <div class="profile-circle ms-lg-4"></div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section class="hero-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h1>Menghubungkan <span class="highlight-text">pengendara</span> Dengan Stasiun Pengecasan Cerdas</h1>
                    </div>
                    <div class="col-lg-6 text-center">
                        <!-- GAMBAR HERO DIUBAH DI SINI -->
                        <img src="images/mobil.png" alt="Placeholder Mobil EV" class="img-fluid hero-image" style="border-radius: 15px;">
                    </div>
                </div>
            </div>
        </section>

        <section class="search-form-container">
            <div class="container">
                <div class="search-form-card">
                    <h4 class="mb-4 fw-bold">Cari EV Charge Station</h4>
                    <form>
                        <!-- Hidden inputs to store the actual values -->
                        <input type="hidden" id="tanggal-value" name="tanggal">
                        <input type="hidden" id="jam-value" name="jam">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Merk Mobil</label>
                                <div class="custom-select-wrapper">
                                    <select class="original-input">
                                        <option value="">Pilih Merk Mobil</option>
                                        <option value="Hyundai">Hyundai</option>
                                        <option value="Wuling">Wuling</option>
                                        <option value="Tesla">Tesla</option>
                                        <option value="Toyota">Toyota</option>
                                        <option value="BMW">BMW</option>
                                        <option value="Mercedes-Benz">Mercedes-Benz</option>
                                        <option value="Nissan">Nissan</option>
                                        <option value="MG">MG</option>
                                        <option value="BYD">BYD</option>
                                        <option value="Kia">Kia</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tipe Mobil</label>
                                <div class="custom-select-wrapper">
                                    <select class="original-input">
                                        <option value="">Pilih Tipe Mobil</option>
                                        <option value="SUV">SUV</option>
                                        <option value="City Car">City Car</option>
                                        <option value="Sedan">Sedan</option>
                                        <option value="Hatchback">Hatchback</option>
                                        <option value="Crossover">Crossover</option>
                                        <option value="Luxury Sedan">Luxury Sedan</option>
                                        <option value="MPV">MPV</option>
                                        <option value="Gran Coupé">Gran Coupé</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tanggal</label>
                                <div id="date-picker-wrapper" class="custom-select-wrapper"></div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Domisili</label>
                                <div class="custom-select-wrapper">
                                    <select class="original-input">
                                        <option value="">Pilih Domisili</option>
                                        <option value="Batam Center">Batam Center</option>
                                        <option value="Nagoya">Nagoya</option>
                                        <option value="Sekupang">Sekupang</option>
                                        <option value="Batu Aji">Batu Aji</option>
                                        <option value="Tiban">Tiban</option>
                                        <option value="Bengkong">Bengkong</option>
                                        <option value="Nongsa">Nongsa</option>
                                        <option value="Tanjung Pinang">Tanjung Pinang</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Stasiun Charger</label>
                                <div class="custom-select-wrapper">
                                    <select class="original-input">
                                        <option value="">Pilih Stasiun</option>
                                        <option value="SPKLU Mega Mall">SPKLU Mega Mall</option>
                                        <option value="SPKLU Grand Batam Mall">SPKLU Grand Batam Mall</option>
                                        <option value="SPKLU Kantor PLN Batam">SPKLU Kantor PLN Batam</option>
                                        <option value="SPKLU Hang Nadim Airport">SPKLU Hang Nadim Airport</option>
                                        <option value="SPKLU One Batam Mall">SPKLU One Batam Mall</option>
                                        <option value="SPKLU Pollux Habibie">SPKLU Pollux Habibie</option>
                                        <option value="SPKLU Harris Hotel">SPKLU Harris Hotel</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Jam</label>
                                <div id="time-picker-wrapper" class="custom-select-wrapper"></div>
                            </div>
                        </div>
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-cari">Cari Jadwal</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section class="company-section">
            <div class="container text-center">
                <h3 class="mb-5">Perusahaan ini bekerja sama oleh</h3>
                <!-- LOGO PERUSAHAAN DIUBAH DI SINI -->
                <div class="d-flex flex-wrap justify-content-center align-items-center company-logos">
                    <img src="https://cdn.worldvectorlogo.com/logos/tesla-9.svg" alt="Tesla Logo" class="m-3 mx-md-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/e/e2/BYD_Auto_2022_logo.svg" alt="BYD Logo" class="m-3 mx-md-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/44/Hyundai_Motor_Company_logo.svg" alt="Hyundai Logo" class="m-3 mx-md-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b6/KIA_logo3.svg" alt="Kia Logo" class="m-3 mx-md-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/1/16/Wuling-logo.svg" alt="Wuling Logo" class="m-3 mx-md-4">
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="navbar-brand text-white"><span style="color: var(--evolt-green);">E</span>-VOLT</h5>
                    <p>Lorem ipsum is simply dummy text of the printing and typesetting industry.</p>
                    <p>@lorem</p>
                </div>
                <div class="col-lg-2 col-6">
                    <h5>About us</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Lorem</a></li>
                        <li><a href="#">Portfolio</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Contact us</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-6">
                    <h5>Contact us</h5>
                    <p>Lorem ipsum is simply dummy text of the printing and typesetting industry.</p>
                    <p>+908 89097 890</p>
                </div>
                <div class="col-lg-3">
                    <div class="social-icons">
                        <a href="#"></a><a href="#"></a><a href="#"></a><a href="#"></a>
                    </div>
                </div>
            </div>
            <div class="text-center copyright">Copyright © 2021 Lorem All Rights Reserved</div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleDropdown = (wrapper) => {
            document.querySelectorAll('.custom-select-wrapper.open').forEach(openWrapper => {
                if (openWrapper !== wrapper) openWrapper.classList.remove('open');
            });
            wrapper.classList.toggle('open');
        };

        // --- 1. SETUP SELECT DROPDOWNS ---
        document.querySelectorAll('select.original-input').forEach(selectElement => {
            const wrapper = selectElement.parentElement;
            let optionsHTML = '';
            Array.from(selectElement.options).forEach(option => {
                optionsHTML += `<div class="custom-option" data-value="${option.value}">${option.textContent}</div>`;
            });

            wrapper.innerHTML += `
                <div class="custom-select-trigger">
                    <span>${selectElement.options[selectElement.selectedIndex].textContent}</span>
                    <svg class="trigger-icon" viewBox="0 0 320 512"><path d="M137.4 374.6c12.5 12.5 32.8 12.5 45.3 0l128-128c9.2-9.2 11.9-22.9 6.9-34.9s-16.6-19.8-29.6-19.8L32 192c-12.9 0-24.6 7.8-29.6 19.8s-2.2 25.7 6.9 34.9l128 128z"/></svg>
                </div>
                <div class="custom-options">${optionsHTML}</div>
            `;
            
            wrapper.querySelector('.custom-select-trigger').addEventListener('click', (e) => {
                e.stopPropagation();
                toggleDropdown(wrapper);
            });

            wrapper.querySelectorAll('.custom-option').forEach(optionDiv => {
                optionDiv.addEventListener('click', () => {
                    wrapper.querySelector('span').textContent = optionDiv.textContent;
                    selectElement.value = optionDiv.dataset.value;
                    wrapper.classList.remove('open');
                });
            });
        });

        // --- 2. SETUP CUSTOM DATE & TIME PICKERS ---
        const datePickerWrapper = document.getElementById('date-picker-wrapper');
        const timePickerWrapper = document.getElementById('time-picker-wrapper');
        const hiddenDateInput = document.getElementById('tanggal-value');
        const hiddenTimeInput = document.getElementById('jam-value');
        
        const today = new Date();
        today.setHours(0, 0, 0, 0); // Normalize to start of day
        let selectedDate = new Date(today);
        let displayDate = new Date(today); // Month/year to display in calendar

        const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        const dayNames = ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"];

        const formatDate = (date) => `${date.getDate()} ${monthNames[date.getMonth()]} ${date.getFullYear()}`;
        
        // Function to generate the calendar HTML
        const generateCalendar = () => {
            const year = displayDate.getFullYear();
            const month = displayDate.getMonth();
            const firstDay = new Date(year, month, 1).getDay();
            const lastDate = new Date(year, month + 1, 0).getDate();
            
            let header = `<div class="calendar-header">
                <div class="calendar-nav" id="prev-month"><svg viewBox="0 0 256 512"><path d="M192 448c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l137.4 137.4c12.5 12.5 12.5 32.75 0 45.25C208.4 444.9 200.2 448 192 448z"/></svg></div>
                <div class="calendar-title">${monthNames[month]} ${year}</div>
                <div class="calendar-nav" id="next-month"><svg viewBox="0 0 256 512"><path d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"/></svg></div>
            </div>`;

            let days = dayNames.map(d => `<div class="day-name">${d}</div>`).join('');
            
            for(let i = 0; i < firstDay; i++) { days += '<div></div>'; }

            for (let i = 1; i <= lastDate; i++) {
                const currentDate = new Date(year, month, i);
                let classes = 'day-number';
                if (currentDate < today) classes += ' disabled';
                if (currentDate.getTime() === selectedDate.getTime()) classes += ' selected';
                days += `<div class="${classes}" data-date="${currentDate.toISOString()}">${i}</div>`;
            }
            
            datePickerWrapper.querySelector('.custom-options').innerHTML = `<div class="calendar-picker">${header}<div class="calendar-grid">${days}</div></div>`;
        };
        
        // Function to generate time slots
        const generateTimeSlots = () => {
            let slotsHTML = '';
            const now = new Date();
            for(let h = 0; h < 24; h++) {
                for(let m = 0; m < 60; m += 30) {
                    const hour = String(h).padStart(2, '0');
                    const minute = String(m).padStart(2, '0');
                    const timeString = `${hour}:${minute}`;
                    let isDisabled = false;
                    
                    if (selectedDate.getTime() === today.getTime()) {
                        if (h < now.getHours() || (h === now.getHours() && m < now.getMinutes())) {
                            isDisabled = true;
                        }
                    }
                    
                    slotsHTML += `<div class="custom-option ${isDisabled ? 'disabled' : ''}" data-value="${timeString}">${timeString}</div>`;
                }
            }
            timePickerWrapper.querySelector('.custom-options').innerHTML = slotsHTML;
        };
        
        // Initialize Date Picker
        datePickerWrapper.innerHTML = `
            <div class="custom-select-trigger">
                <span id="date-picker-text">${formatDate(selectedDate)}</span>
                <svg class="trigger-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64V24c0-13.3-10.7-24-24-24S16 10.7 16 24v40H0v24c0 13.3 10.7 24 24 24h16v32c0 13.3 10.7 24 24 24h32c13.3 0 24-10.7 24-24v-32h16c13.3 0 24-10.7 24-24V64h-16V24zM432 112.1c0-26-15-49-36-59L312 0 296 32l84 42c5.5 2.8 9 8.5 9 14.9v35.2c0 13.3-10.7 24-24 24s-24-10.7-24-24V112c0-22.1-17.9-40-40-40H176c-22.1 0-40 17.9-40 40v288c0 22.1 17.9 40 40 40h160c22.1 0 40-17.9 40-40V288c0-13.3 10.7-24 24-24s24 10.7 24 24v112c0 48.6-39.4 88-88 88H176c-48.6 0-88-39.4-88-88V112C88 63.4 127.4 24 176 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24h-48C110.3 0 48 62.3 48 136v264c0 61.9 50.1 112 112 112h160c61.9 0 112-50.1 112-112V112.1z"/></svg>
            </div>
            <div class="custom-options"></div>
        `;
        hiddenDateInput.value = selectedDate.toISOString().split('T')[0];
        generateCalendar();

        // Initialize Time Picker
        timePickerWrapper.innerHTML = `
            <div class="custom-select-trigger">
                <span id="time-picker-text">Pilih Jam</span>
                 <svg class="trigger-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"/></svg>
            </div>
            <div class="custom-options"></div>
        `;
        generateTimeSlots();

        // Event Listeners for Pickers
        datePickerWrapper.addEventListener('click', (e) => {
            e.stopPropagation();
            if (e.target.closest('.custom-select-trigger')) {
                toggleDropdown(datePickerWrapper);
            } else if (e.target.closest('#prev-month')) {
                displayDate.setMonth(displayDate.getMonth() - 1);
                generateCalendar();
            } else if (e.target.closest('#next-month')) {
                displayDate.setMonth(displayDate.getMonth() + 1);
                generateCalendar();
            } else if (e.target.classList.contains('day-number') && !e.target.classList.contains('disabled')) {
                selectedDate = new Date(e.target.dataset.date);
                hiddenDateInput.value = selectedDate.toISOString().split('T')[0];
                document.getElementById('date-picker-text').textContent = formatDate(selectedDate);
                generateCalendar(); // Re-render to show selection
                generateTimeSlots(); // IMPORTANT: Update time slots based on new date
                datePickerWrapper.classList.remove('open');
            }
        });

        timePickerWrapper.addEventListener('click', (e) => {
            e.stopPropagation();
            if (e.target.closest('.custom-select-trigger')) {
                toggleDropdown(timePickerWrapper);
            } else if (e.target.classList.contains('custom-option') && !e.target.classList.contains('disabled')) {
                hiddenTimeInput.value = e.target.dataset.value;
                document.getElementById('time-picker-text').textContent = e.target.dataset.value;
                timePickerWrapper.classList.remove('open');
            }
        });

        // Close all dropdowns when clicking outside
        window.addEventListener('click', () => {
            document.querySelectorAll('.custom-select-wrapper.open').forEach(w => w.classList.remove('open'));
        });
    });
    </script>
</body>
</html>

