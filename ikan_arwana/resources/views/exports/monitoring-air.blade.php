<table border="1">
    <thead>
        <tr>
            <th>Waktu</th>
            <th>Suhu (°C)</th>
            <th>pH</th>
            <th>Oksigen (mg/L)</th>
            <th>Kolam</th>
        </tr>
    </thead>

    <tbody>
        @foreach($data as $row)
        <tr>
            <td>{{ $row->created_at->format('d-m-Y H:i') }}</td>
            <td>{{ $row->suhu }}</td>
            <td>{{ $row->ph }}</td>
            <td>{{ $row->oksigen }}</td>
            <td>{{ $row->kolam->nama_kolam ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
