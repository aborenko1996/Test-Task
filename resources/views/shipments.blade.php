@extends('layouts.app')
@section('title', 'Shipments')
@section('content')
    <h1 class="text-center">Shipment List</h1>
    <hr/>
    <a href="{{url('shipment/create')}}" class="btn btn-primary">Add shipment</a>
    <a href="{{url('item/create')}}" class="btn btn-primary">Add item</a>
    <hr/>
    <table class="table table-bordered text-center">
        <tbody>
            @foreach ($shipments as $shipment)
                <tr>
                    <td colspan="4"><strong>Shipment {{$shipment['id']}}</strong></td>
                </tr>
                <tr>
                    <td class="bg-success">ID: {{$shipment['id']}}</td>
                    <td class="bg-success" colspan="2">Name: {{$shipment['name']}}</td>
                    <td><a href="{{url('shipment/' . $shipment['id'])}}" class="btn btn-primary">View</a> <a href="{{url('shipment/' . $shipment['id'] . '/edit')}}" class="btn btn-primary">Edit</a> <a onclick="DeleteShipment({{$shipment['id']}})" class="btn btn-danger">Delete</a> <a onclick="SendShipment({{$shipment['id']}})" class="btn btn-success">Send</a></td>
                </tr>
                @if($shipment['items'])
                        <tr>
                            <td colspan="4"><strong>Items</strong></td>
                        </tr>
                        @foreach ($shipment['items'] as $item)
                            <tr>
                                <td class="bg-primary">ID: {{$item['id']}}</td>
                                <td class="bg-primary">Name: {{$item['name']}}</td>
                                <td class="bg-primary">Code: {{$item['code']}}</td>
                                <td>
                                    <a class="btn btn-primary" href="{{url('item/' . $item['id'])}}">View</a>
                                    <a class="btn btn-primary" href="{{url('item/' . $item['id'] . '/edit')}}">Edit</a>
                                    <a class="btn btn-danger" onclick="DeleteItem({{$item['id']}})">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                @endif
            @endforeach
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
                if(response.expired) window.location = "{{url('login')}}";
            }else{
                alert("Shipment with ID " + id + " successfully deleted");
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
                if(response.expired) window.location = "{{url('login')}}";
            }else{
                alert("Item with ID " + id + " successfully deleted");
                location.reload();
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
                if(response.expired) window.location = "{{url('login')}}";
            }else{
                alert("Shipment with ID " + id + " successfully sent");
                location.reload();
            }
        })
    }
    </script>
@endsection