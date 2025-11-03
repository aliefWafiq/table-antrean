@extends('layout.main')
@section('content')
<div class="p-lg-5 p-4">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex flex-column flex-lg-row align-items-center">
                                <div class="col-12 col-sm-8 py-2 d-flex flex-column flex-lg-row">
                                    <span class="card-title">Daftar Perkara Hari Ini</span>
                                    <span class="card-title mx-lg-2">{{ now()->format('d F Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="overflow-x: scroll;">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Nomor Perkara</th>
                                        <th>Tiket Antrean</th>
                                        <th>Jam Sidang</th>
                                        <th>Tanggal Sidang</th>
                                    </tr>
                                </thead>
                                <tbody id="tabel-antrean">
                                    @foreach ($data as $x)
                                    <tr id="antrean-{{ $x->id }}" data-tanggal="{{ \Carbon\Carbon::parse($x->tanggal_sidang)->format('Y-m-d') }}" class="{{ ($antreanSekarang && $antreanSekarang->id == $x->id) ? 'table-success' : '' }}">
                                        <td class="text-center py-3">{{ $loop->iteration }}</td>
                                        <td class="py-3">{{ $x->noPerkara }}</td>
                                        <td class="py-3">{{ $x->tiketAntrean }}</td>
                                        <td class="py-3">{{ \Carbon\Carbon::parse($x->jam_perkiraan)->format('H:i') }}</td>
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
            const tabelBody = document.getElementById('tabel-antrean');

            const barisAktifSebelumnya = tabelBody.querySelector('tr.table-success');
            if (barisAktifSebelumnya) {
                barisAktifSebelumnya.classList.remove('table-success');
            }

            if (antreanSekarang) {
                const barisAktifSekarang = document.getElementById('antrean-' + antreanSekarang.id);
                if (barisAktifSekarang) {
                    barisAktifSekarang.classList.add('table-success');
                }
            }
        }

        window.Echo.channel('antrean-display-channel').listen('UpdateDisplayAntrean', (event) => {
            updateTampilan(event.dataAntreanTerkini);
        });
    })
</script>
@endpush