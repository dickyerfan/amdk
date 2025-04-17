<button id="btn-up"><i class="fas fa-chevron-circle-up logo"></i></button>
<footer class="py-2 bg-light mt-auto logo">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <!-- <div class="text-muted">Copyright &copy; DIE Art'S Production 2022</div> -->
            <div class="text-muted">Built With <span class="text-danger">&hearts;</span> by DIE Art'S Production <?= date('Y'); ?></div>
        </div>
    </div>
</footer>
</div>
</div>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="exampleModalLabel">Yakin Mau Logout.?</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">Pilih "Logout" jika anda yakin mau keluar</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Sweetalert2 -->
<script src="<?php echo base_url('assets/'); ?>sweetalert2.all.min.js"></script>

<script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="<?= base_url() ?>assets/js/scripts.js"></script>
<script src="<?= base_url() ?>assets/js/Chart.min.js" crossorigin="anonymous"></script>
<script src="<?= base_url() ?>assets/demo/chart-area-demo.js"></script>
<script src="<?= base_url() ?>assets/demo/chart-bar-demo.js"></script>
<script src="<?= base_url() ?>assets/js/datatables-simple-demo.js"></script>

<!-- datatable bootstrap5 -->
<script src="<?= base_url(); ?>assets/datatables/bootstrap5/jquery-3.5.1.js"></script>
<script src="<?= base_url(); ?>assets/datatables/bootstrap5/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/datatables/bootstrap5/dataTables.bootstrap5.min.js"></script>
<!-- select2 js -->
<script src="<?= base_url() ?>assets/select2/select2.min.js"></script>
<script src="<?= base_url('assets/js/bootstrap-datepicker.js') ?>"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
        $('#example_2').DataTable();
        $('#example_3').DataTable();
    });
</script>

<script>
    $('.select2').select2({
        theme: 'bootstrap-5'
    });
</script>

<script>
    $("#btn-up").click(function() {
        $("html,body").animate({
            scrollTop: 0
        }, 500);
    });
</script>

<!-- <script>
    $(document).ready(function() {
        $('#tanggal').change(function() {
            $('#form_tanggal').submit();
        });
    });
</script> -->
<!-- <script>
    $(document).ready(function() {
        $('#tanggal').change(function(event) {
            event.preventDefault();
            var selectedDate = $(this).val(); // Mengambil nilai tanggal dari elemen #tanggal
            var currentDate = new Date().toISOString().slice(0, 10); // Mengambil tanggal saat ini
            if (selectedDate === currentDate) {
                window.location.href = $('#form_tanggal').attr('action');
            } else {
                $('#form_tanggal').submit();
            }
        });
    });
</script> -->
<script>
    $(document).ready(function() {
        $('#samden').change(function() {
            $('#form_samden').submit();
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#tahun').change(function() {
            $('#form_tahun').submit();
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#tanggal').change(function() {
            $('#form_tanggal').submit();
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#bulan').change(function() {
            $('#form_bulan').submit();
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#id_produk').change(function() {
            $('#form_produk').submit();
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#id_pelanggan').change(function() {
            $('#form_pelanggan').submit();
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#driver').change(function() {
            $('#form_driver').submit();
        });
    });
</script>
<!-- <script>
    $(document).ready(function() {
        $('#bulan').change(function() {
            var selectedDate = $('#bulan').val();
            var currentDate = new Date();
            var currentMonth = currentDate.getMonth() + 1; // Ingat, bulan dimulai dari 0
            var currentYear = currentDate.getFullYear();
            var currentDateString = currentYear + '-' + (currentMonth < 10 ? '0' + currentMonth : currentMonth);

            // Perbarui action formulir sesuai dengan bulan yang dipilih
            $('#form_bulan').attr('action');

            // Jika bulan yang dipilih adalah bulan saat ini, langsung arahkan ke halaman yang diinginkan
            if (selectedDate === currentDateString) {
                window.location.href = $('#form_bulan').attr('action');
            } else {
                // Jika bulan yang dipilih bukan bulan saat ini, kirimkan formulir
                $('#form_bulan').submit();
            }
        });
    });
</script> -->

<!-- <script>
    $('.btn-danger').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        Swal.fire({
            title: 'Yakin mau Di Hapus?',
            text: 'Jika yakin tekan Hapus',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href;
            }
        })
    })

    $("#btn-up").click(function() {
        $("html,body").animate({
            scrollTop: 0
        }, 500);
    });
</script> -->
<script>
    $('#belum').on('click', function() {
        $('#tanya').show();
    })
    $('#ambilSaldo').on('click', function() {
        $('#tampilTanggal').show();
    })

    $('#tombol_pilih').on('click', function() {
        $('#tanya').hide();
    })
    $('#tanggalPilih').on('click', function() {
        $('#tampilTanggal').hide();
    })

    $('#cetak').on('click', function() {
        window.print();
    })
</script>

<script>
    window.setTimeout(function() {
        $(".alert").animate({
            left: "0",
            width: "80%" // Menggunakan persentase lebar agar lebih responsif
        }, 5000, function() {
            // Animasi selesai
        }).fadeTo(1000, 0).slideUp(1000, function() {
            $(this).remove();
        });
    }, 1000);
</script>
<script>
    $(document).ready(function() {
        $('.hapus-link').click(function(event) {
            event.preventDefault();
            var deleteUrl = $(this).attr('href');

            Swal.fire({
                title: 'Konfirmasi Penghapusan',
                text: 'Anda yakin ingin menghapus data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect ke halaman penghapusan setelah konfirmasi
                    window.location.href = deleteUrl;
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#searchInput').on('keyup', function() {
            var searchText = this.value.toLowerCase();
            $('#example2 tbody tr').each(function() {
                var rowData = $(this).text().toLowerCase();
                $(this).toggle(rowData.indexOf(searchText) > -1);
            });
        });
    });
</script>

<script>
    $('.tombolHapus').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        Swal.fire({
            title: 'Yakin mau Di Hapus?',
            text: 'Jika yakin tekan Hapus',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href;
            }
        })
    })
</script>
<script>
    function tampilkanKonfirmasi(id_keluar_jadi) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda setuju untuk menerima barang?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Setuju!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url("barang_jadi/barang_keluar/terima_barang/") ?>' + id_keluar_jadi;
            }
        });
    }
</script>

</body>

</html>