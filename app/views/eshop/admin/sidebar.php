<!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->

<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">

            <p class="centered"><a href="profile.html"><img src="<?= ASSETS . THEME ?>admin/img/ui-sam.jpg" class="img-circle" width="60"></a></p>
            <h5 class="centered"><?= $data['user_data']->name ?></h5>
            <h5 class="centered" style="font-size: 11px;"><?= $data['user_data']->email ?></h5>

            <!-- Dashboard -->
            <li class="sub-menu">
                <a <?= (isset($current_page) && $current_page == "dashboard") ? ' class="active" ': ''; ?> href="<?= ROOT ?>admin/dashboard:;">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Products -->
            <li class="sub-menu">
                <a <?= (isset($current_page) && $current_page == "products") ? ' class="active" ': ''; ?> href="<?= ROOT ?>admin/products">
                    <i class="fa fa-barcode"></i>
                    <span>Products</span>
                </a>
                
            </li>

            <!-- Categories -->
            <li class="sub-menu">
                <a <?= (isset($current_page) && $current_page == "categories") ? ' class="active" ': ''; ?> href="<?= ROOT ?>admin/categories">
                    <i class="fa fa-list-alt"></i>
                    <span>Categories</span>
                </a>
            </li>

            <!-- Orders -->
            <li class="sub-menu">
                <a <?= (isset($current_page) && $current_page == "orders") ? ' class="active" ': ''; ?> href="<?= ROOT ?>admin/orders">
                    <i class="fa fa-reorder"></i>
                    <span>Orders</span>
                </a>
            </li>

            
            <!-- Messages -->
            <li class="sub-menu">
                <a <?= (isset($current_page) && $current_page == "messages") ? ' class="active" ': ''; ?> href="<?= ROOT ?>admin/messages">
                    <i class="fa fa-envelope"></i>
                    <span>Messages</span>
                </a>
            </li>

            <!-- Blogs -->
            <li class="sub-menu">
                <a <?= (isset($current_page) && $current_page == "blogs") ? ' class="active" ': ''; ?> href="<?= ROOT ?>admin/blogs">
                    <i class="fa fa-rss"></i>
                    <span>Blog Posts</span>
                </a>
            </li>

            <!-- Settings -->
            <li class="sub-menu">
                <a <?= (isset($current_page) && $current_page == "settings") ? ' class="active" ': ''; ?> href="<?= ROOT ?>admin/settings">
                    <i class="fa fa-cogs"></i>
                    <span>Settings</span>
                </a>
                <ul class="sub">
                    <li><a href="<?= ROOT ?>admin/settings/slider_images">Slider Images</a></li>
                </ul>
                <ul class="sub">
                    <li><a href="<?= ROOT ?>admin/settings/socials">Social Links</a></li>
                </ul>
            </li>

            <!-- Divider -->
            <li style="margin-top: 15px; margin-bottom: 15px;">
                <hr style="border-color:rgb(124, 124, 124); margin: 0;">
            </li>

            <!-- Users -->
            <li class="sub-menu">
                <a <?= (isset($current_page) && $current_page == "users") ? ' class="active" ': ''; ?> href="<?= ROOT ?>admin/users">
                    <i class="fa fa-user"></i>
                    <span>Users</span>
                </a>
                <ul class="sub">
                    <li><a href="<?= ROOT ?>admin/users/customers">Customers</a></li>
                    <li><a href="<?= ROOT ?>admin/users/admins">Admins</a></li>
                </ul>
            </li>

            <li class="sub-menu">
                <a href="<?= ROOT ?>admin/backup">
                    <i class="fa fa-hdd-o"></i>
                    <span>Website Backup</span>
                </a>
            </li>

        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->

<!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          	<h3><i class="fa fa-angle-right"></i><?= $data['page_title'] ?></h3>
          	<div class="row mt">
          		<div class="col-lg-12">