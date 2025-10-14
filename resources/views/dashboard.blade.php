@extends('layout.main')
@section('content')
<div class="p-5">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>List Antrean</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dahsboard</a></li>
                        <li class="breadcrumb-item active">List Antrean</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

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
@push('script')
<script>
    // const apiUrl = 'https://operator-production-6d52.up.railway.app/api/antrean-terkini';

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

    // async function fetchAwal() {
    //     try {
    //         const response = await fetch(apiUrl);
    //         const data = await response.json(); 

    //         updateTampilan(data.antrean_sekarang); 
    //     } catch (error) {
    //         console.error('Gagal mengambil data awal:', error);
    //         document.getElementById('display-antrean-sekarang').innerText = 'Error';
    //     }
    // }

    // document.addEventListener('DOMContentLoaded', fetchAwal);

    console.log("BELUM")

    window.Echo.channel('antrean-display-channel')
        .listen('UpdateDisplayAntrean', (event) => { 
            console.log('Update antrean diterima:', event);
            console.log("DAPAT NIIIIIII")

            const antreanData = event.dataAntreanTerkini;

            updateTampilan(event.antrean); 

            // const audio = new Audio('/suara/notifikasi.mp3');
            // audio.play();
        });
</script>
@endpush