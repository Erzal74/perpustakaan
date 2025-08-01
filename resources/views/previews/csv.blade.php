<div class="p-4">
    <div class="overflow-auto">
        <table class="min-w-full border">
            <thead class="bg-gray-100">
                @if (isset($data[0]))
                    <tr>
                        @foreach ($data[0] as $header)
                            <th class="border px-4 py-2">{{ $header }}</th>
                        @endforeach
                    </tr>
                @endif
            </thead>
            <tbody>
                @foreach (array_slice($data, 1) as $row)
                    <tr>
                        @foreach ($row as $cell)
                            <td class="border px-4 py-2">{{ $cell }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
