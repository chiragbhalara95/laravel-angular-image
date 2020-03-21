    <!-- Modal form to add a post -->
    <div id="editModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" name="editProductFrm" role="form" id="edit-product-frm" enctype="multipart/form-data" action="#">
                        <input type="hidden" ng-model="form.id" ng-value="@{{form.id}}">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="title">Name:</label>
                            <div class="col-sm-10">
                                <input type="text" ng-model="form.name" class="form-control" id="name" name="name" required>
                                <span style="color:red" ng-show="editProductFrm.name.$touched && editProductFrm.name.$invalid">The name is required.</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="description">Category:</label>
                            <div class="col-sm-10">
                                <select class="form-control" ng-model="form.category_id" required>
                                    <option value="@{{category_id}}" ng-repeat="(category_id, category_name) in categoryList" ng-selected="category_id == form.category_id">@{{category_name}}</option>
                                </select>
                                  <span style="color:red" ng-show="editProductFrm.category_id.$error.required">Select Category</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="description">Description:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" ng-model="form.description" id="description" name="description" cols="40" rows="5" required></textarea>
                                <span style="color:red" ng-show="editProductFrm.description.$touched && editProductFrm.description.$invalid">The description is required.</span>
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
                                <img id="blah" ng-src="@{{form.imageSrc}}" ng-show = "isVisible" ng-model="form.imageSrc" name="imageSrc" align='middle' width="150px" height="100px">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
                            <button type="button" ng-click="updateProduct()"" class="btn btn-primary" ng-disabled="edit-product.$invalid">Update</button>
                        </div><!-- /modal-footer -->

                    </form>
                </div>
            </div>
        </div>
    </div>
