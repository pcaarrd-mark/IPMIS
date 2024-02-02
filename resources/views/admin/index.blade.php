@extends('admin.template.master')

@section('content')
<div class="row">
    @include('admin.template.filemenu')
    <div class="col-lg-9">
        <div class="card card-transparent file-list recent-files">
            <div class="card-body">
                <h5 class="card-title">RECENT FILES</h5>
                <div class="row">
                    <div class="col-lg-6 col-xl-3">
                        <div class="card file photo">
                            <div class="file-options dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">View Details</a>
                                    <a class="dropdown-item" href="#">Mark as Important</a>
                                    <a class="dropdown-item" href="#">Move To</a>
                                    <a class="dropdown-item" href="#">Copy To</a>
                                    <a class="dropdown-item" href="#">Rename</a>
                                    <a class="dropdown-item" href="#">Download</a>
                                    <div class="divider"></div>
                                    <a class="dropdown-item" href="#">Delete</a>
                                </div>
                            </div>
                            <div class="card-header file-icon">
                                <i class="material-icons">photo</i>
                            </div>
                            <div class="card-body file-info">
                                <p>IMG_08719.jpg</p>
                                <span class="file-size">657.9kb</span><br>
                                <span class="file-date">Last Accessed: 17min ago</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-3">
                        <div class="card file pdf">
                            <div class="file-options dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">View Details</a>
                                    <a class="dropdown-item" href="#">Mark as Important</a>
                                    <a class="dropdown-item" href="#">Move To</a>
                                    <a class="dropdown-item" href="#">Copy To</a>
                                    <a class="dropdown-item" href="#">Rename</a>
                                    <a class="dropdown-item" href="#">Download</a>
                                    <div class="divider"></div>
                                    <a class="dropdown-item" href="#">Delete</a>
                                </div>
                            </div>
                            <div class="card-header file-icon">
                                <i class="material-icons">description</i>
                            </div>
                            <div class="card-body file-info">
                                <p>Lease_05.pdf</p>
                                <span class="file-size">17.5kb</span><br>
                                <span class="file-date">Last Accessed: 2 hours ago</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-3">
                        <div class="card file code">
                            <div class="file-options dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">View Details</a>
                                    <a class="dropdown-item" href="#">Mark as Important</a>
                                    <a class="dropdown-item" href="#">Move To</a>
                                    <a class="dropdown-item" href="#">Copy To</a>
                                    <a class="dropdown-item" href="#">Rename</a>
                                    <a class="dropdown-item" href="#">Download</a>
                                    <div class="divider"></div>
                                    <a class="dropdown-item" href="#">Delete</a>
                                </div>
                            </div>
                            <div class="card-header file-icon">
                                <i class="material-icons">code</i>
                            </div>
                            <div class="card-body file-info">
                                <p>user_info.java</p>
                                <span class="file-size">12.7kb</span><br>
                                <span class="file-date">Last Accessed: 6 hours ago</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-3">
                        <div class="card file audio">
                            <div class="file-options dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">View Details</a>
                                    <a class="dropdown-item" href="#">Mark as Important</a>
                                    <a class="dropdown-item" href="#">Move To</a>
                                    <a class="dropdown-item" href="#">Copy To</a>
                                    <a class="dropdown-item" href="#">Rename</a>
                                    <a class="dropdown-item" href="#">Download</a>
                                    <div class="divider"></div>
                                    <a class="dropdown-item" href="#">Delete</a>
                                </div>
                            </div>
                            <div class="card-header file-icon">
                                <i class="material-icons">volume_up</i>
                            </div>
                            <div class="card-body file-info">
                                <p>music_1.mp3</p>
                                <span class="file-size">37.4mb</span><br>
                                <span class="file-date">Last Accessed: 7 hours ago</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-transparent file-list">
            <div class="card-body">
                <h5 class="card-title">FOLDERS</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card folder">
                            <div class="file-options dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">View Details</a>
                                    <a class="dropdown-item" href="#">Mark as Important</a>
                                    <a class="dropdown-item" href="#">Move To</a>
                                    <a class="dropdown-item" href="#">Copy To</a>
                                    <a class="dropdown-item" href="#">Rename</a>
                                    <a class="dropdown-item" href="#">Download</a>
                                    <div class="divider"></div>
                                    <a class="dropdown-item" href="#">Delete</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="folder-icon">
                                    <i class="material-icons">folder_open</i>
                                </div>
                                <div class="folder-info">
                                    <a href="#">Photos</a>
                                    <span>87 files, 417mb</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card folder">
                            <div class="file-options dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">View Details</a>
                                    <a class="dropdown-item" href="#">Mark as Important</a>
                                    <a class="dropdown-item" href="#">Move To</a>
                                    <a class="dropdown-item" href="#">Copy To</a>
                                    <a class="dropdown-item" href="#">Rename</a>
                                    <a class="dropdown-item" href="#">Download</a>
                                    <div class="divider"></div>
                                    <a class="dropdown-item" href="#">Delete</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="folder-icon">
                                    <i class="material-icons">folder_open</i>
                                </div>
                                <div class="folder-info">
                                    <a href="#">Loan Application</a>
                                    <span>209 files, 56mb</span>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection