<!doctype html>
<html ng-app="authApp">
    <head>
        <meta charset="utf-8">
        <title>Im Tool Version 1.0</title>

    <link href="assets/ui/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/ui/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="assets/ui/css/animate.css" rel="stylesheet">
    <link href="assets/ui/css/style.css" rel="stylesheet">

    <link href="assets/ui/css/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">

    <link href="assets/ui/css/plugins/datapicker/datepicker3.css" rel="stylesheet">

       

    </head>
    <body >

            <div ui-view></div>

    </body>

    <!-- Mainly scripts -->
    <script src="assets/ui/js/jquery-3.1.1.min.js"></script>
    <script src="assets/ui/js/bootstrap.min.js"></script>

    <script src="assets/ui/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="assets/ui/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Peity -->
    <script src="assets/ui/js/plugins/peity/jquery.peity.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="assets/ui/js/inspinia.js"></script>
    <script src="assets/ui/js/plugins/pace/pace.min.js"></script>

    <!-- iCheck -->
    <script src="assets/ui/js/plugins/iCheck/icheck.min.js"></script>

    <!-- Peity -->
    <script src="assets/ui/js/demo/peity-demo.js"></script>

     <!-- Chosen -->
    <script src="assets/ui/js/plugins/chosen/chosen.jquery.js"></script>

       <!-- Data picker -->
   <script src="assets/ui/js/plugins/datapicker/bootstrap-datepicker.js"></script>


    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>

    <!-- Application Dependencies -->
    <script src="assets/lib/angular/angular.js"></script>
    <script src="assets/lib/angular-ui-router/release/angular-ui-router.js"></script>
    <script src="assets/lib/satellizer/dist/satellizer.js"></script>



    <!-- Application Scripts -->

    <script src="../app/app.js"></script>
    <script src="../app/router.js"></script>
    <script src="../app/modules/auth/controllers/authController.js"></script>
    <script src="../app/modules/auth/controllers/logoutController.js"></script>
    <script src="../app/modules/users/controllers/userController.js"></script>
    <script src="../app/modules/profile/controllers/profileController.js"></script>
    <script src="../app/modules/supplier/controllers/manageSupplierController.js"></script>
    <script src="../app/modules/supplier/controllers/supplierAddController.js"></script>
    <script src="../app/modules/supplier/controllers/supplierEditController.js"></script>
    <script src="../app/modules/product/controllers/manageProductController.js"></script>
    <script src="../app/modules/product/controllers/productAddController.js"></script>
    <script src="../app/modules/product/controllers/productEditController.js"></script>
    <script src="../app/modules/productinward/controllers/manageProductinwardController.js"></script>
    <script src="../app/modules/productinward/controllers/productinwardAddController.js"></script>
    <script src="../app/modules/productinward/controllers/productinwardEditController.js"></script>
    <script src="../app/modules/productinward/controllers/productinwardShowController.js"></script>
    <script src="../app/modules/stock/controllers/manageStockController.js"></script>
    


    

</html>