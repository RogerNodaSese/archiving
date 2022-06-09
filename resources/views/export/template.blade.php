<table>
    <thead>
    <tr>
        <th>Title</th>
        <th>Author/s (Lastname, Firstname, Middle Initial;)</th>
        <th>Publisher</th>
        <th>Date of Publication</th>
        <th>College Program</th>
        <th>Subject/s</th>
        <th>Abstract</th>
        <th>Symbol (Undergrad/Grad)</th>
    </tr>
    </thead>
    <tbody>
    @foreach($theses as $thesis)
        <tr>
            <td>{{ $thesis->title }}</td>
            <td>
            @foreach($thesis->authors as $author)
                {{ $author->last_name }}, {{ $author->first_name }}, {{ $author->middle_name }}; 
            @endforeach
            </td>
            <td> {{ $thesis->publisher }} </td>
            <td> {{ $thesis->date_of_publication }} </td>
            <td> {{ $thesis->program->description }} </td>
            <td> 
            @foreach($thesis->subjects as $subject)
                {{ $subject->description }}, 
            @endforeach
            </td>
            <td> {{ $thesis->abstract }} </td>
            <td> Undergrad </td>
        </tr>
    @endforeach
    </tbody>
</table>