@extends('layout.main')
@section('content')
<div class="p-5">
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Antrean Sedang Dipanggil</h3>
                        </div>
                        <div class="card-body text-center">
                            <h1 id="display-antrean-sekarang" class="display-1 font-weight-bold text-primary">
                                {{ $antreanSekarang->tiketAntrean ?? '---' }}
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <hr>
                            <div class="d-flex flex-column flex-lg-row align-items-center">
                                <div class="col-12 col-sm-8 py-2">
                                    <h3 class="card-title">List Antrean Hari Ini</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="overflow-x: scroll;">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Nomor Perkara</th>
                                        <th>Tiket Antrean</th>
                                        <th>Tanggal Sidang</th>
                                    </tr>
                                </thead>
                                <tbody id="tabel-antrean">
                                    @foreach ($data as $x)
                                    <tr id="antrean-{{ $x->id }}" data-tanggal="{{ \Carbon\Carbon::parse($x->tanggal_sidang)->format('Y-m-d') }}" class="{{ ($antreanSekarang && $antreanSekarang->id == $x->id) ? 'table-success' : '' }}">
                                        <td class="text-center py-3">{{ $loop->iteration }}</td>
                                        <td class="py-3">{{ $x->namaLengkap }}</td>
                                        <td class="py-3">{{ $x->noPerkara }}</td>
                                        <td class="py-3">{{ $x->tiketAntrean }}</td>
                                        <td class="py-3">{{ \Carbon\Carbon::parse($x->tanggal_sidang)->format('d F Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function updateTampilan(antreanSekarang) {
            const displayNomorSekarang = document.getElementById('display-antrean-sekarang');
            const tabelBody = document.getElementById('tabel-antrean');

            const barisAktifSebelumnya = tabelBody.querySelector('tr.table-success');
            if (barisAktifSebelumnya) {
                barisAktifSebelumnya.classList.remove('table-success');
            }

            if (antreanSekarang) {
                displayNomorSekarang.innerText = antreanSekarang.tiketAntrean;

                const barisAktifSekarang = document.getElementById('antrean-' + antreanSekarang.id);
                if (barisAktifSekarang) {
                    barisAktifSekarang.classList.add('table-success');
                }
            } else {
                displayNomorSekarang.innerText = '---';
            }
        }

        window.Echo.channel('antrean-display-channel')
            .listen('UpdateDisplayAntrean', (event) => {
                const antreanData = event.dataAntreanTerkini;

                updateTampilan(event.dataAntreanTerkini);
            });
    })
</script>
@endpush