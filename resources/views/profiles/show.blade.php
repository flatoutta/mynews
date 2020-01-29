@extends('layouts.front')

@section('content')
    <div class="container">        
        <div class="row">
            <div class="posts col-md-8 mx-auto mt-3">
                <div class="post">
                    <div class="row">
                        <div class="text col-md-6">
                            <div class="name">
                                {{ $profile->name }}
                            </div>
                            <div class="gender">
                                {{ str_limit($profile->gender, 150) }}
                            </div>
                            <div class="body mt-3">
                                {{ str_limit($profile->hobby, 150) }}
                            </div>
                            <div class="body mt-3">
                                {{ str_limit($profile->introduction, 500) }}
                            </div>
                            
                       </div>                            
                    </div>
                </div>
                <hr color="#c0c0c0">
            </div>
        </div>
    </div>
@endsection