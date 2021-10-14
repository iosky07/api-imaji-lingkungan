<x-app-layout>
    <x-slot name="header_content">
        <h1>Data Customer {{$wasteDeposit->name}}</h1>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Customer</a></div>
            <div class="breadcrumb-item"><a href="">Data Customer {{$wasteDeposit->name}}</a></div>
        </div>
    </x-slot>

    <div class="bg-white p-3">
        <table class="table">
            <thead>
            <tr>
                <th>Tanggal Penjemputan</th>
                @foreach(\App\Models\WasteType::get() as $wt)
                    <th>{{ $wt->title }}</th>
                @endforeach
                <th>Keterangan</th>
            </tr>

            </thead>

            @foreach($wasteDeposit->wasteDeposits as $wd)
                <tr>
                    <td>{{ $wd->created_at->format('d M Y') }}</td>
                    @foreach($wd->wasteDepositDetails as $wdd)
                        <td>{{ $wdd->amount }}</td>
                    @endforeach
                    <td>{{ $wd->note }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</x-app-layout>
