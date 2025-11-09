@extends('layout.layout')

@section('content')
    <h2 class="mb-3">Ticket {{$ticket->id}}</h2>

    <div class="card p-3 mb-4">
        <h3>Customer</h3>
        <p><b>Name</b> {{$ticket->customer->name}}</p>
        <p><b>Email</b> {{$ticket->customer->email}}</p>
        <p><b>Phone</b> {{$ticket->customer->phone}}</p>
    </div>

    <div class="card p-3 mb-4">
        <h3>Ticket</h3>
        <p><b>Subject</b> {{$ticket->subject}}</p>
        <p><b>Text</b> {{$ticket->text}}</p>
        <form method="POST" action="{{route('tickets.updateStatus', $ticket)}}">
            @csrf
            @method('PATCH')
            <div class="d-flex gap-2">
                <p><b>Status</b></p>
                <select name="status" class="form-select w-auto">
                    <option value="new" {{$ticket->status == 'new' ? 'selected' : ''}}>New</option>
                    <option value="in_progress" {{$ticket->status == 'in_progress' ? 'selected' : ''}}>In progress
                    </option>
                    <option value="processed" {{$ticket->status == 'processed' ? 'selected' : ''}}>Processed</option>
                </select>
                <button class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
    <div class="card p-3">
        <h3>Files</h3>
        @if($ticket->files->count())
            <ul>
                @foreach($ticket->files as $file)
                    <div class="text-centre" style="width: 120px">
                        @if(str_contains($file->mime_type, 'image/'))
                            <a href="{{$file->getUrl()}}" target="_blank">
                                <img src="{{$file->getUrl()}}" alt="image"
                                     style="width: 100%; height: 80px; border-radius: 5px; margin-bottom: 3px">
                            </a>
                        @elseif(str_contains($file->mime_type, 'application/pdf'))
                            <a href="{{$file->getUrl()}}" target="_blank">
                                <img src="{{asset('icons/pdf.png')}}" alt="image"
                                     style="width: 100%; height: 80px; border-radius: 5px">
                            </a>
                        @else
                            <a href="{{$file->getUrl()}}" target="_blank">
                                <img src="{{asset('icons/file.png')}}" alt="image"
                                     style="width: 100%; height: 80px; border-radius: 5px">
                            </a>
                        @endif
                    </div>
                @endforeach
            </ul>
        @else
            <p>No files</p>
        @endif
    </div>
@endsection
