<?php include '../smadmin/view_header.php'; ?>
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
            <li>
                <a href="index.html">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-laptop"></i>
                    <span>Layouts</span>
                </a>
                <ul class="sub">
                    <li><a href="boxed_page.html">Boxed Page</a></li>
                    <li><a href="horizontal_menu.html">Horizontal Menu</a></li>
                    <li><a href="language_switch.html">Language Switch Bar</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-book"></i>
                    <span>UI Elements</span>
                </a>
                <ul class="sub">
                    <li><a href="general.html">General</a></li>
                    <li><a href="buttons.html">Buttons</a></li>
                    <li><a href="widget.html">Widget</a></li>
                    <li><a href="slider.html">Slider</a></li>
                    <li><a href="tree_view.html">Tree View</a></li>
                    <li><a href="nestable.html">Nestable</a></li>
                    <li><a href="grids.html">Grids</a></li>
                    <li><a href="calendar.html">Calender</a></li>
                    <li><a href="draggable_portlet.html">Draggable Portlet</a></li>
                </ul>
            </li>
            <li>
                <a href="fontawesome.html">
                    <i class="fa fa-bullhorn"></i>
                    <span>Fontawesome </span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-th"></i>
                    <span>Data Tables</span>
                </a>
                <ul class="sub">
                    <li><a href="basic_table.html">Basic Table</a></li>
                    <li><a href="responsive_table.html">Responsive Table</a></li>
                    <li><a href="dynamic_table.html">Dynamic Table</a></li>
                    <li><a href="editable_table.html">Editable Table</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;" class="active">
                    <i class="fa fa-tasks"></i>
                    <span>Form Components</span>
                </a>
                <ul class="sub">
                    <li class="active"><a href="form_component.html">Form Elements</a></li>
                    <li><a href="advanced_form.html">Advanced Components</a></li>
                    <li><a href="form_wizard.html">Form Wizard</a></li>
                    <li><a href="form_validation.html">Form Validation</a></li>
                    <li><a href="file_upload.html">Muliple File Upload</a></li>
                    <li><a href="dropzone.html">Dropzone</a></li>
                </ul>
            </li>
            <li>
                <a href="mail.html">
                    <i class="fa fa-envelope"></i>
                    <span>Mail </span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class=" fa fa-bar-chart-o"></i>
                    <span>Charts</span>
                </a>
                <ul class="sub">
                    <li><a href="morris.html">Morris</a></li>
                    <li><a href="chartjs.html">Chartjs</a></li>
                    <li><a href="flot_chart.html">Flot Charts</a></li>
                    <li><a href="c3_chart.html">C3 Chart</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class=" fa fa-bar-chart-o"></i>
                    <span>Maps</span>
                </a>
                <ul class="sub">
                    <li><a href="google_map.html">Google Map</a></li>
                    <li><a href="vector_map.html">Vector Map</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-glass"></i>
                    <span>Extra</span>
                </a>
                <ul class="sub">
                    <li><a href="blank.html">Blank Page</a></li>
                    <li><a href="lock_screen.html">Lock Screen</a></li>
                    <li><a href="profile.html">Profile</a></li>
                    <li><a href="invoice.html">Invoice</a></li>
                    <li><a href="pricing_table.html">Pricing Table</a></li>
                    <li><a href="timeline.html">Timeline</a></li>
                    <li><a href="404.html">404 Error</a></li>
                    <li><a href="500.html">500 Error</a></li>
                    <li><a href="registration.html">Registration</a></li>
                </ul>
            </li>
            <li>
                <a href="login.html">
                    <i class="fa fa-user"></i>
                    <span>Login Page</span>
                </a>
            </li>
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
    <!--main content start-->
    <section id="main-content" class="">
        <section class="wrapper">
        <!-- page start-->
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Basic Forms
                        </header>
                        <div class="panel-body">
                            <div class="position-center">
                                <form role="form">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">File input</label>
                                    <input type="file" id="exampleInputFile">
                                    <p class="help-block">Example block-level help text here.</p>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"> Check me out
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-info">Submit</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Horizontal Forms
                    </header>
                    <div class="panel-body">
                        <div class="position-center">
                            <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Email</label>
                                <div class="col-lg-10">
                                    <input type="email" class="form-control" id="inputEmail1" placeholder="Email">
                                    <p class="help-block">Example block-level help text here.</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword1" class="col-lg-2 col-sm-2 control-label">Password</label>
                                <div class="col-lg-10">
                                    <input type="password" class="form-control" id="inputPassword1" placeholder="Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Remember me
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button type="submit" class="btn btn-danger">Sign in</button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </section>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Inline form
                    </header>
                    <div class="panel-body">
                        <div class="position-center">
                            <form class="form-inline" role="form">
                            <div class="form-group">
                                <label class="sr-only" for="exampleInputEmail2">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="exampleInputPassword2">Password</label>
                                <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password">
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> Remember me
                                </label>
                            </div>
                            <button type="submit" class="btn btn-success">Sign in</button>
                        </form>
                        </div>
                    </div>
                </section>

            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Modal form
                    </header>
                    <div class="panel-body">
                        <div class="position-center ">
                            <div class="text-center">
                                <a href="#myModal" data-toggle="modal" class="btn btn-success">
                                    Form in Modal
                                </a>
                                <a href="#myModal-1" data-toggle="modal" class="btn btn-warning">
                                    Form in Modal 2
                                </a>
                                <a href="#myModal-2" data-toggle="modal" class="btn btn-danger">
                                    Form in Modal 3
                                </a>
                            </div>

                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title">Form Tittle</h4>
                                    </div>
                                    <div class="modal-body">

                                        <form role="form">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Enter email">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Password</label>
                                                <input type="password" class="form-control" id="exampleInputPassword3" placeholder="Password">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputFile">File input</label>
                                                <input type="file" id="exampleInputFile3">
                                                <p class="help-block">Example block-level help text here.</p>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox"> Check me out
                                                </label>
                                            </div>
                                            <button type="submit" class="btn btn-default">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal-1" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title">Form Tittle</h4>
                                    </div>
                                    <div class="modal-body">

                                        <form class="form-horizontal" role="form">
                                            <div class="form-group">
                                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Email</label>
                                                <div class="col-lg-10">
                                                    <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputPassword1" class="col-lg-2 col-sm-2 control-label">Password</label>
                                                <div class="col-lg-10">
                                                    <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-offset-2 col-lg-10">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox"> Remember me
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-offset-2 col-lg-10">
                                                    <button type="submit" class="btn btn-default">Sign in</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>

                                </div>
                            </div>
                        </div>
                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal-2" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title">Form Tittle</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-inline" role="form">
                                            <div class="form-group">
                                                <label class="sr-only" for="exampleInputEmail2">Email address</label>
                                                <input type="email" class="form-control sm-input" id="exampleInputEmail5" placeholder="Enter email">
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only" for="exampleInputPassword2">Password</label>
                                                <input type="password" class="form-control sm-input" id="exampleInputPassword5" placeholder="Password">
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox"> Remember me
                                                </label>
                                            </div>
                                            <button type="submit" class="btn btn-default">Sign in</button>
                                        </form>

                                    </div>

                                </div>
                            </div>
                        </div>

                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="row">
        <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Form Elements
            </header>
            <div class="panel-body">
                <form class="form-horizontal bucket-form" method="get">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Default</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Help text</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control">
                            <span class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Rounder</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control round-input">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Input focus</label>
                        <div class="col-sm-6">
                            <input class="form-control" id="focusedInput" type="text" value="This is focused...">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Disabled</label>
                        <div class="col-sm-6">
                            <input class="form-control" id="disabledInput" type="text" placeholder="Disabled input here..." disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Placeholder</label>
                        <div class="col-sm-6">
                            <input type="text"  class="form-control" placeholder="placeholder">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Password</label>
                        <div class="col-sm-6">
                            <input type="password"  class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class=" col-sm-3 control-label">Static control</label>
                        <div class="col-lg-6">
                            <p class="form-control-static">email@example.com</p>
                        </div>
                    </div>
                    <div class="form-group has-success">
                        <label class="col-sm-3 control-label col-lg-3" for="inputSuccess">Input with success</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="inputSuccess">
                        </div>
                    </div>
                    <div class="form-group has-warning">
                        <label class="col-sm-3 control-label col-lg-3" for="inputWarning">Input with warning</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="inputWarning">
                        </div>
                    </div>
                    <div class="form-group has-error">
                        <label class="col-sm-3 control-label col-lg-3" for="inputError">Input with error</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="inputError">
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <section class="panel">
            <div class="panel-body">
                <form class="form-horizontal bucket-form" method="get">
                    <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3" for="inputSuccess">Control sizing</label>
                        <div class="col-lg-6">
                            <input class="form-control input-lg m-bot15" type="text" placeholder=".input-lg">
                            <input class="form-control m-bot15" type="text" placeholder="Default input">
                            <input class="form-control input-sm m-bot15" type="text" placeholder=".input-sm">

                            <select class="form-control input-lg m-bot15">
                                <option>Option 1</option>
                                <option>Option 2</option>
                                <option>Option 3</option>
                            </select>
                            <select class="form-control m-bot15">
                                <option>Option 1</option>
                                <option>Option 2</option>
                                <option>Option 3</option>
                            </select>
                            <select class="form-control input-sm m-bot15">
                                <option>Option 1</option>
                                <option>Option 2</option>
                                <option>Option 3</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <section class="panel">
            <div class="panel-body">
                <form class="form-horizontal bucket-form" method="get">
                    <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3" for="inputSuccess">Checkboxes and radios</label>
                        <div class="col-lg-6">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="">
                                    Option one is this and that&mdash;be sure to include why it's great
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="">
                                    Option one is this and that&mdash;be sure to include why it's great option one
                                </label>
                            </div>

                            <div class="radio">
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                                    Option one is this and that&mdash;be sure to include why it's great
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                    Option two can be something else and selecting it will deselect option one
                                </label>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3" for="inputSuccess">Inline checkboxes</label>
                        <div class="col-lg-6">
                            <label class="checkbox-inline">
                                <input type="checkbox" id="inlineCheckbox1" value="option1"> 1
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" id="inlineCheckbox2" value="option2"> 2
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" id="inlineCheckbox3" value="option3"> 3
                            </label>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3" for="inputSuccess">Selects</label>
                        <div class="col-lg-6">
                            <select class="form-control m-bot15">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>

                            <select multiple class="form-control">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3" for="inputSuccess">Column sizing</label>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-2">
                                    <input type="text" class="form-control" placeholder=".col-lg-2">
                                </div>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" placeholder=".col-lg-3">
                                </div>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" placeholder=".col-lg-4">
                                </div>
                            </div>

                        </div>
                    </div>

                </form>
            </div>
        </section>

        <section class="panel">
            <header class="panel-heading">
                Input groups
            </header>
            <div class="panel-body">
                <form class="form-horizontal bucket-form" method="get">
                    <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3" >Basic examples</label>
                        <div class="col-lg-6">
                            <div class="input-group m-bot15">
                                <span class="input-group-addon btn-success">@</span>
                                <input type="text" class="form-control" placeholder="Username">
                            </div>

                            <div class="input-group m-bot15">
                                <input type="text" class="form-control">
                                <span class="input-group-addon btn-warning">.00</span>
                            </div>

                            <div class="input-group m-bot15">
                                <span class="input-group-addon">$</span>
                                <input type="text" class="form-control">
                                <span class="input-group-addon ">.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3" >Sizing</label>
                        <div class="col-lg-6">
                            <div class="input-group input-group-lg m-bot15">
                                <span class="input-group-addon btn-danger">@</span>
                                <input type="text" class="form-control input-lg" placeholder="Username">
                            </div>

                            <div class="input-group m-bot15">
                                <span class="input-group-addon">@</span>
                                <input type="text" class="form-control" placeholder="Username">
                            </div>

                            <div class="input-group input-group-sm m-bot15">
                                <span class="input-group-addon">@</span>
                                <input type="text" class="form-control" placeholder="Username">
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3" >Iconic</label>
                        <div class="col-lg-6">
                            <div class="input-group m-bot15">
                                <span class="input-group-addon btn-white"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" placeholder="Username">
                            </div>
                            <div class="input-group m-bot15">
                                <span class="input-group-addon btn-white"><i class="fa fa-envelope"></i></span>
                                <input type="text" class="form-control" placeholder="Email">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3" >Checkboxe and radio</label>
                        <div class="col-lg-6">
                            <div class="input-group m-bot15">
                                              <span class="input-group-addon">
                                                <input type="checkbox">
                                              </span>
                                <input type="text" class="form-control">
                            </div>

                            <div class="input-group m-bot15">
                                              <span class="input-group-addon">
                                                <input type="radio">
                                              </span>
                                <input type="text" class="form-control">
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3" >Button addons</label>
                        <div class="col-lg-6">
                            <div class="input-group m-bot15">
                                              <span class="input-group-btn">
                                                <button class="btn btn-danger" type="button">Go!</button>
                                              </span>
                                <input type="text" class="form-control">
                            </div>

                            <div class="input-group m-bot15">
                                <input type="text" class="form-control">
                                              <span class="input-group-btn">
                                                <button class="btn btn-success" type="button">Go!</button>
                                              </span>
                            </div>

                            <div class="input-group m-bot15">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                    </ul>
                                </div>
                                <input type="text" class="form-control">
                            </div>
                            <div class="input-group m-bot15">
                                <input type="text" class="form-control">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3" >Segmented buttons</label>
                        <div class="col-lg-6">
                            <div class="input-group m-bot15">
                                <div class="input-group-btn">
                                    <button tabindex="-1" class="btn btn-info" type="button">Action</button>
                                    <button tabindex="-1" data-toggle="dropdown" class="btn btn-info dropdown-toggle" type="button">
                                        <span class="caret"></span>
                                    </button>
                                    <ul role="menu" class="dropdown-menu">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                    </ul>
                                </div>
                                <input type="text" class="form-control">
                            </div>

                            <div class="input-group m-bot15">
                                <input type="text" class="form-control">
                                <div class="input-group-btn">
                                    <button tabindex="-1" class="btn btn-info" type="button">Action</button>
                                    <button tabindex="-1" data-toggle="dropdown" class="btn btn-info dropdown-toggle" type="button">
                                        <span class="caret"></span>
                                    </button>
                                    <ul role="menu" class="dropdown-menu pull-right">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </section>

        </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Custom Checkbox & Radio
                    </header>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form class="form-horizontal bucket-form" method="get">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Checkboxes</label>

                                        <div class="col-sm-9 icheck minimal">
                                            <div class="checkbox single-row">
                                                <input type="checkbox" checked="" >
                                                <label>Checkbox 1</label>
                                            </div>

                                            <div class="checkbox single-row">
                                                <input type="checkbox" checked="" >
                                                <label>Checkbox 2</label>
                                            </div>

                                            <div class="checkbox single-row">
                                                <input type="checkbox" checked="" >
                                                <label>Checkbox 3</label>
                                            </div>

                                            <div class="checkbox single-row">
                                                <label class="disabled"><input type="checkbox" disabled="" checked="" ></label>
                                                <label>Disabled</label>
                                            </div>


                                            <div class="checkbox checked single-row">
                                                <label class=" disabled"><input type="checkbox" disabled="" checked="" id=""></label>
                                                <label>Checked &amp; Disabled</label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <form class="form-horizontal bucket-form" method="get">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Radio</label>

                                        <div class="col-sm-9 icheck minimal">
                                            <div class="radio single-row">
                                                <input tabindex="3" type="radio"  name="demo-radio">
                                                <label>Checkbox 1</label>
                                            </div>

                                            <div class="radio single-row">
                                                <input tabindex="3" type="radio"  name="demo-radio">
                                                <label>Checkbox 2</label>
                                            </div>

                                            <div class="radio single-row">
                                                <input tabindex="3" type="radio"  name="demo-radio">
                                                <label>Checkbox 3</label>
                                            </div>

                                            <div class="radio single-row">
                                                <label class="disabled"><input type="radio" disabled="" ></label>
                                                <label>Disabled</label>
                                            </div>


                                            <div class="radio checked single-row">
                                                <label class=" disabled"><input type="radio" disabled="" checked=""></label>
                                                <label>Checked &amp; Disabled</label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                      Different Color Custom Checkbox & Radio
                    </header>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form class="form-horizontal bucket-form" method="get">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Checkboxes</label>

                                        <div class="col-sm-9 icheck ">

                                            <div class="minimal single-row">
                                                <div class="checkbox ">
                                                    <input type="checkbox" >
                                                    <label>Black Checkbox </label>
                                                </div>
                                            </div>
                                            <div class="minimal-red single-row">
                                                <div class="checkbox ">
                                                    <input type="checkbox" >
                                                    <label>Red Checkbox </label>
                                                </div>
                                            </div>

                                            <div class="minimal-green single-row">
                                                <div class="checkbox ">
                                                    <input type="checkbox" >
                                                    <label>Green Checkbox </label>
                                                </div>
                                            </div>

                                            <div class="minimal-blue single-row">
                                                <div class="checkbox ">
                                                    <input type="checkbox" >
                                                    <label>Blue Checkbox </label>
                                                </div>
                                            </div>

                                            <div class="minimal-yellow single-row">
                                                <div class="checkbox ">
                                                    <input type="checkbox" >
                                                    <label>Yellow Checkbox </label>
                                                </div>
                                            </div>

                                            <div class="minimal-purple single-row">
                                                <div class="checkbox ">
                                                    <input type="checkbox" >
                                                    <label>Purple Checkbox </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <form class="form-horizontal bucket-form" method="get">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Checkboxes</label>

                                        <div class="col-sm-9 icheck ">

                                            <div class="square single-row">
                                                <div class="checkbox ">
                                                    <input type="checkbox" >
                                                    <label>Black Checkbox </label>
                                                </div>
                                            </div>
                                            <div class="square-red single-row">
                                                <div class="checkbox ">
                                                    <input type="checkbox" >
                                                    <label>Red Checkbox </label>
                                                </div>
                                            </div>

                                            <div class="square-green single-row">
                                                <div class="checkbox ">
                                                    <input type="checkbox" >
                                                    <label>Green Checkbox </label>
                                                </div>
                                            </div>

                                            <div class="square-blue single-row">
                                                <div class="checkbox ">
                                                    <input type="checkbox" >
                                                    <label>Blue Checkbox </label>
                                                </div>
                                            </div>

                                            <div class="square-yellow single-row">
                                                <div class="checkbox ">
                                                    <input type="checkbox" >
                                                    <label>Yellow Checkbox </label>
                                                </div>
                                            </div>

                                            <div class="square-purple single-row">
                                                <div class="checkbox ">
                                                    <input type="checkbox" >
                                                    <label>Purple Checkbox </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <form class="form-horizontal bucket-form" method="get">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Radio</label>

                                        <div class="col-sm-9 icheck ">

                                            <div class="minimal single-row">
                                                <div class="radio ">
                                                    <input tabindex="3" type="radio"  name="demo-radio">
                                                    <label>Black Radio </label>
                                                </div>
                                            </div>
                                            <div class="minimal-red single-row">
                                                <div class="radio ">
                                                    <input tabindex="3" type="radio"  name="demo-radio">
                                                    <label>Red Radio </label>
                                                </div>
                                            </div>

                                            <div class="minimal-green single-row">
                                                <div class="radio ">
                                                    <input tabindex="3" type="radio"  name="demo-radio">
                                                    <label>Green Radio </label>
                                                </div>
                                            </div>

                                            <div class="minimal-blue single-row">
                                                <div class="radio ">
                                                    <input tabindex="3" type="radio"  name="demo-radio">
                                                    <label>Blue Radio </label>
                                                </div>
                                            </div>

                                            <div class="minimal-yellow single-row">
                                                <div class="radio ">
                                                    <input tabindex="3" type="radio"  name="demo-radio">
                                                    <label>Yellow Radio </label>
                                                </div>
                                            </div>

                                            <div class="minimal-purple single-row">
                                                <div class="radio ">
                                                    <input tabindex="3" type="radio"  name="demo-radio">
                                                    <label>Purple Radio </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <form class="form-horizontal bucket-form" method="get">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Radio</label>

                                        <div class="col-sm-9 icheck ">

                                            <div class="square single-row">
                                                <div class="radio ">
                                                    <input tabindex="3" type="radio"  name="demo-radio">
                                                    <label>Black Radio </label>
                                                </div>
                                            </div>
                                            <div class="square-red single-row">
                                                <div class="radio ">
                                                    <input tabindex="3" type="radio"  name="demo-radio">
                                                    <label>Red Radio </label>
                                                </div>
                                            </div>

                                            <div class="square-green single-row">
                                                <div class="radio ">
                                                    <input tabindex="3" type="radio"  name="demo-radio">
                                                    <label>Green Radio </label>
                                                </div>
                                            </div>

                                            <div class="square-blue single-row">
                                                <div class="radio ">
                                                    <input tabindex="3" type="radio"  name="demo-radio">
                                                    <label>Blue Radio </label>
                                                </div>
                                            </div>

                                            <div class="square-yellow single-row">
                                                <div class="radio ">
                                                    <input tabindex="3" type="radio"  name="demo-radio">
                                                    <label>Yellow Radio </label>
                                                </div>
                                            </div>

                                            <div class="square-purple single-row">
                                                <div class="radio ">
                                                    <input tabindex="3" type="radio"  name="demo-radio">
                                                    <label>Purple Radio </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        flat checkbox & radio
                    </header>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form class="form-horizontal bucket-form" method="get">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Radio</label>

                                        <div class="col-sm-9 icheck ">

                                            <div class="flat-grey single-row">
                                                <div class="radio ">
                                                    <input type="checkbox">
                                                    <label>Black Checkbox </label>
                                                </div>
                                            </div>
                                            <div class="flat-red single-row">
                                                <div class="radio ">
                                                    <input type="checkbox">
                                                    <label>Red Checkbox </label>
                                                </div>
                                            </div>

                                            <div class="flat-green single-row">
                                                <div class="radio ">
                                                    <input type="checkbox">
                                                    <label>Green Checkbox </label>
                                                </div>
                                            </div>

                                            <div class="flat-blue single-row">
                                                <div class="radio ">
                                                    <input type="checkbox">
                                                    <label>Blue Checkbox </label>
                                                </div>
                                            </div>

                                            <div class="flat-yellow single-row">
                                                <div class="radio ">
                                                    <input type="checkbox">
                                                    <label>Yellow Checkbox </label>
                                                </div>
                                            </div>

                                            <div class="flat-purple single-row">
                                                <div class="radio ">
                                                    <input type="checkbox">
                                                    <label>Purple Checkbox </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <form class="form-horizontal bucket-form" method="get">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Radio</label>

                                        <div class="col-sm-9 icheck ">

                                            <div class="flat-grey single-row">
                                                <div class="radio ">
                                                    <input tabindex="3" type="radio"  name="demo-radio">
                                                    <label>Black Radio </label>
                                                </div>
                                            </div>
                                            <div class="flat-red single-row">
                                                <div class="radio ">
                                                    <input tabindex="3" type="radio"  name="demo-radio">
                                                    <label>Red Radio </label>
                                                </div>
                                            </div>

                                            <div class="flat-green single-row">
                                                <div class="radio ">
                                                    <input tabindex="3" type="radio"  name="demo-radio">
                                                    <label>Green Radio </label>
                                                </div>
                                            </div>

                                            <div class="flat-blue single-row">
                                                <div class="radio ">
                                                    <input tabindex="3" type="radio"  name="demo-radio">
                                                    <label>Blue Radio </label>
                                                </div>
                                            </div>

                                            <div class="flat-yellow single-row">
                                                <div class="radio ">
                                                    <input tabindex="3" type="radio"  name="demo-radio">
                                                    <label>Yellow Radio </label>
                                                </div>
                                            </div>

                                            <div class="flat-purple single-row">
                                                <div class="radio ">
                                                    <input tabindex="3" type="radio"  name="demo-radio">
                                                    <label>Purple Radio </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Textarea
                    </header>
                    <div class="panel-body">
                        <form class="form-horizontal bucket-form" method="get">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Textarea label</label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" rows="6"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <div data-collapsed="0" class="panel">

                    <div class="panel-heading">
                        <div class="panel-title">
                            Input Grid
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="row">

                            <div class="col-md-12 form-group">
                                <input type="text" placeholder=".col-md-12" class="form-control">
                            </div>

                            <div class="col-md-6 form-group">
                                <input type="text" placeholder=".col-md-6" class="form-control">
                            </div>

                            <div class="col-md-6 form-group">
                                <input type="text" placeholder=".col-md-6" class="form-control">
                            </div>


                            <div class="col-md-4 form-group">
                                <input type="text" placeholder=".col-md-4" class="form-control">
                            </div>

                            <div class="col-md-4 form-group">
                                <input type="text" placeholder=".col-md-4" class="form-control">
                            </div>

                            <div class="col-md-4 form-group">
                                <input type="text" placeholder=".col-md-4" class="form-control">
                            </div>


                            <div class="col-md-3 form-group">
                                <input type="text" placeholder=".col-md-3" class="form-control">
                            </div>

                            <div class="col-md-3 form-group">
                                <input type="text" placeholder=".col-md-3" class="form-control">
                            </div>

                            <div class="col-md-3 form-group">
                                <input type="text" placeholder=".col-md-3" class="form-control">
                            </div>

                            <div class="col-md-3 form-group">
                                <input type="text" placeholder=".col-md-3" class="form-control">
                            </div>


                            <div class="col-md-2 form-group">
                                <input type="text" placeholder=".col-md-2" class="form-control">
                            </div>

                            <div class="col-md-2 form-group">
                                <input type="text" placeholder=".col-md-2" class="form-control">
                            </div>

                            <div class="col-md-2 form-group">
                                <input type="text" placeholder=".col-md-2" class="form-control">
                            </div>

                            <div class="col-md-2 form-group">
                                <input type="text" placeholder=".col-md-2" class="form-control">
                            </div>

                            <div class="col-md-2 form-group">
                                <input type="text" placeholder=".col-md-2" class="form-control">
                            </div>

                            <div class="col-md-2 form-group">
                                <input type="text" placeholder=".col-md-2" class="form-control">
                            </div>


                            <div class="col-md-1 form-group">
                                <input type="text" placeholder=".col-md-1" class="form-control">
                            </div>

                            <div class="col-md-1 form-group">
                                <input type="text" placeholder=".col-md-1" class="form-control">
                            </div>

                            <div class="col-md-1 form-group">
                                <input type="text" placeholder=".col-md-1" class="form-control">
                            </div>

                            <div class="col-md-1 form-group">
                                <input type="text" placeholder=".col-md-1" class="form-control">
                            </div>

                            <div class="col-md-1 form-group">
                                <input type="text" placeholder=".col-md-1" class="form-control">
                            </div>

                            <div class="col-md-1 form-group">
                                <input type="text" placeholder=".col-md-1" class="form-control">
                            </div>

                            <div class="col-md-1 form-group">
                                <input type="text" placeholder=".col-md-1" class="form-control">
                            </div>

                            <div class="col-md-1 form-group">
                                <input type="text" placeholder=".col-md-1" class="form-control">
                            </div>

                            <div class="col-md-1 form-group">
                                <input type="text" placeholder=".col-md-1" class="form-control">
                            </div>

                            <div class="col-md-1 form-group">
                                <input type="text" placeholder=".col-md-1" class="form-control">
                            </div>

                            <div class="col-md-1 form-group">
                                <input type="text" placeholder=".col-md-1" class="form-control">
                            </div>

                            <div class="col-md-1 form-group">
                                <input type="text" placeholder=".col-md-1" class="form-control">
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>

        <!-- page end-->
        <!-- page end-->
        </section>
    </section>
    <!--main content end-->
