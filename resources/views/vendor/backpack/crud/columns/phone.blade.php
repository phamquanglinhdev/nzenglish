{{-- telephone link --}}
@php
    $value = data_get($entry, $column['name']);
    $column['escaped'] = $column['escaped'] ?? true;
    $column['prefix'] = $column['prefix'] ?? '';
    $column['suffix'] = $column['suffix'] ?? '';
    $column['limit'] = $column['limit'] ?? 40;
    $column['wrapper']['element'] = $column['wrapper']['element'] ?? 'a';
    $column['wrapper']['href'] = $column['wrapper']['href'] ?? 'tel:'.$value;
    $column['text'] = '';

    if(!empty($value)) {
        $tmp = "";
        $tmp = substr($value,-3)." ".$tmp;
        $tmp = substr($value,-6,3)." ".$tmp;

        if(substr($value,-10,1)==0){
           $tmp = substr($value,-10,4)." ".$tmp;
           $value=str_replace(substr($value,-10),"",$value);
        }else{
            $tmp = substr($value,-9,3)." ".$tmp;
            $value=str_replace(substr($value,-9),"",$value);
        }
        $value=$value." ".$tmp;

        $column['text'] = $column['prefix'].Str::limit(strip_tags($value), $column['limit'], "[...]").$column['suffix'];
    }
@endphp

<span>
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
    @if($column['escaped'])
        {{ $column['text'] }}
    @else
        {!! $column['text'] !!}
    @endif
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')
</span>
