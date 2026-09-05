<div class="card bg-none card-box">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="info text-sm">
                <strong>{{__('Branch')}} : </strong>
                <span>{{ !empty($appraisal->branches)?$appraisal->branches->name:'' }}</span>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="info text-sm font-style">
                <strong>{{__('Employee')}} : </strong>
                <span>{{!empty($appraisal->employees)?$appraisal->employees->name:'' }}</span>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="info text-sm font-style">
                <strong>{{__('Appraisal Date')}} : </strong>
                <span>{{$appraisal->appraisal_date }}</span>
            </div>
        </div>
    </div>

    @foreach($performance as $performances)

    <div class="row">
        <div class="col-md-12 mt-3">
            <h6>{{$performances->name}}</h6>
            <hr class="mt-0">
        </div>
        @foreach($performances->types as $types )

            <div class="col-6">
                {{$types->name}}
            </div>
            <div class="col-6">
                <fieldset id='demo1' class="rating">
                    <input class="stars" type="radio" id="technical-5-{{$types->id}}" name="rating[{{$types->id}}]" value="5" {{ (isset($ratings[$types->id]) && $ratings[$types->id] == 5)? 'checked':''}} disabled>
                    <label class="full" for="technical-5-{{$types->id}}" title="Awesome - 5 stars"></label>
                    <input class="stars" type="radio" id="technical-4-{{$types->id}}" name="rating[{{$types->id}}]" value="4" {{ (isset($ratings[$types->id]) && $ratings[$types->id] == 4)? 'checked':''}} disabled>
                    <label class="full" for="technical-4-{{$types->id}}" title="Pretty good - 4 stars"></label>
                    <input class="stars" type="radio" id="technical-3-{{$types->id}}" name="rating[{{$types->id}}]" value="3" {{ (isset($ratings[$types->id]) && $ratings[$types->id] == 3)? 'checked':''}} disabled>
                    <label class="full" for="technical-3-{{$types->id}}" title="Meh - 3 stars"></label>
                    <input class="stars" type="radio" id="technical-2-{{$types->id}}" name="rating[{{$types->id}}]" value="2" {{ (isset($ratings[$types->id]) && $ratings[$types->id] == 2)? 'checked':''}} disabled>
                    <label class="full" for="technical-2-{{$types->id}}" title="Kinda bad - 2 stars"></label>
                    <input class="stars" type="radio" id="technical-1-{{$types->id}}" name="rating[{{$types->id}}]" value="1" {{ (isset($ratings[$types->id]) && $ratings[$types->id] == 1)? 'checked':''}} disabled>
                    <label class="full" for="technical-1-{{$types->id}}" title="Sucks big time - 1 star"></label>
                </fieldset>
            </div>
        @endforeach
    </div>
    @endforeach



