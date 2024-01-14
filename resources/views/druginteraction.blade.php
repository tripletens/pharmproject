<x-app-layout>
    <!-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> -->

    <div class="py-12 min-w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __('Drug Interaction Block') }}
                </div>
            </div>

            <div class="bg-teal-800 text-white text-lg m-3 rounded-lg">
                <p class="p-3">
                    @if (session('message'))
                        {{ session('message') }}
                    @endif
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
                <div class="w-full">
                    <!-- Your content for the first column (full width) -->
                    @if (count($drugInteraction))

                        @foreach ($drugInteraction as $value)
                            <div class="bg-slate-800 my-4 p-1 text-white rounded-lg text-start w-full">
                                <div class="flex flex-row h-100">
                                    <h3 class="text-start text-white p-2 justify-center m-1">
                                        {{ ucwords($value->name) .' ' . $value->id }}</h3>

                        
                                    <div class="ml-auto">
                                        <button x-data="{{ $value->id }}"
                                            x-on:click.prevent="$dispatch('open-modal', 'confirm-drug-deletion{{ $value->name }}')"
                                            class="bg-red-500 hover:bg-red-800 text-white p-3 rounded-lg "
                                            title="Delete {{ ucwords($value->name) }}">
                                            <img src="{{ asset('./icons/delete.svg') }}" />
                                        </button>

                                        <x-modal name="confirm-drug-deletion{{ $value->name }}"
                                            :show="$errors->id->isNotEmpty()" focusable>
                                            <form method="post" action="{{ route('drugs.delete') }}"
                                                class="p-6">
                                                @csrf
                                                @method('delete')

                                                <h2 class="text-lg font-medium text-gray-900">
                                                    {{ __('Are you sure you want to delete your Drug ' . ucwords($value->name) . '?') }}
                                                </h2>

                                                {{-- <div class="mt-6">
                                                    <input id="code" name="code" type="hidden"
                                                        class="mt-1 block w-3/4 text-teal-800"
                                                        hidden value="{{ $value->id }}" />
                                                    <x-input-error :messages="$errors->drugDeletion->get('id')" class="mt-2" />
                                                </div> --}}

                                                <div class="mt-6 flex justify-end">
                                                    <x-secondary-button x-on:click="$dispatch('close')">
                                                        {{ __('Cancel') }}
                                                    </x-secondary-button>

                                                    <x-danger-button class="ms-3">
                                                        {{ __('Delete Drug') }}
                                                    </x-danger-button>
                                                </div>
                                            </form>
                                        </x-modal>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    @else
                        <p> Sorry you don't have any drugs available</p>
                    @endif
                </div>
                <div class="w-full bg-teal-800 p-4">
                    <!-- Drug Search Form -->

                    <form method="POST" action="{{ route('drugs.add') }}">
                        @csrf
                        <div class="w-full">
                            <input type="text" name="search_input" id="searchInput" class="rounded-lg"
                                placeholder="Search for drugs..." />
                            <button type="submit" id="addItemButton"
                                class="rounded-lg bg-white p-3 hover:bg-black hover:ring-2 hover-ring-white  hover:text-white text-teal-800">Add
                                Item</button>
                        </div>
                    </form>
                    <!-- Display Search Results -->
                    <ul id="searchResults"></ul>
                </div>
            </div>
        </div>
    </div>


    <!-- resources/views/drug-interaction.blade.php -->
    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const addItemButton = document.getElementById('addItemButton');
                const leftList = document.getElementById('leftList');
                const searchInput = document.getElementById('searchInput');
                const searchResults = document.getElementById('searchResults');

                addItemButton.addEventListener('click', function() {
                    const selectedDrug = searchInput.value.trim();

                    if (selectedDrug !== '') {
                        // Create a new list item for the left list
                        const listItem = document.createElement('li');
                        listItem.textContent = selectedDrug;
                        listItem.classList.add('text-white');

                        // Append the new item to the left list
                        leftList.appendChild(listItem);

                        // TODO: Add logic to save the selected drug to the database
                        saveToDatabase(selectedDrug);

                        // i need to check the item with the other items 

                        // Clear the search input
                        searchInput.value = '';
                        // Clear the search results
                        searchResults.innerHTML = '';
                    }
                });

                searchInput.addEventListener('input', function() {
                    const query = this.value.trim();

                    if (query.length >= 3) {
                        // Make Ajax request to fetch drug results
                        fetch(`/drugs/search?q=${query}`)
                            .then(response => response.json())
                            .then(data => {
                                // Update search results
                                searchResults.innerHTML = '';

                                data.forEach(drug => {
                                    const listItem = document.createElement('li');
                                    listItem.textContent = drug
                                        .name; // Use drug name as selected drug
                                    listItem.classList.add('text-white');
                                    listItem.addEventListener('click', function() {
                                        searchInput.value = drug
                                            .name; // Set search input value on click
                                        searchResults.innerHTML =
                                            ''; // Clear search results
                                    });
                                    searchResults.appendChild(listItem);
                                });
                            });
                    } else {
                        searchResults.innerHTML = '';
                    }
                });

                function saveToDatabase(drug) {
                    // TODO: Add logic to save the drug to the database
                    // You can use AJAX or any other method to send the data to your server

                    // Make an AJAX request to your ChatGPT endpoint
                    fetch('/add-drug-interaction', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                // Add any other headers as needed
                            },
                            body: JSON.stringify({
                                drug: drug,
                                otherDrugs: Array.from(leftList.children).map(item => item.textContent
                                    .trim()),
                            }),
                        })
                        .then(response => response.json())
                        .then(interactionData => {
                            // TODO: Handle the drug interaction data (e.g., display it to the user)
                            console.log('Drug Interaction Data:', interactionData);
                        })
                        .catch(error => {
                            console.error('Error fetching drug interaction data:', error);
                        });
                }
            });
        </script>
    @endsection



</x-app-layout>
