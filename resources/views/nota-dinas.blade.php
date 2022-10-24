@if(Auth::user()->level != 0)
    <script type="text/javascript">
        window.location = "{{ url('/dashboard') }}";//here double curly bracket
    </script>
@endif

@extends('layouts.main', ['title' => 'Nota Dinas'])

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Nota Dinas</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title inline">
                Tabel Nota Dinas Pengajuan Keputusan Kepala BSN
                <button type="button" class="btn btn-sm btn-dark" id="tombol-tambah-data" title="tambah data" data-toggle="modal" data-target="#modal-tambah-nodin">
                    <span class="fa fa-plus"></span>
                </button>
            </h3>
        </div>
        <div class="card-body">
            <table class="table table-sm table-bordered table-hover" id="nodin-dt">
                <thead class="bg-info text-white">
                    <tr>
                        <th>No</th>
                        <th>Nomor Surat</th>
                        <th>Lampiran</th>
                        <th>Jenis</th>
                        <th>Tahap</th>
                        <th>Nomor Kepka</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

    <!-- {{-- Modal Tambah Nota Dinas --}} -->
    <div class="modal fade" id="modal-tambah-nodin">
        <form id="form-tambah-nodin" enctype="multipart/form-data">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Buat Nota Dinas</h4>
                    <button type="button" class="close tutup-modal-tambah" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body body-modal-tambah-nodin">
                    <div class="form-group">
                        <label for="nmr_surat">Nomor Surat</label>
                        <input type="text" class="form-control" id="nmr_surat" name="nmr_surat" placeholder="Masukkan nomor nota dinas...">
                    </div>
                    <div class="form-group">
                        <label for="jenis_nodin">Jenis Nota Dinas</label>
                        <select id="jenis_nodin" class="form-control" name="jenis_nodin">
                            <option value="">-- Pilih Jenis Nota Dinas --</option>
                            <option value="0">pencabutan</option>
                            <option value="1">Transisi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_rapat">Lampiran Nota Dinas</label>
                        <select id="tanggal_rapat" class="form-control" name="tanggal_rapat">
                            <option value="">-- Pilih Tanggal Rapat --</option>
                            {{-- @foreach ($data_rapat as $item)
                                <option value="{{ $item->id }}">{{ $item->tanggal_rapat }}&nbsp;(pencabutan : {{ $item->jumlah_pencabutan }} | Transisi : {{ $item->jumlah_transisi }})</option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="status_nodin" class="form-select" name="status_nodin" hidden>
                            <option value="0" selected></option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger tutup-modal-tambah" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="tambah-data-nodin">Simpan</button>
                </div>
                </div>
                <!-- /.modal-content -->
            </div>
        </form>
        <!-- /.modal-dialog -->
    </div>
    <!-- {{-- End of - Modal Tambah Nota Dinas --}} -->

    {{-- Modal Konfirmasi Hapus Nota Dinas --}}
    <div class="modal fade" id="modal-konfirmasi-hapus-nodin">
        <form id="form-konfirmasi-hapus-nodin">
            <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Hapus Nota Dinas</h4>
                    <button type="button" class="close tutup-modal-konfirmasi-hapus-nodin" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" id="body-konfirmasi-hapus-nodin">
                      
                      
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default tutup-modal-konfirmasi-hapus-nodin" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger tombol-hapus-nodin">Hapus</button>
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
        </form>
        <!-- /.modal-dialog -->
    </div>
    {{-- End of - Modal Konfirmasi Hapus Nota Dinas --}}

    {{-- Modal Lihat Status Progres Tahapan Nota Dinas --}}
    <div class="modal fade" id="modal-tahap-nodin">
        <form id="form-tahap-nodin">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title judul-modal"></h4>
                    <button type="button" class="close tutup-modal-tahap-nodin" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" id="body-tahap-nodin">
                      <input type="hidden" name="id_nodin" id="id-nodin">
                      <table class="table table-sm table-bordered">
                        <thead>
                            <th>No</th>
                            <th>Cek</th>
                            <th>Tahapan</th>
                            <th>Tanggal</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input type="checkbox" id="tahap-1" class="form-check-input" disabled="disabled">
                                    </div>
                                </td>
                                <td id="ket-tahap-1">Nodin penyampaian draft KEPKA ke Bagian Hukum SDMOH</td>
                                <td><p id="tanggal-tahap-1" class="hapus-tanggal"></p></td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input type="checkbox" id="tahap-2" class="form-check-input" value="1" disabled="disabled">
                                    </div>
                                </td>
                                <td id="ket-tahap-2">Draft KEPKA dari Bagian Hukum ke Subkoordinator</td>
                                <td><p id="tanggal-tahap-2" class="hapus-tanggal"></p></td>
                            </tr>
                            <tr>
                                <td class="text-center">3</td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input type="checkbox" id="tahap-3" class="form-check-input" value="2" disabled="disabled">
                                    </div>
                                </td>
                                <td id="ket-tahap-3">Subkoordinator cek draft, diteruskan ke Koordinator utk paraf persetujuan Pengusul</td>
                                <td><p id="tanggal-tahap-3" class="hapus-tanggal"></p></td>
                            </tr>
                            <tr>
                                <td class="text-center">4</td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input type="checkbox" id="tahap-4" class="form-check-input" value="3" disabled="disabled">
                                    </div>
                                </td>
                                <td id="ket-tahap-4">Dari Koordinator, dilanjutkan ke Direktur untuk paraf persetujuan</td>
                                <td><p id="tanggal-tahap-4" class="hapus-tanggal"></p></td>
                            </tr>
                            <tr>
                                <td class="text-center">5</td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input type="checkbox" id="tahap-5" class="form-check-input" value="4" disabled="disabled">
                                    </div>
                                </td>
                                <td id="ket-tahap-5">Dari Direktur, dilanjutkan ke Deputi untuk paraf persetujuan</td>
                                <td><p id="tanggal-tahap-5" class="hapus-tanggal"></p></td>
                            </tr>
                            <tr>
                                <td class="text-center">6</td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input type="checkbox" id="tahap-6" class="form-check-input" value="5" disabled="disabled">
                                    </div>
                                </td>
                                <td id="ket-tahap-6">Dari Deputi, dikembalikan ke Subkoordinator, kemudian disampaikan ke Bagian Hukum SDMOH</td>
                                <td><p id="tanggal-tahap-6" class="hapus-tanggal"></p></td>
                            </tr>
                            <tr>
                                <td class="text-center">7</td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input type="checkbox" id="tahap-7" class="form-check-input" value="6" disabled="disabled">
                                    </div>
                                </td>
                                <td id="ket-tahap-7">Bagian Hukum SDMOH terbitkan KEPKA dengan tanda tangan Kepala BSN</td>
                                <td><p id="tanggal-tahap-7" class="hapus-tanggal"></p></td>
                            </tr>
                        </tbody>
                      </table>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger tutup-modal-tahap-nodin" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="update-tahap-nodin">Simpan</button>
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
        </form>
        <!-- /.modal-dialog -->
    </div>
    {{-- End of - Modal Lihat Status Progres Tahapan Nota Dinas --}}
@endsection

@push('css')
    
@endpush

@push('js')
    <script>
        $(document).ready(function() {

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-right',
                iconColor: 'white',
                customClass: {
                    popup: 'colored-toast'
                },
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });

            nodin_dt();

            function nodin_dt() {
                $('#nodin-dt').DataTable({
                    language: {
                        url: "/json/id.json"
                    },
                    serverside: true,
                    ajax: {
                        url: "/nota-dinas",
                        type: "GET",
                    },
                    columns: [
                        {
                            data : 'DT_RowIndex',
                            name : 'DT_RowIndex',
                            orderable : false,
                            searchable : false,
                        },
                        {
                            data : 'nmr_surat',
                            name : 'nmr_surat',
                            render : function(data, type, row, meta) {
                                return '<a href="javascript:void(0)" id="'+ row.id +'" class="lihat-detail-nodin">'+ row.nmr_surat +'</a>';
                            }
                        },
                        {
                            data : 'tanggal_rapat',
                            name : 'tanggal_rapat',
                        },
                        {
                            data : 'jenis_nodin',
                            name : 'jenis_nodin',
                            render :
                                function(data, type, row) {
                                    if(row.jenis_nodin == 0) {
                                        return row.jenis_nodin = '<span class="badge badge-secondary">pencabutan</span>';
                                    }
                                    else {
                                        return row.jenis_nodin = '<span class="badge badge-primary">Transisi</span>';
                                    }
                                }
                        },
                        {
                            data : 'status_nodin_update',
                            name : 'status_nodin_update',
                            render :
                                function(data, type, row) {
                                    if(row.status_nodin_update == 0) {
                                        return row.status_nodin_update = 'tahap 1';
                                    }
                                    else if(row.status_nodin_update == 1) {
                                        return row.status_nodin_update = 'tahap 2';
                                    }
                                    else if(row.status_nodin_update == 2) {
                                        return row.status_nodin_update = 'tahap 3';
                                    }
                                    else if(row.status_nodin_update == 3) {
                                        return row.status_nodin_update = 'tahap 4';
                                    }
                                    else if(row.status_nodin_update == 4) {
                                        return row.status_nodin_update = 'tahap 5';
                                    }
                                    else if(row.status_nodin_update == 5) {
                                        return row.status_nodin_update = 'tahap 6';
                                    }
                                    else {
                                        return row.status_nodin_update = 'tahap 7';
                                    }
                                }
                        },
                        {
                            data : 'nmr_kepka',
                            name : 'nmr_kepka',
                        },
                        {
                            data : 'created_at',
                            name : 'created_at',
                            render: function ( data, type, row ) {
                                return data.substr(0, 10);
                            }
                        },
                        {
                            data : 'aksi',
                            name : 'aksi',
                            orderable : false,
                            searchable : false,
                        },
                    ],
                    columnDefs: [
                        { 
                            targets: 1,
                            width: "20%",
                        },
                        { 
                            targets: 2,
                            width: "10%",
                        },
                        { 
                            targets: 3,
                            width: "10%",
                        },
                        { 
                            targets: 5,
                            width: "15%",
                        },
                    ],
                    order : [[5, 'desc']],
                });
            }

            $('#jenis_nodin').on('change',function() {
                $('.pilihan-tanggal-rapat').remove();
                $('#data-sni-lama').remove();
                $.ajax({
                    type: "GET",
                    url: "/nota-dinas/data-pilihan-tanggal-rapat",
                    dataType: "JSON",
                    success: function(response) {
                        $.each(response.pilihan, function (key, item) { 
                             $('#tanggal_rapat').append(
                                '<option class="pilihan-tanggal-rapat" value="'+item.id+'">'+item.tanggal_rapat+' (pencabutan : '+item.jumlah_pencabutan+' | Transisi : '+item.jumlah_transisi+')</option>'
                             );
                        });
                    }
                });
            });

            $('#tanggal_rapat').on('change',function() { 
                var id_rapat = $('select[name=tanggal_rapat] option:selected').val();
                
                if(id_rapat != '' && $('#jenis_nodin').val() != '') {
                    if($('#jenis_nodin').val() == 0) {
                        $.ajax({
                            type: "GET",
                            url: "/nota-dinas/data-pencabutan/"+id_rapat,
                            dataType: "JSON",
                            success: function(response) {
                                if(response.data.length == 0) {
                                    Toast.fire({
                                        icon : "warning",
                                        title: "Tidak ada data SNI transisi yang dapat ditampilkan.",
                                    });
                                }
                                else {
                                    $('.body-modal-tambah-nodin').append(
                                        '<table id="data-sni-lama" class="mb-3 table table-sm table-bordered">\
                                            <thead>\
                                                <tr>\
                                                    <th class="text-center">No</th>\
                                                    <th class="text-center">Nomor SNI Lama</th>\
                                                    <th class="text-center w-50">Judul SNI Lama</th>\
                                                    <th class="text-center">Status Pembahasan</th>\
                                                </tr>\
                                            </thead>\
                                            <tbody id="tabel-sni-pencabutan">\
                                            </tbody>\
                                        </table>'
                                    );
                                    $.each(response.data, function (key, item) { 
                                        $('#tabel-sni-pencabutan').append(
                                            '<tr>\
                                                <td>'+(key+1)+'</td>\
                                                <td>'+item.nmr_sni_lama+'</td>\
                                                <td>'+item.jdl_sni_lama+'</td>\
                                                <td>pencabutan</td>\
                                            </tr>'
                                        );
                                    });
                                }
                            }
                        });
                    }
                    else if($('#jenis_nodin').val() == 1) {
                        $.ajax({
                            type: "GET",
                            url: "/nota-dinas/data-transisi/"+id_rapat,
                            dataType: "JSON",
                            success: function (response) {
                                if(response.data.length == 0) {
                                    Toast.fire({
                                        icon : "warning",
                                        title: "Tidak ada data SNI transisi yang dapat ditampilkan.",
                                    });
                                }
                                else {
                                    $('.body-modal-tambah-nodin').append(
                                        '<table id="data-sni-lama" class="mb-3 table table-sm table-bordered">\
                                            <thead>\
                                                <tr>\
                                                    <th class="text-center">No</th>\
                                                    <th class="text-center">Nomor SNI Lama</th>\
                                                    <th class="text-center w-50">Judul SNI Lama</th>\
                                                    <th class="text-center">Status Pembahasan</th>\
                                                </tr>\
                                            </thead>\
                                            <tbody id="tabel-sni-pencabutan">\
                                            </tbody>\
                                        </table>'
                                    );
                                    $.each(response.data, function (key, item) { 
                                        $('#tabel-sni-pencabutan').append(
                                            '<tr>\
                                                <td>'+(key+1)+'</td>\
                                                <td>'+item.nmr_sni_lama+'</td>\
                                                <td>'+item.jdl_sni_lama+'</td>\
                                                <td>Transisi</td>\
                                            </tr>'
                                        );
                                    });
                                }
                            }
                        });
                    }
                }
                else if($('#jenis_nodin').val() == '') {
                    Toast.fire({
                        icon : "warning",
                        title: "Pilih jenis nota dinas terlebih dahulu.",
                    });

                    $('#tanggal_rapat').prop('selectedIndex',0);
                }
                else {
                    $('#data-sni-lama').remove();
                }
            });

            /**********************************************/
            /*********** Tambah Data Nota Dinas ***********/
            /**********************************************/
            $('#tambah-data-nodin').click(function() {
                $('#form-tambah-nodin').validate({
                    rules: {
                        nmr_surat: {
                            required: true,
                        },
                        jenis_nodin: {
                            required: true,
                        },
                        tanggal_rapat: {
                            required: true,
                        },
                    },
                    messages: {
                        nmr_surat: {
                            required: "Masukkan nomor nota dinas pengajuan draft kepka.",
                        },
                        jenis_nodin: {
                            required: "Pilih jenis nota dinas.",
                        },
                        tanggal_rapat: {
                            required: "Pilih tanggal rapat sebagai lampiran nodin.",
                        },
                    },
                    errorElement: 'span',
                        errorPlacement: function (error, element) {
                            error.addClass('invalid-feedback');
                            element.closest('.form-group').append(error);
                        },
                        highlight: function (element, errorClass, validClass) {
                            $(element).addClass('is-invalid');
                        },
                        unhighlight: function (element, errorClass, validClass) {
                            $(element).removeClass('is-invalid');
                        },
                        submitHandler: function(form) {

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $('#tambah-data-nodin').html('<i class="spinner-border spinner-border-sm text-light" role="status"></i> Menyimpan...');
                            $('#tambah-data-nodin').attr('disabled', true);

                            $.ajax({
                                type        : "POST",
                                dataType    : "JSON",
                                url         : "/nota-dinas/tambah-data-nodin",
                                contentType : false,
                                processData : false,
                                cache       : false,
                                data        : new FormData($(form)[0]),
                                success: function(response) {
                                    Toast.fire({
                                        icon : "success",
                                        title: "Data nota dinas telah tersimpan.",
                                    });                     
                                },
                                error: function(response) {
                                    Toast.fire({
                                        icon : "error",
                                        title: "Gagal upload data.",
                                    });
                                },
                                complete: function(response) {
                                    $('#modal-tambah-nodin').modal('hide');
                                    $('#form-tambah-nodin').find('input').val('');
                                    $('#jenis_nodin').prop('selectedIndex',0);
                                    $('#tanggal_rapat').prop('selectedIndex',0);
                                    $('.pilihan-tanggal-rapat').remove();
                                    $('#data-sni-lama').remove();
                                    $('#tambah-data-nodin').html('');
                                    $('#tambah-data-nodin').text('Simpan');
                                    $('#tambah-data-nodin').attr('disabled', false);
                                    $('#nodin-dt').DataTable().ajax.reload();
                                }
                            });
                        }
                });
            });

            /**********************************************/
            /************* Hapus Nota Dinas ***************/
            /**********************************************/
            $('#nodin-dt').on('click','.hapus',function() {
                if($(this).hasClass('disabled')) {
                    Toast.fire({
                        icon : "warning",
                        title: "Tidak dapat dihapus, rapat pembahasan sudah terlaksana.",
                    });
                }
                else {
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    var id_konfirmasi_hapus_nodin = $(this).attr('id');

                    $.ajax({
                        type: "GET",
                        url: "/nota-dinas/konfirmasi-hapus-nota-dinas/"+id_konfirmasi_hapus_nodin,
                        success: function(response) {
                            $('#body-konfirmasi-hapus-nodin').append(
                                '<input type="hidden" id="id_hapus_nodin">\
                                <h6>Apakah anda yakin menghapus nota dinas <strong>'+ response.data.nmr_surat +'</strong> ?</h6>'
                            );

                            $('#id_hapus_nodin').val(response.data.id);
                        }
                    });

                    $('#modal-konfirmasi-hapus-nodin').modal('show');

                    $('.tombol-hapus-nodin').on('click', function(e) {

                        e.preventDefault();
                    
                        var id_hapus_nodin = $('#id_hapus_nodin').val();

                        $(this).html('<i class="spinner-border spinner-border-sm text-light" role="status"></i> Menghapus...');
                        $(this).attr('disabled', true);

                        $.ajax({
                            type: "DELETE",
                            url: "/nota-dinas/hapus-nota-dinas/"+id_hapus_nodin,
                            success: function(response) {
                                Toast.fire({
                                    icon : "success",
                                    title: "Berhasil hapus data nota dinas pengajuan KEPKA.",
                                });
                                $('#modal-konfirmasi-hapus-nodin').modal('hide');
                                $('#body-konfirmasi-hapus-nodin').html('');
                                $('.tombol-hapus-nodin').html('');
                                $('.tombol-hapus-nodin').text('Hapus');
                                $('.tombol-hapus-nodin').attr('disabled', false);
                                $('#nodin-dt').DataTable().ajax.reload();
                            }
                        });
                    });
                }
            });

            $('.tutup-modal-konfirmasi-hapus-nodin').on('click', function() {
                $('#body-konfirmasi-hapus-nodin').html('');
            });

            /**********************************************/
            /************ Lihat Detail Nodin **************/
            /**********************************************/
            $('body').off('click').on('click', '.lihat-detail-nodin', function() {
                var id_nodin = $(this).attr('id');

                $.ajax({
                    type: "GET",
                    url: "/nota-dinas/modal-update-tahap-nota-dinas/"+id_nodin,
                    dataType: "JSON",
                    success: function(response) {
                        $('.judul-modal').text('Tahapan Nota Dinas : '+response.judul_modal.nmr_surat);
                        $('#id-nodin').val(response.judul_modal.id);

                        $.each(response.tahap_nodin, function(key, item) { 
                            if(item.status_nodin == 0) {
                                $('#tahap-1').attr('checked', true);
                                $('#ket-tahap-1').addClass('text-success');
                                $('#tanggal-tahap-1').html(item.created_at).addClass('text-success');
                                $('#tahap-2').attr('disabled', false);
                                $('#tahap-2').attr('name', 'centang');
                            }
                            else if(item.status_nodin == 1) {
                                $('#tahap-2').removeAttr('name');
                                $('#tahap-2').attr('disabled', true);
                                $('#tahap-2').attr('checked', true);
                                $('#ket-tahap-2').addClass('text-success');
                                $('#tanggal-tahap-2').html(item.created_at).addClass('text-success');
                                $('#tahap-3').attr('disabled', false);
                                $('#tahap-3').attr('name', 'centang');
                            }
                            else if(item.status_nodin == 2) {
                                $('#tahap-3').removeAttr('name');
                                $('#tahap-3').attr('disabled', true);
                                $('#tahap-3').attr('checked', true);
                                $('#ket-tahap-3').addClass('text-success');
                                $('#tanggal-tahap-3').html(item.created_at).addClass('text-success');
                                $('#tahap-4').attr('disabled', false);
                                $('#tahap-4').attr('name', 'centang');
                            }
                            else if(item.status_nodin == 3) {
                                $('#tahap-4').removeAttr('name');
                                $('#tahap-4').attr('disabled', true);
                                $('#tahap-4').attr('checked', true);
                                $('#ket-tahap-4').addClass('text-success');
                                $('#tanggal-tahap-4').html(item.created_at).addClass('text-success');
                                $('#tahap-5').attr('disabled', false);
                                $('#tahap-5').attr('name', 'centang');
                            }
                            else if(item.status_nodin == 4) {
                                $('#tahap-5').removeAttr('name');
                                $('#tahap-5').attr('disabled', true);
                                $('#tahap-5').attr('checked', true);
                                $('#ket-tahap-5').addClass('text-success');
                                $('#tanggal-tahap-5').html(item.created_at).addClass('text-success');
                                $('#tahap-6').attr('disabled', false);
                                $('#tahap-6').attr('name', 'centang');
                            }
                            else if(item.status_nodin == 5) {
                                $('#tahap-6').removeAttr('name');
                                $('#tahap-6').attr('disabled', true);
                                $('#tahap-6').attr('checked', true);
                                $('#ket-tahap-6').addClass('text-success');
                                $('#tanggal-tahap-6').html(item.created_at).addClass('text-success');
                                $('#tahap-7').attr('disabled', false);
                                $('#tahap-7').attr('name', 'centang');
                                $('#body-tahap-nodin').append(
                                    '<div id="nmr_kepka" class="form-group">\
                                        <label for="nmr_kepka">Nomor KEPKA</label>\
                                        <input type="text" class="form-control" name="nmr_kepka" placeholder="Masukkan nomor KEPKA...">\
                                    </div>'
                                );
                            }
                            else {
                                $('#tahap-7').removeAttr('name');
                                $('#tahap-7').attr('disabled', true);
                                $('#tahap-7').attr('checked', true);
                                $('#ket-tahap-7').addClass('text-success');
                                $('#tanggal-tahap-7').html(item.created_at).addClass('text-success');
                                $('#update-tahap-nodin').attr('disabled', true);
                                $('#nmr_kepka').remove();
                            }
                        });
                    }
                });

                $('#modal-tahap-nodin').modal('show');
            });

            $('.tutup-modal-tahap-nodin').click(function(){
                $('form input:checkbox').removeAttr('name');
                $('form input:checkbox').attr('disabled', true);
                $('form input:checkbox').attr('checked', false);
                $('table td').removeClass('text-success');
                $('.hapus-tanggal').html('').removeClass('text-success');
                $('#update-tahap-nodin').attr('disabled', false);
                $('#nmr_kepka').remove();
                $('.error').remove();
            });

            /**********************************************/
            /********* Simpan Update Tahap Nodin **********/
            /**********************************************/
            $('#update-tahap-nodin').click(function() {
                $('#form-tahap-nodin').validate({
                    rules: {
                        centang: {
                            required: true,
                        },
                        nmr_kepka: {
                            required: true,
                        },
                    },
                    messages: {
                        centang: {
                            required: "Beri tanda centang pada checkbox yang tersedia.<br/>",
                        },
                        nmr_kepka: {
                            required: "Nomor KEPKA wajib diisi.",
                        },
                    },
                    errorElement: 'span',
                        errorPlacement: function (error, element) {
                            error.addClass('invalid-feedback');
                            element.closest('#body-tahap-nodin').append(error);
                        },
                        highlight: function (element, errorClass, validClass) {
                            $(element).addClass('is-invalid');
                        },
                        unhighlight: function (element, errorClass, validClass) {
                            $(element).removeClass('is-invalid');
                        },
                        submitHandler: function(form) {

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            var id_nodin_update = $('#id-nodin').val();

                            $('#update-tahap-nodin').html('<i class="spinner-border spinner-border-sm text-light" role="status"></i> Menyimpan...');
                            $('#update-tahap-nodin').attr('disabled', true);

                            $.ajax({
                                type        : "POST",
                                dataType    : "JSON",
                                url         : "/nota-dinas/update-tahap-nota-dinas/"+id_nodin_update,
                                contentType : false,
                                processData : false,
                                cache       : false,
                                data        : new FormData($(form)[0]),
                                success: function(response) {
                                    Toast.fire({
                                        icon : "success",
                                        title: "Tahapan nota dinas telah diperbaharui.",
                                    });                     
                                },
                                error: function(response) {
                                    Toast.fire({
                                        icon : "error",
                                        title: "Gagal upload data.",
                                    });
                                },
                                complete: function(response) {
                                    $('#modal-tahap-nodin').modal('hide');
                                    $('#update-tahap-nodin').html('');
                                    $('#update-tahap-nodin').text('Simpan');
                                    $('#update-tahap-nodin').attr('disabled', false);
                                    $('form input:checkbox').removeAttr('name');
                                    $('form input:checkbox').attr('disabled', true);
                                    $('form input:checkbox').attr('checked', false);
                                    $('table td').removeClass('text-success');
                                    $('#nmr_kepka').remove();
                                    $('#nodin-dt').DataTable().ajax.reload();
                                }
                            });
                        }
                });
            });

            $('.tutup-modal-tambah').click(function() {
                $('#jenis_nodin').prop('selectedIndex',0);
                $('#tanggal_rapat').prop('selectedIndex',0);
                $('#data-sni-lama').remove();
            });
        });
    </script>
@endpush