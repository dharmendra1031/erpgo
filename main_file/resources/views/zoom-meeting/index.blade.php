@extends('layouts.admin')
@section('page-title')
    {{__('Manage Zoom Meeting')}}
@endsection

@push('css-page')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/daterangepicker.css')}}">
@endpush

@push('script-page')
    <script src="{{url('assets/js/daterangepicker.js')}}"></script>
    <script type="text/javascript">

        $(document).on("click", '.member_remove', function () {
            var rid = $(this).attr('data-id');
            $('.confirm_yes').addClass('m_remove');
            $('.confirm_yes').attr('uid', rid);
            $('#cModal').modal('show');
        });
        $(document).on('click', '.m_remove', function (e) {
            var id = $(this).attr('uid');
            var p_url = "{{url('zoom-meeting')}}"+'/'+id;
            var data = {id: id};
            deleteAjax(p_url, data, function (res) {
                toastrs(res.flag, res.msg);
                if(res.flag == 1){
                    location.reload();
                }
                $('#cModal').modal('hide');
            });
        });
    </script>
@endpush


@section('action-button')
    <div class="all-button-box row d-flex justify-content-end">
        @can('create constant category')
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                <a href="{{ route('zoom-meeting.calender') }}"  data-original-title="{{__('Calender View')}}" class="btn btn-xs btn-white btn-icon-only width-auto">
                    <i class="fas fa-calendar"></i> {{__('Calender View')}}
                </a>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                <a href="#" data-url="{{ route('zoom-meeting.create') }}" data-ajax-popup="true" data-title="{{__('Create New Meeting')}}" class="btn btn-xs btn-white btn-icon-only width-auto">
                    <i class="fas fa-plus"></i> {{__('Create')}}
                </a>
            </div>
        @endcan
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body py-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 dataTable">
                            <thead>
                            <tr>
                                <th> {{ __('Title') }} </th>
                                <th> {{ __('Project') }}  </th>
                                <th> {{ __('User') }}  </th>
                                <th> {{ __('Client') }}  </th>
                                <th >{{ __('Meeting Time') }}</th>
                                <th >{{ __('Duration') }}</th>
                                <th >{{ __('Join URL') }}</th>
                                <th >{{ __('Status') }}</th>
                                <th class="text-right"> {{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>

                            @forelse ($meetings as $item)

                                <tr>
                                    <td>{{$item->title}}</td>
                                    <td>{{ !empty($item->projectName)?$item->projectName:'' }}</td>
{{--                                    <td>{{ !empty($item->userName)?$item->userName->name:'' }}</td>--}}
                                <td>
                                    <div class="avatar-group">
                                        @foreach($item->users($item->user_id) as $projectUser)
                                            <a href="#" class="avatar rounded-circle avatar-sm avatar-group">
                                                <img alt="" @if(!empty($users->avatar)) src="{{$profile.'/'.$projectUser->avatar}}" @else  avatar="{{(!empty($projectUser)?$projectUser->name:'')}}" @endif data-original-title="{{(!empty($projectUser)?$projectUser->name:'')}}" data-toggle="tooltip" data-original-title="{{(!empty($projectUser)?$projectUser->name:'')}}" class="">
                                            </a>
                                        @endforeach
                                    </div>

                                </td>


                                @if(\Auth::user()->type == 'company')
                                        <td>{{$item->client_name}}</td>
                                    @endif
                                    <td>{{$item->start_date}}</td>
                                    <td>{{$item->duration}} {{__("Minutes")}}</td>

                                    <td>
                                        @if($item->created_by == \Auth::user()->id && $item->checkDateTime())

                                            <a href="{{$item->start_url}}" target="_blank"> {{__('Start meeting')}} <i class="fas fa-external-link-square-alt "></i></a>
                                        @elseif($item->checkDateTime())
                                            <a href="{{$item->join_url}}" target="_blank"> {{__('Join meeting')}} <i class="fas fa-external-link-square-alt "></i></a>
                                        @else
                                            -
                                        @endif

                                    </td>
                                    <td>
                                        @if($item->checkDateTime())
                                            @if($item->status == 'waiting')
                                                <span class="badge badge-info">{{ucfirst($item->status)}}</span>
                                            @else
                                                <span class="badge badge-success">{{ucfirst($item->status)}}</span>
                                            @endif
                                        @else
                                            <span class="badge badge-danger">{{__("End")}}</span>
                                        @endif
                                    </td>
                                    @if(\Auth::user()->type == 'company')
                                        <td class="text-right">
                                            <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$item->id}}').submit();"><i class="fas fa-trash"></i></a>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['zoom-meeting.destroy', $item->id],'id'=>'delete-form-'.$item->id]) !!}
                                            {!! Form::close() !!}

                                        </td>
                                    @endif
                                </tr>
                            @empty

                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


