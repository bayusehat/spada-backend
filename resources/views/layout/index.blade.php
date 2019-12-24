@include('layout.head')
@if ($data['content'])
    {{ view($data['content'], $data) }}
@endif
@include('layout.foot')