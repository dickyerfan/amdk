<button id="btn-up"><i class="fas fa-chevron-circle-up logo"></i></button>
<footer class="py-2 bg-light mt-auto logo">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
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

<script>
    function showUploadWarning(uploadAllowed) {
        if (!uploadAllowed) {
            Swal.fire({
                title: 'Tidak bisa Upload data lagi',
                icon: 'warning',
                confirmButtonText: 'Tutup'
            });
            return false; // Mencegah tautan mengarahkan ke URL
        }
    }
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
    function checkStatus_produksi() {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('barang_produksi/permintaan_barang_baku/cek_status_produksi') ?>',
            dataType: 'json',
            success: function(response) {
                if (response.success === true) {
                    // Ada data dengan status 1, ubah warna ikon dan tampilkan pesan
                    $('#bellIcon').css('color', 'red');
                    $('#permintaanProduksi').show();
                } else {
                    // Tidak ada data dengan status 0, kembalikan warna ikon ke semula dan sembunyikan pesan
                    $('#bellIcon').css('color', '');
                    $('#permintaanProduksi').hide();
                }
            }
        });
    }

    // Memanggil fungsi checkStatus setiap 5 detik

    setInterval(function() {
        checkStatus_produksi(); // Pemanggilan fungsi tampil_data_barang
    }, 5000); // 5000 milidetik (5 detik)
</script>

<script>
    window.setTimeout(function() {
        $(".alert").animate({
            left: "0",
            width: "80%"
        }, 5000, function() {}).fadeTo(1000, 0).slideUp(1000, function() {
            $(this).remove();
        });
    }, 1000);
</script>
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
</body>

</html>