@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">

                <div class="displayuser-wraper">
                    <ul class="displayusers">

                        @foreach($users as $user)
                        <li class="oneuser" id="{{ $user->id }}">

                            <span class="pendingmessages"></span>

                            <div class="starmedia">
                                <div class="starmedia-left">
                                    <img src="{{ $user->image }}" class="media-objects" alt="">
                                </div>

                                <div class="starmedia-body">
                                    <p class="name">{{ $user->name }}</p>
                                    <p class="email">{{ $user->email }}</p>

                                </div>
                            </div>
                        </li>
                        @endforeach

                    </ul>
                </div>

            </div>

            <div class="col-md-8" id="communicationmessages">



            </div>
        </div>
    </div>
@endsection
