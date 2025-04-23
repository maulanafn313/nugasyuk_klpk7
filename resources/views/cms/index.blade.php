<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('CMS List') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">


                <div class="flex justify-end mb-4">
                    <a href="{{ route('admin.cms.create') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                        + Add CMS
                    </a>
                </div>


                <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Logo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Color</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Hero Text 1</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Description 1</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Hero Text 2</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Description 2</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Image 2</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Hero Text 3</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Description 3</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Image 3</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Hero Text 4</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Description 4</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Image 4</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($cms as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($item->logo)
                                    <img src="{{ asset('storage/cms/' . $item->logo) }}" alt="Logo" class="w-16 h-16 object-cover rounded">
                                    @else
                                    <span class="text-gray-500">No Logo</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $item->color }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $item->hero_text }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ Str::limit($item->description_text, 50) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $item->hero_text2 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ Str::limit($item->description_text2, 50) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($item->img_text2)
                                    <img src="{{ asset('storage/cms/' . $item->img_text2) }}" alt="Image 2" class="w-16 h-16 object-cover rounded">
                                    @else
                                    <span class="text-gray-500">No Image</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $item->hero_text3 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ Str::limit($item->description_text3, 50) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($item->img_text3)
                                    <img src="{{ asset('storage/cms/' . $item->img_text3) }}" alt="Image 3" class="w-16 h-16 object-cover rounded">
                                    @else
                                    <span class="text-gray-500">No Image</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $item->hero_text4 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ Str::limit($item->description_text4, 50) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($item->img_text4)
                                    <img src="{{ asset('storage/cms/' . $item->img_text4) }}" alt="Image 3" class="w-16 h-16 object-cover rounded">
                                    @else
                                    <span class="text-gray-500">No Image</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                                    <a href="{{ route('admin.cms.edit', $item->id) }}"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-1 px-3 rounded text-sm">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.cms.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this CMS?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
</x-app-layout>


