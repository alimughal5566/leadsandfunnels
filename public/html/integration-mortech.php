<?php
    include ("includes/head.php");
?>
    <!-- contain sidebar of the page -->
    <?php
        include ("includes/sidebar-menu.php");
        include ("includes/inner-sidebar-menu.php");
    ?>
    <!-- contain the main content of the page -->
        <div id="content">
            <!-- header of the page -->
            <?php
                include ("includes/header.php");
            ?>
            <!-- contain main informative part of the site -->
            <main class="main">
                <!-- content of the page -->
                <section class="main-content">
                    <!-- Title wrap of the page -->
                    <div class="main-content__head">
                        <div class="col-left">
                            <h1 class="title">
                                Integrations - Mortech
                            </h1>
                        </div>
                        <div class="col-right">
                            <a href="integrations-funnel.php" class="back-link"><span class="icon icon-back ico-caret-up"></span> Back to integrations</a>
                        </div>
                    </div>
                    <!-- content of the page -->

                    <div class="lp-panel">
                        <div class="lp-panel__head d-block">
                            <div class="col-left">
                                <h2 class="lp-panel__title">
                                    How does it work?
                                </h2>
                            </div>
                            <div class="row">
                                <div class="col lp-panel__head-disc">
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        Aenean commodo neque quam, sit amet condimentum nibh accumsan sed.
                                        Vestibulum venen tis sem non ex ullamcorper blandit.
                                        Morbi urna nibh, maximus ac lacinia eu, consequat eget sapien.
                                        Nunc nunc lectus, dapibus id interdum porta.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="lp-panel__body">
                            <div class="authenticate__panel">
                                <h3 class="authenticate__head">
                                    Authenticate
                                </h3>
                                <p class="authenticate__desc">
                                    Hi! Please enter your <a class="link" href="#">Mortech</a> username and password below to add subscribers from your forms.
                                </p>
                                <form id="mortech_form" action="" method="post">
                                    <div class="authentication__form authentication__form_form-group">
                                        <div class="form-group">
                                            <label for="user_name">Username</label>
                                            <div class="input__wrapper">
                                                <input id="user_name" name="user_name" class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-center">Password</label>
                                            <div class="input__wrapper">
                                                <input id="password" name="password" class="form-control" type="password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button class="button button-primary" type="submit">authenticate</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- content of the page -->

                </section>
            </main>
        </div>
<?php
    include ("includes/footer.php");
?>