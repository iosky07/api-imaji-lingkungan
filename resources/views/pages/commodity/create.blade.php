<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Menambah Komoditas') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Komoditas</a></div>
        </div>
    </x-slot>

    <div>
        <livewire:form-waste-type action="create" :dataId="$id"/>
    </div>
</x-app-layout>