{{--    <div class="row">--}}
{{--        <div class="col-md-12 mt-3">--}}
{{--            <h6>{{__('Organizational Competencies')}}</h6>--}}
{{--            <hr class="mt-0">--}}
{{--        </div>--}}
{{--        @foreach($organizationals as $organizational )--}}
{{--            <div class="col-6">--}}
{{--                {{$organizational->name}}--}}
{{--            </div>--}}
{{--            <div class="col-6">--}}
{{--                <fieldset id='demo1' class="rating">--}}
{{--                    <input class="stars" type="radio" id="technical-5-{{$organizational->id}}" name="rating[{{$organizational->id}}]" value="5" {{ (isset($ratings[$organizational->id]) && $ratings[$organizational->id] == 5)? 'checked':''}} disabled>--}}
{{--                    <label class="full" for="technical-5-{{$organizational->id}}" title="Awesome - 5 stars"></label>--}}
{{--                    <input class="stars" type="radio" id="technical-4-{{$organizational->id}}" name="rating[{{$organizational->id}}]" value="4" {{ (isset($ratings[$organizational->id]) && $ratings[$organizational->id] == 4)? 'checked':''}} disabled>--}}
{{--                    <label class="full" for="technical-4-{{$organizational->id}}" title="Pretty good - 4 stars"></label>--}}
{{--                    <input class="stars" type="radio" id="technical-3-{{$organizational->id}}" name="rating[{{$organizational->id}}]" value="3" {{ (isset($ratings[$organizational->id]) && $ratings[$organizational->id] == 3)? 'checked':''}} disabled>--}}
{{--                    <label class="full" for="technical-3-{{$organizational->id}}" title="Meh - 3 stars"></label>--}}
{{--                    <input class="stars" type="radio" id="technical-2-{{$organizational->id}}" name="rating[{{$organizational->id}}]" value="2" {{ (isset($ratings[$organizational->id]) && $ratings[$organizational->id] == 2)? 'checked':''}} disabled>--}}
{{--                    <label class="full" for="technical-2-{{$organizational->id}}" title="Kinda bad - 2 stars"></label>--}}
{{--                    <input class="stars" type="radio" id="technical-1-{{$organizational->id}}" name="rating[{{$organizational->id}}]" value="1" {{ (isset($ratings[$organizational->id]) && $ratings[$organizational->id] == 1)? 'checked':''}} disabled>--}}
{{--                    <label class="full" for="technical-1-{{$organizational->id}}" title="Sucks big time - 1 star"></label>--}}
{{--                </fieldset>--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--    </div>--}}
{{--    <div class="row">--}}
{{--        <div class="col-md-12 mt-3">--}}
{{--            <h6>{{__('Behavioural Competencies')}}</h6>--}}
{{--            <hr class="mt-0">--}}
{{--        </div>--}}
{{--        @foreach($behaviourals as $behavioural )--}}
{{--            <div class="col-6">--}}
{{--                {{$behavioural->name}}--}}
{{--            </div>--}}
{{--            <div class="col-6">--}}
{{--                <fieldset id='demo1' class="rating">--}}
{{--                    <input class="stars" type="radio" id="technical-5-{{$behavioural->id}}" name="rating[{{$behavioural->id}}]" value="5" {{ (isset($ratings[$behavioural->id]) && $ratings[$behavioural->id] == 5)? 'checked':''}} disabled>--}}
{{--                    <label class="full" for="technical-5-{{$behavioural->id}}" title="Awesome - 5 stars"></label>--}}
{{--                    <input class="stars" type="radio" id="technical-4-{{$behavioural->id}}" name="rating[{{$behavioural->id}}]" value="4" {{ (isset($ratings[$behavioural->id]) && $ratings[$behavioural->id] == 4)? 'checked':''}} disabled>--}}
{{--                    <label class="full" for="technical-4-{{$behavioural->id}}" title="Pretty good - 4 stars"></label>--}}
{{--                    <input class="stars" type="radio" id="technical-3-{{$behavioural->id}}" name="rating[{{$behavioural->id}}]" value="3" {{ (isset($ratings[$behavioural->id]) && $ratings[$behavioural->id] == 3)? 'checked':''}} disabled>--}}
{{--                    <label class="full" for="technical-3-{{$behavioural->id}}" title="Meh - 3 stars"></label>--}}
{{--                    <input class="stars" type="radio" id="technical-2-{{$behavioural->id}}" name="rating[{{$behavioural->id}}]" value="2" {{ (isset($ratings[$behavioural->id]) && $ratings[$behavioural->id] == 2)? 'checked':''}} disabled>--}}
{{--                    <label class="full" for="technical-2-{{$behavioural->id}}" title="Kinda bad - 2 stars"></label>--}}
{{--                    <input class="stars" type="radio" id="technical-1-{{$behavioural->id}}" name="rating[{{$behavioural->id}}]" value="1" {{ (isset($ratings[$behavioural->id]) && $ratings[$behavioural->id] == 1)? 'checked':''}} disabled>--}}
{{--                    <label class="full" for="technical-1-{{$behavioural->id}}" title="Sucks big time - 1 star"></label>--}}
{{--                </fieldset>--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--    </div>--}}

    <div class="row">
        <div class="col-md-12">
            <hr>
            <h6>{{__('Remark')}}</h6>
        </div>
        <div class="col-md-12 mt-3">
            <p class="text-sm">{{$appraisal->remark }}</p>
        </div>
    </div>

</div>
