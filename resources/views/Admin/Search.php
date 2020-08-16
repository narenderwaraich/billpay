 @extends('layouts.master')
@section('content')

 <div class="container" style="margin-top: 50px;">
    @if(isset($details))
        <p> The Search results for your query <b> {{ $query }} </b> are :</p>
    <h2>Find Data</h2>
    <table class="table table-striped">
        <thead>
            <tr><th>User Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
            </tr>
        </thead>
        <tbody>
             @foreach($details as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->mobile}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection