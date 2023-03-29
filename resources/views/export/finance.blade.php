<table>
    <thead>
    <tr>
        <th>Ngày</th>
        <th>Tổng thu gia hạn</th>
        <th>Tổng thu khác</th>
        <th>Tổng chi</th>
        <th>Thu chi ngày</th>
    </tr>
    </thead>
    <tbody>
    @foreach($finance as $item)
        <tr>
            <td>{{ $item->day }}</td>
            <td>{{ $item->extend }}</td>
            <td>{{ $item->invoice }}</td>
            <td>{{ $item->payment }}</td>
            <td>{{ $item->total }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
