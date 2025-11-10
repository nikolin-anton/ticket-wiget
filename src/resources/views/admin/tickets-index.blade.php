@extends('layout.admin')

@section('content')
    <h2 class="mb-3">Tickets</h2>
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="text" name="email" class="form-control" placeholder="email" value="{{request('email')}}">
        </div>
        <div class="col-md-3">
            <input type="text" name="phone" class="form-control" placeholder="phone" value="{{request('phone')}}">
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">Status</option>
                <option value="new" {{request('status') == 'new' ? 'selected' : ''}}>Open</option>
                <option value="new" {{request('status') == 'in_progress' ? 'selected' : ''}}>In progress</option>
                <option value="new" {{request('status') == 'processed' ? 'selected' : ''}}>Processed</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" name="date_from" class="form-control" value="{{request('date_from')}}">
        </div>
        <div class="col-md-2">
            <input type="date" name="date_to" class="form-control" value="{{request('date_to')}}">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
    </form>
    <table class="table table-bordered bg-white">
        <thead>
        <tr>
            <th>ID</th>
            <th>Subject</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Created</th>
            <th>Responded</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($tickets as $ticket)
            <tr>
                <td>{{$ticket->id}}</td>
                <td>{{$ticket->subject}}</td>
                <td>{{$ticket->customer->email}}</td>
                <td>{{$ticket->customer->phone}}</td>
                <td>{{$ticket->status}}</td>
                <td>{{$ticket->created_at}}</td>
                <td>{{$ticket->responded_at}}</td>
                <td>
                    <a href="{{route('tickets.show', $ticket)}}" class="btn btn-sm btn-primary">View</a>
                    @role('admin')
                        <form method="POST" action="{{route('tickets.destroy', $ticket->id)}}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    @endrole
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{$tickets->links()}}
@endsection
