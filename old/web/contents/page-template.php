<!DOCTYPE html>
<html lang="fr">
    <?php include('../includes/header.php'); ?>
    <body class="light">
        <!-- Pre loader -->
        <?php include('../includes/preloader.php'); ?>
        <div id="app">
            <!--Sidebar Left Start-->
            <?php include('../includes/sidebar-left.php'); ?>
            <!--Sidebar Left End-->

            <!--Navbar Start-->
            <?php include('../includes/navbar.php'); ?>
            <!--Navbar End-->

            <div class="page has-sidebar-left bg-light height-full">
                <header class="blue accent-3 relative nav-sticky"> <!-- style="background-color: #09709f !important;"-->
                    <div class="container-fluid text-white">
                        <div class="row">
                            <div class="col">
                                <h3 class="my-3"><i class="icon icon-note-important"></i> <strong>Titre de la Page</strong></h3>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="container-fluid my-3">
                    <div class="d-flex row">
                        <div class="col-md-12">
                            <!-- Basic Validation -->
                            <div class="card mb-3 shadow no-b r-0">
                                <div class="card-header white"><h6>TOP Info Page</h6></div>
                                <div class="card-body">
                                    <form id="formModal" class="form-material" method="POST">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="name" required>
                                                <label class="form-label">Name</label>
                                            </div>
                                        </div>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="surname" required>
                                                <label class="form-label">Surname</label>
                                            </div>
                                        </div>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="email" class="form-control" name="email" required>
                                                <label class="form-label">Email</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="radio" name="gender" id="male" class="with-gap">
                                            <label for="male">Male</label>

                                            <input type="radio" name="gender" id="female" class="with-gap">
                                            <label for="female" class="m-l-20">Female</label>
                                        </div>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <textarea name="description" cols="30" rows="2" class="form-control no-resize" required></textarea>
                                                <label class="form-label">Description</label>
                                            </div>
                                        </div>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="password" class="form-control" name="password" required>
                                                <label class="form-label">Password</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" id="checkbox" name="checkbox">
                                            <label for="checkbox">I have read and accept the terms</label>
                                        </div>
                                        <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Right Sidebar Start-->
            <?php include('../includes/sidebar-right.php'); ?>
            <!-- Right Sidebar End-->

            <div class="control-sidebar-bg shadow white fixed"></div>
        </div>
        <?php include('../includes/footer.php'); ?>
    </body>
</html>