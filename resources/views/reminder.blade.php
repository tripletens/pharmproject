<x-app-layout>
    <!-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Reminder Block") }}

                    <p> We will add the calendar here </p>

                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
    
    {{ $appointments[0]->appointment_date }}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
    
            var calendar = new FullCalendar.Calendar(calendarEl, {
                events: [
                    @foreach($appointments as $appointment)
                    {
                        title: '{{ $appointment->patient_subject }}',
                        start: '{{ $appointment->patient_appointment_date }}',
                        // Add other event properties as needed
                    },
                    @endforeach
                ]
            });
    
            calendar.render();
        });
    </script>

   

</x-app-layout>
