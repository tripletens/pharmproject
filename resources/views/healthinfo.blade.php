<x-app-layout>
    <!-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> -->

    <div class="py-12">

        <div class="grid lg:grid-cols-2 md:grid-cols-2 ">
            <!-- First Div -->
            <x-prescriptions :prescriptions="$prescriptions"></x-prescriptions>

            <!-- Second Div -->
            <x-add-prescriptions></x-add-prescriptions>
        </div>

    </div>

    <div class="py-12">

        <div class="grid lg:grid-cols-2 md:grid-cols-2 ">
            <!-- First Div -->
            {{-- <x-health-metrics :healthmetrics="$healthmetrics"></x-health-metrics> --}}

            <!-- Second Div -->
            <x-add-health-metrics></x-add-health-metrics>

            <x-health-metrics :healthmetrics="$healthmetrics"></x-health-metrics>
        </div>

    </div>



</x-app-layout>
