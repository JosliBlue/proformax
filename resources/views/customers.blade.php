@extends('layouts.app')

@section('content')
    @livewire('partials.table', [
        'columns' => $columns,
        'rows' => $rows,
    ])

    {{ $paginator->links() }}
@endsection
