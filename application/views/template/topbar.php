<?php
	$photo = !empty($this->session->userdata('photo'))?$this->session->userdata('photo'):'default.jpg';
	//var_dump($this->session->userdata('photo'));die;
?>
</head>
<body class="skin-blue">
    <!-- Site wrapper -->
    <div class="wrapper">

        <header class="main-header">
            <a href="#" class="logo"><img width="200px" height="45px" src="<?php echo base_url('assets/alesa.jpg')?>"></a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?php echo base_url('assets/user_img/'.$photo) ?>" class="user-image" alt="User Image"/>
                                <span class="hidden-xs"><?php echo $this->session->userdata('fullname')?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
								
                                <li class="user-header">
                                    <img src="<?php echo base_url('assets/user_img/'.$photo) ?>" class="img-circle" alt="User Image" />
                                    <p>
                                       <?php echo $this->session->userdata('fullname')?> - <?php echo $this->session->userdata('level_name')?>
                                       
                                    </p>
                                </li>
                                <!-- Menu Body 
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>-->
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?php echo site_url('user/profile/'. $this->session->userdata('user_id'))?>" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo site_url('auth/logout') ?>" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- =============================================== -->