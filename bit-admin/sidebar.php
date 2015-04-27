<div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu"> 
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i>Panou</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i>Articole<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                               
                                <li>
                                    <a href="post_edit.php">Articol Nou</a>
                                </li>
                                <li>
                                    <a href="posts.php">Articole</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="comments.php"><i class="fa fa-edit fa-fw"></i>Comentarii</a>
                        </li>
                        <li>
                            <a href="users.php"><i class="fa fa-sitemap fa-fw"></i>Utilizatori<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="users.php">Utilizatori</a>
                                </li>
                                <li>
                                    <a href="users.php?action=add_new">Adauga Utilizator</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="<?php echo $addr; ?>">Main Site</a>
                        </li>
                        <li>
                            <a href="<?php echo $addr; ?>/logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>