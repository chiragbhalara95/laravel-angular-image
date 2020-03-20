@extends('layouts.app')

@section('title', 'Product List')

@section('content')


<div ng-controller="ProductController">

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Laravel 5 AngularJS File Upload Demo</h2>
            </div>
        </div>

        <ul class="alert alert-danger alert-dismissible" ng-if="errors.length > 0">
            <li ng-repeat="error in errors">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                @{{ error }}
            </li>
        </ul>

        <ul class="alert alert-success alert-dismissible" ng-if="success.length > 0">
            <li ng-repeat="msg in success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                @{{ msg }}
            </li>
        </ul>

        <div class="pull-right">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModal">Create New Product</button>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h4>Product List</h4>
                <table ng-if="productList.length > 0" class="table table-bordered table-striped">
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Uploaded On</th>
                        <th>Delete</th>
                    </tr>
                    <tr ng-repeat="file in productList">
                        <td>@{{ $index + 1 }}</td>
                        <td>@{{ file.name }}</td>
                        <td>@{{ file.description }}</td>
                        <td><a href="{{ url('/') }}@{{ file.image }}"><img src="{{ url('/') }}@{{ file.image }}" width="200px"  height="150px" /></a></td>
                        <th>
                            @{{ file.created_at }}
                        </th>
                        <td>
                            <button data-toggle="modal" data-target="#editModal" ng-click="editProduct($index)" class="btn btn-primary">Edit</button>
                            <button ng-click="deleteProduct($index)" class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="clear"></div>

              <div>
                <posts-pagination></posts-pagination>
              </div>
                <!--//==Pagination End==//-->
            </div>
        </div>
    </div>


    <!-- Create Item Modal -->

    <!-- Modal form to add a post -->
    <div id="addModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" id="add-product-frm" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="title">Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" ng-model="form.name" id="name" name="name" autofocus>
                                <small>Min: 2, Max: 32, only text</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="description">Category:</label>
                            <div class="col-sm-10">
                                <select class="form-control" ng-model="form.category_id" name="category_id" id="category_id">
                                    <option value="@{{category.id}}" ng-repeat="category in categoryList" selected="true">@{{category.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="description">Description:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="description" ng-model="form.description" name="description" cols="40" rows="5"></textarea>
                                <small>Min: 2</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="files" class="control-label col-sm-2">Select Image File</label>
                            <div class="col-sm-6">
                                <input type="file" ng-files="setTheFiles($files)" id="image_file"  class="form-control">
                            </div>
                            <div class="col-sm-2">
                                <button ng-click="uploadFile()" class="btn btn-primary">Upload File</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-3">
                                <input type="text" ng-value="@{{form.image}}" ng-model="form.image" style="display: none;">
                            </div>
                            <div class="col-sm-9">
                                <img id="blah" ng-src="@{{form.imageSrc}}" ng-show = "IsVisible" ng-model="form.imageSrc" name="imageSrc" align='middle' width="150px" height="100px">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
                            <button type="button" ng-click="addProduct()" class="btn btn-primary">Add Product</button>
                        </div><!-- /modal-footer -->
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal form to add a post -->
    <div id="editModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" id="edit-product-frm" enctype="multipart/form-data" action="#">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="title">Name:</label>
                            <div class="col-sm-10">
                                <input type="text" ng-model="form.name" class="form-control" id="name" name="name" autofocus>
                                <small>Min: 2, Max: 32, only text</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="description">Category:</label>
                            <div class="col-sm-10">
                                <select class="form-control" ng-model="form.category_id" name="category_id" id="category_id" >
                                    <option value="@{{category.id}}" ng-repeat="category in categoryList" ng-selected="category.id === form.category_id">@{{category.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="description">Description:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" ng-model="form.description" id="description" name="description" cols="40" rows="5"></textarea>
                                <small>Min: 2</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="files" class="control-label col-sm-2">Select Image File</label>
                            <div class="col-sm-6">
                                <input type="file" ng-files="setTheFiles($files)" id="image_file"  class="form-control">
                            </div>
                            <div class="col-sm-2">
                                <button ng-click="uploadFile()" class="btn btn-primary">Upload File</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-3">
                                <input type="text" ng-value="@{{form.image}}" ng-model="form.image" style="display: none;">
                            </div>
                            <div class="col-sm-9">
                                <img id="blah" ng-src="@{{form.imageSrc}}" ng-show = "IsVisible" ng-model="form.imageSrc" name="imageSrc" align='middle' width="150px" height="100px">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
                            <button type="button" ng-click="updateProduct($index)" class="btn btn-primary">Update</button>
                        </div><!-- /modal-footer -->

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endSection