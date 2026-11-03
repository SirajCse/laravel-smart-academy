@props([
    'columns' => [],       // ['Label', 'Label2', ...]
    'id' => null,          // table id (auto-generated if not provided)
    'datatable' => true,   // initialize DataTables?
    'class' => '',
])

@php
    $tableId = $id ?: 'tbl-' . uniqid();
@endphp

<div class="rounded-md border">
    <table
        id="{{ $tableId }}"
        @if ($datatable) data-datatable @endif
        class="display dataTable"
        style="width:100%"
    >
        @if (count($columns) > 0)
            <thead>
                <tr>
                    @foreach ($columns as $col)
                        <th>{{ is_array($col) ? ($col['label'] ?? '') : $col }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                {{ $slot }}
            </tbody>
        @else
            {{ $slot }}
        @endif
    </table>
</div>
