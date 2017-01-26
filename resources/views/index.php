<!doctype html>
<html ng-app="authApp">
    <head>
        <meta charset="utf-8">
        <title>Angular-Laravel Authentication</title>

    <link href="../assets/ui/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/ui/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="../assets/ui/css/animate.css" rel="stylesheet">
    <link href="../assets/ui/css/style.css" rel="stylesheet">
       

    </head>
    <body >

            <div ui-view></div>

    </body>

    <!-- Mainly scripts -->
    <script src="../assets/ui/js/jquery-3.1.1.min.js"></script>
    <script src="../assets/ui/js/bootstrap.min.js"></script>

    <script src="../assets/ui/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="../assets/ui/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Peity -->
    <script src="../assets/ui/js/plugins/peity/jquery.peity.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="../assets/ui/js/inspinia.js"></script>
    <script src="../assets/ui/js/plugins/pace/pace.min.js"></script>

    <!-- iCheck -->
    <script src="../assets/ui/js/plugins/iCheck/icheck.min.js"></script>

    <!-- Peity -->
    <script src="../assets/ui/js/demo/peity-demo.js"></script>

    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>

    <!-- Application Dependencies -->
    <script src="../assets/lib/angular/angular.js"></script>
    <script src="../assets/lib/angular-ui-router/release/angular-ui-router.js"></script>
    <script src="../assets/lib/satellizer/dist/satellizer.js"></script>



    <!-- Application Scripts -->
    <script src="../app/app.js"></script>
    <script src="../app/router.js"></script>
    <script src="../app/modules/auth/controllers/authController.js"></script>
    <script src="../app/modules/users/controllers/userController.js"></script>
    <script src="../app/modules/profile/controllers/profileController.js"></script>
    <script src="../app/modules/supplier/controllers/manageSupplierController.js"></script>
    <script src="../app/modules/supplier/controllers/addSupplierController.js"></script>

</html>