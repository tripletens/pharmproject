<x-app-layout>
    <!-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> -->

    <div class="py-12">

        {{-- <div class="flex flex-col w-full p-6"> --}}
            <h3 class="my-3 p-3 text-3xl">Our AI Chat Bot</h3>

            <form action="{{route('chatbot.response')}}" method="POST">
                @csrf 
                <div class="flex flex-row justify-start m-4 ms-3">
                    <x-text-input id="chat_input" class="block mt-1 w-full text-teal-800"
                        type="text" name="chat_input" required autofocus
                        autocomplete="chat_input" placeholder="Enter your Question" />
                </div>
                <x-primary-button class="ms-3">
                    {{ __('Send message') }}
                </x-danger-button>
            </form>
        </div>

    </div>




</x-app-layout>
