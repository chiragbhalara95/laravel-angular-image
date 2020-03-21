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
            <button type="button" ng-click="addProductFrom()" class="btn btn-success" data-toggle="modal" data-target="#addModal">Create New Product</button>
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


    <!-- Create Item Modal -->

        <!-- Create Item Modal -->
    @include('product.create')
    @include('product.edit')

</div>

@endSection