<!--right sidebar start-->
<div class="right-sidebar">
<div class="search-row">
    <input type="text" placeholder="Search" class="form-control">
</div>
<ul class="right-side-accordion">
<li class="widget-collapsible">
    <a href="#" class="head widget-head red-bg active clearfix">
        <span class="pull-left">work progress (5)</span>
        <span class="pull-right widget-collapse"><i class="ico-minus"></i></span>
    </a>
    <ul class="widget-container">
        <li>
            <div class="prog-row side-mini-stat clearfix">
                <div class="side-graph-info">
                    <h4>Target sell</h4>
                    <p>
                        25%, Deadline 12 june 13
                    </p>
                </div>
                <div class="side-mini-graph">
                    <div class="target-sell">
                    </div>
                </div>
            </div>
            <div class="prog-row side-mini-stat">
                <div class="side-graph-info">
                    <h4>product delivery</h4>
                    <p>
                        55%, Deadline 12 june 13
                    </p>
                </div>
                <div class="side-mini-graph">
                    <div class="p-delivery">
                        <div class="sparkline" data-type="bar" data-resize="true" data-height="30" data-width="90%" data-bar-color="#39b7ab" data-bar-width="5" data-data="[200,135,667,333,526,996,564,123,890,564,455]">
                        </div>
                    </div>
                </div>
            </div>
            <div class="prog-row side-mini-stat">
                <div class="side-graph-info payment-info">
                    <h4>payment collection</h4>
                    <p>
                        25%, Deadline 12 june 13
                    </p>
                </div>
                <div class="side-mini-graph">
                    <div class="p-collection">
						<span class="pc-epie-chart" data-percent="45">
						<span class="percent"></span>
						</span>
                    </div>
                </div>
            </div>
            <div class="prog-row side-mini-stat">
                <div class="side-graph-info">
                    <h4>delivery pending</h4>
                    <p>
                        44%, Deadline 12 june 13
                    </p>
                </div>
                <div class="side-mini-graph">
                    <div class="d-pending">
                    </div>
                </div>
            </div>
            <div class="prog-row side-mini-stat">
                <div class="col-md-12">
                    <h4>total progress</h4>
                    <p>
                        50%, Deadline 12 june 13
                    </p>
                    <div class="progress progress-xs mtop10">
                        <div style="width: 50%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar" class="progress-bar progress-bar-info">
                            <span class="sr-only">50% Complete</span>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</li>
