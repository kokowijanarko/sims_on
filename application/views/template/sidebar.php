<?php
	$photo = !empty($this->session->userdata('photo'))?$this->session->userdata('photo'):'default.jpg';
	//var_dump($photo);die;
?>
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo base_url('assets/user_img/'.$photo) ?>" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p><?php echo $this->session->userdata('fullname')?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Logged In</a>
            </div>
        </div>
        <!-- search form 
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                    <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>-->
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN MENU</li>
            <li id="menu_dashboard" class="treeview">
                <a href="<?php  echo site_url('dashboard')?>">
                    <i class="fa fa-dashboard"></i> 
					<span>Home</span>
                </a>
            </li>
            <li id="menu_inventory" class="treeview">
                <a href="<?php echo site_url('inventory')?>">
                    <i class="fa fa-files-o"></i>
                    <span>Produk</span>
                </a>
                
            </li>
			<li id="menu_cashier" class="treeview">
                <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>Kasir</span><i class="fa fa-angle-left pull-right"></i>
                </a>
				<ul id="child_menu_cashier" class="treeview-menu">
                    <li id="child_menu_cashier_buat_order"><a href="<?php echo site_url('cashier')?>"><i class="fa fa-circle-o"></i>Buat Order</a></li>
                    <li id="child_menu_cashier_daftar_customer"><a href="<?php echo site_url('customer') ?>"><i class="fa fa-circle-o"></i>Daftar Customer</a></li>
                </ul>
            </li>
			<li id="menu_report" class="treeview">
                <a href="<?php echo site_url('#')?>">
					<i class="fa fa-files-o"></i> <span>Laporan</span><i class="fa fa-angle-left pull-right"></i>
                </a>       
				<ul id="child_menu_report" class="treeview-menu">
                    <li id="child_menu_report_laporan_harian"><a href="<?php echo site_url('report/daily_list') ?>"><i class="fa fa-circle-o"></i>Laporan penjualan</a></li>
                </ul>
            </li>
			<li id="menu_user" class="treeview">
                <a href="<?php echo site_url('#')?>">
					<i class="fa fa-files-o"></i> <span>Pembelian</span><i class="fa fa-angle-left pull-right"></i>
                </a>       
				<ul id="child_menu_user" class="treeview-menu">
                    <li id="child_menu_report_daftar_user"><a href="<?php echo site_url('pembelian') ?>"><i class="fa fa-circle-o"></i>Daftar Pembelian</a></li>
                    <li id="child_menu_report_daftar_user"><a href="<?php echo site_url('supplier') ?>"><i class="fa fa-circle-o"></i>Daftar Supplier</a></li>
                </ul>
            </li>
			
			<li id="menu_user" class="treeview">
                <a href="<?php echo site_url('#')?>">
					<i class="fa fa-files-o"></i> <span>Pengguna</span><i class="fa fa-angle-left pull-right"></i>
                </a>       
				<ul id="child_menu_user" class="treeview-menu">
                    <li id="child_menu_report_daftar_user"><a href="<?php echo site_url('user') ?>"><i class="fa fa-circle-o"></i>Daftar Pengguna</a></li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<!-- =============================================== -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
