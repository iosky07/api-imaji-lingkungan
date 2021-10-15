<div>
    <x-data-table :data="$data" :model="$users">
        <x-slot name="head">
            <tr>
                <th style="width: 75px"><a wire:click.prevent="sortBy('id')" role="button" href="#">
                        ID
                        @include('components.sort-icon', ['field' => 'id'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('name')" role="button" href="#">
                        Nama
                        @include('components.sort-icon', ['field' => 'name'])
                    </a></th>
                <th>Jumlah setor</th>
                <th>
                    <a wire:click.prevent="sortBy('pickup_status_id')" role="button" href="#">
                        Status penjemputan
                        @include('components.sort-icon', ['field' => 'pickup_status_id'])
                    </a>
                </th>
                <th>Action</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($users as $index=>$user)
                <tr x-data="window.__controller.dataTableController({{ $user->id }})">
                    <td>{{ $index+1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->wasteDeposits->count() }}</td>
                    <td style="color: {{ $user->pickup_status_id==1?'red':$user->pickup_status_id==2?'orange':'green'}};font-weight: bold">{{ $user->pickupStatus->title }}</td>
                    <td class="whitespace-no-wrap row-action--icon">
                        <a role="button" href="user/edit/{{ $user->id }}" class="mr-3"><i class="fa fa-16px fa-pen"></i></a>
                        <a role="button" href="deposit-detail/{{ $user->id }}" class="mr-3"><i
                                class="fa fa-16px fa-eye"></i></a>
                        <a role="button" x-on:click.prevent="deleteItem" href="#"><i
                                class="fa fa-16px fa-trash text-red-500"></i></a>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
