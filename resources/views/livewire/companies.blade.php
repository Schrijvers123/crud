<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Companies') }}
    </h2>
</x-slot>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    @if (session()->has('message'))
        <div id="alert" class="text-white px-6 py-4 border-0 rounded relative mb-4 bg-green-500">
            <span class="inline-block align-middle mr-8">
                {{ session('message') }}
            </span>
            <button class="absolute bg-transparent text-2xl font-semibold leading-none right-0 top-0 mt-4 mr-6 outline-none focus:outline-none" onclick="document.getElementById('alert').remove();">
                <span>×</span>
            </button>
        </div>
    @endif
    <button wire:click="create()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-10">Create New Company</button>
    @if (count($companies)>0)
        <div class="py-10">
            <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                    <tr>
                        <th
                            class="px-5 py-3 border-b-2 border-black bg-black text-left text-xs font-semibold text-white uppercase tracking-wider">
                            {{ __('Title') }}
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-black bg-black text-left text-xs font-semibold text-white uppercase tracking-wider">
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($companies as $company)
                        <tr>
                            <td class="px-5 py-5 bg-white text-sm @if (!$loop->last) border-gray-200 border-b @endif">
                                {{ Str::limit($company->title, 25) }}
                            </td>
                            <td class="px-5 py-5 bg-white text-sm @if (!$loop->last) border-gray-200 border-b @endif text-right">
                                <div class="inline-block whitespace-no-wrap">
                                    <button wire:click="edit({{ $company->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</button>
                                    <button wire:click="$emit('triggerDelete',{{ $company->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $companies->links('pagination',['is_livewire' => true]) }}
            </div>
        </div>
    @endif
    @if($isOpen)
        <x-customised_modal>
            <x-slot name="content">
                <form>
                    <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <label for="noInput" class="block text-gray-700 text-sm font-bold mb-2">No:</label>
                                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="noInput" placeholder="Enter No" wire:model="no">
                                @error('no') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <label for="titleInput" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="titleInput" placeholder="Enter Title" wire:model="title">
                                @error('title') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <span class="flex w-full sm:ml-3 sm:w-auto">
                            <button wire:click.prevent="store()" type="button" class="inline-flex bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save</button>
                        </span>
                        <span class="mt-3 flex w-full sm:mt-0 sm:w-auto">
                            <button wire:click="closeModal()" type="button" class="inline-flex bg-white hover:bg-gray-200 border border-gray-300 text-gray-500 font-bold py-2 px-4 rounded">Cancel</button>
                        </span>
                    </div>
                </form>
            </x-slot>
        </x-customised_modal>
    @endif
</div>

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {

        @this.on('triggerDelete', companyId => {
            Swal.fire({
                title: 'Are You Sure?',
                text: 'Company record will be deleted!',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Delete!'
            }).then((result) => {
                if (result.value) {
                @this.call('delete',companyId)
                } else {
                    console.log("Canceled");
                }
            });
        });
        })
    </script>
@endpush
