<x-app-layout>
    <x-slot name="header_content">
        <h1>Data Customer {{$dataId->name}}</h1>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">User</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.user',$dataId->id) }}">Data Customer {{$dataId->name}}</a></div>
        </div>
    </x-slot>

    <div>
        <livewire:table.main name="user" :model="$user" dataId="{{$dataId->id}}"/>
    </div>
</x-app-layout>
