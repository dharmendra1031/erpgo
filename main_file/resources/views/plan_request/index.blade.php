@extends('layouts.admin')
@section('page-title')
    {{__('Plan-Request')}}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{__('Plan Request')}}</h5>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" width="100%">
                            <tbody>
                            @if($plan_requests->count() > 0)
                                @foreach($plan_requests as $prequest)
                                    <tr>
                                        <td>
                                            <div class="font-style font-weight-bold">{{ $prequest->user->name }}</div>
                                        </td>
                                        <td>
                                            <div class="font-style font-weight-bold">{{ $prequest->plan->name }}</div>
                                        </td>
                                        <td>
                                            <div class="font-weight-bold">{{ $prequest->plan->max_users }}</div>
                                            <div>{{__('Users')}}</div>
                                        </td>
                                        <td>
                                            <div class="font-weight-bold">{{ $prequest->plan->max_clients }}</div>
                                            <div>{{__('Clients')}}</div>
                                        </td>
                                        <td>
                                            <div class="font-style font-weight-bold">{{ ($prequest->duration == 'monthly') ? __('One Month') : __('One Year') }}</div>
                                        </td>
                                        <td>{{ Utility::getDateFormated($prequest->created_at,true) }}</td>
                                        <td>
                                            <div>
                                                <form method="POST" action="{{route('response.request',[$prequest->id,1])}}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-xs"><i class="fas fa-check"></i></button>
                                                </form>
                                                <form method="POST" action="{{route('response.request',[$prequest->id,0])}}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-xs"><i class="fas fa-times"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <th scope="col" colspan="7"><h6 class="text-center">{{__('No Manually Plan Request Found.')}}</h6></th>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
