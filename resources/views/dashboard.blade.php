@extends('layout.app')
@section('content')
<div class="flex-1 flex flex-col h-screen overflow-hidden relative">
    @include('layout.header')

    <div class="bg-white border-b border-gray-200 px-6 pt-4 shadow-sm z-10 flex-shrink-0">
        <div class="flex space-x-1 overflow-x-auto scrollbar-hide" id="tab-container">
            @include('partial.tab')
        </div>
    </div>

    <main class="flex-1 overflow-y-auto p-4 md:p-8 bg-gray-50 custom-scroll relative">
        @include('partial.pendaftaran')

        @include('partial.pelayanan')

        @include('partial.pembatalan')

        @include('partial.rencanakunjungan')

        @include('partial.cetak')

        @include('partial.skpj')
    </main>
</div>
@endsection
