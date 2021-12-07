<div>
    <x-data-table :data="$data" :model="$wasteTypes">
        <x-slot name="head">
            <tr>
                <th style="width: 75px"><a wire:click.prevent="sortBy('id')" role="button" href="#">
                        ID
                        @include('components.sort-icon', ['field' => 'id'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('title')" role="button" href="#">
                        Jenis sampah
                        @include('components.sort-icon', ['field' => 'title'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('price')" role="button" href="#">
                        harga
                @include('components.sort-icon', ['field' => 'price'])
                <th>Action</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($wasteTypes as $index=>$user)
                <tr x-data="window.__controller.dataTableController({{ $user->id }})">
                    <td>{{ $index+1 }}</td>
                    <td>{{ $user->title }}</td>
                    <td>{{ $user->price }}</td>
                    <td class="whitespace-no-wrap row-action--icon">
                        <a role="button" href="{{ route('admin.wasteType.edit',$user->id) }}" class="mr-3"><i
                                class="fa fa-16px fa-eye"></i></a>
                        <a role="button" x-on:click.prevent="deleteItem" href="#"><i
                                class="fa fa-16px fa-trash text-red-500"></i></a>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
