<footer class="mega-footer" id="kontak">

    <div class="footer-top">

        <!-- Informasi Pemerintah Desa -->
        <div class="footer-col footer-col--village">

            <div class="footer-brand">

                <span class="footer-brand-mark" aria-hidden="true">
                    <img src="{{ asset('uploads/logo-desa-maor.png') }}" alt="" class="footer-brand-logo">
                </span>

                <span class="brand-text">
                    <strong>Pemerintah {{ $desa['nama'] }}</strong>
                </span>

            </div>

            <p>
                {{ $desa['alamat'] }}<br>
                {{ $desa['kecamatan'] }}, {{ $desa['kabupaten'] }}<br>
                {{ $desa['provinsi'] }}, {{ $desa['kode_pos'] }}
            </p>

            <p class="footer-region-code">
                <strong>Kode Wilayah:</strong>
                {{ $desa['kode_wilayah'] }}
            </p>

        </div>


        <!-- Hubungi Kami -->
        <div class="footer-col footer-col--contact">

            <h3 class="footer-heading">
                Hubungi Kami
            </h3>

            <ul class="footer-contact">

                <li>
                    <svg class="ui-icon footer-contact-icon" viewBox="0 0 24 24" aria-hidden="true">

                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2
              19.79 19.79 0 0 1-8.63-3.07
              19.5 19.5 0 0 1-6-6
              19.79 19.79 0 0 1-3.07-8.67
              A2 2 0 0 1 4.11 2h3
              a2 2 0 0 1 2 1.72
              12.84 12.84 0 0 0 .7 2.81
              2 2 0 0 1-.45 2.11L8.09 9.91
              a16 16 0 0 0 6 6l1.27-1.27
              a2 2 0 0 1 2.11-.45
              12.84 12.84 0 0 0 2.81.7
              A2 2 0 0 1 22 16.92Z">
                        </path>

                    </svg>

                    <a href="tel:{{ $desa['telepon'] }}">
                        {{ $desa['telepon'] }}
                    </a>
                </li>

                <li>
                    <svg class="ui-icon footer-contact-icon" viewBox="0 0 24 24" aria-hidden="true">

                        <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                        <path d="m3 7 9 6 9-6"></path>

                    </svg>

                    <a href="mailto:{{ $desa['email'] }}">
                        {{ $desa['email'] }}
                    </a>
                </li>

            </ul>

            <div class="footer-social">

                <a href="{{ $desa['sosial']['instagram'] }}" target="_blank" rel="noopener noreferrer"
                    aria-label="Instagram Desa Maor" title="Instagram">

                    <svg viewBox="0 0 24 24" aria-hidden="true"
                        style="fill: none; stroke: currentColor; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round;">
                        <rect x="3" y="3" width="18" height="18" rx="5"></rect>
                        <circle cx="12" cy="12" r="4"></circle>
                        <circle cx="17.5" cy="6.5" r="1" style="fill: currentColor; stroke: none;"></circle>
                    </svg>

                </a>

                <a href="{{ $desa['sosial']['facebook'] }}" target="_blank" rel="noopener noreferrer"
                    aria-label="Facebook Desa Maor" title="Facebook">

                    <svg viewBox="0 0 24 24" aria-hidden="true" style="fill: currentColor; stroke: none;">
                        <path d="M13.5 22v-8h2.8l.4-3.2h-3.2V8.7c0-.9.3-1.6 1.7-1.6H17V4.2
                c-.3 0-1.4-.2-2.6-.2C11.8 4 10 5.6 10 8.5V11H7v3.2h3V22h3.5Z">
                        </path>
                    </svg>

                </a>

                <a href="{{ $desa['sosial']['youtube'] }}" target="_blank" rel="noopener noreferrer"
                    aria-label="YouTube Desa Maor" title="YouTube">

                    <svg viewBox="0 0 24 24" aria-hidden="true"
                        style="fill: none; stroke: currentColor; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round;">
                        <rect x="2.5" y="6" width="19" height="12" rx="4"></rect>
                        <path d="m10 9 5 3-5 3Z" style="fill: currentColor; stroke: none;"></path>
                    </svg>

                </a>

            </div>

        </div>


        <!-- Tautan Penting -->
        <div class="footer-col footer-col--links">

            <h3 class="footer-heading">
                Jelajahi
            </h3>

            <ul class="footer-links">

                <li>
                    <a href="https://kemendesa.go.id" target="_blank" rel="noopener">
                        Website Kemendesa
                    </a>
                </li>

                <li>
                    <a href="https://kemendagri.go.id" target="_blank" rel="noopener">
                        Website Kemendagri
                    </a>
                </li>

                <li>
                    <a href="https://lamongankab.go.id" target="_blank" rel="noopener">
                        Website Kab. Lamongan
                    </a>
                </li>

                <li>
                    <a href="https://cekdptonline.kpu.go.id" target="_blank" rel="noopener">
                        Cek DPT Online
                    </a>
                </li>

            </ul>

        </div>

    </div>


    <div class="footer-bottom">
        <p>
            &copy; 2026 Pemerintah {{ $desa['nama'] }}
        </p>
    </div>

</footer>