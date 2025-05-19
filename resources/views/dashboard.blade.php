@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Page Container START -->
<div class="page-container">     
    <!-- Content Wrapper START -->
    <div class="main-content">
        <div class="page-header no-gutters">
            <div class="d-md-flex align-items-md-center justify-content-between">
                <div class="media m-v-10 align-items-center">
                    <div class="avatar avatar-image avatar-lg">
                        <img src="{{ asset('images/avatars/avatar.png') }}" alt="">
                    </div>
                    <div class="media-body m-l-15">
                        <h4 class="m-b-0">Selamat datang, {{ Auth::user()->name }}</h4>
                        <span class="text-gray">{{ Auth::user()->role->name }}</span>
                    </div>
                </div>
                <div class="d-md-flex align-items-center d-none">
                    <div class="media align-items-center m-r-40 m-v-5">
                        <div class="font-size-27">
                            <i class="text-primary anticon anticon-check-circle"></i>
                        </div>
                        <div class="d-flex align-items-center m-l-10">
                            <h2 class="m-b-0 m-r-5">{{ $activeMember }}</h2>
                            <span class="text-gray">Member Aktif</span>
                        </div>
                    </div>
                    <div class="media align-items-center m-r-40 m-v-5">
                        <div class="font-size-27">
                            <i class="text-danger anticon anticon-close-circle"></i>
                        </div>
                        <div class="d-flex align-items-center m-l-10">
                            <h2 class="m-b-0 m-r-5">{{ $inactiveMember }}</h2>
                            <span class="text-gray">Tidak Aktif</span>
                        </div>
                    </div>
                    <div class="media align-items-center m-v-5">
                        <div class="font-size-27">
                            <i class="text-danger anticon anticon-team"></i>
                        </div>
                        <div class="d-flex align-items-center m-l-10">
                            <h2 class="m-b-0 m-r-5">{{ $countMember }}</h2>
                            <span class="text-gray">Member</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Project Completion </h5>
                            <div class="dropdown dropdown-animated scale-left">
                                <a class="text-gray font-size-18" href="javascript:void(0);" data-toggle="dropdown">
                                    <i class="anticon anticon-ellipsis"></i>
                                </a>
                                <div class="dropdown-menu">
                                    <button class="dropdown-item" type="button">
                                        <i class="anticon anticon-printer"></i>
                                        <span class="m-l-10">Print</span>
                                    </button>
                                    <button class="dropdown-item" type="button">
                                        <i class="anticon anticon-download"></i>
                                        <span class="m-l-10">Download</span>
                                    </button>
                                    <button class="dropdown-item" type="button">
                                        <i class="anticon anticon-file-excel"></i>
                                        <span class="m-l-10">Export</span>
                                    </button>
                                    <button class="dropdown-item" type="button">
                                        <i class="anticon anticon-reload"></i>
                                        <span class="m-l-10">Refresh</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="d-md-flex justify-content-space m-t-50">
                            <div class="completion-chart p-r-10">
                                <canvas class="chart" id="completion-chart"></canvas>
                            </div>
                            <div class="calendar-card border-0">
                                <div data-provide="datepicker-inline"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Team Members</h5>
                            <div>
                                <a href="" class="btn btn-default btn-sm">View All</a> 
                            </div>
                        </div>
                        <div class="m-t-30">
                            <div class="avatar-string m-l-5">
                                <a href="javascript:void(0);" data-toggle="tooltip" title="Erin Gonzales">
                                    <div class="avatar avatar-image team-member">
                                        <img src="{{ asset('images/avatars/thumb-1.jpg') }}" alt="">
                                    </div>
                                </a>
                                <a href="javascript:void(0);" data-toggle="tooltip" title="Darryl Day">
                                    <div class="avatar avatar-image team-member">
                                        <img src="{{ asset('images/avatars/thumb-2.jpg') }}" alt="">
                                    </div>
                                </a>
                                <a href="javascript:void(0);" data-toggle="tooltip" title="Marshall Nichols">
                                    <div class="avatar avatar-image team-member">
                                        <img src="{{ asset('images/avatars/thumb-3.jpg') }}" alt="">
                                    </div>
                                </a>
                                <a href="javascript:void(0);" data-toggle="tooltip" title="Virgil Gonzales">
                                    <div class="avatar avatar-image team-member">
                                        <img src="{{ asset('images/avatars/thumb-4.jpg') }}" alt="">
                                    </div>
                                </a>
                                <a href="javascript:void(0);" data-toggle="tooltip" title="Nicole Wyne">
                                    <div class="avatar avatar-image team-member">
                                        <img src="{{ asset('images/avatars/thumb-5.jpg') }}" alt="">
                                    </div>
                                </a>
                                <a href="javascript:void(0);" data-toggle="tooltip" title="Riley Newman">
                                    <div class="avatar avatar-image team-member">
                                        <img src="{{ asset('images/avatars/thumb-6.jpg') }}" alt="">
                                    </div>
                                </a>
                                <a href="javascript:void(0);" data-toggle="tooltip" title="Pamela Wanda">
                                    <div class="avatar avatar-image team-member">
                                        <img src="{{ asset('images/avatars/thumb-7.jpg') }}" alt="">
                                    </div>
                                </a>
                                <a href="javascript:void(0);" data-toggle="tooltip" title="Add Member">
                                    <div class="avatar avatar-icon avatar-blue team-member">
                                        <i class="anticon anticon-plus font-size-22"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
@endsection