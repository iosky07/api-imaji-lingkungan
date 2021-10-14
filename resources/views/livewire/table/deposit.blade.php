<div>
    <x-data-table :data="$data" :model="$deposits">
        <x-slot name="head">
            <tr>
                <th><a wire:click.prevent="sortBy('id')" role="button" href="#">
                    ID
                    @include('components.sort-icon', ['field' => 'id'])
                </a></th>
                <th><a wire:click.prevent="sortBy('name')" role="button" href="#">
                    Waktu
                    @include('components.sort-icon', ['field' => 'name'])
                </a></th>
                <th><a wire:click.prevent="sortBy('email')" role="button" href="#">
                    Detail Sampah
                    @include('components.sort-icon', ['field' => 'email'])
                </a></th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($deposits as $d)
                <tr x-data="window.__controller.dataTableController({{ $d->id }})">
                    <td>{{ $d->id }}</td>
                    <td>
                        @foreach($user->wasteDeposits as $wd)
                            {{$wd->created_at->format('d M Y')}}
                            <br>
                            @foreach($wd->wasteDepositDetails as $wdd)
                                {{$wdd->wasteType->title.' - '.$wdd->amount}} <br>
                            @endforeach
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
