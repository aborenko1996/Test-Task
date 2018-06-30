@extends('layouts.app')
@section('title', 'View Shipment')
@section('content')
<h1 class="text-center">View Shipment with ID {{$shipment['id']}}</h1>
<hr/>
<a href="{{url('shipment')}}" class="btn btn-primary">< Back</a>
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
            <td class="text-center">{{$shipment['id']}}</td>
            <td class="text-center">{{$shipment['name']}}</td>
            <td class="text-center">{{$shipment['is_send']}}</td>
            <td class="text-center">{{$shipment['last_sended_at']}}</td>
            <td class="text-center">{{$shipment['created_at']}}</td>
            <td class="text-center">{{$shipment['updated_at']}}</td>
            <td>
            <a href="{{url('shipment/' . $shipment['id'] . '/edit')}}" class="btn btn-primary">Edit</a>
                <a onclick="DeleteShipment({{$shipment['id']}})" class="btn btn-danger">Delete</a>
                <a onclick="SendShipment({{$shipment['id']}})" class="btn btn-success">Send</a>
            </td>
        </tr>
        @if($shipment['items'])
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
            @foreach ($shipment['items'] as $item)
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
            if(response.error){
                alert(response.message);
            }else{
                alert("Shipment with ID " + id + " successfully deleted");
                window.location = "{{url('shipment')}}";
            }
        })
    }
    
    function SendShipment(id){
        $.ajax({
            url: '{{url('shipment')}}' + '/' + id + '/send',
            method: 'post',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        }).then(function(response){
            if(response.error){
                alert(response.message);
            }else{
                alert("Shipment with ID " + id + " successfully sent");
                location.reload();
            }
        })
    }

    function DeleteItem(id){
        $.ajax({
            url: '{{url('item')}}' + '/' + id,
            method: 'delete',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        }).then(function(response){
            if(response.error){
                alert(response.message);
            }else{
                alert("Item with ID " + id + " successfully deleted");
                window.location = "{{url('shipment')}}";
            }
        })
    }
    </script>
@endsection