<li class="widget-collapsible">
    <a href="#" class="head widget-head terques-bg active clearfix">
        <span class="pull-left">contact online (5)</span>
        <span class="pull-right widget-collapse"><i class="ico-minus"></i></span>
    </a>
    <ul class="widget-container">
        <li>
            <div class="prog-row">
                <div class="user-thumb">
                    <a href="#"><img src="images/avatar1_small.jpg" alt=""></a>
                </div>
                <div class="user-details">
                    <h4><a href="#">Jonathan Smith</a></h4>
                    <p>
                        Work for fun
                    </p>
                </div>
                <div class="user-status text-danger">
                    <i class="fa fa-comments-o"></i>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb">
                    <a href="#"><img src="images/avatar1.jpg" alt=""></a>
                </div>
                <div class="user-details">
                    <h4><a href="#">Anjelina Joe</a></h4>
                    <p>
                        Available
                    </p>
                </div>
                <div class="user-status text-success">
                    <i class="fa fa-comments-o"></i>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb">
                    <a href="#"><img src="images/chat-avatar2.jpg" alt=""></a>
                </div>
                <div class="user-details">
                    <h4><a href="#">John Doe</a></h4>
                    <p>
                        Away from Desk
                    </p>
                </div>
                <div class="user-status text-warning">
                    <i class="fa fa-comments-o"></i>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb">
                    <a href="#"><img src="images/avatar1_small.jpg" alt=""></a>
                </div>
                <div class="user-details">
                    <h4><a href="#">Mark Henry</a></h4>
                    <p>
                        working
                    </p>
                </div>
                <div class="user-status text-info">
                    <i class="fa fa-comments-o"></i>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb">
                    <a href="#"><img src="images/avatar1.jpg" alt=""></a>
                </div>
                <div class="user-details">
                    <h4><a href="#">Shila Jones</a></h4>
                    <p>
                        Work for fun
                    </p>
                </div>
                <div class="user-status text-danger">
                    <i class="fa fa-comments-o"></i>
                </div>
            </div>
            <p class="text-center">
                <a href="#" class="view-btn">View all Contacts</a>
            </p>
        </li>
    </ul>
