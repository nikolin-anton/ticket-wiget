@php use App\Enum\TicketStatusEnum; @endphp
@extends('layout.admin')

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
                    @foreach(TicketStatusEnum::cases() as $status)
                        <option value="{{$status->value}}" {{$ticket->status === $status->value ? 'selected' : ''}}>
                            {{$status->label()}}
                        </option>
                    @endforeach
                </select>
                <button class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
    <div class="card p-3 mb-4">
        <h3>Files</h3>
        @if($ticket->files->count())
            <div class="d-flex flex-wrap" style="gap: 20px">
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
                        <div>
                            <div>{{$file->file_name}}</div>
                            <a href="{{route('tickets.downloadFile', $file->id)}}"
                               class="btn btn-sm btn-primary mt-1"
                            >Download</a>
                        </div>
                    </div>

                @endforeach
            </div>
        @else
            <p>No files</p>
        @endif
    </div>

    @if($ticket->files->count())
        <div class="card p-3 mb-2">
            <a href="{{route('tickets.downloadAllFile', $ticket->id)}}"
               class="btn btn-sm btn-primary" style="width: 180px"
            >Download All (ZIP)</a>
        </div>
    @endif

    @role('admin')
    <form method="POST" action="{{route('tickets.destroy', $ticket->id)}}" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
    </form>
    @endrole
@endsection
