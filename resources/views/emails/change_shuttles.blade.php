
{{-- Place your body here: --}}

{{-- TABLE HEADER HERE --}}

<table border="1">
    <thead>
        <tr bgcolor="#009999" style="color: white;" role="row">
            <th rowspan="2">CONTROL NUMBER</th>
            <th rowspan="2">DATES</th>
            <th rowspan="2">NAMES</th>
            <th colspan="2">DESTINATION</th>
            <th rowspan="2">TIME</th>
            <th rowspan="2">RECORDER BY:</th>
        </tr>
        <tr bgcolor="#ff751a" style="color: white;">
            <th>FROM</th>
            <th>TO</th>
        </tr>
    </thead>
    <tbody>
        {{-- @foreach ($result as $details)
            <tr>
                <td>{{$details->control_number}}</td>
                <td>{{$details->date}}</td>
                <td>{{$details->last_name}},{{$details->first_name}}</td>
                <td>{{$details->sh_destination}}</td>
                <td>{{$details->location}}</td>
                <td>{{$details->time}}</td>
                <td>{{$details->users_id}}</td>
            </tr>
        @endforeach --}}
        
    </tbody> 
</table>   