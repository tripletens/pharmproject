<x-app-layout>
    <!-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> -->

    <div class="py-12">

        <div class="grid lg:grid-cols-2 md:grid-cols-2 ">
            <!-- First Div -->
            <div class="p-3 justify-items-center">
                <div class="bg-teal-800 text-white rounded-lg text-center w-full">
                    <h3 class="text-center p-6"> Current Medication </h3>
                </div>

                @if (count($prescriptions) > 0)
                    @foreach ($prescriptions as $key => $value)
                        <div class="bg-slate-800 my-4 p-1 text-white rounded-lg text-start w-full">
                            <div class="flex flex-row h-100">
                                <h3 class="text-start text-white p-2 justify-center m-1">
                                    {{ ucwords($value->medication_name) }}</h3>
                                <span class="p-2 ring-1 ring-white rounded-2xl m-2 h-10">{{ ucwords($value->medication_mode) }}</span>
                                <p class="p-2 ring-1 ring-white rounded-2xl m-2 ">
                                    {{ implode(' ', explode('_', ucwords($value->medication_frequency))) }}</p>

                                <div class="ml-auto">
                                    <a href="" class="align-middle">
                                        <button class="bg-sky-500 hover:bg-sky-800 text-white p-3 rounded-lg "
                                            title="Edit {{ ucwords($value->medication_name) }}">
                                            <img src="{{ asset('./icons/edit_square.svg') }}" />
                                        </button>
                                    </a>
                                    <a href="{{route('healthinfo.delete_prescription', $value->id)}}" data-confirm-delete="true" class="align-middle">
                                        <button class="bg-red-500 hover:bg-red-800 text-white p-3 rounded-lg "
                                            title="Delete {{ ucwords($value->medication_name) }}">
                                            <img src="{{ asset('./icons/delete.svg') }}" />
                                        </button>
                                    </a>
                                </div>
                                
                            </div>

                            <div class="flex flex-row">
                                <p class="p-2 m-1 text-xs">
                                    {{ $value->formatted_start_date . ' to ' . $value->formatted_end_date }}
                                    {{-- {{ \Illuminate\Support\Carbon::parse($value->start_date)->format('jS F Y') . ' to ' . \Illuminate\Support\Carbon::parse($value->end_date)->format('jS F Y') }} --}}
                                </p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="bg-slate-400 my-4 text-white rounded-lg text-center w-1/2">
                        <h3 class="text-center text-white p-6 justify-center"> Sorry you dont have any prescriptions.
                        </h3>
                    </div>
                @endif

                {{ $prescriptions->links() }}
            </div>

            <!-- Second Div -->
            <div class="p-3 w-full">
                <div class="bg-teal-8   00 text-white rounded-lg text-center w-100 p-6">
                    <form method="POST" action="{{ route('healthinfo.add_prescription') }}" class="w-full">
                        @csrf

                        <!-- Medication Name -->
                        <div class="flex flex-row justify-start">
                            <x-input-label for="medication_name" class="w-full text-white py-3 text-start"
                                :value="__('Medication Name:')" />
                            <x-text-input id="medication_name" class="block mt-1 w-full text-teal-800" type="text"
                                name="medication_name" :value="old('medication_name')" required autofocus
                                autocomplete="medication_name" placeholder="Enter Medication Name" />
                            
                        </div>

                        <x-input-error :messages="$errors->get('medication_name')" class="mt-2 text-end" />
                        {{-- medication_name, medication_mode, start_date, end_date, medication_frequency --}}

                        {{-- mode of medication --}}
                        <div class="flex flex-row justify-start my-3">
                            <x-input-label for="medication_mode" class="w-full text-white py-3 text-start"
                                :value="__('Mode of Medication:')" />
                            <select name="medication_mode" class="block mt-1 w-100 rounded-lg text-teal-800" required>
                                <option value="" default name="medication_mode[]">-- Select a Mode of Medication
                                    --
                                </option>
                                <option value="oral" name="medication_mode[]"> Oral medication (Pills, syrups
                                    etc) </option>
                                <option value="inhaler" name="medication_mode[]"> Inhaler</option>
                                <option value="injection" name="medication_mode[]"> Injection</option>
                                <option value="iv" name="medication_mode[]"> IV</option>
                            </select>
                            
                        </div>
                        <x-input-error :messages="$errors->get('medication_name')" class="mt-2 text-end" />

                        {{-- Start Date  --}}
                        <div class="flex flex-row justify-start my-3">
                            <x-input-label for="start_date" class="w-full text-white py-3 text-start"
                                :value="__('Start Date:')" />
                            <x-text-input id="start_date" class="block mt-1 w-full text-teal-800" type="date"
                                name="start_date" :value="old('start_date')" required autofocus autocomplete="start_date" />
                            
                        </div>
                        <x-input-error :messages="$errors->get('start_date')" class="mt-2 text-end" />
                        {{-- end date  --}}
                        <div class="flex flex-row justify-start my-3">
                            <x-input-label for="end_date" class="w-full text-white py-3 text-start" :value="__('End Date:')" />
                            <x-text-input id="end_date" class="block mt-1 w-full text-teal-800" type="date"
                                name="end_date" :value="old('end_date')" required autofocus autocomplete="end_date" />
                           
                        </div>
                        <x-input-error :messages="$errors->get('end_date')" class="mt-2 text-end" />

                        <div class="flex flex-row justify-start my-3">
                            <x-input-label for="medication_frequency" class="w-full text-white text-start"
                                :value="__('Frequency of Medication:')" />
                            <select name="medication_frequency" class="block mt-1 w-100 rounded-lg text-teal-800"
                                required>
                                <option value="" default name="medication_frequency[]">-- Select a Frequency of
                                    Medication --
                                </option>
                                <option value="once_daily" name="medication_frequency[]"> Once daily </option>
                                <option value="twice_daily" name="medication_frequency[]"> Twice Daily </option>
                                <option value="three_times_daily" name="medication_frequency[]"> Three times Daily
                                </option>
                                <option value="once_eight_hours" name="medication_frequency[]"> Once in 8 hrs </option>
                            </select>
                           
                        </div>
                        <x-input-error :messages="$errors->get('medication_name')" class="mt-2 text-end" />

                        <x-primary-button class="mt-4">
                            {{ __('Add Medication') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>

    </div>




</x-app-layout>
