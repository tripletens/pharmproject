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

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
                <div class="w-full">
                    <!-- Your content for the first column (full width) -->
                    @if(count($drugInteraction))
                    <ul class="flex flex-col w-full">
                        @foreach($drugInteeraction as $drug)
                            <li> {{ $drug->name }}</li>
                        @endforeach 
                    </ul>
                    @else
                    <p> Sorry you don't have any drugs available</p>
                    @endif
                </div>
                <div class="w-full bg-teal-800 p-4">
                    <!-- Drug Search Form -->

                    <div class="w-full">
                        <input type="text" id="searchInput" class="rounded-lg" placeholder="Search for drugs..." />
                        <button id="addItemButton"
                            class="rounded-lg bg-white p-3 hover:bg-black hover:ring-2 hover-ring-white  hover:text-white text-teal-800">Add
                            Item</button>
                    </div>

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
