<div class="overflow-x-auto rounded-lg shadow">
    <table class="min-w-full bg-white">
        <thead class="bg-gray-100">
            <tr>
                @foreach ($columns as $column)
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        {{ $column }}
                    </th>
                @endforeach
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200">
            @foreach ($rows as $row)
                <tr class="hover:bg-gray-50">
                    @foreach ($columns as $column)
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            @if ($column === 'Estado')
                                <span
                                    class="{{ $row[$column] ? 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800' : 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800' }}">
                                    {{ $row[$column] ? 'Activo' : 'Inactivo' }}
                                </span>
                            @else
                                {{ $row[$column] ?? '' }}
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
