@extends('layouts.app')
@section('title', 'View Shipment')
@section('content')
@if(isset($data['error']) && $data['error'])
<h1 class="text-center text-danger">{{$data['message']}}</h1>
@else
<h1 class="text-center">View Shipment with ID {{$data['id']}}</h1>
<hr/>
<a href="{{url('shipment/list')}}" class="btn btn-primary">< Back</a>
<hr/>
<table class="table table-bordered">
    <thead>
        <tr>
            <th class="text-center">ID</th>
            <th class="text-center">Name</th>
            <th class="text-center">Is Send</th>
            <th class="text-center">Last Sended At</th>
            <th class="text-center">Created At</th>
            <th class="text-center">Updated At</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center">{{$data['id']}}</td>
            <td class="text-center">{{$data['name']}}</td>
            <td class="text-center">{{$data['is_send']}}</td>
            <td class="text-center">{{$data['last_sended_at']}}</td>
            <td class="text-center">{{$data['created_at']}}</td>
            <td class="text-center">{{$data['updated_at']}}</td>
            <td>
            <a href="{{url('shipment/' . $data['id'] . '/edit')}}" class="btn btn-primary">Edit</a>
                <a onclick="DeleteShipment({{$data['id']}})" class="btn btn-danger">Delete</a>
                <a onclick="SendShipment({{$data['id']}})" class="btn btn-success">Send</a>
            </td>
        </tr>
        @if($data['items'])
            <tr>
                <td class="text-center" colspan="7"><strong>Items</strong></td>
            </tr>
            <tr>
                <td class="text-center"><strong>ID</strong></td>
                <td class="text-center"><strong>Shipment ID</strong></td>
                <td class="text-center"><strong>Name</strong></td>
                <td class="text-center"><strong>Code</strong></td>
                <td class="text-center"><strong>Created At</strong></td>
                <td class="text-center"><strong>Updated At</strong></td>
                <td></td>
            </tr>
            @foreach ($data['items'] as $item)
            <tr>
                <td class="text-center">{{$item['id']}}</td>
                <td class="text-center">{{$item['shipment_id']}}</td>
                <td class="text-center">{{$item['name']}}</td>
                <td class="text-center">{{$item['code']}}</td>
                <td class="text-center">{{$item['created_at']}}</td>
                <td class="text-center">{{$item['updated_at']}}</td>
                <td>
                    <a class="btn btn-primary" href="{{url('item/' . $item['id'])}}">View</a>
                    <a class="btn btn-primary" href="{{url('item/' . $item['id'] . '/edit')}}">Edit</a>
                    <a class="btn btn-danger" onclick="DeleteItem({{$item['id']}})">Delete</a>
                </td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>
@endsection
@section('scripts')
    <script>function DeleteShipment(id){
        $.ajax({
            url: '{{url('shipment')}}' + '/' + id,
            method: 'delete',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        }).then(function(response){
            if(response.expired){
                alert('Token Expired');
                location.reload();
            }else{
                if(response.error){
                    alert(response.message);
                }else{
                    alert("Shipment with ID " + id + " successfully deleted");
                    window.location = "{{url('shipment/list')}}";
                }
            }
        })
    }
    
    function SendShipment(id){
        $.ajax({
            url: '{{url('shipment')}}' + '/' + id + '/send',
            method: 'post',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        }).then(function(response){
            if(response.expired){
                alert('Token Expired');
                location.reload();
            }else{
               if(response.error){
                    alert(response.message);
                }else{
                    alert("Shipment with ID " + id + " successfully sent");
                    location.reload();
                }
            }
        })
    }

    function DeleteItem(id){
        $.ajax({
            url: '{{url('item')}}' + '/' + id,
            method: 'delete',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        }).then(function(response){
            if(response.expired){
                alert('Token Expired');
                location.reload();
            }else{
                if(response.error){
                    alert(response.message);
                }else{
                    alert("Item with ID " + id + " successfully deleted");
                    location.reload();
                }
            }
        })
    }
    </script>
@endif
@endsection