</li>
<li class="widget-collapsible">
    <a href="#" class="head widget-head purple-bg active">
        <span class="pull-left"> recent activity (3)</span>
        <span class="pull-right widget-collapse"><i class="ico-minus"></i></span>
    </a>
    <ul class="widget-container">
        <li>
            <div class="prog-row">
                <div class="user-thumb rsn-activity">
                    <i class="fa fa-clock-o"></i>
                </div>
                <div class="rsn-details ">
                    <p class="text-muted">
                        just now
                    </p>
                    <p>
                        <a href="#">Jim Doe </a>Purchased new equipments for zonal office setup
                    </p>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb rsn-activity">
                    <i class="fa fa-clock-o"></i>
                </div>
                <div class="rsn-details ">
                    <p class="text-muted">
                        2 min ago
                    </p>
                    <p>
                        <a href="#">Jane Doe </a>Purchased new equipments for zonal office setup
                    </p>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb rsn-activity">
                    <i class="fa fa-clock-o"></i>
                </div>
                <div class="rsn-details ">
                    <p class="text-muted">
                        1 day ago
                    </p>
                    <p>
                        <a href="#">Jim Doe </a>Purchased new equipments for zonal office setup
                    </p>
                </div>
            </div>
        </li>
    </ul>
</li>
<li class="widget-collapsible">
    <a href="#" class="head widget-head yellow-bg active">
        <span class="pull-left"> shipment status</span>
        <span class="pull-right widget-collapse"><i class="ico-minus"></i></span>
    </a>
    <ul class="widget-container">
        <li>
            <div class="col-md-12">
                <div class="prog-row">
                    <p>
                        Full sleeve baby wear (SL: 17665)
                    </p>
                    <div class="progress progress-xs mtop10">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                            <span class="sr-only">40% Complete</span>
                        </div>
                    </div>
                </div>
                <div class="prog-row">
                    <p>
                        Full sleeve baby wear (SL: 17665)
                    </p>
                    <div class="progress progress-xs mtop10">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 70%">
                            <span class="sr-only">70% Completed</span>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</li>
</ul>
</div>
<!--right sidebar end-->

</section>



<?php include '../smadmin/view_footer.php'; ?>
