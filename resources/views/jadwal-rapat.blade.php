@if(Auth::user()->level != 0)
    <script type="text/javascript">
        window.location = "{{ url('/dashboard') }}";//here double curly bracket
    </script>
@endif

@extends('layouts.main', ['title' => 'Jadwal Rapat'])

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Penjadwalan Rapat</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
@endsection

@section('content')
    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tabel Jadwal Rapat Masa Transisi SNI</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover" id="jadwal-rapat-dt">
                <thead class="bg-success text-white">
                    <tr>
                        <th>Tanggal Rapat</th>
                        <th>PIC Rapat</th>
                        <th>Jumlah SNI Lama</th>
                        <th>Tanggal Dibuat</th>
                        <th>Status Pembahasan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulir Pembuatan Jadwal Rapat Masa Transisi SNI</h3>
        </div>
        <div class="card-body">
            <form id="form-jadwal-rapat" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-label">PIC Rapat</label>
                    <select id="pic_rapat" class="form-control" name="pic_rapat">
                        @foreach ($data_pic as $pic)
                            <option value="{{ $pic->name }}">{{ $pic->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="tanggal_rapat">Tanggal Rapat</label>
                    <input type="text" class="form-control tanggal_rapat" id="tanggal_rapat" name="tanggal_rapat" placeholder="Masukkan tanggal rapat..." readonly>
                </div>
                <div class="form-group">
                    <label class="inline" for="daftar_sni_lama">Daftar SNI Lama</label>
                    <button type="button" class="btn btn-sm btn-dark" id="tombol-tambah-sni-lama" title="tambah sni lama" data-toggle="modal" data-target="#modal-tambah-sni-lama">
                        <span class="fa fa-plus"></span>
                    </button>
                </div>
                <div class="form-group">
                    <select id="status_pembahasan" class="form-select" name="status_pembahasan" hidden>
                        <option value="0" selected></option>
                    </select>
                </div>
                <div class="form-group">
                    <select id="status_nodin" class="form-select" name="status_nodin" hidden>
                        <option value="0" selected></option>
                    </select>
                </div>
                <table class="mb-3 table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nomor SNI Lama</th>
                            <th class="text-center">Judul SNI Lama</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody id="tabel-sni-lama">
                        <input type="hidden" id="counter" value="0">

                    </tbody>
                </table>
                <div class="form-group mb-3">
                    <button id="tombol-buat-jadwal" type="submit" class="btn btn-primary col-sm-2">Buat Jadwal</button>
                </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    {{-- Modal Konfirmasi Hapus Jadwal Rapat --}}
    <div class="modal fade" id="modal-konfirmasi-hapus-jadwal-rapat">
        <form id="form-konfirmasi-hapus-jadwal-rapat">
            <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Hapus Jadwal Rapat Masa Transisi SNI</h4>
                    <button type="button" class="close tutup-modal-konfirmasi-hapus-jadwal-rapat" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" id="body-konfirmasi-hapus-jadwal-rapat">
                      
                      
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default tutup-modal-konfirmasi-hapus-jadwal-rapat" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger tombol-hapus-jadwal-rapat">Hapus</button>
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
        </form>
        <!-- /.modal-dialog -->
    </div>
    {{-- End of - Modal Konfirmasi Hapus Jadwal Rapat --}}

    {{-- Modal SNI Lama, Komtek, Penerap --}}
    <div class="modal fade" data-backdrop="static" id="modal-sni-lama">
        <form id="form-sni-lama">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data SNI Lama, Komtek, dan Penerap</h4>
                        <button type="button" class="close" id="tutup-modal-sni-lama" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table-xl table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:15%">Nomor SNI Lama</th>
                                    <th class="text-center" style="width:45%">Judul SNI Lama</th>
                                    <th class="text-center" style="width:20%">Komtek</th>
                                    <th class="text-center" style="width:10%">Jumlah Penerap</th>
                                    <th class="text-center" style="width:10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-modal-sni-lama">

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </form>
    </div>
    {{-- End of - Modal SNI Lama, Komtek, Penerap --}}


    {{-- Modal Lihat Penerap --}}
    <div class="modal fade" data-backdrop="static" id="modal-lihat-penerap">
        <form id="form-penerap">
            <div class="modal-lg modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Penerap</h4>
                        <button type="button" class="close" id="tutup-modal-lihat-penerap" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="body-lihat-penerap" class="modal-body">

                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </form>
    </div>
    {{-- End of - Modal SNI Lama, Komtek, Penerap --}}


    <!-- {{-- Modal Lihat Detail Jadwal Rapat --}} -->
    <div class="modal fade" id="modal-lihat-detail-jadwal-rapat">
        <form id="form-lihat-detail-jadwal-rapat" enctype="multipart/form-data">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title inline">
                            Data Detail Jadwal Rapat Masa Transisi SNI
                            <button type="button" class="btn btn-sm btn-success" id="tombol-unduh-excel" title="unduh tabel">
                                <span class="fas fa-file-excel"></span>
                            </button>
                        </h4>
                        <button type="button" class="close tutup-modal-lihat-detail-jadwal-rapat" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <input type="hidden" id="id_detail">
                        </div>

                        <table class="mb-3">
                            <tr class="form-group">
                                <th class="col-sm-3">PIC</th>
                                <td>:</td>
                                <td class="col-sm-9 reset-value" id="pic_detail"></td>
                            </tr>
                            <tr class="form-group">
                                <th class="col-sm-3">Tanggal Rapat</th>
                                <td>:</td>
                                <td class="col-sm-9 reset-value"  id="tanggal_rapat_detail"></td>
                            </tr>
                            <tr class="form-group">
                                <th class="col-sm-3">Jumlah SNI Lama</th>
                                <td>:</td>
                                <td class="col-sm-9 reset-value" id="jumlah_sni_lama_detail"></td>
                            </tr>
                        </table>
                        <table class="mb-3 table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">SNI Baru</th>
                                    <th class="text-center">SNI Lama</th>
                                    <th class="text-center">Komite Teknis</th>
                                    <th class="text-center">Sekretariat Komtek</th>
                                    <th class="text-center">Penerap</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-sni-lama-detail">

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger tutup-modal-lihat-detail-jadwal-rapat" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
        </form>
        <!-- /.modal-dialog -->
    </div>
    <!-- {{-- End of - Modal Lihat Detail Jadwal Rapat --}} -->
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

            $(".tanggal_rapat").datepicker({
                todayBtn   :'linked',
                changeYear : true,
                yearRange  : '+0:+1',
                dateFormat : 'yy-mm-dd',
                orientation: 'top auto',
                autoclose  : true,
                minDate: '0',
            });

            jadwal_rapat_dt();

            function jadwal_rapat_dt() {
                $('#jadwal-rapat-dt').DataTable({
                    language: {
                        url: "/json/id.json"
                    },
                    serverside: true,
                    ajax: {
                        url: "/jadwal-rapat",
                        type: "GET",
                    },
                    columns: [
                        {
                            data : 'tanggal_rapat',
                            name : 'tanggal_rapat',
                            render : function(data, type, row, meta) {
                                return '<a href="javascript:void(0)" id="'+ row.id +'" class="lihat-detail-jadwal-rapat">'+ row.tanggal_rapat +'</a>';
                            }
                        },
                        {
                            data : 'pic_rapat',
                            name : 'pic_rapat',
                        },
                        {
                            data : 'jumlah_sni_lama',
                            name : 'jumlah_sni_lama',
                        },
                        {
                            data : 'created_at',
                            name : 'created_at',
                        },
                        {
                            data : 'status_pembahasan',
                            name : 'status_pembahasan',
                            orderable : false,
                            searchable : false,
                            render :
                                function(data, type, row) {
                                    if(row.status_pembahasan == 0) {
                                        return row.status_pembahasan = '<span class="badge badge-warning">Belum dibahas</span>';
                                    }
                                    else {
                                        return row.status_pembahasan = '<span class="badge badge-success">Sudah dibahas</span>';
                                    }
                                }
                        },
                        {
                            data : 'aksi',
                            name : 'aksi',
                            orderable : false,
                            searchable : false,
                        },
                    ],
                    // columnDefs: [
                    //     { 
                    //         targets: 2,
                    //         width: "25%",
                    //     },
                    //     { 
                    //         targets: 1,
                    //         width: "13%",
                    //     },
                    // ],
                    order : [[0, 'desc']],
                });
            }

            $('#tombol-tambah-sni-lama').on('click', function() {
                $('#modal-sni-lama').modal('show');

                $.ajax({
                    type: "GET",
                    url: "/jadwal-rapat/data-sni-lama",
                    dataType: "JSON",
                    success: function (response) {
                        $.each(response.data_sni_lama, function (key, item) { 
                            $('#tabel-modal-sni-lama').append(
                                '<tr class="record">\
                                    <td style="width:20%">'+ item.nmr_sni_lama +'</td>\
                                    <td style="width:30%">'+ item.jdl_sni_lama +'</td>\
                                    <td style="width:25%">'+ item.komtek +'</td>\
                                    <td class="text-center" style="width:25%"><a href="javascript:void(0)" class="lihat-penerap" id="'+item.id+'">'+ item.jumlah_penerap +'</a></td>\
                                    <td>\
                                        <button type="button" value="'+item.id+'" class="btn btn-default tambah" title="Tambah data-sni-lama">\
                                            <i class="fas fa-plus"></i>\
                                        </button>\
                                    </td>\
                                </tr>'
                            );
                        });
                    }
                });


                //******************* Lihat Penerap **********************//
                $('#modal-sni-lama').on('click','.lihat-penerap',function() {
                    $('#modal-lihat-penerap').modal('show');

                    var id = $(this).attr('id');

                    $.ajax({
                        type: "GET",
                        url: "/jadwal-rapat/data-penerap/"+id,
                        dataType: "JSON",
                        success: function (response) {
                            $.each(response.data_penerap, function (key, item) {
                                $('#body-lihat-penerap').append('<p>'+item.penerap+'</p>');
                            });
                        }
                    })
                });

                $('#tutup-modal-lihat-penerap').click(function() {
                    $('#body-lihat-penerap').html('');
                });
            });

            $('#tutup-modal-sni-lama').on('click', function() {
                $('#tabel-modal-sni-lama').html('');
            });

            $('#modal-sni-lama').off('click').on('click', '.tambah', function() {
                $(this).closest('.record').remove();
                var id_sni_lama = $(this).val();
                var counter = parseInt($('#counter').val());

                $('.tambah').html('<i class="spinner-border spinner-border-sm text-dark" role="status"></i>');
                $('.tambah').attr('disabled', true);

                Toast.fire({
                    icon : "info",
                    title: "Mohon menunggu.",
                });
                
                $.ajax({
                    type : "GET",
                    url : "/jadwal-rapat/tambah-sni-lama/"+id_sni_lama,
                    success : function(response) {
                        $('#tabel-sni-lama').append(
                            '<tr class="record">\
                                <input type="hidden" name="id_sk_revisi['+counter+']" value="'+ response.tambah_sni_lama.id +'">\
                                <td style="width:5%" class="text-center">'+(counter+1)+'</td>\
                                <td style="width:20%"><input name="nmr_sni_lama['+counter+']" class="form-control" value="'+ response.tambah_sni_lama.nmr_sni_lama +'" readonly></td>\
                                <td><textarea name="jdl_sni_lama['+counter+']" class="form-control" readonly>'+response.tambah_sni_lama.jdl_sni_lama+'</textarea></td>\
                                <td style="width:5%"><button type="button" class="hapus-sni-lama btn-sm btn-default form-control" title="hapus sni lama"><span class="fas fa-minus"></span></button></td>\
                            </tr>' 
                        );
                        $('#counter').val( counter + 1 );

                        $(document).on('click','.hapus-sni-lama', function() {
                            $(this).closest('.record').remove();
                        });

                        $('.tambah').html('<i class="fas fa-plus"></i>');
                        $('.tambah').attr('disabled', false);
                    }
                });
            });

            
            /**********************************************/
            /************ Simpan Jadwal Rapat *************/
            /**********************************************/
            $('#tombol-buat-jadwal').click(function(e) {

                if($('#tabel-sni-lama tr').length == 0) {
                    e.preventDefault();
                    Toast.fire({
                        icon : "warning",
                        title: "Daftar SNI lama tidak boleh kosong.",
                    });
                }
                else if($('#tanggal_rapat').val() == 0) {
                    e.preventDefault();
                    Toast.fire({
                        icon : "warning",
                        title: "Tanggal rapat tidak boleh kosong.",
                    });
                }
                else {
                    $('#form-jadwal-rapat').validate({
                        rules: {
                            // agenda_rapat: {
                            //     required: true,
                            // },
                        },
                        messages: {
                            // agenda_rapat: {
                            //     required: "Agenda rapat tidak boleh kosong.",
                            // },
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

                            $('#tombol-buat-jadwal').html('<i class="spinner-border spinner-border-sm text-light" role="status"></i> Menyimpan...');
                            $('#tombol-buat-jadwal').attr('disabled', true);

                            $.ajax({
                                type        : "POST",
                                dataType    : "JSON",
                                url         : "/jadwal-rapat/simpan-jadwal-rapat",
                                contentType : false,
                                processData : false,
                                cache       : false,
                                data        : new FormData($(form)[0]),
                                success: function(response) {
                                    Toast.fire({
                                        icon : "success",
                                        title: "Rapat Masa Transisi SNI telah terjadwalkan.",
                                    });                     
                                },
                                error: function(response) {
                                    Toast.fire({
                                        icon : "error",
                                        title: "Gagal menyimpan jadwal rapat.",
                                    });
                                },
                                complete: function(response) {
                                    $('#form-jadwal-rapat').find('textarea').val('');
                                    $('#form-jadwal-rapat').find('input').val('');
                                    $('#pic_rapat').prop('selectedIndex',0);
                                    $('#tabel-sni-lama tr').remove();
                                    $('.record-penerap').html('');
                                    $('#counter').val(0);
                                    $('#tombol-buat-jadwal').text('Buat Jadwal');
                                    $('#tombol-buat-jadwal').attr('disabled', false);
                                    $('#jadwal-rapat-dt').DataTable().ajax.reload();
                                }
                            });
                        }
                    });     
                }
            });


            /**********************************************/
            /********* Lihat Detail Jadwal Rapat **********/
            /**********************************************/
            $('body').on('click', '.lihat-detail-jadwal-rapat', function() {
                var id_jadwal_rapat = $(this).attr('id');

                $('#modal-lihat-detail-jadwal-rapat').modal('show');

                $.ajax({
                    type: "GET",
                    url: "/jadwal-rapat/lihat-detail-jadwal-rapat/"+id_jadwal_rapat,
                    success: function(response) {
                        $('#id_detail').val(response.detail_jadwal_rapat.id);
                        $('#pic_detail').html(response.detail_jadwal_rapat.pic_rapat);
                        $('#tanggal_rapat_detail').html(response.detail_jadwal_rapat.tanggal_rapat);
                        $('#agenda_rapat_detail').html(response.detail_jadwal_rapat.agenda_rapat);
                        $('#jumlah_sni_lama_detail').html(response.detail_jadwal_rapat.jumlah_sni_lama);
                        $.each(response.sni_lama, function(key, item) {
                            $('#tabel-sni-lama-detail').append(
                                '<tr>\
                                    <td class="text-center align-text-top">'+(key+1)+'</td>\
                                    <td class="align-text-top" style="width:25%">'+item.nmr_sni_baru+' '+item.jdl_sni_baru+'</td>\
                                    <td class="align-text-top" style="width:25%">'+item.nmr_sni_lama+' '+item.jdl_sni_lama+'</td>\
                                    <td class="align-text-top">'+item.komtek+'</td>\
                                    <td class="align-text-top">'+item.sekretariat_komtek+'</td>\
                                    <td class="align-text-top">'+item.penerap+'</td>\
                                </tr>'
                            );
                        });
                    }
                });
            });

            $('body').on('click','#tombol-unduh-excel', function() {
                $id = $('#id_detail').val();

                $(location).prop('href', '/jadwal-rapat/export-bahan-rapat/'+$id);

                $('#modal-lihat-detail-jadwal-rapat').modal('hide');
                $('#tabel-sni-lama-detail tr').html('');
                $('.reset-value').html('');
            });

            $('.tutup-modal-lihat-detail-jadwal-rapat').click(function() {
                $('#tabel-sni-lama-detail tr').html('');
                $('.reset-value').html('');
            });

            /**********************************************/
            /************ Hapus Jadwal Rapat **************/
            /**********************************************/
            $('body').on('click','.hapus',function() {
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

                    var id_konfirmasi_hapus_jadwal_rapat = $(this).attr('id');

                    $.ajax({
                        type: "GET",
                        url: "/jadwal-rapat/konfirmasi-hapus-jadwal-rapat/"+id_konfirmasi_hapus_jadwal_rapat,
                        success: function(response) {
                            $('#body-konfirmasi-hapus-jadwal-rapat').append(
                                '<input type="hidden" id="id_hapus_jadwal_rapat">\
                                <h6>Apakah anda yakin menghapus jadwal rapat tanggal <strong>'+ response.data.tanggal_rapat +'</strong> ?</h6>'
                            );

                            $('#id_hapus_jadwal_rapat').val(response.data.id);
                        }
                    });

                    $('#modal-konfirmasi-hapus-jadwal-rapat').modal('show');

                    $('.tombol-hapus-jadwal-rapat').on('click', function(e) {

                        e.preventDefault();
                    
                        var id_hapus_jadwal_rapat = $('#id_hapus_jadwal_rapat').val();

                        $(this).html('<i class="spinner-border spinner-border-sm text-light" role="status"></i> Menghapus...');
                        $(this).attr('disabled', true);

                        $.ajax({
                            type: "DELETE",
                            url: "/jadwal-rapat/hapus-jadwal-rapat/"+id_hapus_jadwal_rapat,
                            success: function(response) {
                                Toast.fire({
                                    icon : "success",
                                    title: "Berhasil hapus data jadwal rapat masa transisi SNI.",
                                });
                                $('#modal-konfirmasi-hapus-jadwal-rapat').modal('hide');
                                $('#body-konfirmasi-hapus-jadwal-rapat').html('');
                                $('#jadwal-rapat-dt').DataTable().ajax.reload();
                            }
                        });
                    });
                }
            });

            $('.tutup-modal-konfirmasi-hapus-jadwal-rapat').on('click', function() {
                $('#body-konfirmasi-hapus-jadwal-rapat').html('');
            });
        });    
    </script>    
@endpush