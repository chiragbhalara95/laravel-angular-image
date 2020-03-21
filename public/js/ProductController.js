window.setTimeout(function() {
    $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
        $(this).remove(); 
    });
}, 5000);

var app = angular.module('App', [], ['$httpProvider', function ($httpProvider) {
    $httpProvider.defaults.headers.post['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
}]);


app.controller('ProductController', ['$scope', '$http', '$window', function ($scope, $http, $window) {

    var apiDomain = 'http://localhost/laravel-angular-image';
    var apiUrl = apiDomain+'/public';
    $scope.errors        = [];
    $scope.success       = [];
    $scope.categoryList  = {};
    $scope.range         = [];
    $scope.files         = [];
    $scope.isVisible     = false;
    $scope.form          = {};
    $scope.form.imageSrc = '';
    $scope.form.image    = '';

    $scope.categoryInfo = function(index) {
        var request = {
            method: 'GET',
            url: apiUrl+'/admin/category/list?need_all=1',
            headers: {
                'Content-Type': undefined
            }
        };

        $http(request)
            .then(function success(e) {
                var catData = {};
                angular.forEach(e.data.data, function (value, key) {
                    catData[value.id] = value.name;
                });
                $scope.categoryList = catData;
                //$scope.categoryList = e.data.data;
            });

    };

    $scope.addProductFrom = function() {
        $scope.form = {};
        $scope.isVisible = false;
        $scope.categoryInfo();
    };

    $scope.listFiles = function (page=1) {
        $scope.categoryInfo();
        var request = {
            method: 'GET',
            url: apiUrl+'/admin/product/list?page='+page,
            headers: {
                'Content-Type': undefined
            }
        };

        $http(request)
            .then(function success(e) {
                $scope.productList  = e.data.moviesData.data;
                if ($scope.productList.length > 0) {
                    $scope.success = ['Success'];
                     var response = e.data.moviesData;
                      $scope.totalPages   = response.last_page;
                      $scope.currentPage  = response.current_page;

                      // Pagination Range
                      var pages = [];

                      for(var i=1;i<=response.last_page;i++) {          
                        pages.push(i);
                      }

                      $scope.range = pages; 
                } else {
                    $scope.success = ['There are no any product. Please add new product'];
                }
            }, function error(e) {
                $scope.errors = ['Something Went Wrong. Please try again.'];
            });
    };

    $scope.listFiles();

    var formData = new FormData();

    $scope.uploadFile = function () {

        var request = {
            method: 'POST',
            url: apiUrl+'/admin/api/imageUpload',
            data: formData,
            headers: {
                'Content-Type': undefined
            }
        };
        $http(request)
            .then(function success(e) {
                $scope.form.imageSrc = e.data.data.image_path;
                $scope.form.image = e.data.data.image_name;
                $scope.isVisible = true;
            }, function error(e) {
                $scope.errors = e.data.errors;
            });
    };


    $scope.addProduct= function () {

        var request = {
            method: 'POST',
            url: apiUrl+'/admin/product/createPrduct',
            data: $scope.form,
            headers: {
                'Content-Type': 'application/json'
            }
        };

        $http(request)
            .then(function success(e) {
                $(".modal").modal('hide');
                if (e.data.code == -1) {
                    $scope.errors = [e.data.data];
                } else {
                    $scope.errors = [];  
                    $scope.productList.unshift(e.data);
                }
            }, function error(e) {
                $scope.errors = e.data.errors;
            });
    };

    $scope.updateProduct = function () {

        var id = $scope.form.id;
        var request = {
            method: 'POST',
            url: apiUrl+'/admin/product/'+id+'/update',
            data: $scope.form,
            headers: {
                'Content-Type': 'application/json'
            }
        };

        $http(request)
            .then(function success(e) {
            $(".modal").modal('hide');
                $scope.errors = [];
                $scope.listFiles();
            }, function error(e) {
                $scope.errors = e.data.errors;
            });
    };

    $scope.setTheFiles = function ($files) {
        angular.forEach($files, function (value, key) {
            formData.append('image', value);
        });
    };

    $scope.editProduct = function(index) {
        $scope.categoryInfo();
        $scope.isVisible    = true;
        $scope.form = $scope.productList[index];
        $scope.form.imageSrc = apiUrl+"/"+$scope.form.image;
    };


    $scope.deleteProduct = function (index) {
        var conf = confirm("Do you really want to delete this file?");

        if (conf == true) {
            var request = {
                method: 'DELETE',
                url: apiUrl+'/admin/product/'+$scope.productList[index]['id'],
                //data: $scope.files[index]
            };

            $http(request)
                .then(function success(e) {
                    $scope.errors  = [];
                    $scope.success = ['Success'];
                    $scope.productList.splice(index, 1);
                }, function error(e) {
                    $scope.errors = e.data.errors;
                });
        }
    };

}]);

app.directive('ngFiles', ['$parse', function ($parse) {

    function file_links(scope, element, attrs) {
        var onChange = $parse(attrs.ngFiles);
        element.on('change', function (event) {
            onChange(scope, {$files: event.target.files});
        });
    }

    return {
        link: file_links
    }
}]);

app.directive('postsPagination', function(){  
   return{
      restrict: 'E',
      template: '<ul class="pagination">'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="listFiles(1)">&laquo;</a></li>'+
        '<li ng-show="currentPage > 1"><a href="javascript:void(0)" ng-click="listFiles(currentPage-1)">&lsaquo; Prev</a></li>'+
        '<li ng-show="range.length > 1" ng-repeat="i in range" ng-class="{active : currentPage == i}">'+
            '<a href="javascript:void(0)" ng-click="listFiles(i)">{{i}}</a>'+
        '</li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="listFiles(currentPage+1)">Next &rsaquo;</a></li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="listFiles(totalPages)">&raquo;</a></li>'+
      '</ul>'
   };
});