<?php
$pagetitle = 'Categories';
include(\App\Config::F_ROOT . 'App/Views/Admin/header.php');
$post = false;
if(isset($_SESSION['post'])){
    $post = $_SESSION['post'];
    unset($_SESSION['post']);
}
?>

<!-- BEGIN PAGE -->
<div class="page-content">
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">

        <!-- BEGIN PAGE HEADER-->
        <div class="row-fluid header-title">
            <div class="span12">
                <h3 class="page-title">
                    Categories
                </h3>
            </div>
        </div>
        <!-- END PAGE HEADER-->

        <?php include(\App\Config::F_VIEW . 'Admin/notifications.php') ?>

        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">

                <div class="span6">
                    <div class="tabbable tabbable-custom boxless">
                        <div class="tab-pane">
                            <div class="portlet box grey">
                                <div class="portlet-title">
                                    <h4><i class="icon-reorder"></i><?php echo (!empty($category)) ? 'Edit' : 'Add'; ?> Category
                                    </h4>
                                </div>
                                <div class="portlet-body form">
                    <form action="<?php echo \App\Config::W_ROOT . "admin/add-category" ?>" method="post"
                          class="category-form form-horizontal">
                        <input type="hidden" name="token" value="<?php echo \Core\Csrf::getToken(); ?>">
                        <?php if ((!empty($category))) { ?>
                            <input type="hidden" name="id" value="<?php echo $category['id'] ?>">
                        <?php } ?>
                        <?php $name = (!empty($category['name'])) ? $category['name'] : ($post ? $post['name'] : '') ?>
                        <div class="control-group">
                            <label class="control-label">Name</label>

                            <div class="controls">
                                <div class="validation">
                                    <input type="text" name="name" placeholder="Name" class="m-wrap medium"
                                           value="<?php echo $name; ?>"/></div>
                            </div>
                        </div>
                        <?php $slug = (!empty($category['slug'])) ? $category['slug'] : ($post ? $post['slug'] : '') ?>
                        <div class="control-group">
                            <label class="control-label">Slug</label>

                            <div class="controls">
                                <div class="validation">
                                    <input type="text" name="slug" placeholder="Slug" class="m-wrap medium"
                                           value="<?php echo $slug; ?>"/></div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Parent Categories</label>

                            <div class="controls">
                                <select class="medium m-wrap" name="parent_id" tabindex="1">
                                    <option value="0">None</option>
                                    <?php foreach ($parent_cat as $option) {
                                        $selected = "";
                                        if(!empty($category['parent_id']) && $category['parent_id'] == $option['4']){
                                            $selected = 'selected="selected"';
                                        } else if($post && isset($post['parent_id']) && $post['parent_id'] == $option['4']){
                                            $selected = 'selected="selected"';
                                        }
                                        ?>
                                        <option
                                            value="<?php echo $option['4'] ?>" <?php echo $selected; ?>><?php echo $option['1'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <?php $description = (!empty($category['description'])) ? $category['description'] : ($post ? $post['description'] : '') ?>
                        <div class="control-group">
                            <label class="control-label">Description</label>

                            <div class="controls">
                                <textarea class="m-wrap medium" name="description"
                                          rows="3"><?php echo $description; ?></textarea>
                            </div>
                        </div>
                        <div class="form-actions" style="margin-left: 15px;">
                            <button type="submit" name="submit" class="btn blue"><i class="icon-ok"></i> Save</button>
                        </div>
                    </form>
                                    </div>
                                </div></div></div>
                </div>

                <div class="span6">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet box grey">
                        <div class="portlet-title">
                            <h4>Categories</h4>

                            <div class="actions">
                                <a href="#deleteModel" role="button" id="delete-btn" class="btn btn-danger red hidden" data-toggle="modal">Delete</a>
                                <div class="btn-group">
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="#"><i class="icon-pencil"></i> Edit</a></li>
                                        <li><a href="#"><i class="icon-trash"></i> Delete</a></li>
                                        <li><a href="#"><i class="icon-ban-circle"></i> Ban</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#"><i class="i"></i> Make admin</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table id="category-grid" class="display table table-striped table-bordered table-hover responsive nowrap">
                                <thead>
                                <tr>
                                    <th style="width:8px;"><input type="checkbox" id="bulkDelete"/>
                                    </th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Slug</th>
                                </tr>
                                </thead>
                            </table>
                            <!--</div>-->
                        </div>
                    </div>
                    <div id="deleteModel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h3>Delete</h3>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure, want to remove the selected categories?</p>
                        </div>
                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn red" id="deleteCategories">Delete</button>
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>

        </div>
        <!-- END PAGE CONTENT-->

    </div>
    <!-- END PAGE CONTAINER-->
</div>
<!-- END PAGE -->

<?php include(\App\Config::F_ROOT . 'App/Views/Admin/footer.php') ?>

<script>
    var categoryAjaxPaginateUrl = "<?php echo \App\Config::W_ROOT ?>admin/categories-ajax-paginate";
    var categoryBulkDeleteUrl = "<?php echo \App\Config::W_ROOT ?>admin/bulk-delete-categories";
</script>
<script src="<?php echo \App\Config::W_ADMIN_ASSETS ?>/js/category.js"></script>
<script>
    $(document).ready(function () {
        Category.initList();
    });
</script>
</body>


