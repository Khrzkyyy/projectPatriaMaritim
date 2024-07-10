<div>
    <div class="row">
        @foreach($barangs as $barang)
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2" style="font-weight: bold">{{ $barang->nama }}</p>
                                @php
                                    $stok = $barang->stok;
                                    if ($stok <= 10) {
                                        $stokClass = 'text-danger';
                                        $iconColor = 'text-danger';
                                    } elseif ($stok <= 20) {
                                        $stokClass = 'text-warning';
                                        $iconColor = 'text-warning';
                                    } else {
                                        $stokClass = 'text-success';
                                        $iconColor = 'text-success';
                                    }
                                @endphp
                                <h4 class="mb-2 {{ $stokClass }}">
                                    {{ $stok }} {{ $barang->satuan_stok }}
                                </h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <i class="ri-pie-chart-fill font-size-24 {{ $iconColor }}"></i>  
                                </span>
                            </div>
                        </div>                                              
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
        @endforeach
    </div>

    @if (Auth::user()->role == 'admin')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Peminjaman Terakhir</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr class="text-center">
                                <th style="width:160px">No. Peminjaman</th>
                                <th>Peminjam</th>
                                <th style="width:140px">Tanggal Pinjam</th>
                                <th>Barang</th>
                                <th style="width:140px">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barangKeluars as $barangKeluar)
                                @if($barangKeluar->detailBarangKeluar->isEmpty())
                                    <tr class="text-center" style="vertical-align: middle;">
                                        <td>{{ ucwords($barangKeluar->user->nama) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($barangKeluar->tanggal)->format('d/m/Y') }}</td>
                                        <td colspan="4">Tidak ada detail</td>
                                    </tr>
                                @else
                                    @foreach($barangKeluar->detailBarangKeluar as $index => $detail)
                                        <tr @if($index == 0) class="parent-row" style="vertical-align: middle;" @endif data-id="{{ $barangKeluar->id }}">
                                            @if($index == 0)
                                                <td rowspan="{{ $barangKeluar->detailBarangKeluar->count() }}" class="text-center">PMJ-{{ $barangKeluar->id }}
                                                </td>
                                                <td rowspan="{{ $barangKeluar->detailBarangKeluar->count() }}" class="text-center">{{ ucwords($barangKeluar->user->nama) }}</td>
                                                <td rowspan="{{ $barangKeluar->detailBarangKeluar->count() }}" class="text-center">{{ \Carbon\Carbon::parse($barangKeluar->tanggal)->format('d/m/Y') }}</td>
                                            @endif
                                            <td class="text-center">{{ $detail->barang->nama }}</td>
                                            <td class="text-center">{{ $detail->jumlah }} {{ $detail->barang->satuan }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
